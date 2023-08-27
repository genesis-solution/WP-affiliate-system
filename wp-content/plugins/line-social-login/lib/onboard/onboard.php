<?php

namespace WP_Social\Lib\Onboard;

use WP_Social\App\Login_Settings;
use WP_Social\Lib\Onboard\Classes\Plugin_Data_Sender;
use WP_Social\Plugin;
use WP_Social\Traits\Singleton;

defined('ABSPATH') || exit;

class Onboard {

    use Singleton;
    protected $optionKey = 'wp_social_onboard_status';
    protected $optionValue = 'onboarded';

    const CONTACT_LIST_ID = 4;
    const ENVIRONMENT_ID = 4;

    public function views() {
        ?>
			<div class="metform-onboard-dashboard">
				<div class="metform_container">
					<form action="" method="POST" id="wslu-admin-settings-form">
						<?php include self::get_dir() . 'views/layout-onboard.php';?>
					</form>
				</div>
			</div>
		<?php
	}

    public static function get_dir() {
        return Plugin::instance()->lib_dir() . 'onboard/';
    }

    public static function get_url() {
        return Plugin::instance()->lib_url() . 'onboard/';
    }

    public function init() {

        new Classes\Ajax;

        if (get_option($this->optionKey)) {
            if (isset($_GET['wp-social-met-onboard-steps'])) {
                wp_redirect($this->get_plugin_url());
            }
            return true;
        }

        add_action('wpsocial/admin/after_save', [$this, 'ajax_action']);

        $param = isset($_GET['wp-social-met-onboard-steps']) ? sanitize_text_field($_GET['wp-social-met-onboard-steps']) : null;
        $requestUri = (isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : '') . (isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '');

        if (strpos($requestUri, 'wslu') !== false && is_admin()) {
            if ($param !== 'loaded' && !get_option($this->optionKey)) {
                wp_redirect($this->get_onboard_url());
                exit;
            }
        }

        return true;
    }

    public function ajax_action() {

        $this->finish_onboard();

        if ( isset( $_POST['settings']['tut_term'] ) && sanitize_text_field($_POST['settings']['tut_term']) == 'user_agreed' ) {
             Plugin_Data_Sender::instance()->send( 'diagnostic-data' ); // send non-sensitive diagnostic data and details about plugin usage.
        }

        if ( isset( $_POST['settings']['newsletter_email'] ) && !empty($_POST['settings']['newsletter_email'])) {
            $data = [
                'email'           => sanitize_email($_POST['settings']['newsletter_email']),
                'environment_id'  => Onboard::ENVIRONMENT_ID,
                'contact_list_id' => Onboard::CONTACT_LIST_ID,
            ];

            $response = Plugin_Data_Sender::instance()->sendAutomizyData( 'email-subscribe', $data);
            exit;
        }
    }

    private function get_onboard_url() {
        return add_query_arg(
            array(
                'page'                        => 'wslu_global_setting',
                'wp-social-met-onboard-steps' => 'loaded',
            ),
            admin_url('admin.php')
        );
    }

    public function redirect_onboard() {
        if (is_null(get_option($this->optionKey))) {
            wp_redirect($this->get_onboard_url());
            exit;
        }
    }

    private static function get_plugin_url() {
        return add_query_arg(
            array(
                'page' => 'wslu_global_setting',
            ),
            admin_url('admin.php')
        );
    }

    public function finish_onboard() {

        if(class_exists('\WP_Social_Pro'))  {
        
            $activated_module = [];
            $modules = \WP_Social_Pro\Modules\Manifesto::modules_list();

            foreach ($modules as $key => $value) {
                if (isset($_POST['module_list']) && in_array($key, map_deep( wp_unslash( $_POST['module_list'] ) , 'sanitize_text_field' ))) {
                    $activated_module[$key] = 'yes';
                } else {
                    $activated_module[$key] = 'no';
                }
            }

            update_option(\WP_Social_Pro\Modules\Manifesto::OPTION_KEY_ACTIVE_MODULE_CONF, $activated_module);
        }

        $login_global_settings = get_option(Login_Settings::OK_GLOBAL, []);
		
        foreach (self::settings()['login'] as $key => $value) {
			if (isset($_POST['login']) && array_key_exists($key, map_deep( wp_unslash( $_POST['login'] ) , 'sanitize_text_field' ))) {

				$login_global_settings[$key]['enable'] = 1;
				
                if ($value != 1 && empty($login_global_settings[$key]['data'])) {
					$login_global_settings[$key]['data'] = $value;
                }
            } else {
				$login_global_settings[$key]['enable'] = 0;
            }
        }
		
        update_option(Login_Settings::OK_GLOBAL, $login_global_settings);

        foreach (self::settings()['share'] as $key => $value) {
            switch ($key) {
            case 'show_font_from_theme':

                if (isset($_POST['share']) && array_key_exists($key, map_deep( wp_unslash( $_POST['share'] ) , 'sanitize_text_field' ))) {
                    update_option('xs_share_global_setting_data', ['show_font_from_theme' => 1]);
                } else {
                    update_option('xs_share_global_setting_data', ['show_font_from_theme' => 0]);
                }

                break;
            case 'show_social_count_share':

                $style_setting_data_share = get_option('xs_style_setting_data_share', []);

                if (isset($_POST['share']) && array_key_exists($key, map_deep( wp_unslash( $_POST['share'] ) , 'sanitize_text_field' ))) {
                    $style_setting_data_share['main_content']['show_social_count_share'] = 1;
                    $style_setting_data_share['fixed_display']['show_social_count_share'] = 1;
                } else {
                    $style_setting_data_share['main_content']['show_social_count_share'] = 0;
                    $style_setting_data_share['fixed_display']['show_social_count_share'] = 0;
                }

                update_option('xs_style_setting_data_share', $style_setting_data_share);
                break;
            }
        }

        if (isset($_POST['counter']['show_font_from_theme'])) {
            update_option('xs_counter_global_setting_data', ['show_font_from_theme' => 1]);
        } else {
            update_option('xs_counter_global_setting_data', ['show_font_from_theme' => 0]);
        }

        if (!get_option($this->optionKey)) {
            add_option($this->optionKey, $this->optionValue);
        }
    }

    public static function settings() {
        return [
            'login'   => [
                'wp_login_page'             => [
                    'title' => __('Show button to wp-login page', 'wp-social'),
                    'value' => 'login_form',
                ],
                'email_new_registered_user' => [
                    'title' => __('Email login credentials to a newly-registered user', 'wp-social'),
                    'value' => 1,
                ],
            ],
            'share'   => [
                'show_font_from_theme'    => [
                    'title' => __('Use theme default font family', 'wp-social'),
                    'value' => 1,
                ],
                'show_social_count_share' => [
                    'title' => __('Show total count', 'wp-social'),
                    'value' => 1,
                ],
            ],
            'counter' => [
                'show_font_from_theme' => [
                    'title' => __('Use theme default font family', 'wp-social'),
                    'value' => 1,
                ],
            ],
        ];
    }
}