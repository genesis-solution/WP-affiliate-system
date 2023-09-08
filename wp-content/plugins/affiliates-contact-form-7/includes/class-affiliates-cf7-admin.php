<?php
/**
 * affiliates-cf7-admin.php
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
 * @since affiliates-contact-form-7 3.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin admin section.
 */
class Affiliates_CF7_Admin {

	const NONCE = 'aff_cf7_admin_nonce';
	const SET_ADMIN_OPTIONS = 'set_admin_options';

	/**
	 * Adds the proper initialization action on the wp_init hook.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'wp_init' ) );
	}

	/**
	 * Adds actions and filters.
	 */
	public static function wp_init() {
		add_action( 'affiliates_admin_menu', array( __CLASS__, 'affiliates_admin_menu' ) );
		add_filter( 'affiliates_footer', array( __CLASS__, 'affiliates_footer' ) );
	}

	/**
	 * Adds a submenu item to the Affiliates menu for integration options.
	 */
	public static function affiliates_admin_menu() {
		$page = add_submenu_page(
			'affiliates-admin',
			__( 'Affiliates Contact From 7', 'affiliates-contact-form-7' ),
			__( 'Contact Form 7', 'affiliates-contact-form-7' ),
			AFFILIATES_ADMINISTER_OPTIONS,
			'affiliates-admin-cf7',
			array( __CLASS__, 'affiliates_admin_cf7' )
		);
		$pages[] = $page;
		add_action( 'admin_print_styles-' . $page, 'affiliates_admin_print_styles' );
		add_action( 'admin_print_scripts-' . $page, 'affiliates_admin_print_scripts' );
	}

	/**
	 * Affiliates - Contact Form 7 admin section.
	 */
	public static function affiliates_admin_cf7() {

		if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) {
			wp_die( esc_html__( '拒絕訪問。', 'affiliates-contact-form-7' ) );
		}

		$options = get_option( Affiliates_CF7::PLUGIN_OPTIONS, array() );

		if ( isset( $_POST['submit'] ) ) {
			if ( wp_verify_nonce( $_POST[self::NONCE], self::SET_ADMIN_OPTIONS ) ) {

				if ( !class_exists( 'Affiliates_Referral' ) ) {
					$options[Affiliates_CF7::REFERRAL_RATE]  = floatval( $_POST[Affiliates_CF7::REFERRAL_RATE] );
					if ( $options[Affiliates_CF7::REFERRAL_RATE] > 1.0 ) {
						$options[Affiliates_CF7::REFERRAL_RATE] = 1.0;
					} else if ( $options[Affiliates_CF7::REFERRAL_RATE] < 0 ) {
						$options[Affiliates_CF7::REFERRAL_RATE] = 0.0;
					}
				}

				$ids = '';
				$include_form_ids = array();
				if ( !empty( $_POST[Affiliates_CF7::INCLUDED_FORMS] ) ) {
					$ids = trim( $_POST[Affiliates_CF7::INCLUDED_FORMS] );
					if ( !empty( $ids ) ) {
						$ids = explode( ',', $ids );
						foreach ( $ids as $id ) {
							$id = intval( trim( $id ) );
							if ( $id >= 0 && !in_array( $id, $include_form_ids ) ) {
								$include_form_ids[] = $id;
							}
						}
					}
				}
				$options[Affiliates_CF7::INCLUDED_FORMS] = $include_form_ids;

				$ids = '';
				$exclude_form_ids = array();
				if ( !empty( $_POST[Affiliates_CF7::EXCLUDED_FORMS] ) ) {
					$ids = trim( $_POST[Affiliates_CF7::EXCLUDED_FORMS] );
					if ( !empty( $ids ) ) {
						$ids = explode( ',', $ids );
						foreach ( $ids as $id ) {
							$id = intval( trim( $id ) );
							if ( $id >= 0 && !in_array( $id, $exclude_form_ids ) ) {
								$exclude_form_ids[] = $id;
							}
						}
					}
				}
				$options[Affiliates_CF7::EXCLUDED_FORMS] = $exclude_form_ids;

				$ids = '';
				$petition_form_ids = array();
				if ( !empty( $_POST[Affiliates_CF7::PETITION_FORMS] ) ) {
					$ids = trim( $_POST[Affiliates_CF7::PETITION_FORMS] );
					if ( !empty( $ids ) ) {
						$ids = explode( ',', $ids );
						foreach ( $ids as $id ) {
							$id = intval( trim( $id ) );
							if ( $id >= 0 && !in_array( $id, $petition_form_ids ) ) {
								$petition_form_ids[] = $id;
							}
						}
					}
				}
				$options[Affiliates_CF7::PETITION_FORMS] = $petition_form_ids;

				if ( isset( $_POST[Affiliates_CF7::CURRENCY] ) && in_array( $_POST[Affiliates_CF7::CURRENCY], Affiliates_CF7::$supported_currencies ) ) {
					$options[Affiliates_CF7::CURRENCY] = $_POST[Affiliates_CF7::CURRENCY];
				}

				$options[Affiliates_CF7::USE_FORM_AMOUNT]      = !empty( $_POST[Affiliates_CF7::USE_FORM_AMOUNT] );
				$options[Affiliates_CF7::USE_FORM_BASE_AMOUNT] = !empty( $_POST[Affiliates_CF7::USE_FORM_BASE_AMOUNT] );
				$options[Affiliates_CF7::USE_FORM_CURRENCY]    = !empty( $_POST[Affiliates_CF7::USE_FORM_CURRENCY] );
				$options[Affiliates_CF7::USAGE_STATS]          = !empty( $_POST[Affiliates_CF7::USAGE_STATS] );
			}
			update_option( Affiliates_CF7::PLUGIN_OPTIONS, $options );
		}

