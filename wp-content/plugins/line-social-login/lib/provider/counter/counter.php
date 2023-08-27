<?php

namespace WP_Social\Lib\Provider\Counter;


abstract class Counter implements Counter_Interface {

	protected $cache_time;


	public static function get_last_cache_time() {

		return 	get_option(static::get_last_cache_key(), -1);
	}


	public static function get_cache_time_verbose() {

		$time = self::get_last_cache_time();

		if($time < 0) {

			return __('No cache found', 'wp-social');
		}

		return human_time_diff($time, time()). ' ago';
	}

	public function get_cached_count() {

		return $this->get_count($this->cache_time);
	}

	public function set_cache_time($time) {

		$this->cache_time = $time;
	}
}
