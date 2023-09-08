<?php
/**
 * affiliates-cf7-handler-legacy.php
 *
 * Copyright (c) 2013-2017 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-contact-form-7
 * @since affiliates-contact-form-7 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin main handler class.
 */
class Affiliates_CF7_Handler_Legacy {

	/**
	 * Adds the proper initialization action on the wp_init hook.
	 */
	public static function init() {

		// hook into after form submission, before the email is sent
		add_action( 'wpcf7_before_send_mail', array( __CLASS__, 'wpcf7_before_send_mail' ) );

		if ( class_exists( 'Affiliates_Attributes' ) ) {
			$options = get_option( Affiliates_CF7::PLUGIN_OPTIONS , array() );
			$rate_adjusted = isset( $options[Affiliates_CF7::RATE_ADJUSTED] );
			if ( !$rate_adjusted ) {
				$referral_rate = isset( $options[Affiliates_CF7::REFERRAL_RATE] ) ? $options[Affiliates_CF7::REFERRAL_RATE] : Affiliates_CF7::REFERRAL_RATE_DEFAULT;
				if ( $referral_rate ) {
					$key   = get_option( 'aff_def_ref_calc_key', null );
					$value = get_option( 'aff_def_ref_calc_value', null );
					if ( empty( $key ) ) {
						if ( $key = Affiliates_Attributes::validate_key( 'referral.rate' ) ) {
							update_option( 'aff_def_ref_calc_key', $key );
						}
						if ( $referral_rate = Affiliates_Attributes::validate_value( $key, $referral_rate ) ) {
							update_option( 'aff_def_ref_calc_value', $referral_rate );
						}
					}
				}
				$options[Affiliates_CF7::RATE_ADJUSTED] = 'yes';
				update_option( Affiliates_CF7::PLUGIN_OPTIONS, $options );
			}
		} else {
			// Reset the rate flag so it gets set when switching plugins
			// back and forth.
			$options = get_option( Affiliates_CF7::PLUGIN_OPTIONS , array() );
			unset( $options[Affiliates_CF7::RATE_ADJUSTED] );
			update_option( Affiliates_CF7::PLUGIN_OPTIONS, $options );
		}

		// We add a hidden field because the user id is not available on wpcf7_before_send_mail
		add_filter( 'wpcf7_form_hidden_fields', array( __CLASS__, 'wpcf7_form_hidden_fields' ), 10, 1 );

	}

	/**
	 * We add a hidden field because the user id is not available on wpcf7_before_send_mail
	 *
	 * @param array $fields
	 */
	public static function wpcf7_form_hidden_fields( $fields ) {
		$fields[AFF_CF7_CURRENT_USER_FIELD] = get_current_user_id();
		return $fields;
	}

