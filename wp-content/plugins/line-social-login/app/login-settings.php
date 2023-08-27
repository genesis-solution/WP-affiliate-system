<?php

namespace WP_Social\App;

use WP_Social\Traits\Singleton;

defined('ABSPATH') || exit;

class Login_Settings {

	use Singleton;

	const OK_GLOBAL             = 'xs_global_setting_data';
	const OK_STYLES             = 'xs_style_setting_data';
	const OK_PROVIDER           = 'xs_provider_data';
	const OK_PROVIDER_ENABLED   = 'xs_providers_enabled_login';


	private $global;
	private $providers;
	private $enabled;
	private $styles;

	public function __construct() {

		$this->global    = get_option(self::OK_GLOBAL, []);
		$this->enabled   = get_option(self::OK_PROVIDER_ENABLED, []);
		$this->providers = get_option(self::OK_PROVIDER, []);
		$this->styles    = get_option(self::OK_STYLES, []);
	}


	public static function get_login_styles() {

		$free_styles = [
			'style-1' => [
				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-1.png',
				'title'   => __('Icon with providers label', 'wp-social'),
				'package' => 'free',
				'unlocked' => true,
			],
			'style-2' => [
				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-2.png',
				'title'   => __('Only social icon', 'wp-social'),
				'package' => 'free',
				'unlocked' => true,
			],
			'style-3' => [
				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-3.png',
				'title'   => __('Only providers label', 'wp-social'),
				'package' => 'free',
				'unlocked' => true,
			],
		];

		if(\WP_Social::is_pro_active()) {

			return apply_filters('wp_social_pro/login/styles/pro_design', $free_styles);
		}

		$pro_only = [
			'style-4'  => [
				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-4-pro.png',
				'title'   => __('Icon Overlay', 'wp-social'),
				'package' => 'pro',
				'unlocked' => false,
			],
			'style-5'  => [
				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-5-pro.png',
				'title'   => __('Left Slide', 'wp-social'),
				'package' => 'pro',
				'unlocked' => false,
			],
			'style-6'  => [
				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-6-pro.png',
				'title'   => __('Circle Blow', 'wp-social'),
				'package' => 'pro',
				'unlocked' => false,
			],

//			'style-7'  => [
//				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-7-pro.png',
//				'title'   => 'Left Slide Overlay',
//				'package' => 'pro',
//				'unlocked' => false,
//			],
//			'style-8'  => [
//				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-8-pro.png',
//				'title'   => 'Circle Line Icon',
//				'package' => 'pro',
//				'unlocked' => false,
//			],
//			'style-9'  => [
//				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-9-pro.png',
//				'title'   => 'Slide to arrow',
//				'package' => 'pro',
//				'unlocked' => false,
//			],
//			'style-10' => [
//				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-10-pro.png',
//				'title'   => 'Stroke right radius',
//				'package' => 'pro',
//				'unlocked' => false,
//			],
//			'style-11' => [
//				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-11-pro.png',
//				'title'   => 'Gradient Icon',
//				'package' => 'pro',
//				'unlocked' => false,
//			],
//			'style-12' => [
//				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-12-pro.png',
//				'title'   => 'Box Style',
//				'package' => 'pro',
//				'unlocked' => false,
//			],
//			'style-13' => [
//				'image'   => WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/login/style-13-pro.png',
//				'title'   => 'Drop icon',
//				'package' => 'pro',
//				'unlocked' => false,
//			],
		];

		return array_merge($free_styles, $pro_only);
	}


	public function load() {

		if(empty($this->global)) {
			$this->global = get_option(self::OK_GLOBAL, []);
		}

		if(empty($this->enabled)) {
			$this->enabled = get_option(self::OK_PROVIDER_ENABLED, []);
		}

		if(empty($this->providers)) {
			$this->providers = get_option(self::OK_PROVIDER, []);
		}

		if(empty($this->styles)) {
			$this->styles = get_option(self::OK_STYLES, []);
		}

		return $this;
	}


	public function get_enabled_providers() {

		return $this->enabled;
	}


	public function update_enabled_providers($val) {

		$this->enabled = $val;

		update_option(self::OK_PROVIDER_ENABLED, $val, true);

		return $this;
	}


	public function get_provider_settings() {

		return $this->providers;
	}


	public function update_provider_settings($val) {

		$this->providers = $val;

		update_option(self::OK_PROVIDER, $val, true);

		return $this;
	}


	public function get_style_settings() {

		return $this->styles;
	}


	public function update_style_settings($val) {

		$this->styles = $val;

		update_option(self::OK_STYLES, $val, true);

		return $this;
	}


	public function get_global_settings() {

		return $this->global;
	}


	public function update_global_settings($val) {

		$this->global = $val;

		update_option(self::OK_GLOBAL, $val, true);

		return $this;
	}


	public function is_custom_url_enabled() {

		return !empty($this->global['custom_login_url']['enable']);
	}


	public function get_custom_url() {

		return empty($this->global['custom_login_url']['data']) ? '#' : $this->global['custom_login_url']['data'];
	}


	public function is_login_page_login_button_enabled() {

		return !empty($this->global['wp_login_page']['enable']);
	}


	public function get_selected_style() {

		return empty($this->styles['login_button_style']) ? 'style-1' : $this->styles['login_button_style'];
	}
}
