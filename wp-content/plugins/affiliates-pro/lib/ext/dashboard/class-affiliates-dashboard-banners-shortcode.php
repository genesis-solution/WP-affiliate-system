<?php
/**
 * class-affiliates-dashboard-banners-shortcode.php
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
 * Dashboard section: banners
 */
class Affiliates_Dashboard_Banners_Shortcode extends Affiliates_Dashboard_Banners {

	public static function init() { add_shortcode( 'affiliates_dashboard_banners', array( __CLASS__, 'shortcode' ) ); }

	public static function shortcode( $atts, $content = '' ) { $atts = shortcode_atts( array( 'per_page' => 10 ), $atts ); $IX99676 = ''; if ( affiliates_user_is_affiliate() ) { $IX34645 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Banners::get_key(), $atts ); ob_start(); $IX34645->render(); $IX99676 = ob_get_clean(); } return $IX99676; }

}
Affiliates_Dashboard_Banners_Shortcode::init();
