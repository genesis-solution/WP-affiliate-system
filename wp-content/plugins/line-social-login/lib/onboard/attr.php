<?php 
namespace WP_Social\Lib\Onboard;

use WP_Social\Lib\Onboard\Classes\Utils;
use WP_Social\Plugin;
use WP_Social\Traits\Singleton;

defined( 'ABSPATH' ) || exit;

class Attr{

    use Singleton;
    
    public $utils;

    public static function get_dir(){
        return Plugin::instance()->lib_dir() . 'onboard/';
    }

    public static function get_url(){
        return Plugin::instance()->lib_url() . 'onboard/';
    }

    public function __construct() {

        $this->utils = Utils::instance();

        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_scripts'] );
    }

    public function whitelisted_styles($styles) {
        $styles[] = 'admin-global.css';
        return $styles;
    }

    public function enqueue_scripts() {

        wp_register_style( 'wpsocial-onboard-icon', self::get_url() . 'assets/css/onboard-icons.css', WSLU_VERSION );
        wp_register_style( 'metform-admin-global', self::get_url() . 'assets/css/admin-global.css', WSLU_VERSION );
        wp_register_style( 'metform-init-css-admin', self::get_url() . 'assets/css/admin-style.css', WSLU_VERSION );
        
        wp_enqueue_style( 'wpsocial-onboard-icon' );

        wp_enqueue_style( 'metform-init-css-admin' );
        
        wp_enqueue_style( 'metform-admin-global' );

        wp_enqueue_script( 'wslu-admin-core', self::get_url() . 'assets/js/metform-onboard.js', ['jquery'], WSLU_VERSION, true );

        $data['rest_url']   = get_rest_url();
	    $data['nonce']      = wp_create_nonce('wp_rest');

	    wp_localize_script('wslu-admin-core', 'rest_config', $data);

        wp_localize_script('wslu-admin-core', 'ekit_ajax_var', array(
            'nonce' => wp_create_nonce('ajax-nonce')
        ));
    }

}
