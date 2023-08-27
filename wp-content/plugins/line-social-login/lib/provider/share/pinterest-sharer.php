<?php

namespace WP_Social\Lib\Provider\Share;

use WP_Social\App\Settings;

defined('ABSPATH') || exit;

class Pinterest_Sharer extends Sharer {


	/**
	 *
	 * @param int $global_cache_time
	 * @return int
	 */
	public function get_count($global_cache_time = 43200) {

		/**
		 * For now we are returning the default set value
		 * todo - give check for required info for calling api, if not found then return the default value
		 */


		if(!empty($this->global_options['enable'])) {

			$tran_key = $this->get_transient_key();
			$trans_value = get_transient($tran_key);

			if(true || false === $trans_value) {

				$set = Settings::instance()->get_providers_settings_share();

				$result = empty($set['social'][$this->key]['data']['value']) ? 0 : intval($set['social'][$this->key]['data']['value']);

				$expiration_time = empty($global_cache_time) ? 43200 : intval($global_cache_time);

				set_transient($tran_key, $result, $expiration_time);

				return $result;
			}

			return $trans_value;
		}

		return 0;
	}
}