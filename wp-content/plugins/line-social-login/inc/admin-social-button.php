<?php

defined('ABSPATH') || exit;

/**
 * Class Name : xs_button_in_login_page;
 * Class Details : this class for showing login button in login and register page for wp, woocommerce, buddyPress and others
 *
 * @params : void
 * @return : void
 *
 * @since : 1.0
 */
class xs_button_in_login_page {

	/**
	 * Method Name : xs_addLoginButton
	 * Method Details : added social button with hide Current URL
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public static function xs_addLoginButton() {
		echo xs_social_login_shortcode_widget(['all'], '', 'hide'); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ignoring due to shortcode
	}

	/**
	 * Method Name : xs_addLoginButton_on
	 * Method Details : added social button with Show Current URL
	 *
	 * @params : void
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public static function xs_addLoginButton_on() {
		echo xs_social_login_shortcode_widget(['all'], '', 'show'); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ignoring due to shortcode
	}

	/**
	 * Method Name : xs_login_form_login_wp
	 * Method Details : For added social button in wp-login page
	 *
	 * @params : String $type.
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public static function xs_login_form_login_wp($type = 'login_form') {

		add_action('login_enqueue_scripts', 'xs_my_global_stylesheet');

		switch($type):
			case 'login_form':
				add_action('login_enqueue_scripts', 'xs_my_login_stylesheet');
				add_filter('login_form', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'login_footer':
				add_filter('login_footer', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'login_head_top':
				//add_action( 'login_enqueue_scripts', 'xs_my_login_stylesheet' );
				add_filter('login_head', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'login_form_middle':
				add_filter('login_form_middle', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'login_form_bottom':
				add_filter('login_form_bottom', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'login_head':
				add_filter('login_head', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'login_message':
				add_filter('login_message', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			default:
				add_action('login_enqueue_scripts', 'xs_my_login_stylesheet');
				add_filter('login_form', 'xs_button_in_login_page::xs_addLoginButton');
				break;
		endswitch;

	}

	/**
	 * Method Name : xs_login_form_register_wp
	 * Method Details : For added social button in wp-register page
	 *
	 * @params : String $type.
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public static function xs_login_form_register_wp($type = 'register_form') {

		add_action('login_enqueue_scripts', 'xs_my_global_stylesheet');

		switch($type):
			case 'register_form':
				add_filter('register_form', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'register_head':
				add_action('login_enqueue_scripts', 'xs_my_login_stylesheet');
				add_filter('register_form', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'register_footer':
				add_filter('login_footer', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			default:
				add_filter('register_form', 'xs_button_in_login_page::xs_addLoginButton');
				break;
		endswitch;

	}

	/**
	 * Method Name : xs_login_form_login_wp
	 * Method Details : For added social button in wp-login page
	 *
	 * @params : String $type.
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public static function wfp_login_form_login_wp($type = 'wfp_login_form_end') {
		add_action('login_enqueue_scripts', 'xs_my_global_stylesheet');
		switch($type):
			case 'wfp_login_form_before_outer':
				//add_action( 'login_enqueue_scripts', 'xs_my_login_stylesheet' );
				add_action('wfp_login_form_before_outer', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'wfp_login_form_after_outer':
				//add_action( 'login_enqueue_scripts', 'xs_my_login_stylesheet' );
				add_action('wfp_login_form_after_outer', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'wfp_login_form_before_inner':
				//add_action( 'login_enqueue_scripts', 'xs_my_login_stylesheet' );
				add_action('wfp_login_form_before_inner', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'wfp_login_form_after_inner':
				add_action('wfp_login_form_after_inner', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'wfp_login_form_start':
				add_action('wfp_login_form_start', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'wfp_login_form_end':
				add_action('wfp_login_form_end', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'wfp_login_form_button_before':
				add_action('wfp_login_form_button_before', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'wfp_login_form_button_after':
				add_action('wfp_login_form_button_after', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'wfp_login_form_message':
				add_action('wfp_login_form_message', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			default:
				//add_action( 'login_enqueue_scripts', 'xs_my_login_stylesheet' );
				add_filter('wfp_login_form_button_after', 'xs_button_in_login_page::xs_addLoginButton');
				break;
		endswitch;

	}

	/**
	 * Method Name : xs_login_form_comment_wp
	 * Method Details : For added social button in wp-comment page
	 *
	 * @params : String $type.
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public static function xs_login_form_comment_wp($type = 'comment_form_top') {

		switch($type):
			case 'comment_form_top':
				add_filter('comment_form_top', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			case 'comment_form_must_log_in_after':
				add_filter('comment_form_must_log_in_after', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;

			default:
				add_filter('comment_form_top', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;

		endswitch;


	}


	/**
	 * Method Name : xs_login_form_login_woo
	 * Method Details : For added social button in woocommerce login form page
	 *
	 * @params : String $type.
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public static function xs_login_form_login_woo($type = 'woocommerce_login_form') {

		switch($type):
			case 'woocommerce_register_form':
				add_filter('woocommerce_register_form', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			case 'woocommerce_register_form_start':
				add_filter('woocommerce_register_form_start', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			case 'woocommerce_register_form_end':
				add_filter('woocommerce_register_form_end', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			case 'woocommerce_login_form':
				add_filter('woocommerce_login_form', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			case 'woocommerce_login_form_start':
				add_filter('woocommerce_login_form_start', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			case 'woocommerce_login_form_end':
				add_filter('woocommerce_login_form_end', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			case 'woocommerce_before_checkout_billing_form':
				add_filter('woocommerce_before_checkout_billing_form', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			case 'woocommerce_after_checkout_billing_form':
				add_filter('woocommerce_after_checkout_billing_form', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
			default :
				add_filter('woocommerce_login_form', 'xs_button_in_login_page::xs_addLoginButton_on');
				break;
		endswitch;

	}


	/**
	 * Method Name : xs_login_form_login_buddy
	 * Method Details : For added social button in BuddyPress form page
	 *
	 * @params : String $type.
	 * @return : void
	 *
	 * @since : 1.0
	 */
	public static function xs_login_form_login_buddy($type = 'bp_before_register_page') {

		switch($type):
			case 'bp_before_register_page':
				add_filter('bp_before_register_page', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'bp_before_account_details_fields':
				add_filter('bp_before_account_details_fields', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			case 'bp_after_register_page':
				add_filter('bp_after_register_page', 'xs_button_in_login_page::xs_addLoginButton');
				break;
			default:
				add_filter('bp_before_register_page', 'xs_button_in_login_page::xs_addLoginButton');
				break;

		endswitch;


	}


}

if(class_exists('xs_button_in_login_page')) {

	// action hooks for load global css file
	add_action('wp_enqueue_scripts', 'xs_my_global_stylesheet');
	/**
	 * Variable Name : $xs_login_admin_page
	 * Variable Type : Array
	 * @return : array() $xs_login_admin_page .  Get array from socail global setting data "xs_global_setting_data"
	 *
	 * @since : 1.0
	 */
	$xs_login_admin_page = get_option('xs_global_setting_data');

	/**
	 * Variable Name : $enable_woocmarce_login
	 * Variable Type : int()
	 * @return : int $enable_woocmarce_login Enable 0,1
	 *
	 * @since : 1.0
	 */
	$enable_woocmarce_login = isset($xs_login_admin_page['woocommerce_login_page']['enable']) ? $xs_login_admin_page['woocommerce_login_page']['enable'] : 0;
	if($enable_woocmarce_login) {
		$enable_woocmarce_login_type = isset($xs_login_admin_page['woocommerce_login_page']['data']) ? $xs_login_admin_page['woocommerce_login_page']['data'] : 'woocommerce_login_form_end';
		xs_button_in_login_page::xs_login_form_login_woo($enable_woocmarce_login_type);
	}
	/**
	 * Variable Name : $enable_woocmarce_register
	 * Variable Type : int()
	 * @return : int $enable_woocmarce_register Enable 0,1
	 *
	 * @since : 1.0
	 */
	$enable_woocmarce_register = isset($xs_login_admin_page['woocommerce_register_page']['enable']) ? $xs_login_admin_page['woocommerce_register_page']['enable'] : 0;
	if($enable_woocmarce_register) {
		$enable_woocmarce_register_type = isset($xs_login_admin_page['woocommerce_register_page']['data']) ? $xs_login_admin_page['woocommerce_register_page']['data'] : 'woocommerce_register_form_end';
		xs_button_in_login_page::xs_login_form_login_woo($enable_woocmarce_register_type);
	}
	/**
	 * Variable Name : $enable_woocmarce_billing
	 * Variable Type : int()
	 * @return : int $enable_woocmarce_billing Enable 0,1
	 *
	 * @since : 1.0
	 */
	$enable_woocmarce_billing = isset($xs_login_admin_page['woocommerce_billing_page']['enable']) ? $xs_login_admin_page['woocommerce_billing_page']['enable'] : 0;
	if($enable_woocmarce_billing) {
		$enable_woocmarce_billing_type = isset($xs_login_admin_page['woocommerce_billing_page']['data']) ? $xs_login_admin_page['woocommerce_billing_page']['data'] : 'woocommerce_after_checkout_billing_form';
		xs_button_in_login_page::xs_login_form_login_woo($enable_woocmarce_billing_type);
	}
	/**
	 * Variable Name : $enable_wp_login
	 * Variable Type : int()
	 * @return : int $enable_wp_login Enable 0,1
	 *
	 * @since : 1.0
	 */
	$enable_wp_login = isset($xs_login_admin_page['wp_login_page']['enable']) ? $xs_login_admin_page['wp_login_page']['enable'] : 0;
	if($enable_wp_login) {
		$enable_wp_login_type = isset($xs_login_admin_page['wp_login_page']['data']) ? $xs_login_admin_page['wp_login_page']['data'] : 'login_form';
		xs_button_in_login_page::xs_login_form_login_wp($enable_wp_login_type);
	}

	/**
	 * Variable Name : $enable_wp_register
	 * Variable Type : int()
	 * @return : int $enable_wp_register Enable 0,1
	 *
	 * @since : 1.0
	 */
	$enable_wp_register = isset($xs_login_admin_page['wp_register_page']['enable']) ? $xs_login_admin_page['wp_register_page']['enable'] : 0;
	if($enable_wp_register) {
		//xs_button_in_login_page::$showFilter = 'hide';
		$enable_wp_register_type = isset($xs_login_admin_page['wp_register_page']['data']) ? $xs_login_admin_page['wp_register_page']['data'] : 'register_form';
		xs_button_in_login_page::xs_login_form_register_wp($enable_wp_register_type);
	}

	/**
	 * Variable Name : $enable_wfp_login
	 * Variable Type : int()
	 * @return : int $enable_wp_register Enable 0,1
	 *
	 * @since : 1.0
	 */
	$enable_wfp_login = isset($xs_login_admin_page['wfp_fund_login_page']['enable']) ? $xs_login_admin_page['wfp_fund_login_page']['enable'] : 0;
	if($enable_wfp_login) {
		$enable_wfp_login_type = isset($xs_login_admin_page['wfp_fund_login_page']['data']) ? $xs_login_admin_page['wfp_fund_login_page']['data'] : 'wfp_login_form_end';
		xs_button_in_login_page::wfp_login_form_login_wp($enable_wfp_login_type);
	}

	/**
	 * Variable Name : $enable_wp_comment
	 * Variable Type : int()
	 * @return : int $enable_wp_comment Enable 0,1
	 *
	 * @since : 1.0
	 */
	$enable_wp_comment = isset($xs_login_admin_page['wp_comment_page']['enable']) ? $xs_login_admin_page['wp_comment_page']['enable'] : 0;
	if($enable_wp_comment) {
		$enable_wp_comment_type = isset($xs_login_admin_page['wp_comment_page']['data']) ? $xs_login_admin_page['wp_comment_page']['data'] : 'comment_form_top';
		xs_button_in_login_page::xs_login_form_comment_wp($enable_wp_comment_type);
	}


	/**
	 * Variable Name : $enable_buddyPress_register
	 * Variable Type : int()
	 * @return : int $enable_buddyPress_register Enable 0,1
	 *
	 * @since : 1.0
	 */
	$enable_buddyPress_register = isset($xs_login_admin_page['buddypress_page']['enable']) ? $xs_login_admin_page['buddypress_page']['enable'] : 0;
	if($enable_buddyPress_register) {
		$enable_buddyPress_register_type = isset($xs_login_admin_page['buddypress_page']['data']) ? $xs_login_admin_page['buddypress_page']['data'] : 'bp_before_register_page';
		xs_button_in_login_page::xs_login_form_login_buddy($enable_buddyPress_register_type);
	}

}