		$referral_rate = isset( $options[Affiliates_CF7::REFERRAL_RATE] ) ? $options[Affiliates_CF7::REFERRAL_RATE] : Affiliates_CF7::REFERRAL_RATE_DEFAULT;

		$included_forms    = isset( $options[Affiliates_CF7::INCLUDED_FORMS] ) ? $options[Affiliates_CF7::INCLUDED_FORMS] : array();
		$excluded_forms    = isset( $options[Affiliates_CF7::EXCLUDED_FORMS] ) ? $options[Affiliates_CF7::EXCLUDED_FORMS] : array();
		$petition_forms    = isset( $options[Affiliates_CF7::PETITION_FORMS] ) ? $options[Affiliates_CF7::PETITION_FORMS] : array();
		$currency          = isset( $options[Affiliates_CF7::CURRENCY] ) ? $options[Affiliates_CF7::CURRENCY] : Affiliates_CF7::DEFAULT_CURRENCY;

		$use_form_amount      = isset( $options[Affiliates_CF7::USE_FORM_AMOUNT] ) ? $options[Affiliates_CF7::USE_FORM_AMOUNT] : Affiliates_CF7::DEFAULT_USE_FORM_AMOUNT;
		$use_form_base_amount = isset( $options[Affiliates_CF7::USE_FORM_BASE_AMOUNT] ) ? $options[Affiliates_CF7::USE_FORM_BASE_AMOUNT] : Affiliates_CF7::DEFAULT_USE_FORM_BASE_AMOUNT;
		$use_form_currency    = isset( $options[Affiliates_CF7::USE_FORM_CURRENCY] ) ? $options[Affiliates_CF7::USE_FORM_CURRENCY] : Affiliates_CF7::DEFAULT_USE_FORM_CURRENCY;

		$usage_stats = isset( $options[Affiliates_CF7::USAGE_STATS] ) ? $options[Affiliates_CF7::USAGE_STATS] : Affiliates_CF7::USAGE_STATS_DEFAULT;

		echo '<div>';
		echo '<h2>';
		esc_html_e( 'Contact Form 7 Integration Settings', 'affiliates-contact-form-7' );
		echo '</h2>';
		echo '</div>';

