<?php
/**
 * class-affiliates-dashboard-overview-block.php
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
 * @package affiliates
 * @since affiliates 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard section: Overview (Pro)
 */
class Affiliates_Dashboard_Overview_Pro_Block extends Affiliates_Dashboard_Overview_Pro {

	public static function init() { add_action( 'init', array( __CLASS__, 'wp_init' ) ); add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_assets' ) ); add_action( 'enqueue_block_assets', array( __CLASS__, 'enqueue_block_assets' ) ); }

	public static function enqueue_block_editor_assets() { wp_register_script( 'affiliates-dashboard-overview-block', plugins_url( 'js/dashboard-overview-block.js', AFFILIATES_FILE ), array( 'wp-blocks', 'wp-element' ) ); wp_localize_script( 'affiliates-dashboard-overview-block', 'affiliates_dashboard_overview_block', array( 'title' => _x( 'Affiliates Dashboard Overview', 'block title', 'affiliates' ), 'description' => _x( 'Displays the Overview section from the Affiliates Dashboard', 'block description', 'affiliates' ), 'keyword_affiliates' => __( 'Affiliates', 'affiliates' ), 'keyword_dashboard' => __( 'Dashboard', 'affiliates' ), 'keyword_overview' => __( 'Overview', 'affiliates' ), 'dashboard_overview_notice' => _x( 'Affiliates Dashboard Overview', 'Notice shown when editing the Affiliates Dashboard Overview block as a non-affiliate.', 'affiliates' ) ) ); }

	public static function enqueue_block_assets() { }

	public static function wp_init() { if ( function_exists( 'unregister_block_type' ) ) { unregister_block_type( 'affiliates/dashboard-overview' ); } if ( function_exists( 'register_block_type' ) ) { register_block_type( 'affiliates/dashboard-overview', array( 'editor_script' => 'affiliates-dashboard-overview-block', 'render_callback' => array( __CLASS__, 'block' ) ) ); } }

	public static function block( $atts, $content = '' ) { $atts = shortcode_atts( array( 'from' => null, 'until' => null ), $atts ); $IX31890 = ''; if ( affiliates_user_is_affiliate( get_current_user_id() ) ) { $IX64824 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Overview_Pro::get_key(), $atts ); ob_start(); $IX64824->render(); $IX31890 = ob_get_clean(); } if ( ( strlen( $IX31890 ) === 0 ) && defined( 'REST_REQUEST' ) && REST_REQUEST && isset( $_REQUEST['context'] ) && $_REQUEST['context'] === 'edit' ) { $IX31890 .= '<div style="display:none"></div>'; } return $IX31890; }

}
Affiliates_Dashboard_Overview_Pro_Block::init();
