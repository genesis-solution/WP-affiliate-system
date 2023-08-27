<?php 

namespace WP_Social\Lib\Provider\Share;

defined('ABSPATH') || exit;

class No_Provider_Share extends Sharer {

    public function get_count($global_cache_time = 43200) {

		/**
		 * This is just dummy
		 *
		 */

		return 0;
	}
}