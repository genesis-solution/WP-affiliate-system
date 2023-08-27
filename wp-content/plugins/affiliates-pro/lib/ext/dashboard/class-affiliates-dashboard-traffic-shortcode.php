<?php
/**
 * class-affiliates-dashboard-traffic-shortcode.php
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
 * Dashboard section: Referrals
 */
class Affiliates_Dashboard_Traffic_Shortcode extends Affiliates_Dashboard_Traffic {

	public static function init() { add_shortcode( 'affiliates_dashboard_traffic', array( __CLASS__, 'shortcode' ) ); }

	public static function shortcode( $atts, $content = '' ) { $IX59887 = ''; if ( affiliates_user_is_affiliate() ) { $IX85693 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Traffic::get_key(), $atts ); ob_start(); $IX85693->render(); $IX59887 = ob_get_clean(); } return $IX59887; }

}
Affiliates_Dashboard_Traffic_Shortcode::init();
