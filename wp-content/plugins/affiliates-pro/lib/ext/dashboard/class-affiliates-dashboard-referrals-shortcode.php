<?php
/**
 * class-affiliates-dashboard-referrals-shortcode.php
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
class Affiliates_Dashboard_Referrals_Shortcode extends Affiliates_Dashboard_Referrals {

	public static function init() { add_shortcode( 'total_profit_fee_from_product', array( __CLASS__, 'shortcode' ) ); }

	public static function shortcode( $atts, $content = '' ) {
        $IX47475 = '';
        if ( affiliates_user_is_affiliate() ) {
            $attributes = shortcode_atts(
                array(
                    'view_page_full_path' => 'default_value1',
                    'is_view' => 'false',
                ),
                $atts
            );
            /**
             * @var Affiliates_Dashboard_Earnings $section
             */
            $view_page = $attributes['view_page_full_path'];
            $is_view = $attributes['is_view'];
            update_option('view_page_full_path', $view_page, true);
            update_option('is_view', $is_view, true);

            $IX63483 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Referrals::get_key(), $atts ); ob_start(); $IX63483->render(); $IX47475 = ob_get_clean(); } return $IX47475; }

}
Affiliates_Dashboard_Referrals_Shortcode::init();
