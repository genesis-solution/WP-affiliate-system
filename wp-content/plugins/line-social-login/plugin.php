<?php

namespace WP_Social;

defined('ABSPATH') || exit;

class Plugin {

    private static $instance;

	public static function instance() {
		if(!self::$instance) {
			self::$instance = new static();
		}

		return self::$instance;
    }

    public function plugin_url() {

        return trailingslashit(plugin_dir_url(__FILE__));
    }

    public function plugin_dir() {

        return trailingslashit(plugin_dir_path(__FILE__));
    }

    public function lib_url() {

        return $this->plugin_url() . 'lib/';
    }

    public function lib_dir() {

        return $this->plugin_dir() . 'lib/';
    }

    public function account_url(){
		return 'https://account.wpmet.com';
	}

    public function package_type() {
        return apply_filters( 'wp-social/core/package_type', 'free');
    }

    public function enqueue() {
        
        add_action( 'admin_enqueue_scripts', [$this, 'load_admin_scripts'] );

        add_action( 'wp_enqueue_scripts', [$this, 'load_public_scripts'] );        
    }


    public function load_admin_scripts() {
        wp_enqueue_style( 'wps-wp-dashboard', WSLU_LOGIN_PLUGIN_URL . 'assets/css/wps-wp-dashboard.css', [], WSLU_VERSION );

	    wp_register_script( 'wslu_admin', WSLU_LOGIN_PLUGIN_URL. 'assets/js/admin-main.js', array('jquery', 'jquery-ui-sortable'));
	    wp_register_script( 'xs_login_custom_js1', WSLU_LOGIN_PLUGIN_URL. 'assets/js/admin-login-custom.js', array('jquery'));
        wp_register_script( 'wp_social_select2_js', WSLU_LOGIN_PLUGIN_URL. 'assets/select2/script/select2-min.js', array('jquery'));
        wp_register_script( 'wp_social_sortable_js', WSLU_LOGIN_PLUGIN_URL. 'assets/js/sortable.min.js', array('jquery'));


        wp_localize_script('xs_login_custom_js1', 'rest_api_conf', array(
            'siteurl' => get_option('siteurl'),
            'nonce'   => wp_create_nonce('wp_rest'),
            'root' 	  => get_rest_url(),
        ));

	    wp_localize_script('wslu_admin', 'wsluAdminObj', [
		    'resturl'    => get_rest_url(),
		    'rest_nonce' => wp_create_nonce('wp_rest'),
	    ]);
    
        wp_enqueue_script( 'xs_login_custom_js1' );
        wp_enqueue_script( 'wp_social_select2_js' );
        wp_enqueue_script( 'wp_social_sortable_js' );
        wp_enqueue_script( 'wslu_admin' );


        wp_register_style( 'xs_login_custom_css1', WSLU_LOGIN_PLUGIN_URL. 'assets/css/admin-login-custom.css');
        wp_register_style( 'wp_social_select2_css', WSLU_LOGIN_PLUGIN_URL. 'assets/select2/css/select2-min.css');
        wp_register_style( 'xs_login_custom_css_icon', WSLU_LOGIN_PLUGIN_URL. 'assets/css/font-icon.css');
        wp_register_style( 'xs_login_custom_css2', WSLU_LOGIN_PLUGIN_URL. 'assets/css/admin.css');
        wp_register_style( 'xs_login_custom_css3', WSLU_LOGIN_PLUGIN_URL. 'assets/css/admin-responsive.css');

        wp_enqueue_style( 'xs_login_custom_css1' );
        wp_enqueue_style( 'wp_social_select2_css' );
        wp_enqueue_style( 'xs_login_custom_css2' );
        wp_enqueue_style( 'xs_login_custom_css3' );
        wp_enqueue_style( 'xs_login_custom_css_icon' );
    }


    public function load_public_scripts() {

        wp_register_script( 'xs_social_custom', WSLU_LOGIN_PLUGIN_URL. 'assets/js/social-front.js', array('jquery'));

	    wp_localize_script('xs_social_custom', 'rest_api_conf', array(
		    'siteurl' => get_option('siteurl'),
		    'nonce'   => wp_create_nonce('wp_rest'),
		    'root' 	  => get_rest_url(),
	    ));

	    wp_localize_script('xs_social_custom', 'wsluFrontObj', [
		    'resturl'    => get_rest_url(),
		    'rest_nonce' => wp_create_nonce('wp_rest'),
	    ]);

	    wp_enqueue_script( 'xs_social_custom' );
    }
}
