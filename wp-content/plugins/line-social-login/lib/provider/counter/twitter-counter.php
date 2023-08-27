<?php

namespace WP_Social\Lib\Provider\Counter;


class Twitter_Counter extends Counter {

	public static $provider_key = 'twitter';

	private $global_options;

	public function need_to_call_legacy_function() {

		return false;
	}

	public static function get_transient_key($user = '') {

		return '_xs_social_'.self::$provider_key.'_count_'.trim($user);
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

		if(empty($this->global_options['id']) || empty($this->global_options['api'])) {

			/**
			 * Client does not set up his credential, so just show defaults value
			 */

			return empty($this->global_options['data']['value']) ? 0 : $this->global_options['data']['value'];
		}

		/**
		 * At this point client has set up his credentials and want to grab show actual values
		 *
		 */
		$username = $this->global_options['id'];
		$tran_key = self::get_transient_key($username);
		$result   = 0;
		$trans_value = get_transient($tran_key);

		if(false === $trans_value) {

			try {

				$token = get_option('xs_counter_twitter_token', '');

				$args = array(
					'httpversion' => '1.1',
					'blocking'    => true,
					'timeout'     => 10,
					'headers'     => array(
						'Authorization'   => "Bearer $token",
						'Accept-Language' => 'en',
					),
				);
	
				add_filter('https_ssl_verify', '__return_false');
				$api_url  = 'https://api.twitter.com/1.1/users/show.json?screen_name='.$username;
				$response = xsc_remote_get($api_url, true, $args);
	
				/**
				 * We will show actual count always if user gives the access token
				 * even if it is 0!
				 */
				if(isset($response['followers_count'])) {
					$result = intval($response['followers_count']);
				}

				$expiration_time = empty($global_cache_time) ? 43200: intval($global_cache_time);

				set_transient($tran_key, $result, $expiration_time);				

				update_option(self::get_last_cache_key(), time());

			} catch(\Exception $ex) {

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