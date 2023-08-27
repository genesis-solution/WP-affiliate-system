<?php
/**
 * class-affiliates-settings-integrations.php
 *
 * Copyright (c) 2010 - 2015 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates
 * @since affiliates 2.8.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Integration section.
 */
class Affiliates_Settings_Integrations extends Affiliates_Settings {

	private static $integrations = null;
	private static $premium_integrations = null;

	public static function init() {
		self::$integrations =  array(
			'affiliates-woocommerce-light' => array(
				'title'        => __( 'WooCommerce (light)', 'affiliates' ),
				'plugin_title' => __( 'Affiliates WooCommerce Integration Light', 'affiliates' ),
				'plugin_url'   => 'https://wordpress.org/plugins/affiliates-woocommerce-light/',
				'description'  => sprintf(
					__( 'This plugin integrates <a href="%s">Affiliates</a> with <a href="%s">WooCommerce</a>. With this integration plugin, referrals are created automatically for your affiliates when sales are made.', 'affiliates' ),
					'https://wordpress.org/plugins/affiliates/',
					'https://woocommerce.com/?aff=7223&cid=1656523'
				),
				'plugin_file'  => 'affiliates-woocommerce-light/affiliates-woocommerce-light.php',
				'notes'        => __( 'This light integration is suitable to be used with the <a href="https://wordpress.org/plugins/affiliates/">Affiliates</a> plugin.', 'affiliates' ),
				'repository'   => 'wordpress',
				'access'       => 'free',
				'targets'      => array( 'affiliates' ),
				'platforms'    => array( 'woocommerce' )
			),
			'affiliates-contact-form-7' => array(
				'title'        => __( 'Contact Form 7', 'affiliates' ),
				'plugin_title' => __( 'Affiliates Contact Form 7 Integration', 'affiliates' ),
				'plugin_url'   => 'https://wordpress.org/plugins/affiliates-contact-form-7/',
				'description'  => __( 'This plugin integrates <a href="https://wordpress.org/plugins/affiliates/">Affiliates</a>, <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with Contact Form 7. This integration stores data from submitted forms and tracks form submissions to the referring affiliate.', 'affiliates' ),
				'plugin_file'  => 'affiliates-contact-form-7/affiliates-contact-form-7.php',
				'notes'        => '',
				'repository'   => 'wordpress',
				'access'       => 'free',
				'targets'      => array( 'affiliates', 'my affiliate pro', 'affiliates-enterprise' ),
				'platforms'    => array( 'contact-form-7' )
			),
			'affiliates-events-manager' => array(
				'title'        => __( 'Events Manager', 'affiliates' ),
				'plugin_title' => __( 'Affiliates Events Manager Integration', 'affiliates' ),
				'plugin_url'   => 'https://wordpress.org/plugins/affiliates-events-manager/',
				'description'  => __( 'This plugin integrates <a href="https://wordpress.org/plugins/affiliates/">Affiliates</a>, <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with Events Manager. This integration allows to record referrals to grant affiliates commissions on referred bookings.', 'affiliates' ),
				'plugin_file'  => 'affiliates-events-manager/affiliates-events-manager.php',
				'notes'        => '',
				'repository'   => 'wordpress',
				'access'       => 'free',
				'targets'      => array( 'affiliates', 'my affiliate pro', 'affiliates-enterprise' ),
				'platforms'    => array( 'events-manager' )
			),
			'affiliates-formidable' => array(
				'title'        => __( 'Formidable Forms', 'affiliates' ),
				'plugin_title' => __( 'Affiliates Formidable Forms Integration', 'affiliates' ),
				'plugin_url'   => 'https://wordpress.org/plugins/affiliates-formidable/',
				'description'  => __( 'This plugin integrates <a href="https://wordpress.org/plugins/affiliates/">Affiliates</a>, <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with Formidable Forms. Affiliates can sign up through forms handled with Formidable Forms. Form submissions that are referred through affiliates, can grant commissions to affiliates and record referral details.', 'affiliates' ),
				'plugin_file'  => 'affiliates-formidable/affiliates-formidable.php',
				'notes'        => '',
				'repository'   => 'wordpress',
				'access'       => 'free',
				'targets'      => array( 'affiliates', 'my affiliate pro', 'affiliates-enterprise' ),
				'platforms'    => array( 'formidable' )
			),
			'affiliates-ninja-forms' => array(
				'title'        => __( 'Ninja Forms', 'affiliates' ),
				'plugin_title' => __( 'Affiliates Ninja Forms Integration', 'affiliates' ),
				'plugin_url'   => 'https://wordpress.org/plugins/affiliates-ninja-forms/',
				'description'  => __( 'This plugin integrates <a href="https://wordpress.org/plugins/affiliates/">Affiliates</a>, <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with Ninja Forms. Affiliates can sign up through forms handled with Ninja Forms. Form submissions that are referred through affiliates, can grant commissions to affiliates and record referral details.', 'affiliates' ),
				'plugin_file'  => 'affiliates-ninja-forms/affiliates-ninja-forms.php',
				'notes'        => '',
				'repository'   => 'wordpress',
				'access'       => 'free',
				'targets'      => array( 'affiliates', 'my affiliate pro', 'affiliates-enterprise' ),
				'platforms'    => array( 'ninja-forms' )
			),
		);
		self::$integrations = apply_filters( 'affiliates_settings_integrations', self::$integrations );
		self::$premium_integrations = array(
			'affiliates-woocommerce' => array(
				'title'        => __( 'WooCommerce', 'affiliates' ),
				'description'  =>
					sprintf(
						__( 'This plugin integrates <a href="%s">Affiliates Pro</a> and <a href="%s">Affiliates Enterprise</a> with <a href="%s">WooCommerce</a>. With this advanced integration plugin, referrals are created and synchronized automatically for your affiliates when sales are made. This integration also supports referrals on recurring payments related to subscriptions and coupons related to affiliates to grant referrals when customers use them to credit the corresponding affiliate.', 'affiliates' ),
						'https://www.itthinx.com/shop/affiliates-pro/',
						'https://www.itthinx.com/shop/affiliates-enterprise/',
						'https://woocommerce.com/?aff=7223&cid=1656523'
					),
				'notes'        => __( 'This integration is suitable to be used with <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> or <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a>.', 'affiliates' ),
				'class'        => 'ext',
			),
			'affiliates-addtoany' => array(
				'title'        => __( 'AddToAny', 'affiliates' ),
				'description'  => __( 'This plugin integrates <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with <a href="https://www.addtoany.com/">AddToAny</a> &hellip; <em>&ldquo;The Universal Sharing Platform&rdquo;</em>. The <a href="https://wordpress.org/plugins/add-to-any/">Share Buttons by AddToAny</a> are required.', 'affiliates' ),
				'notes'        =>
					__( 'Makes it even easier to share using affiliate links automatically.', 'affiliates' ) .
					' ' .
					__( 'This integration is suitable to be used with <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> or <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a>.', 'affiliates' ),
				'class'        => 'ext'
			),
			'affiliates-addthis' => array(
				'title'        => __( 'AddThis', 'affiliates' ),
				'description'  => __( 'This plugin integrates <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with <a href="https://www.addthis.com/">AddThis</a> &hellip; <em>&ldquo;Website tools that drive more shares, follows and conversions&rdquo;</em>. The <a href="https://wordpress.org/plugins/addthis/">Smart Website Tools</a> by AddThis are required.', 'affiliates' ),
				'notes'        =>
					__( 'Makes it even easier to share using affiliate links automatically.', 'affiliates' ) .
					' ' .
					__( 'This integration is suitable to be used with <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> or <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a>.', 'affiliates' ),
				'class'        => 'ext'
			),
			'affiliates-ppc' => array(
				'title'        => __( 'Pay per Click', 'affiliates' ),
				'description'  => __( 'Pay affiliate commissions based on clicks or visits to affiliate links. This plugin adds the possibility to grant commissions based on Pay per Click, Pay per Visit and Pay per Daily Visit with <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a>.', 'affiliates' ),
				'notes'        => __( 'This integration is suitable to be used with <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> or <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a>.', 'affiliates' ),
				'class'        => 'ext'
			),
			'affiliates-gravityforms' => array(
				'title'        => __( 'Gravity Forms', 'affiliates' ),
				'description'  => __( 'This plugin integrates <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with <a href="https://www.e-junkie.com/ecom/gb.php?cl=54585&c=ib&aff=290919">Gravity Forms</a>.', 'affiliates' ),
				'notes'        =>
					__( 'This extension allows to record referrals for form submissions and to create affiliate accounts (requires the Gravity Forms User Registation Add-On) for new users based on Gravity Forms.', 'affiliates' ) .
					' ' .
					__( 'This integration is suitable to be used with <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> or <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a>.', 'affiliates' ),
				'class'        => 'ext'
			),
			'affiliates-paypal' => array(
				'title'        => __( 'PayPal', 'affiliates' ),
				'description'  =>
					'<strong>' .
					__( 'Discontinued, we recommend to use our WooCommerce integration instead.', 'affiliates' ) .
					'</strong>' .
					' ' .
					__( 'This plugin integrates <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> and <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a> with PayPal Payments Standard. With this advanced integration plugin, referrals are created and synchronized automatically for your affiliates when sales are made.', 'affiliates' ),
				'notes'        => __( 'This integration is suitable to be used with <a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a> or <a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a>. Note that this integration is not intended to be used for e-commerce systems that provide their own PayPal Payments Standard gateway.', 'affiliates' ),
				'class'        => 'ext'
			)
		);
	}

	/**
	 * Returns the registered integrations.
	 *
	 * @return array
	 */
	public static function get_integrations() {
		return self::$integrations;
	}

	/**
	 * Renders the integrations section.
	 */
	public static function section() {

		$output = '';

		echo $output;

		
	}
}
Affiliates_Settings_Integrations::init();
