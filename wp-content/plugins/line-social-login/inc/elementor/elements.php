<?php

namespace WP_Social\Inc\Elementor;

defined('ABSPATH') || exit;

/**
 * Class Name : Elements - For configration elementtor widget for Fundrasing.
 * Class Type : Normal class
 *
 * initiate all necessary classes, hooks, configs
 *
 * @since 1.0.0
 * @access Public
 */

class Elements {

    private $active_widgets = ['share'];

	private static $instance;

    public function _init($load = true){
		if($load){
            if ( ! did_action( 'elementor/loaded' ) ) {
                return false;
            }
           // categories
           add_action('elementor/elements/categories_registered', [$this, '_elementor_widget_resister']);

           //call widget 
           add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widget']);
        }
    }

     /**
     * Method Name: _elementor_widget_resister
     * Details : Register categories of Elementor Controls
     * 
     * @since 1.0.0
     * @access public
     */
    public function _elementor_widget_resister( $widgets_manager ){
        \Elementor\Plugin::$instance->elements_manager->add_category(
			'xs-wpsocial-login',
			[
				'title' =>esc_html__( 'Social Login', 'wp-social' ),
				'icon' => 'fa fa-plug',
			],
			1
		);
    }

     /**
     * Method Name: register_widget
     * Details : Register widget of Elementor Controls
     * 
     * @since 1.0.0
     * @access public
     */

    public function register_widget( ){
        foreach($this->active_widgets as $widget){
            $files = plugin_dir_path(__FILE__).'widgets/'.$widget.'.php';
            if( file_exists( $files) ){
                require_once $files;
                $class_name = '\Elementor\Wps_'. ucfirst($widget);
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $class_name());
            }
        }
    }
	
	public static function instance(){
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

}

