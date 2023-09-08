<?php
/**
 * affiliates-cf7.php
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
 * Plugin main class.
 */
class Affiliates_CF7 {

	const PLUGIN_OPTIONS = 'affiliates_cf7';

	const NONCE = 'aff_cf7_admin_nonce';
	const SET_ADMIN_OPTIONS = 'set_admin_options';

	const REFERRAL_TYPE = 'contact';

	// currency
	const DEFAULT_CURRENCY = 'USD';
	const CURRENCY = 'currency';

	/**
	 * Supported currencies array (overr
	 *
	 * @var array
	 */
	public static $supported_currencies = array(
		// Australian Dollar
		'AUD',
		// Brazilian Real
		'BRL',
		// Canadian Dollar
		'CAD',
		// Czech Koruna
		'CZK',
		// Danish Krone
		'DKK',
		// Euro
		'EUR',
		// Hong Kong Dollar
		'HKD',
		// Hungarian Forint
		'HUF',
		// Israeli New Sheqel
		'ILS',
		// Japanese Yen
		'JPY',
		// Malaysian Ringgit
		'MYR',
		// Mexican Peso
		'MXN',
		// Norwegian Krone
		'NOK',
		// New Zealand Dollar
		'NZD',
		// Philippine Peso
		'PHP',
		// Polish Zloty
		'PLN',
		// Pound Sterling
		'GBP',
		// Singapore Dollar
		'SGD',
		// Swedish Krona
		'SEK',
		// Swiss Franc
		'CHF',
		// Taiwan New Dollar
		'TWD',
		// Thai Baht
		'THB',
		// Turkish Lira
		'TRY',
		// U.S. Dollar
		'USD'
	);

	// forms
	const INCLUDED_FORMS = 'included_forms';
	const EXCLUDED_FORMS = 'excluded_forms';
	const PETITION_FORMS = 'petition_forms';

	const USE_FORM_AMOUNT = 'use_form_amount';
	const DEFAULT_USE_FORM_AMOUNT = false;
	const USE_FORM_BASE_AMOUNT = 'use_form_base_amount';
	const DEFAULT_USE_FORM_BASE_AMOUNT = false;
	const USE_FORM_CURRENCY = 'use_form_currency';
	const DEFAULT_USE_FORM_CURRENCY = false;

	// email
	const SUBJECT = 'subject';
	const DEFAULT_SUBJECT = 'Form submission referral';
	const MESSAGE = 'message';
	const DEFAULT_MESSAGE =
		"A referral has been created for a form submission on <a href='[site_url]'>[site_title]</a>.<br/>
		<br/>
		Greetings,<br/>
		[site_title]<br/>
		[site_url]
		";

	const NOTIFY_ADMIN             = 'notify_admin';
	const NOTIFY_AFFILIATE         = 'notify_affiliate';
	const NOTIFY_ADMIN_DEFAULT     = true;
	const NOTIFY_AFFILIATE_DEFAULT = true;

	const REFERRAL_RATE         = 'referral-rate';
	const REFERRAL_RATE_DEFAULT = '0';
	const USAGE_STATS           = 'usage_stats';
	const USAGE_STATS_DEFAULT   = true;

	const AUTO_ADJUST_DEFAULT = true;

	const RATE_ADJUSTED = 'rate-adjusted';

	/**
	 * Admin messages
	 *
	 * @var array
	 */
	private static $admin_messages = array();

	/**
	 * Activation handler.
	 */
	public static function activate() {
		$options = get_option( self::PLUGIN_OPTIONS , '' );
		if ( $options === null ) {
			$options = array();
			// add the options and there's no need to autoload these
			add_option( self::PLUGIN_OPTIONS, $options, '', 'no' );
		}
	}

	/**
	 * Prints admin notices.
	 */
	public static function admin_notices() {
		if ( !empty( self::$admin_messages ) ) {
			foreach ( self::$admin_messages as $msg ) {
				echo wp_kses( $msg, array(
					'a'      => array( 'href' => array(), 'target' => array(), 'title' => array() ),
					'br'     => array(),
					'div'    => array( 'class' => array() ),
					'em'     => array(),
					'p'      => array( 'class' => array() ),
					'strong' => array()
				));
			}
		}
	}

