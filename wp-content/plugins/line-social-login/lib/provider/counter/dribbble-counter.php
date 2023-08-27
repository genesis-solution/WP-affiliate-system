<?php

namespace WP_Social\Lib\Provider\Counter;


class Dribbble_Counter extends Counter {

	public static $provider_key = 'dribbble';

	private $global_options;

	public function need_to_call_legacy_function() {

		return false;
	}

	public static function get_transient_key($user = '') {

		return '_xs_social_'.self::$provider_key.'_count_';
	}


	public static function get_transient_timeout_key() {

		return 'timeout_' . self::get_transient_key();
	}


	public static function get_last_cache_key() {

		return '_xs_social_'.self::$provider_key.'_last_cached';
	}


	public function set_config_data($conf_array) {

		$this->global_options = $conf_array;

		return $this;
	}


	/**
	 *
	 * @param int $global_cache_time - default is 12 hours
	 * @return mixed
	 */
	public function get_count($global_cache_time = 43200) {

		if(empty($this->global_options['api'])) {

			/**
			 * Client does not set up his credential, so just show defaults value
			 */

			return empty($this->global_options['data']['value']) ? 0 : $this->global_options['data']['value'];
		}

		/**
		 * At this point client has set up his credentials and want to grab show actual values
		 *
		 */
		$tran_key = self::get_transient_key();
		$trans_value = get_transient($tran_key);


		if(false === $trans_value) {

			try {

				$token  = get_option('xs_counter_dribbble_token', '') ;

				$data   = xsc_remote_get('https://api.dribbble.com/v2/user?access_token='.$token);

				$result = isset($data['followers_count']) ? intval($data['followers_count']) : 0;

				$home_url = isset($data['html_url']) ? $data['html_url'] : 'https://dribbble.com/';

				$expiration_time = empty($global_cache_time) ? 43200: intval($global_cache_time);

				set_transient($tran_key, $result, $expiration_time);
				update_option('home_url_dribbble_count', $home_url);
				update_option(self::get_last_cache_key(), time());

			} catch(Exception $e) {

				/**
				 * todo - AR; need to get confirmation what should we do in case there are errors from Product Owner
				 * for now returning 0;
				 *
				 */
				$result = 0;
			}

			return $result;
		}

		return $trans_value;
	}
}