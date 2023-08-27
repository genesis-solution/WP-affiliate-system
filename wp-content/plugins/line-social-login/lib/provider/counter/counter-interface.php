<?php

namespace WP_Social\Lib\Provider\Counter;


interface Counter_Interface {

	public static function get_transient_key();

	public static function get_transient_timeout_key();

	public static function get_last_cache_key();

	public function need_to_call_legacy_function();

	public function set_config_data($conf_array);

	public function get_count($global_cache_time = 43200);

	public function get_cached_count();

	public static function get_last_cache_time();

	public static function get_cache_time_verbose();
}
