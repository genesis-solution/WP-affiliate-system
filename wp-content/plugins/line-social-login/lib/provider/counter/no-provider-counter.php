<?php

namespace WP_Social\Lib\Provider\Counter;


class No_Provider_Counter extends Counter {

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

		return true;
	}


	public function set_config_data($conf_array) {

		return $this;
	}


	public function get_count($global_cache_time = 43200) {

		/**
		 * This is just dummy
		 *
		 */

		return 0;
	}
}