		echo '<form action="" name="options" method="post">';
		echo '<div>';

		echo '<h3>' . esc_html__( 'Forms', 'affiliates-contact-form-7' ) . '</h3>';
		echo '<p class="description">' . esc_html__( 'By default, form submissions on all Contact Form 7 forms will originate referrals.', 'affiliates-contact-form-7' ) . '</p>';
		echo '<p class="description">' . esc_html__( 'If you only want specific forms to originate referrals, or if you want to exclude some forms from originating referrals, input their form ids in the fields below.', 'affiliates-contact-form-7' ) . '</p>';
		echo '<p class="description">' . wp_kses( __( 'The id of a form is the <b>X</b> that can be found in the Contact Form 7 shortcode [contact-form-7 id="<b>X</b>" title="Form title"]', 'affiliates-contact-form-7' ), array( 'b' => array() ) ) . '</p>';
		echo '<p class="description">' . esc_html__( 'Separate form ids by comma.', 'affiliates-contact-form-7' ) . '</p>';

		echo '<h4>' . esc_html__( 'Included forms', 'affiliates-contact-form-7' ) . '</h4>';
		echo '<p>';
		echo '<label>';
		echo esc_html__( 'Included form ids', 'affiliates-contact-form-7' );
		echo ' ';
		echo '<input style="width:40em" name="' . esc_attr( Affiliates_CF7::INCLUDED_FORMS ) . '" type="text" value="' . esc_attr( implode( ',', $included_forms ) ) . '" />';
		echo '</label>';
		echo '</p>';

		echo '<h4>' . esc_html__( 'Excluded forms', 'affiliates-contact-form-7' ) . '</h4>';
		echo '<p>';
		echo '<label>';
		echo esc_html__( 'Excluded form ids', 'affiliates-contact-form-7' );
		echo ' ';
		echo '<input style="width:40em" name="' . esc_attr( Affiliates_CF7::EXCLUDED_FORMS ) . '" type="text" value="' . esc_attr( implode( ',', $excluded_forms ) ) . '" />';
		echo '</label>';
		echo '</p>';

		echo '<h4>' . esc_html__( 'Petition forms', 'affiliates-contact-form-7' ) . '</h4>';
		echo '<p>';
		echo '<label>';
		echo esc_html__( 'Petition form ids', 'affiliates-contact-form-7' );
		echo ' ';
		echo '<input style="width:40em" name="' . esc_attr( Affiliates_CF7::PETITION_FORMS ) . '" type="text" value="' . esc_attr( implode( ',', $petition_forms ) ) . '" />';
		echo '</label>';
		echo '</p>';
		echo '<p class="description">';
		echo esc_html__( 'Petition forms allow affiliates to submit referrals directly. Include form ids of those forms which should credit referrals directly to the affiliate who submits the form.', 'affiliates-contact-form-7' );
		echo '</p>';

		echo '<h3>' . esc_html__( '推薦率', 'affiliates-contact-form-7' ) . '</h3>';
		if ( class_exists( 'Affiliates_Referral' ) ) {
			echo '<p>';
			echo wp_kses( __( 'The referral rate settings are as determined in <strong>Affiliates > Settings</strong>.', 'affiliates-contact-form-7' ), array( 'strong' => array() ) );
			echo '</p>';
		} else {
			echo '<p>';
			echo '<label for="' . esc_attr( Affiliates_CF7::REFERRAL_RATE ) . '">' . esc_html__( 'Referral rate', 'affiliates-contact-form-7' ) . '</label>';
			echo '&nbsp;';
			echo '<input name="' . esc_attr( Affiliates_CF7::REFERRAL_RATE ) . '" type="text" value="' . esc_attr( $referral_rate ) . '"/>';
			echo '</p>';
			echo '<p>';
			echo esc_html__( 'The referral rate determines the referral amount (or commission) calculated from the base amount.', 'affiliates-contact-form-7' );
			echo '</p>';
			echo '<p class="description">';
			echo wp_kses( __( 'Example: Set the referral rate to <strong>0.1</strong> if you want your affiliates to get a <strong>10%</strong> commission on each referral.', 'affiliates-contact-form-7' ), array( 'strong' => array() ) );
			echo '</p>';
		}

