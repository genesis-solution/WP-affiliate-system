<?php

namespace WP_Social\Lib\Counter;


class Instagram_Counter {

	public $enabled = false;

	/**
	 * If user id is empty then expired is false
	 * if transient time is less than time then it is true
	 *
	 * @var bool
	 */
	public $cache_expired = false;

	public $user_id = '';

	private $debug = '';


	public function load() {

		$opt = get_option('xs_counter_providers_data', []);

		if(!empty($opt['social']['instagram']['enable'])) {

			$this->enabled = true;

			if(!empty($opt['social']['instagram']['id'])) {

				$this->user_id = $opt['social']['instagram']['id'];

				$get_transient_time = get_transient(self::get_transient_timeout_key());

				$this->cache_expired = $get_transient_time < time();
			}

			/**
			 * Also set the def value and label and etc etc, if needed
			 */
		}
	}



	public static function get_last_cache_key() {

		return '_xs_social_instagram_last_cached';
	}

	public static function get_transient_key() {

		return '_xs_social_instagram_count_';
	}


	public static function get_transient_timeout_key() {

		return 'timeout_' . self::get_transient_key();
	}


	public static function is_expired() {

		$opt = get_option('xs_counter_providers_data', []);


		$get_transient_time = get_transient(self::get_transient_timeout_key());

		return $get_transient_time < time();
	}


	public static function get_user_id() {

		$xsc_options_save = get_option('xs_counter_providers_data', []);

		return empty($xsc_options_save['social']['instagram']['id']) ? '' : $xsc_options_save['social']['instagram']['id'];
	}


	/**
	 *
	 * @param $count
	 * @param int $expire - we will cache this for given amount of second
	 *
	 * @return bool
	 */
	public function cache_instagram_return($count, $expire = 86400) {

		$tran_key = self::get_transient_key();

		$conf['followed_by'] = $count;
		$conf['fetch_time'] = time();


		/**
		 * If every thing goes okay
		 */
		set_transient($tran_key, $conf, $expire);

		update_option(self::get_last_cache_key(), $count);

		return true;
	}


	function get_count($user_id) {

		$url = 'https://www.instagram.com/' . $user_id . '/?__a=1';

		try {
			$request = wp_remote_get($url);

			if(!is_wp_error($request)) {

				$body = wp_remote_retrieve_body($request);
				$dt   = json_decode($body);
			}

		} catch(\Exception $ex) {

		}
	}


	/**
	 * @return string
	 */
	public function getDebug() {
		return $this->debug;
	}

}