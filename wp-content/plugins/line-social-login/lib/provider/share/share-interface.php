<?php

namespace WP_Social\Lib\Provider\Share;

defined('ABSPATH') || exit;

interface Share_Interface {

    public function need_to_call_legacy_function();

    public function set_config_data($conf_array = []);

    public function get_count($global_cache_time = 43200);
}