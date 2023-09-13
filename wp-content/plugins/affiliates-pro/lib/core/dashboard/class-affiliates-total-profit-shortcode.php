<?php
/**
 * class-affiliates-total-profit-shortcode.php
 *
 * Copyright (c) 2010 - 2018 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates
 * @since affiliates 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Dashboard section: Total-Profit
 */
class Affiliates_Total_Profit_Shortcode extends Affiliates_Total_Profit {

    /**
     * Initialization - adds the shortcode.
     */
    public static function init() {
        add_shortcode( 'affiliates_total_profit', array( __CLASS__, 'shortcode' ) );
    }

    /**
     * Shortcode handler for the section shortcode.
     *
     * @param array $atts shortcode attributes
     * @param string $content not used
     *
     * @return string
     */
    public static function shortcode( $atts, $content = '' ) {
        $output = '';
        if ( affiliates_user_is_affiliate() ) {
            /**
             * @var Affiliates_Total_Profit $section
             */
            $section = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Total_Profit::get_key() );
            ob_start();
            $section->render();
            $output = ob_get_clean();
        }
        return $output;
    }

}
Affiliates_Total_Profit_Shortcode::init();
