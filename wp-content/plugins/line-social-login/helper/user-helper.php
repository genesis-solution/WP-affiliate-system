<?php

namespace WP_Social\Helper;

use WP_User_Query;

defined('ABSPATH') || exit;

class User_Helper
{
    public static function provider()
    {
        global $wpdb;

        $socials_sql = "SELECT DISTINCT meta_value FROM $wpdb->usermeta WHERE meta_key = 'xs_social_register_by'";

        return $wpdb->get_results($socials_sql);
    }

    public static function export_users_content_csv($type)
    {
        if ($type != 'all') {
            $args_type = array(
                'key'     => 'xs_social_register_by',
                'value'    => $type
            );
        } else {
            $args_type = array(
                'key'     => 'xs_social_register_by',
            );
        }
        $args = array(
            'meta_query' => array($args_type)
        );

        $wp_user_query = new WP_User_Query($args);

        $users = $wp_user_query->get_results();

        $user_table_data = array("ID", "user_login", "user_email", "user_pass", "user_nicename", "user_url", "user_registered", "display_name");

        $data = [];
        $row = [];
        $usermeta = self::get_user_meta_keys();

        foreach ($users as $user) {
            foreach ($user_table_data as $key) {
                $row[$key] = $user->data->{$key};
            }
            $row['role'] = get_userdata($user->data->ID)->roles[0];
            foreach ($usermeta as $key) {
                $row[$key] = self::user_data_filter(get_user_meta($user->data->ID, $key, true));
            }
            $data[] = array_values($row);
        }

        $user_table_data[] = 'role';
        $usernd = array_merge($user_table_data, $usermeta);
        $data = array_merge(array($usernd), $data);

        $upload_dir = wp_upload_dir();

        $csv = $upload_dir['basedir'] . "/users-list.csv";

        $file = fopen($csv, 'w');

        foreach ($data as $line) {
            fputcsv($file, $line, ',');
        }

        fclose($file);

        $fsize = filesize($csv) + 3;
        $path_parts = pathinfo($csv);

        header("Content-type: text/csv;charset=utf-8");
        header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\"");
        header("Content-length: $fsize");

        ob_clean();
        flush();

        // csv encoding format
        echo esc_html("\xEF\xBB\xBF");
        readfile($csv);
        unlink($csv);
    }

    private static function user_data_filter($value)
    {
        if (is_array($value) || is_object($value)) {
            return serialize($value);
        }
        return $value;
    }

    private static function get_user_meta_keys()
    {
        global $wpdb;

        $meta_keys = [];

        $select = "SELECT distinct $wpdb->usermeta.meta_key FROM $wpdb->usermeta";

        $usermeta = $wpdb->get_results($select, ARRAY_A);

        foreach ($usermeta as $key => $value) {
            $meta_keys[] = $value["meta_key"];
        }
        return $meta_keys;
    }
}
