<?php
/**
 * class-affiliates-dashboard-purchased-block.php
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
 * @author Jon
 * @package affiliates-pro
 * @since affiliates-pro 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Dashboard section: Purchased
 */
class Affiliates_Dashboard_Purchased_Block extends Affiliates_Dashboard_Purchased {

    public static function init() {
        add_action( 'init', array( __CLASS__, 'wp_init' ) );
        add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_assets' ) );
        add_action( 'enqueue_block_assets', array( __CLASS__, 'enqueue_block_assets' ) );
    }

    public static function enqueue_block_editor_assets() {

    }

    public static function enqueue_block_assets() { }

    public static function wp_init() {
        if ( function_exists( 'register_block_type' ) ) {
            register_block_type( 'affiliates/dashboard-purchased',
                array( 'editor_script' => 'affiliates-dashboard-purchased-block', 'render_callback' => array( __CLASS__, 'block' ) ) );
        }
    }

    public static function block( $atts, $content = '' ) {
        $IX85498 = '';
        if ( affiliates_user_is_affiliate( get_current_user_id() ) ) {
            $IX19524 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Purchased::get_key(), $atts );
            ob_start();
            $IX19524->render();
            $IX85498 = ob_get_clean();
        }
        if ( ( strlen( $IX85498 ) === 0 ) && defined( 'REST_REQUEST' ) && REST_REQUEST && isset( $_REQUEST['context'] ) && $_REQUEST['context'] === 'edit' ) { $IX85498 .= '<div style="display:none"></div>'; } return $IX85498; }

}
Affiliates_Dashboard_Purchased_Block::init();
