<?php

namespace WP_Social\Lib\Provider\Counter;


class Facebook_Counter extends Counter {

	public static $provider_key = 'facebook';

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

		if(empty($this->global_options['id'])) {

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

				$get_request = wp_remote_get("https://www.facebook.com/plugins/likebox.php?href=https://facebook.com/$username&show_faces=true&header=false&stream=false&show_border=false&locale=en_US", array('timeout' => 20));
				$the_request = wp_remote_retrieve_body($get_request);

				$pattern = '/_1drq[^>]+>(.*?)<\/a/s';
				preg_match($pattern, $the_request, $matches);

				if(!empty($matches[1])) {

					$number = strip_tags($matches[1]);
					$result = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
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