	/**
	 * From CF7 3.9, this hook is called from WPCF7_Submission::mail(...) and
	 * the parameter is NOT passed by reference.
	 *
	 * Before CF7 3.9, this hook is called from WPCF7_ContactForm::mail(...)
	 * and the parameter passed by reference.
	 *
	 * @param WPCF7_ContactForm $form
	 */
	public static function wpcf7_before_send_mail( WPCF7_ContactForm $form ) {

		global $wpdb, $affiliates_db;

		$options = get_option( Affiliates_CF7::PLUGIN_OPTIONS , array() );

		$included_form_ids = isset( $options[Affiliates_CF7::INCLUDED_FORMS] ) ? $options[Affiliates_CF7::INCLUDED_FORMS] : array();
		$excluded_form_ids = isset( $options[Affiliates_CF7::EXCLUDED_FORMS] ) ? $options[Affiliates_CF7::EXCLUDED_FORMS] : array();
		$petition_form_ids = isset( $options[Affiliates_CF7::PETITION_FORMS] ) ? $options[Affiliates_CF7::PETITION_FORMS] : array();

		$valid_form = true;
		$form_id = method_exists( 'WPCF7_ContactForm', 'id' ) ? $form->id() : $form->id;
		$form_title = method_exists( 'WPCF7_ContactForm', 'title' ) ? $form->title() : $form->title;
		if ( count( $included_form_ids ) > 0 ) {
			if ( !in_array( $form_id, $included_form_ids ) ) {
				$valid_form = false;
			}
		}
		if ( count( $excluded_form_ids ) > 0 ) {
			if ( in_array( $form_id, $excluded_form_ids ) ) {
				$valid_form = false;
			}
		}
		if ( !$valid_form ) {
			return;
		}

		// check if this is a form that admits petitions
		$petition_form = false;
		if ( count( $petition_form_ids ) > 0 ) {
			if ( in_array( $form_id, $petition_form_ids ) ) {
				$petition_form = true;
			}
		}

		// only record actual form fields of interest
		if ( class_exists( 'WPCF7_FormTagsManager' ) && method_exists( 'WPCF7_FormTagsManager', 'get_instance' ) ) {
			$manager = WPCF7_FormTagsManager::get_instance();
			$scanned_fields = $manager->scan( $form->prop( 'form' ) );
		} else if ( class_exists( 'WPCF7_ShortcodeManager' ) && method_exists( 'WPCF7_ShortcodeManager', 'get_instance' ) ) {
			$manager = WPCF7_ShortcodeManager::get_instance();
			$scanned_fields = $manager->scan_shortcode( $form->prop( 'form' ) );
		} else {
			$scanned_fields = $form->scanned_form_tags;
		}

		$fields = array();
		foreach ( $scanned_fields as $field ) {
			$fields[$field['name']] = $field;
		}

		if ( class_exists( 'WPCF7_Submission' ) ) {
			$submission = WPCF7_Submission::get_instance();
			$posted_data = $submission->get_posted_data();
			$uploaded_files = $submission->uploaded_files();
		} else {
			$posted_data = $form->posted_data;
			$uploaded_files = $form->uploaded_files;
		}

		$data = array();
		foreach ( $posted_data as $key => $value ) {
			if ( key_exists( $key, $fields ) ) {
				$v = '';
				switch ( $fields[$key]['type'] ) {
					case 'acceptance' :
						break;

					case 'captchac' :
					case 'captchar' :
						break;

					case 'checkbox' :
					case 'checkbox*' :
					case 'radio' :
					case 'select' :
					case 'select*' :
						if ( is_array( $value ) ) {
							$v = implode( ', ', $value );
						} else {
							$v = $value;
						}
						break;

					// Files are handled below
					// case 'file' :
					// case 'file*' :
					// break;

					case 'quiz' :
						break;

					case 'response' :
						break;

					case 'submit' :
						break;

					case 'text' :
					case 'text*' :
					case 'email' :
					case 'email*' :
					case 'textarea' :
					case 'textarea*' :
					case 'number' :
					case 'number*' :
					case 'range' :
					case 'range*' :
						$v = $value;
						break;

					default :
						$v = $value;
				}

				// IMPORTANT
				// Applying htmlentities() to $v or stripping tags is VERY
				// important. Think e.g. <script> when displaying referral data
				// in the admin areas would be disastrous.
				$data[$key] = array(
					'title'  => $key,
					'domain' => 'affiliates-contact-form-7',
					'value'  => wp_strip_all_tags( $v ),
				);
			}
		}

		foreach ( $uploaded_files as $key => $value ) {
			if ( key_exists( $key, $fields ) ) {
				$data[$key] = array(
					'title'  => $key,
					'domain' => 'affiliates-contact-form-7',
					'value'  => wp_strip_all_tags( basename( $value ) ), // better paranoia than disaster
				);
			}
		}

		// can't get_the_ID() here
		$post_id = isset( $_GET['page_id'] ) ? intval( $_GET['page_id'] ) : 0;

		$description = !empty( $form_title ) ? $form_title : 'Contact Form 7';
		$base_amount = null;
		$amount = null;
		$currency = isset( $options[Affiliates_CF7::CURRENCY] ) ? $options[Affiliates_CF7::CURRENCY] : Affiliates_CF7::DEFAULT_CURRENCY;

		$use_form_amount      = isset( $options[Affiliates_CF7::USE_FORM_AMOUNT] ) ? $options[Affiliates_CF7::USE_FORM_AMOUNT] : Affiliates_CF7::DEFAULT_USE_FORM_AMOUNT;
		$use_form_base_amount = isset( $options[Affiliates_CF7::USE_FORM_BASE_AMOUNT] ) ? $options[Affiliates_CF7::USE_FORM_BASE_AMOUNT] : Affiliates_CF7::DEFAULT_USE_FORM_BASE_AMOUNT;
		$use_form_currency    = isset( $options[Affiliates_CF7::USE_FORM_CURRENCY] ) ? $options[Affiliates_CF7::USE_FORM_CURRENCY] : Affiliates_CF7::DEFAULT_USE_FORM_CURRENCY;

		// check form for value/currency?
		if ( $use_form_base_amount ) {
			if ( isset( $data['base-amount'] ) && isset( $data['base-amount']['value'] ) && is_numeric( $data['base-amount']['value'] ) ) {
				$base_amount = bcadd( '0', $data['base-amount']['value'] );
			}
		}
		if ( $use_form_amount ) {
			if ( isset( $data['amount'] ) && isset( $data['amount']['value'] ) && is_numeric( $data['amount']['value'] ) ) {
				$amount = bcadd( '0', $data['amount']['value'] );
			}
		}
		if ( $use_form_currency ) {
			if ( isset( $data['currency'] ) && isset( $data['currency']['value'] ) ) {
				if ( in_array( $data['currency']['value'], Affiliates_CF7::$supported_currencies ) ) {
					$currency = $data['currency']['value'];
				}
			}
		}

		$affiliate_id = null;
		if ( $petition_form ) {
			if ( is_user_logged_in() ) {
				$user_id = get_current_user_id();
				$affiliate_ids = affiliates_get_user_affiliate( $user_id );
				$affiliate_id = array_shift( $affiliate_ids );
			} else if ( isset( $posted_data[AFF_CF7_CURRENT_USER_FIELD] ) ) {
				$user_id = intval( $posted_data[AFF_CF7_CURRENT_USER_FIELD] );
				$affiliate_ids = affiliates_get_user_affiliate( $user_id );
				$affiliate_id = array_shift( $affiliate_ids );
			}
		}

		if ( isset( $data['affiliate_id'] ) && !empty( $data['affiliate_id']['value'] ) && is_numeric( $data['affiliate_id']['value'] ) ) {
			$affiliate_id = intval( $data['affiliate_id']['value'] );
		}

		if ( isset( $data['affiliate_login'] ) && !empty( $data['affiliate_login']['value'] ) ) {
			if ( $user = get_user_by( 'login', $data['affiliate_login']['value'] ) ) {
				$affiliate_ids = affiliates_get_user_affiliate( $user->ID );
				$affiliate_id  = array_shift( $affiliate_ids );
			}
		}

		if ( class_exists( 'Affiliates_Referral_WordPress' ) ) {
			$r = new Affiliates_Referral_WordPress();
			if ( !$affiliate_id ) {
				$affiliate_id = $r->evaluate( $post_id, $description, $data, $base_amount, $amount, $currency, null, Affiliates_CF7::REFERRAL_TYPE );
			} else {
				$r->add_referrals( array( $affiliate_id ), $post_id, $description, $data, $base_amount, $amount, $currency, null, Affiliates_CF7::REFERRAL_TYPE );
			}
		} else {
			$options = get_option( Affiliates_CF7::PLUGIN_OPTIONS , array() );
			$referral_rate  = isset( $options[Affiliates_CF7::REFERRAL_RATE] ) ? $options[Affiliates_CF7::REFERRAL_RATE] : Affiliates_CF7::REFERRAL_RATE_DEFAULT;
			if ( $base_amount !== null ) {
				$amount = round( floatval( $referral_rate ) * floatval( $base_amount ), AFFILIATES_REFERRAL_AMOUNT_DECIMALS );
			}
			if ( !$affiliate_id ) {
				$affiliate_id = affiliates_suggest_referral( $post_id, $description, $data, $amount, $currency, null, Affiliates_CF7::REFERRAL_TYPE );
			} else {
				affiliates_add_referral( $affiliate_id, $post_id, $description, $data, $amount, $currency, null, Affiliates_CF7::REFERRAL_TYPE );
			}
		}

	}
}
Affiliates_CF7_Handler_Legacy::init();
