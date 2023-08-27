<?php

namespace WP_Social\Lib\Provider\Counter;


class Youtube_Counter extends Counter {

	public static $provider_key = 'youtube';

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

		if(empty($this->global_options['id']) || empty($this->global_options['key'])) {

			/**
			 * Client does not set up his credential, so just show defaults value
			 */

			return empty($this->global_options['data']['value']) ? 0 : $this->global_options['data']['value'];
		}

		$username = $this->global_options['id'];
		$api_key = $this->global_options['key'];
		$type = $this->global_options['type'];

		$tran_key = self::get_transient_key(md5($type.$username));
		$trans_value = get_transient($tran_key);

		if(false === $trans_value) {

			try {

				if($type == 'Channel') {
					$url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.trim($username).'&key='.trim($api_key);
				} else {
					$url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername='.trim($username).'&key='.trim($api_key);
				}

				$data = xsc_remote_get($url);

				$subscriber = empty($data['items'][0]['statistics']['subscriberCount']) ? 0 : intval($data['items'][0]['statistics']['subscriberCount']);
				//$videos = empty($data['items'][0]['statistics']['videoCount']) ? 0 : intval($data['items'][0]['statistics']['videoCount']);
				//$views = empty($data['items'][0]['statistics']['viewCount']) ? 0 : intval($data['items'][0]['statistics']['viewCount']);


				/**
				 * Updating transient cache
				 */

				$expiration_time = empty($global_cache_time) ? 43200: intval($global_cache_time);

				set_transient($tran_key, $subscriber, $expiration_time);

				update_option(self::get_last_cache_key(), time());
				
			} catch(Exception $e) {

				/**
				 * todo - AR; need to get confirmation what shoud we do in case there are errors from Product Owner
				 * for now returning 0;
				 *
				 */
				$subscriber = 0;
			}

			return $subscriber;
		}

		return $trans_value;
	}
}