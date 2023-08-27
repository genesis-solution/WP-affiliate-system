<?php

namespace WP_Social\Lib\Provider\Counter;


class Comments_Counter extends Counter {

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
		$comments_count = wp_count_comments();

		return empty($this->global_options['data']['value']) ? $comments_count->approved : $this->global_options['data']['value'];
	}
}