	/**
	 * Initializes the integration if dependencies are verified.
	 */
	public static function init() {
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'plugins_loaded' ) );
		if ( is_admin() ) {
			include_once 'class-affiliates-cf7-admin.php';
		}
	}

	/**
	 * Loads classes.
	 */
	public static function wp_init() {
		if ( self::check_dependencies() ) {
			register_activation_hook( __FILE__, array( __CLASS__, 'activate' ) );
		}
	}

	/**
	 * @since 5.2.1
	 */
	public static function plugins_loaded() {
		if ( self::check_dependencies() ) {
			if ( class_exists( 'Affiliates' ) ) {
				self::$supported_currencies = apply_filters( 'affiliates_cf7_currencies', Affiliates::$supported_currencies );
			}
			sort( self::$supported_currencies );
			if (
				defined( 'AFFILIATES_EXT_VERSION' ) &&
				version_compare( AFFILIATES_EXT_VERSION, '3.0.0' ) >= 0 &&
				class_exists( 'Affiliates_Referral' ) &&
			(
				!defined( 'Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY' ) ||
				!get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY, null )
				)
			) {
				include_once 'class-affiliates-cf7-handler.php';
			} else {
				include_once 'class-affiliates-cf7-handler-legacy.php';
			}
		}
	}

	/**
	 * Check dependencies and print notices if they are not met.
	 *
	 * @return true if ok, false if plugins are missing
	 */
	public static function check_dependencies() {

		$result = true;

		$active_plugins = get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$active_sitewide_plugins = get_site_option( 'active_sitewide_plugins', array() );
			$active_sitewide_plugins = array_keys( $active_sitewide_plugins );
			$active_plugins = array_merge( $active_plugins, $active_sitewide_plugins );
		}

		// required plugins
		$affiliates_is_active =
			in_array( 'affiliates/affiliates.php', $active_plugins ) ||
			in_array( 'affiliates-pro/affiliates-pro.php', $active_plugins ) ||
			in_array( 'affiliates-enterprise/affiliates-enterprise.php', $active_plugins );
		if ( !$affiliates_is_active ) {
			self::$admin_messages[] =
				"<div class='error'>" .
				__( 'The <strong>Affiliates Contact Form 7 Integration</strong> plugin requires an appropriate Affiliates plugin: <a href="https://www.itthinx.com/plugins/affiliates" target="_blank">Affiliates</a>, <a href="https://www.itthinx.com/shop/affiliates-pro/" target="_blank">Affiliates Pro</a> or <a href="https://www.itthinx.com/shop/affiliates-enterprise/" target="_blank">Affiliates Enterprise</a>.', 'affiliates-contact-form-7' ) .
				'</div>';
		}
		// $cf7_is_active = in_array( 'contact-form-7/wp-contact-form-7.php', $active_plugins );
		// if ( !$cf7_is_active ) {
		// self::$admin_messages[] =
		// "<div class='error'>" .
		// __( 'The <strong>Affiliates Contact Form 7 Integration</strong> plugin requires <a href="https://wordpress.org/plugins/contact-form-7" target="_blank">Contact Form 7</a>.', 'affiliates-contact-form-7' ) .
		// "</div>";
		// }
		// if ( !$affiliates_is_active || !$cf7_is_active ) {
		// $result = false;
		// }
		if ( !$affiliates_is_active ) {
			$result = false;
		}

		// deactivate the old plugin
		$affiliates_cf7_is_active = in_array( 'affiliates-cf7/affiliates-cf7.php', $active_plugins );
		if ( $affiliates_cf7_is_active ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
			if ( function_exists( 'deactivate_plugins' ) ) {
				deactivate_plugins( 'affiliates-cf7/affiliates-cf7.php' );
				self::$admin_messages[] =
					"<div class='error'>" .
					__( 'The <strong>Affiliates Contact Form 7 Integration</strong> plugin version 3 and above replaces the former integration plugin (version number below 3.x).<br/>The former plugin has been deactivated and can now be deleted.', 'affiliates-contact-form-7' ) .
					'</div>';
			} else {
				self::$admin_messages[] =
				"<div class='error'>" .
				__( 'The <strong>Affiliates Contact Form 7 Integration</strong> plugin version 3 and above replaces the former integration plugin with an inferior version number.<br/><strong>Please deactivate and delete the former integration plugin with version number below 3.x.</strong>', 'affiliates-contact-form-7' ) .
				'</div>';
			}
		}

		return $result;
	}

}
Affiliates_CF7::init();