		echo '<h3>' . esc_html__( 'Referral amount and currency', 'affiliates-contact-form-7' ) . '</h3>';

		echo '<h4>' . esc_html__( 'Default currency', 'affiliates-contact-form-7' ) . '</h4>';
		echo '<p>';
		echo '<label>' . esc_html__( 'Currency', 'affiliates-contact-form-7' ) . '</label>';
		echo ' ';
		echo '<select name="' . esc_attr( Affiliates_CF7::CURRENCY ) . '">';
		foreach ( Affiliates_CF7::$supported_currencies as $cid ) {
			$selected = ( $currency == $cid ) ? ' selected="selected" ' : '';
			echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $cid ) . '">' . esc_attr( $cid ) . '</option>';
		}
		echo '</select>';
		echo '</p>';

		echo '<h4>' . esc_html__( 'Form amount (base)', 'affiliates-contact-form-7' ) . '</h4>';
		echo '<p>';
		echo '<label>';
		echo '<input name="' . esc_attr( Affiliates_CF7::USE_FORM_BASE_AMOUNT ) . '" type="checkbox" ' . ( $use_form_base_amount ? ' checked="checked" ' : '' ) . ' />';
		echo ' ';
		echo wp_kses( __( "Use the amount provided by the form's <b>base-amount</b> field.", 'affiliates-contact-form-7' ), array( 'b' => array() ) );
		echo '</label>';
		echo '</p>';
		echo '<p class="description">' . wp_kses( __( 'This will assign a referral amount (commission) resulting from the calculation based on the form field named <b>base-amount</b>.', 'affiliates-contact-form-7' ), array( 'b' => array() ) ) . '</p>';

		echo '<h4>' . esc_html__( 'Form amount (fixed)', 'affiliates-contact-form-7' ) . '</h4>';
		echo '<p>';
		echo '<label>';
		echo '<input name="' . esc_attr( Affiliates_CF7::USE_FORM_AMOUNT ) . '" type="checkbox" ' . ( $use_form_amount ? ' checked="checked" ' : '' ) . ' />';
		echo ' ';
		echo wp_kses( __( "Use the amount provided by the form's <b>amount</b> field.", 'affiliates-contact-form-7' ), array( 'b' => array() ) );
		echo '</label>';
		echo '</p>';
		echo '<p class="description">' . wp_kses( __( 'If you want to have the referral amount provided through a form, add a field to your form named <b>amount</b>.', 'affiliates-contact-form-7' ), array( 'b' => array() ) ) . '</p>';

		echo '<h4>' . esc_html__( 'Form currency', 'affiliates-contact-form-7' ) . '</h4>';
		echo '<p>';
		echo '<label>';
		echo '<input name="' . esc_attr( Affiliates_CF7::USE_FORM_CURRENCY ) . '" type="checkbox" ' . ( $use_form_currency ? ' checked="checked" ' : '' ) . ' />';
		echo ' ';
		echo wp_kses( __( 'Use the currency code provided by the form\'s <b>currency</b> field.', 'affiliates-contact-form-7' ), array( 'b' => array() ) );
		echo '</label>';
		echo '</p>';
		echo '<p class="description">' . wp_kses( __( 'If you want to have the referral in a currency other than the default currency, add a field to your form named <b>currency</b>. The value of that field must be a three-letter currency code of those selectable for the default currency.', 'affiliates-contact-form-7' ), array( 'b' => array() ) ) . '</p>';

		echo '<h3>' . esc_html__( 'Notifications', 'affiliates-contact-form-7' ) . '</h3>';

		if ( !class_exists( 'Affiliates_Notifications' ) ) {
			echo '<p class="">';
			echo wp_kses( __( 'Notifications require <a href="https://www.itthinx.com/shop/affiliates-pro/" target="_blank">Affiliates Pro</a> or <a href="https://www.itthinx.com/shop/affiliates-enterprise/" target="_blank">Affiliates Enterprise</a>', 'affiliates-contact-form-7' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) );
			echo  '</p>';
		} else {

			echo '<p class="description">';
			echo sprintf( wp_kses( __( 'The settings for <a href="%s">Notifications</a> apply.', 'affiliates-contact-form-7' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( admin_url( 'admin.php?page=affiliates-admin-notifications' ) ) );
			echo '</p>';

			echo '<p>';
			echo wp_kses( __( '<b>Contact Form 7</b> field names can also be used as tokens. The tokens are replaced by the text or values that have been submitted through a form.', 'affiliates-contact-form-7' ), array( 'b' => array() ) );
			echo '</p>';
			echo '<p>';
			echo wp_kses( __( 'For example, assuming you have a text field in your form named <b>your-name</b> and the field is represented by the code <b>[text your-name]</b> in your form, you can use <b>[your-name]</b> in the notification email subject and message body.', 'affiliates-contact-form-7' ), array( 'b' => array() ) );
			echo '</p>';
			echo '<p>';
			echo esc_html__( 'Text form fields and the values submitted through fields of other types (e.g. checkbox, select, ...) are represented in a consistent manner when supported.', 'affiliates-contact-form-7' );
			echo '</p>';
		}

		echo '<h3>' . esc_html__( 'Usage stats', 'affiliates-contact-form-7' ) . '</h3>';
		echo '<p>';
		echo '<label>';
		echo '<input name="' . esc_attr( Affiliates_CF7::USAGE_STATS ) . '" type="checkbox" ' . ( $usage_stats ? ' checked="checked" ' : '' ) . '/>';
		echo ' ';
		echo esc_html__( 'Allow the plugin to provide usage stats.', 'affiliates-contact-form-7' );
		echo '</label>';
		echo '</p>';
		echo '<p class="description">' . esc_html__( 'This will allow the plugin to help in computing how many installations are actually using it. No personal or site data is transmitted, this simply embeds an icon on the bottom of the Affiliates admin pages, so that the number of visits to these can be counted. This is useful to help prioritize development.', 'affiliates-contact-form-7' ) . '</span>';
		echo '</p>';

		echo '<p>';
		echo wp_nonce_field( self::SET_ADMIN_OPTIONS, self::NONCE, true, false );
		echo '<input type="submit" name="submit" value="' . esc_attr__( 'Save', 'affiliates-contact-form-7' ) . '" class="button button-primary" />';
		echo '</p>';

		echo '</div>';
		echo '</form>';

		affiliates_footer();
	}

	/**
	 * Add a notice to the footer that the integration is active.
	 *
	 * @param string $footer
	 */
	public static function affiliates_footer( $footer ) {
		$options = get_option( Affiliates_CF7::PLUGIN_OPTIONS , array() );
		$usage_stats   = isset( $options[Affiliates_CF7::USAGE_STATS] ) ? $options[Affiliates_CF7::USAGE_STATS] : Affiliates_CF7::USAGE_STATS_DEFAULT;

		$output = '';

		$output .= '<div style="font-size:0.9em">';
		$output .= '<p>';
		$image_html = $usage_stats ? "<img src='https://www.itthinx.com/img/affiliates-contact-form-7/affiliates-contact-form-7.png' alt=''/>" : '';
		$output .= wp_kses( $image_html, array( 'img' => array( 'src' => array(), 'alt' => array() ) ) );
		$output .= wp_kses(
			sprintf(
				__( 'Affiliates Contact Form 7 integration by <a href="%s" target="_blank">itthinx.com</a>', 'affiliates-contact-form-7' ),
				'https://www.itthinx.com/shop/'
			),
			array( 'a' => array( 'href' => array(), 'target' => array() ) )
		);
		$output .= '</p>';
		$output .= '</div>';
		return $output . $footer;
	}

}
Affiliates_CF7_Admin::init();
