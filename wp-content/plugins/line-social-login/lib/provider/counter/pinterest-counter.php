<?php

namespace WP_Social\Lib\Provider\Counter;

class Pinterest_Counter extends Counter {

	public static $provider_key = 'pinterest';

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

		if(empty($this->global_options['username'])) {

			/**
			 * Client does not set up his credential, so just show defaults value
			 */

			return empty($this->global_options['data']['value']) ? 0 : $this->global_options['data']['value'];
		}

		/**
		 * At this point client has set up his credentials and want to grab show actual values
		 *
		 */
		$username = $this->global_options['username'];
		$tran_key = self::get_transient_key($username);
		$result   = 0;
		$trans_value = get_transient($tran_key);

		if(false === $trans_value) {

			/**
			 * Either key is not exists or value is expired!
			 *
			 */


			try {

				/**
				 * todo - For now previous code is working, so why bother writing new codes :P
				 */
				$url = 'https://www.pinterest.com/'.trim($username);
				$html = xsc_remote_get($url, false);
				$prev = libxml_use_internal_errors(true);
				$doc  = new \DOMDocument();
				@$doc->loadHTML($html);
				libxml_use_internal_errors($prev);

				$metas = $doc->getElementsByTagName('meta');

				for($i = 0; $i < $metas->length; $i++) {
					$meta = $metas->item($i);
					if($meta->getAttribute('name') == 'pinterestapp:followers') {
						$result = $meta->getAttribute('content');
						break;
					}
				}

				/**
				 * Updating transient cache
				 */

				$expiration_time = empty($global_cache_time) ? 43200: intval($global_cache_time);

				set_transient($tran_key, $result, $expiration_time);
				update_option(self::get_last_cache_key(), time());

			} catch(Exception $e) {

				/**
				 * todo - AR; need to get confirmation what shoud we do in case there are errors from Product Owner
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