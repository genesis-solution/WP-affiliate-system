<?php 

namespace WP_Social\Lib\Onboard\Classes;

use WP_Social\Plugin;

defined( 'ABSPATH' ) || exit;

class Utils{

    public static $instance = null;
    private static $key = 'wp_social_options';

    public static function get_dir(){
        return Plugin::instance()->lib_dir() . 'onboard/';
    }

    public static function get_url(){
        return Plugin::instance()->lib_dir() . 'onboard/';
    }

    public function get_option($key, $default = ''){
        $data_all = get_option(self::$key);
        return (isset($data_all[$key]) && $data_all[$key] != '') ? $data_all[$key] : $default;
    }

    public function save_option($key, $value = ''){
        $data_all = get_option(self::$key);
        $data_all[$key] = $value;
        update_option(self::$key, $data_all);
    }

    public function get_settings($key, $default = ''){
        $data_all = $this->get_option('settings', []);
        return (isset($data_all[$key]) && $data_all[$key] != '') ? $data_all[$key] : $default;
    }

    public function save_settings($new_data = ''){
        $data_old = $this->get_option('settings', []);
        $data = array_merge($data_old, $new_data);
        $this->save_option('settings', $data);
    }

    /*
        -> this method used to check weather the widget active/deactive
        -> this method takes two paramitter 1. widget name 2. Active/deactive hook
     */ 
    public function is_widget_active_class( $widget_name, $pro_active ){
        if($pro_active){
            return 'label-'.esc_attr($widget_name).' attr-panel-heading';
        }else{
            return 'label-'.esc_attr($widget_name).' attr-panel-heading pro-disabled';
        }
    }

    public function input($input_options){
        $defaults = [
            'type' => null,
            'name' => '',
            'value' => '',
            'class' => '',
            'label' => '',
            'info' => '',
            'disabled' => '',
            'options' => [],
        ];
        $input_options = array_merge($defaults, $input_options);

        if(file_exists(self::get_dir() . 'controls/settings/' . $input_options['type'] . '.php')){
            extract($input_options);
            include self::get_dir() . 'controls/settings/' . $input_options['type'] . '.php';
        }
    }

    public static function strify($str){
        return strtolower(preg_replace("/[^A-Za-z0-9]/", "__", $str));
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {

            // Fire the class instance
            self::$instance = new self();
        }

        return self::$instance;
    }
	

    public static function kses( $raw ) {

		$allowed_tags = array(
			'a'								 => array(
				'class'	 => array(),
				'href'	 => array(),
				'rel'	 => array(),
				'title'	 => array(),
				'target' => array(),
			),
			'abbr'							 => array(
				'title' => array(),
			),
			'b'								 => array(),
			'blockquote'					 => array(
				'cite' => array(),
			),
			'cite'							 => array(
				'title' => array(),
			),
			'code'							 => array(),
			'pre'							 => array(),
			'del'							 => array(
				'datetime'	 => array(),
				'title'		 => array(),
			),
			'dd'							 => array(),
			'div'							 => array(
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
			),
			'dl'							 => array(),
			'dt'							 => array(),
			'em'							 => array(),
			'strong'						 => array(),
			'h1'							 => array(
				'class' => array(),
			),
			'h2'							 => array(
				'class' => array(),
			),
			'h3'							 => array(
				'class' => array(),
			),
			'h4'							 => array(
				'class' => array(),
			),
			'h5'							 => array(
				'class' => array(),
			),
			'h6'							 => array(
				'class' => array(),
			),
			'i'								 => array(
				'class' => array(),
			),
			'img'							 => array(
				'alt'	 => array(),
				'class'	 => array(),
				'height' => array(),
				'src'	 => array(),
				'width'	 => array(),
			),
			'li'							 => array(
				'class' => array(),
			),
			'ol'							 => array(
				'class' => array(),
			),
			'p'								 => array(
				'class' => array(),
			),
			'q'								 => array(
				'cite'	 => array(),
				'title'	 => array(),
			),
			'span'							 => array(
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
			),
			'iframe'						 => array(
				'width'			 => array(),
				'height'		 => array(),
				'scrolling'		 => array(),
				'frameborder'	 => array(),
				'allow'			 => array(),
				'src'			 => array(),
			),
			'strike'						 => array(),
			'br'							 => array(),
			'strong'						 => array(),
			'data-wow-duration'				 => array(),
			'data-wow-delay'				 => array(),
			'data-wallpaper-options'		 => array(),
			'data-stellar-background-ratio'	 => array(),
			'ul'							 => array(
				'class' => array(),
			),
			'svg'   => array(
				'class' => true,
				'aria-hidden' => true,
				'aria-labelledby' => true,
				'role' => true,
				'xmlns' => true,
				'width' => true,
				'height' => true,
				'viewbox' => true, // <= Must be lower case!
			),
			'g'     => array( 'fill' => true ),
			'title' => array( 'title' => true ),
			'path'  => array( 'd' => true, 'fill' => true,  ),
		);

		if ( function_exists( 'wp_kses' ) ) { // WP is here
			return wp_kses( $raw, $allowed_tags );
		} else {
			return $raw;
		}
	}
}