<?php

use WP_Social\App\Settings;

defined('ABSPATH') || exit;

/**
 * Variable Name : $getLogoutUrl;
 * Variable Details : User logout and redirect current url
 *
 * @params : String() $_GET['XScurrentPageLog']. Get data from URL
 *
 * @since : 1.0
 */
if(isset($_GET['loggedout']) && isset($_GET['XScurrentPageLog'])) {
	$getLogoutUrl = sanitize_url($_GET['XScurrentPageLog']);

	if(wp_redirect($getLogoutUrl)) {
		exit;
	}
}

/**
 * Function Name : xs_current_url_custom();
 * Function Details : Set current url with HTTPS | HTTP.
 *
 * @params : void
 *
 * @return : String() Current URL when Current URL != base URL
 *
 * @since : 1.0
 */
if(!function_exists('xs_current_url_custom')) {
	function xs_current_url_custom() {
		$current_url = (isset($_SERVER['HTTPS']) && sanitize_text_field($_SERVER['HTTPS']) === 'on' ? 'https' : 'http') . '://' . sanitize_text_field($_SERVER['HTTP_HOST']) . sanitize_url($_SERVER['REQUEST_URI']);
		if(get_site_url() . '/' === $current_url) {
			$current_url = '';
		}

		return trim($current_url);
	}
}

/**
 * Function Name : xs_create_dynamic_shortcode();
 * Function Details : Create shortcode dynamic . if you provide or not
 *
 * @params : String $atts. if you provide Exam: provider="facebook,twitter,github"
 * @params : String $btn-text. if you provide Exam: btn-text="Login with Facebook"
 * @params : String $class Set Class. class="test-class"
 *
 * @return : String Output
 *
 * @since : 1.0
 */
if(!function_exists('xs_create_dynamic_shortcode')) {

	function xs_create_dynamic_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'provider' => 'all',
				'btn-text' => $content,
				'class'    => '',
				'style'    => '',
			), $atts, 'xs_social_login'
		);

		$str = empty($atts['provider']) ? 'all' : str_replace(' ', '', $atts['provider']);

		$providers = explode(',', $str);

		return xs_social_login_shortcode_widget($providers, $atts['btn-text'], 'show', $atts['class'], $atts['style']);
	}
}

/**
 * Function Name : xs_social_login_shortcode_widget();
 * Function Details : Create shortcode button from template page .
 *
 * @params : String $atts. if you provide Exam: provider="facebook,twitter,github"
 * @params : String $btn_content. if you provide Exam: btn-text="Login with Facebook"
 * @params : String $typeCurrent. Current URL add or remove from redirect URL
 * @params : String $className Set Class. class="test-class"
 *
 * @return : String Output of button
 *
 * @since : 1.0
 */
if(!function_exists('xs_social_login_shortcode_widget')) {

	function xs_social_login_shortcode_widget($attr_provider, $btn_content = null, $typeCurrent = 'show', $className = '', $force_style = '') {

		$provider_data = \WP_Social\App\Settings::get_login_settings_data();
		$style_data = get_option('xs_style_setting_data', []);

		ob_start();
		require(WSLU_LOGIN_PLUGIN . '/template/login/login-btn-html.php');
		$buttonData = ob_get_contents();
		ob_end_clean();
		
		return $buttonData;
	}
}

/**
 * Function Name : xs_my_login_stylesheet();
 * Function Details : Added style and script page in wp-login.php page
 *
 * @params : void
 *
 * @return : link page
 *
 * @since : 1.0
 */
if(!function_exists('xs_my_login_stylesheet')) {
	function xs_my_login_stylesheet() {
		wp_enqueue_script('xs_login_custom_login_js', WSLU_LOGIN_PLUGIN_URL . 'assets/js/login-page/font-login-page.js', ['jquery']);
	}
}


if(!function_exists('xs_my_global_stylesheet')) {

	function xs_my_global_stylesheet() {
		wp_enqueue_style('xs-front-style', WSLU_LOGIN_PLUGIN_URL . 'assets/css/frontend.css', [], WSLU_VERSION);

		wp_enqueue_style('xs_login_font_login_css', WSLU_LOGIN_PLUGIN_URL . 'assets/css/font-icon.css', [], WSLU_VERSION);
		wp_enqueue_script('xs_front_main_js', WSLU_LOGIN_PLUGIN_URL . 'assets/js/front-main.js', ['jquery'],  WSLU_VERSION);

		$data['rest_url'] = get_rest_url();
		$data['nonce'] = wp_create_nonce('wp_rest');
		$data['insta_enabled'] = Settings::instance()->load()->is_instagram_counter_enabled();

		wp_localize_script('xs_front_main_js', 'rest_config', $data);
	}
}

