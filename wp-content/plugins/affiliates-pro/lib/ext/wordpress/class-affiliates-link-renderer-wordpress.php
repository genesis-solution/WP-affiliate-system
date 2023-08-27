<?php
/**
 * class-affiliates-link-renderer-wordpress.php
 *
 * Copyright (c) 2011 "kento" Karim Rahimpur www.itthinx.com
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
 * @since affiliates-pro 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Link-renderer implementation.
 */
class Affiliates_Link_Renderer_WordPress extends Affiliates_Link_Renderer {

	const NONCE          = 'affiliate-nonce';
	const NONCE_1        = 'affiliate-nonce-1';
	const NONCE_2        = 'affiliate-nonce-2';
	const NONCE_FILTERS  = 'affiliate-nonce-filters';

	/**
	 * Class initialization.
	 */
	public static function init() { add_shortcode( 'affiliates_affiliate_link', array( 'Affiliates_Link_Renderer_WordPress', 'link_shortcode' ) ); }

	public static function link_shortcode( $atts, $content = null ) { $IX86003 = shortcode_atts( self::$link_defaults, $atts ); return self::render_affiliate_link( $IX86003, $content ); }

	public static function render_affiliate_link( $options = array(), $IX79132 = null ) { parent::set_implementation( array( 'Affiliates_Affiliate' => 'Affiliates_Affiliate_WordPress', 'Affiliates_Url_Renderer' => 'Affiliates_Url_Renderer_WordPress', 'image_sizes' => get_intermediate_image_sizes(), 'image_retriever' => 'wp_get_attachment_image', 'esc_attr' => 'esc_attr' ) ); $IX19152 = ''; $IX19152 .= parent::render_affiliate_link( $options, $IX79132 ); return $IX19152; }
}
Affiliates_Link_Renderer_WordPress::init();
