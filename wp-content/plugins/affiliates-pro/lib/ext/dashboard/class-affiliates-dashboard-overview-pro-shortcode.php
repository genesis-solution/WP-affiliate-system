<?php
/**
 * class-affiliates-dashboard-overview-shortcode.php
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
 * Dashboard section: Overview
 */
class Affiliates_Dashboard_Overview_Pro_Shortcode extends Affiliates_Dashboard_Overview_Pro {

	public static function init() { add_shortcode( 'affiliates_dashboard_overview', array( __CLASS__, 'shortcode' ) ); }

	public static function shortcode( $atts, $content = '' ) { $atts = shortcode_atts( array( 'from' => null, 'until' => null ), $atts ); $IX11016 = ''; if ( affiliates_user_is_affiliate() ) { $IX42032 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Overview_Pro::get_key(), $atts ); ob_start(); $IX42032->render(); $IX11016 = ob_get_clean(); } return $IX11016; }

}
Affiliates_Dashboard_Overview_Pro_Shortcode::init();
