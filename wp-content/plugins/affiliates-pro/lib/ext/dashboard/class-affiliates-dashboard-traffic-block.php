<?php
/**
 * class-affiliates-dashboard-traffic-block.php
 *
 * Copyright (c) 2010 - 2019 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-pro
 * @since affiliates-pro 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard section: Traffic
 */
class Affiliates_Dashboard_Traffic_Block extends Affiliates_Dashboard_Traffic {

	public static function init() { add_action( 'init', array( __CLASS__, 'wp_init' ) ); add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_assets' ) ); add_action( 'enqueue_block_assets', array( __CLASS__, 'enqueue_block_assets' ) ); }

	public static function enqueue_block_editor_assets() { wp_register_script( 'affiliates-dashboard-traffic-block', plugins_url( 'js/dashboard-traffic-block.js', AFFILIATES_FILE ), array( 'wp-blocks', 'wp-element' ) ); wp_localize_script( 'affiliates-dashboard-traffic-block', 'affiliates_dashboard_traffic_block', array( 'title' => _x( 'Affiliates Dashboard Traffic', 'block title', 'affiliates' ), 'description' => _x( 'Displays the Traffic section from the Affiliates Dashboard', 'block description', 'affiliates' ), 'keyword_affiliates' => __( 'Affiliates', 'affiliates' ), 'keyword_dashboard' => __( 'Dashboard', 'affiliates' ), 'keyword_traffic' => __('交通', 'affiliates' ), 'dashboard_traffic_notice' => _x( 'Affiliates Dashboard Traffic', 'Notice shown when editing the Affiliates Dashboard Traffic block as a non-affiliate.', 'affiliates' ) ) ); }

	public static function enqueue_block_assets() { }

	public static function wp_init() { if ( function_exists( 'register_block_type' ) ) { register_block_type( 'affiliates/dashboard-traffic', array( 'editor_script' => 'affiliates-dashboard-traffic-block', 'render_callback' => array( __CLASS__, 'block' ) ) ); } }

	public static function block( $atts, $content = '' ) { $IX52519 = ''; if ( affiliates_user_is_affiliate( get_current_user_id() ) ) { $IX63462 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Traffic::get_key(), $atts ); ob_start(); $IX63462->render(); $IX52519 = ob_get_clean(); } if ( ( strlen( $IX52519 ) === 0 ) && defined( 'REST_REQUEST' ) && REST_REQUEST && isset( $_REQUEST['context'] ) && $_REQUEST['context'] === 'edit' ) { $IX52519 .= '<div style="display:none"></div>'; } return $IX52519; }

}
Affiliates_Dashboard_Traffic_Block::init();
