<?php

namespace WP_Social\App;

defined('ABSPATH') || exit;

class Settings {

	public static $ok_counter_cached_data = 'xs_counter_options';
	public static $ok_global_counter_setting = 'xs_counter_global_setting_data';
	public static $ok_counter_provider_setting = 'xs_counter_providers_data';
	public static $ok_enabled_providers_counter = 'xs_providers_enabled_counter';
	public static $ok_enabled_providers_login = 'xs_providers_enabled_login';
	public static $ok_enabled_providers_share = 'xs_providers_enabled_share';
	public static $ok_login_settings_data = 'xs_provider_data';

	private static $instance;

	private $enabled_providers_login;
	private $enabled_providers_counter;
	private $enabled_providers_share;
	private $share_style_settings;
	private $share_main_settings;
	private $provider_settings_share;
	private $provider_settings_counter;
	private $provider_settings_login;


	public static function instance() {
		if(!self::$instance) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	/**
	 * todo - we will finish it later
	 *
	 */
	public function load() {

		$enabled_counters = get_option(Settings::$ok_enabled_providers_counter, []);

		/**
		 * This is just for legacy support for future version
		 * After 3/4 version we can safely assumes all of our client has updated the plugin to at least this version
		 *
		 */
		if(empty($enabled_counters)) {

			$old_settings = get_option(self::$ok_counter_provider_setting, []);

			if(!empty($old_settings['social'])) {

				$tmp = [];

				foreach($old_settings['social'] as $key => $info) {

					$tmp[$key]['enable'] = empty($info['enable']) ? '' : 1;
				}

				update_option(Settings::$ok_enabled_providers_counter, $tmp);

				$enabled_counters = $tmp;
			}
		}

		$this->enabled_providers_counter = $enabled_counters;


		return $this;
	}

	public function load_share_style_settings() {

		if(empty($this->share_style_settings)) {

			$this->share_style_settings = get_option('xs_style_setting_data_share', []);
		}

		return $this;
	}

	public function load_share_main_settings() {

		if(empty($this->share_main_settings)) {

			$this->share_main_settings = get_option('xs_share_global_setting_data', []);
		}

		return $this;
	}

	protected function load_enabled_providers_share() {

		if(empty($this->enabled_providers_share)) {

			$this->enabled_providers_share = self::get_enabled_provider_conf_share();
		}

		return $this;
	}

	public function get_enabled_providers_share() {

		return $this->load_enabled_providers_share()->enabled_providers_share;
	}

	public function get_providers_settings_share() {

		if(empty($this->provider_settings_share)) {

			$this->provider_settings_share = get_option('xs_share_providers_data', []);
		}

		return $this->provider_settings_share;
	}

	public function get_providers_settings_counter() {

		if(empty($this->provider_settings_share)) {

		}

		return $this->provider_settings_share;
	}

	public function get_providers_settings_login() {

		if(empty($this->provider_settings_share)) {

		}

		return $this->provider_settings_share;
	}


	public function get_share_style_settings() {

		return $this->load_share_style_settings()->share_style_settings;
	}

	public function get_share_main_settings() {

		return $this->load_share_main_settings()->share_main_settings;
	}

	/**
	 * Alias of get_providers_settings_share
	 *
	 * @return mixed
	 */
	public function get_share_provider_settings() {

		return $this->get_providers_settings_share();
	}

	public function update_share_provider_settings($val) {

		update_option('xs_share_providers_data', $val, true);

		$this->provider_settings_share = $val;

		return $this;
	}


	public function is_instagram_counter_enabled() {

		return !empty($this->enabled_providers_counter['instagram']['enable']);
	}


	/**
	 * Return caching time in seconds as set in global counter settings
	 *
	 * @return int
	 */
	public static function get_counter_cache_time() {

		$opt = get_option(self::$ok_global_counter_setting, []);

		return empty($opt['global']['cache']) ? 12 * 3600 : intval(floatval($opt['global']['cache']) * 3600);
	}


	public static function get_counter_provider_settings() {

		$opt = get_option(self::$ok_counter_provider_setting, []);

		return empty($opt['social']) ? [] : $opt['social'];
	}

	public static function get_counter_provider_conf() {

		$opt = get_option(self::$ok_counter_provider_setting, []);

		return $opt;
	}

	public static function update_counter_provider_conf($val) {

		return update_option(self::$ok_counter_provider_setting, $val);
	}


	public static function get_enabled_provider_conf_counter() {

		$opt = get_option(self::$ok_enabled_providers_counter, []);

		return $opt;
	}

	public static function update_enabled_provider_conf_counter($val) {

		return update_option(self::$ok_enabled_providers_counter, $val);
	}

	public static function get_enabled_provider_conf_login() {

		$opt = get_option(self::$ok_enabled_providers_login, []);

		return $opt;
	}

	public static function update_enabled_provider_conf_login($val) {

		return update_option(self::$ok_enabled_providers_login, $val);
	}

	public static function get_enabled_provider_conf_share() {

		$opt = get_option(self::$ok_enabled_providers_share, []);

		return $opt;
	}

	public static function update_enabled_provider_conf_share($val) {

		return update_option(self::$ok_enabled_providers_share, $val);
	}

	public static function get_counter_cached_data() {

		$opt = get_option(self::$ok_counter_cached_data, []);

		return empty($opt['data']) ? [] : $opt['data'];
	}

	public static function get_login_settings_data() {

		return get_option(self::$ok_login_settings_data, []);
	}

	public static function has_number_content_in_selected_style($selected_share_style, $all_style) {

		return !empty($all_style[$selected_share_style]['content']['number']);
	}

	public static function has_text_content_in_selected_style($selected_share_style, $all_style) {

		return !empty($all_style[$selected_share_style]['content']['text']);
	}

	public static function has_label_content_in_selected_style($selected_share_style, $all_style) {

		return !empty($all_style[$selected_share_style]['content']['label']);
	}


	public static function get_extra_data_class($selected_share_style, $all_style) {

		return empty($all_style[$selected_share_style]['content']) ? 'wslu-no-extra-data' : 'wslu-extra-data';
	}


	public static function get_hash($url = '') {

		return md5($url);
	}

	public static function get_old_count($key) {

		return apply_filters('wp_social_pro/provider/share/old_count', 0, $key);
	}
}
