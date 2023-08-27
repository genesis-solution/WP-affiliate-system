<?php

namespace WP_Social\Lib\Login;

defined('ABSPATH') || exit;

class Line_App {

    private $client_id;

    private $client_secret;

    public function __construct() {
        $saved_settings = \WP_Social\App\Settings::get_login_settings_data();
        if (!empty($saved_settings['lineapp'])) {
           $this->client_id = $saved_settings['lineapp']['id'];
           $this->client_secret = $saved_settings['lineapp']['secret'];
        }
    }

    public function get_auth_url($redirect_uri) {
        return "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=" . $this->client_id . "&redirect_uri=" . $redirect_uri . "&state=12345abcde&scope=profile%20openid%20email";
    }

    public function get_id_token($code) {
        $redirect_uri = get_site_url() . '/wp-json/wslu-social-login/type/lineapp';

        $response = wp_remote_post(
            'https://api.line.me/oauth2/v2.1/token',
            array(
                'method'      => 'POST',
                'body'        => array(
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $redirect_uri,
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                )
            )
        );

        if (is_wp_error($response)) {
            return $response->get_error_message();
        }
        return json_decode($response['body']);
    }

    public function get_user_info($code) {

        $id_token = $this->get_id_token($code);

        $response = wp_remote_post(
            'https://api.line.me/oauth2/v2.1/verify',
            array(
                'method'        => 'POST',
                'body'          => array(
                    'client_id' => $this->client_id,
                    'id_token'  => $id_token->id_token,
                )
            )
        );

        if (is_wp_error($response)) {
            return $response->get_error_message();
        }
        return json_decode($response['body']);
    }
}
