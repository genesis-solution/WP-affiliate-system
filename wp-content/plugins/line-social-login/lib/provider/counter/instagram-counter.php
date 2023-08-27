<?php

namespace WP_Social\Lib\Provider\Counter;

class Instagram_Counter extends Counter {

	public static $provider_key = 'instagram';

	private $global_options;


	public function need_to_call_legacy_function() {

		return false;
	}


	public static function get_transient_key() {

		return '_xs_social_instagram_count_';
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

	public function get_cached_count() {

		return $this->get_count($this->cache_time);
	}

	/**
	 * todo - move it to parent class and make it available for all
	 *
	 */
	public function get_default_fan_count() {

		return empty($this->global_options['data']['value']) ? 0 : $this->global_options['data']['value'];
	}

	public function get_count($global_cache_time = 43200) {

		if(empty($this->global_options['access_token']) || empty($this->global_options['user_name']) || empty($this->global_options['user_id'])) {

			/**
			 * Client does not set up his access token, so just show defaults value
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

			$access_token = $this->global_options['access_token'];
			$user_id = $this->global_options['user_id'];
			$username = $this->global_options['user_name'];

			$url='https://graph.facebook.com/v11.0/'.$user_id.'?fields=business_discovery.username('.$username.'){username,follows_count,followers_count}&access_token=' . $access_token .'';

			try {

				$get_request = wp_remote_get($url, array('timeout' => 40, 'sslverify' => false,));

				if(is_wp_error($get_request)) {

					$result = -1;

				} else {

					$body = wp_remote_retrieve_body($get_request);
					$dt   = json_decode($body);

					/**
					 * todo - this is a temporary fix for immediate release
					 */
					if(!empty($dt->error)) {

						$result = $this->get_default_fan_count();

					} else {

						$result = empty($dt['business_discovery']['followers_count']) ? 0 : intval($dt['business_discovery']['followers_count']);
					}
				}

				$expiration_time = empty($global_cache_time) ? 43200: intval($global_cache_time);

				set_transient($tran_key, $result, $expiration_time);
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
