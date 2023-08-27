<?php

namespace WP_Social\App;

defined('ABSPATH') || exit;

class Legacy {

	public function __construct() {

		$this->clone_enabled_provider_share();

	}


	public function clone_enabled_provider_share() {

		$enabled_providers = Settings::instance()->get_enabled_providers_share();

		if(empty($enabled_providers)) {

			$old = Settings::instance()->get_share_provider_settings();
			$tmp = [];

			if(empty($old)) {

				$core_provider = Providers::get_core_providers_share();

				foreach($core_provider as $key => $item) {
					$tmp[$key]['enable'] = '';
				}

				$settings['social'] = $tmp;

				Settings::instance()->update_share_provider_settings($settings);

				return true;
			}


			foreach($old['social'] as $key => $item) {
				$tmp[$key]['enable'] = empty($item['enable']) ? '' : 1;
			}

			$settings['social'] = $tmp;

			Settings::instance()->update_share_provider_settings($settings);

			return true;
		}

		return true;
	}
}