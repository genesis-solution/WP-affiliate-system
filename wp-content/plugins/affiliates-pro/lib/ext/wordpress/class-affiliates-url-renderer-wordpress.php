<?php
/**
 * class-affiliates-url-renderer-wordpress.php
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
 * Platform-specific URL rendering.
 */
class Affiliates_Url_Renderer_WordPress extends Affiliates_Url_Renderer {

	const NONCE          = 'affiliate-nonce';
	const NONCE_1        = 'affiliate-nonce-1';
	const NONCE_2        = 'affiliate-nonce-2';
	const NONCE_FILTERS  = 'affiliate-nonce-filters';

	/**
	 * Class initialization.
	 */
	public static function init() { self::$pname = get_option( 'aff_pname', AFFILIATES_PNAME ); self::$cname = 'cmid'; self::$encoder = 'affiliates_encode_affiliate_id'; add_shortcode( 'affiliates_affiliate_url', array( 'Affiliates_Url_Renderer_WordPress', 'url_shortcode' ) ); add_shortcode( 'affiliates_generate_url', array( 'Affiliates_Url_Renderer_WordPress', 'generate_url_shortcode' ) ); }

	/**
	 * URL shortcode handler.
	 *
	 * @param array $atts attributes
	 * @param string $content not used
	 */
	public static function url_shortcode( $atts, $content = null ) { $IX93552 = shortcode_atts( self::$url_defaults, $atts ); return self::render_affiliate_url( $IX93552 ); }

	/**
	 * Renders an affiliate URL.
	 *
	 * @param array $options rendering options
	 */
	public static function render_affiliate_url( $options = array() ) { global $wp_rewrite; parent::set_implementation( array( 'Affiliates_Affiliate' => 'Affiliates_Affiliate_WordPress', 'affiliate_id_encoder' => 'affiliates_encode_affiliate_id', 'esc_attr' => 'esc_attr', 'use_parameter' => !$wp_rewrite->using_permalinks() ) ); $IX20021 = ''; if ( !isset( $options['url'] ) ) { $options['url'] = home_url(); } $options['pname'] = get_option( 'aff_pname', AFFILIATES_PNAME ); $IX20021 .= parent::render_affiliate_url( $options ); return $IX20021; }

