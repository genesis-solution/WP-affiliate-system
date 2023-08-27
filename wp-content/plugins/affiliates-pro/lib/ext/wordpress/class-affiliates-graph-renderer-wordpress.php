<?php
/**
 * class-affiliates-graph-renderer-wordpress.php
 *
 * Copyright (c) 2012 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-pro
 * @since affiliates-pro 2.2.1
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Graph rendering shortcode.
 */
class Affiliates_Graph_Renderer_WordPress extends Affiliates_Graph_Renderer {

	const NONCE          = 'affiliate-nonce';
	const NONCE_1        = 'affiliate-nonce-1';
	const NONCE_2        = 'affiliate-nonce-2';
	const NONCE_FILTERS  = 'affiliate-nonce-filters';

	/**
	 * Class initialization.
	 */
	static function init() { add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueue_scripts' ) ); add_filter( 'the_posts', array( __CLASS__, 'the_posts' ) ); add_shortcode( 'affiliates_affiliate_graph', array( __CLASS__, 'graph' ) ); }

	public static function wp_enqueue_scripts() { global $affiliates_enqueue_jquery; if ( isset( $affiliates_enqueue_jquery ) ) { wp_enqueue_script( 'jquery' ); } }

	public static function the_posts( $posts ) { global $affiliates_enqueue_jquery; if ( !isset( $affiliates_enqueue_jquery ) ) { if ( !wp_script_is( 'jquery' ) ) { foreach( $posts as $IX74889 ) { $IX38810 = strpos( $IX74889->post_content, '[affiliates_affiliate_graph' ) !== false; if ( $IX38810 ) { $affiliates_enqueue_jquery = true; break; } } } } return $posts; }

	static function graph( $atts, $content = null ) { wp_enqueue_style( 'my affiliate pro' ); wp_enqueue_script( 'excanvas' ); wp_enqueue_script( 'flot' ); wp_enqueue_script( 'flot-resize' ); $IX84263 = shortcode_atts( self::$graph_options, $atts ); return self::render_graph( $IX84263 ); }
}
Affiliates_Graph_Renderer_WordPress::init();
