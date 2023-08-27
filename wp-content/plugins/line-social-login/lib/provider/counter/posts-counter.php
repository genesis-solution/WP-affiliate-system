<?php

namespace WP_Social\Lib\Provider\Counter;


class Posts_Counter extends Counter {

	private $global_options;

	public static function get_transient_key() {

		return '';
	}

	public static function get_transient_timeout_key() {

		return '';
	}

	public static function get_last_cache_key() {
		return '';
	}

	public function need_to_call_legacy_function() {

		return false;
	}


	public function set_config_data($conf_array) {

		$this->global_options = $conf_array;

		return $this;
	}


	public function get_count($global_cache_time = 43200) {

		/**
		 * Here if there is no default value then show actual value!
		 */
		$count_posts = wp_count_posts();

		return empty($this->global_options['data']['value']) ? $count_posts->publish : $this->global_options['data']['value'];
	}
}