	/**
	 * Render the affiliate URL generator form.
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string form HTML
	 */
	public static function generate_url_shortcode( $atts, $content = null ) { $atts = shortcode_atts( array( 'campaign' => 'no' ), $atts ); $IX89666 = isset( $_POST['generate-url'] ) ? trim( $_POST['generate-url'] ) : ''; if ( !empty( $IX89666 ) ) { if ( ( stripos( $IX89666, 'http://' ) !== 0 ) && ( stripos( $IX89666, 'https://' ) !== 0 ) ) { $IX89666 = 'http://' . $IX89666; } } $IX53488 = true; if ( !empty( $IX89666 ) ) { if ( function_exists( 'filter_var' ) ) { $IX53488 = filter_var( $IX89666, FILTER_VALIDATE_URL ) !== false; } } $IX54923 = !empty( $IX89666 ) ? self::render_affiliate_url( array( 'url' => $IX89666, 'type' => self::TYPE_APPEND ) ) : ''; if ( class_exists( 'Affiliates_Campaign' ) ) { if ( !empty( $IX89666 ) ) { $IX20964 = !empty( $_POST['campaign_id'] ) ? intval( $_POST['campaign_id'] ) : null; if ( $IX20964 ) { if ( $IX70317 = affiliates_get_user_affiliate( get_current_user_id() ) ) { if ( $IX65358 = array_shift( $IX70317 ) ) { if ( $IX72906 = Affiliates_Campaign::get_affiliate_campaign( $IX65358, $IX20964 ) ) { $IX54923 = $IX72906->get_url( array( 'url' => $IX89666 ) ); } } } } } } $IX74078 = ''; $IX85710 = apply_filters( 'affiliates_generate_url_style', 'div.generate-field span.field-label { display:block; }' . 'div.generate-field span.field-input { display:block; width:62%; }' . 'div.generate-field span.field-input input { width:100%; }' . 'div.generate-field span.error { display:block; color: #900; }' ); if ( !empty( $IX85710 ) ) { $IX74078 .= '<style type="text/css">'; $IX74078 .= $IX85710; $IX74078 .= '</style>'; } $IX74078 .= '<div class="affiliates-generate-url">'; $IX74078 .= '<form action="" method="post">'; $IX74078 .= '<div>'; $IX74078 .= '<div class="generate-field generate-url">'; $IX74078 .= '<label>'; $IX74078 .= '<span class="field-label">'; $IX74078 .= __( 'Page URL', 'affiliates' ); $IX74078 .= '</span>'; $IX74078 .= sprintf( '<span class="error" style="%s">', $IX53488 ? 'display:none;' : '' ); $IX74078 .= __( 'Please enter a valid URL.', 'affiliates' ); $IX74078 .= '</span>'; $IX74078 .= '<span class="field-input">'; $IX74078 .= sprintf( '<input type="text" name="generate-url" value="%s" />', $IX89666 ); $IX74078 .= '</span>'; $IX74078 .= '</label>'; $IX74078 .= '</div>'; if ( class_exists( 'Affiliates_Campaign' ) && isset( $atts['campaign'] ) && strtolower( $atts['campaign'] ) == 'yes' ) { if ( $IX70317 = affiliates_get_user_affiliate( get_current_user_id() ) ) { if ( $IX65358 = array_shift( $IX70317 ) ) { $IX32812 = Affiliates_Campaign::get_campaigns( $IX65358 ); if ( !empty( $IX32812 ) ) { $IX63449 = null; $IX20964 = !empty( $_POST['campaign_id'] ) ? intval( $_POST['campaign_id'] ) : null; if ( $IX20964 ) { if ( $IX72906 = Affiliates_Campaign::get_affiliate_campaign( $IX65358, $IX20964 ) ) { $IX63449 = $IX72906->campaign_id; } } $IX74078 .= '<div class="generate-field campaign">'; $IX74078 .= '<label>'; $IX74078 .= '<span class="field-label">'; $IX74078 .= __( 'Campaign', 'affiliates' ); $IX74078 .= '</span>'; $IX74078 .= '<select name="campaign_id">'; $IX74078 .= '<option value="">&mdash;</option>'; foreach( $IX32812 as $IX72906 ) { $IX74078 .= sprintf( '<option value="%d" %s>%s</option>', intval( $IX72906->campaign_id ), $IX63449 !== null && $IX72906->campaign_id == $IX63449 ? ' selected="selected" ' : '', esc_html( stripslashes( $IX72906->name ) ) ); } $IX74078 .= '</select>'; $IX74078 .= '</label>'; $IX74078 .= '</div>'; } } } } $IX74078 .= '<div class="generate-field affiliate-url">'; $IX74078 .= '<label>'; $IX74078 .= '<span class="field-label">'; $IX74078 .= __( 'Affiliate URL', 'affiliates' ); $IX74078 .= '</span>'; $IX74078 .= '<span class="field-input">'; $IX74078 .= sprintf( '<input type="text" name="affiliate-url" value="%s" readonly="readonly" />', $IX54923 ); $IX74078 .= '</span>'; $IX74078 .= '</label>'; $IX74078 .= '</div>'; $IX74078 .= '<div class="generate-button">'; $IX74078 .= sprintf( '<input type="submit" name="generate" value="%s" />', __( 'Generate', 'affiliates' ) ); $IX74078 .= '</div>'; $IX74078 .= '</div>'; $IX74078 .= '</form>'; $IX74078 .= '</div>'; return $IX74078; }
}
Affiliates_Url_Renderer_WordPress::init();
