<?php

namespace Elementor;

defined('ABSPATH') || exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \WP_Social\Inc\Admin_Settings;
use \WP_Social\Inc\Share;


class Wps_Share extends Widget_Base {

    public $base;

    public function get_name() {
        return 'xs-wpsocial-share-button';
    }

    public function get_title() {
        return esc_html__( 'Share Button', 'wp-social' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['xs-wpsocial-login'];
    }

	public function __style(){
		$styles = Admin_Settings::share_styles();

		$option = [];

		foreach ($styles as $k => $style) {
			$option[$k] = $style['name'];
		}

		return $option;
	}
	
	public function __share_provider(){
		$obj = New Share(false);
		
		$link = $obj->social_share_link();
		$provider = [];
		foreach($link as $k=>$v):
			$provider[$k] = isset($v['label']) ? $v['label'] : '';
		endforeach;
		
		return $provider;
	}
     
    protected function register_controls() {

        // content of listing
		$this->start_controls_section(
			'__social_login_providers',
			array(
				'label' => esc_html__( 'Providers', 'wp-social' ),
			)
        );
		$this->add_control(
			'provider_styles',
			[
				'label' => esc_html__( 'Select Providers', 'wp-social' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->__share_provider(),
				'default' =>  '',
			]
        );
		 $this->add_control(
			'select_styles',
			[
				'label' => esc_html__( 'Select Style', 'wp-social' ),
				'type' => Controls_Manager::SELECT,
				'multiple' => false,
				'options' => $this->__style(),
				'default' =>  '',
			]
        );
		$this->add_control(
			'show_count',
			[
				'label'		=> esc_html__( 'Show Share Count', 'wp-social' ),
				'type'		=> Controls_Manager::SWITCHER,
				'label_on'	=> esc_html__('Yes', 'wp-social'),
				'label_off'	=> esc_html__('No', 'wp-social'),
				'default'	=> 'yes',
			]
		);
		$this->add_control(
			'custom_class',
			[
				'label' => esc_html__( 'Custom Class', 'wp-social' ),
				'type' => Controls_Manager::TEXT,
				'default' =>  '',
			]
        );
		
        $this->end_controls_section();
		
		 $this->start_controls_section(
			'__social_login_providers_styles',
			array(
                'label' => esc_html__( 'Providers', 'wp-social' ),
                'tab' => Controls_Manager::TAB_STYLE,
			)
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'       => '__social_login_providers_typograghy',
                'selector'   => '{{WRAPPER}} .xs_social_share_widget .xs_share_url > li > a .xs-social-icon span',
            ]
        );
        $this->end_controls_section();
	


    }
     // render files
     protected function render( ) {
        $settings = $this->get_settings_for_display();
		extract($settings);

		$provider = 'all';
		$attr = [
			'conf_type'		=> 'widget',
			'style'			=> $select_styles,
			'class'			=> $custom_class,
			'show_count'	=> $show_count,
		];
		
		if(!empty($provider_styles)){
			$provider = array_values($provider_styles);
		}

		if( function_exists('__wp_social_share_pro_check') ){
			if( __wp_social_share_pro_check() ){
				echo __wp_social_share( $provider, $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --  It's already has been escaped from the /template/share/share-html.php
			}
		}
     }
}

