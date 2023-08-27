<?php
/**
 * class-affiliates-dashboard-banners-block.php
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
 * Dashboard section: Banners (Pro)
 */
class Affiliates_Dashboard_Banners_Block extends Affiliates_Dashboard_Banners {

	public static function init() { add_action( 'init', array( __CLASS__, 'wp_init' ) ); add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_assets' ) ); add_action( 'enqueue_block_assets', array( __CLASS__, 'enqueue_block_assets' ) ); }

	public static function enqueue_block_editor_assets() {
        wp_register_script( 'affiliates-dashboard-banners-block',
            plugins_url( 'js/dashboard-banners-block.js', AFFILIATES_FILE ), array( 'wp-blocks', 'wp-element' ) );
        wp_localize_script( 'affiliates-dashboard-banners-block', 'affiliates_dashboard_banners_block',
            array( 'title' => _x( 'Affiliates Dashboard Banners', 'block title', 'affiliates' ),
                'description' => _x( 'Displays the Banners section from the Affiliates Dashboard', 'block description', 'affiliates' ),
                'keyword_affiliates' => __( 'Affiliates', 'affiliates' ),
        'keyword_dashboard' => __( '儀表板', 'affiliates' ),
                'keyword_banners' => __( '橫幅', 'affiliates' ),
                'dashboard_banners_notice' => _x( 'Affiliates Dashboard Banners', 'Notice shown when editing the Affiliates Dashboard Banners block as a non-affiliate.', 'affiliates' ) ) );
    }

	public static function enqueue_block_assets() { }

	public static function wp_init() { if ( function_exists( 'register_block_type' ) ) { register_block_type( 'affiliates/dashboard-banners', array( 'editor_script' => 'affiliates-dashboard-banners-block', 'render_callback' => array( __CLASS__, 'block' ) ) ); } }

	public static function block( $atts, $content = '' ) { $atts = shortcode_atts( array( 'per_page' => 10 ), $atts ); $IX70632 = ''; if ( affiliates_user_is_affiliate( get_current_user_id() ) ) { $IX31871 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Banners::get_key(), $atts ); ob_start(); $IX31871->render(); $IX70632 = ob_get_clean(); } if ( ( strlen( $IX70632 ) === 0 ) && defined( 'REST_REQUEST' ) && REST_REQUEST && isset( $_REQUEST['context'] ) && $_REQUEST['context'] === 'edit' ) { $IX70632 .= '<div style="display:none"></div>'; } return $IX70632; }

}
Affiliates_Dashboard_Banners_Block::init();
