<?php
/**
 * class-affiliates-dashboard-purchased-shortcode.php
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
 * Dashboard section: Referrals
 */
class Affiliates_Dashboard_Purchased_Shortcode extends Affiliates_Dashboard_Purchased {

    public static function init() { add_shortcode( 'affiliates_dashboard_purchased', array( __CLASS__, 'shortcode' ) ); }

    public static function shortcode( $atts, $content = '' ) {
        $IX47475 = '';
        if ( affiliates_user_is_affiliate() ) {
            $IX63483 = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Purchased::get_key(), $atts );
            ob_start();
            $IX63483->render();
            $IX47475 = ob_get_clean(); }
        return $IX47475;
    }

}
Affiliates_Dashboard_Purchased_Shortcode::init();
