<?php
/**
 * class-affiliates-rates-wordpress.php
 *
 * Copyright (c) 2017 "kento" Karim Rahimpur www.itthinx.com
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
 * @author itthinx
 * @package affiliates-pro
 * @since affiliates-pro 3.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rates admin section.
 */
class Affiliates_Rates_WordPress {

	const NONCE = 'nonce-rates';

	public static function init() { add_action( 'affiliates_admin_menu', array( __CLASS__, 'affiliates_admin_menu' ) ); add_action( 'wp_ajax_affiliates_rates_set_fields', array( __CLASS__, 'affiliates_rates_set_fields' ) ); }

	public static function affiliates_rates_set_fields() { ob_start(); $IX27954 = ''; $IX63490 = isset( $_REQUEST['integration'] ) ? esc_html( $_REQUEST['integration'] ) : null; switch ( $IX63490 ) { case 'affiliates-woocommerce' : $IX13741 = affiliates_pro_get_integrations(); if ( isset( $IX13741['affiliates-woocommerce'] ) ) { $IX63490 = $IX13741['affiliates-woocommerce']; $IX31120 = array(); $IX52212 = get_posts( array( 'post_type' => $IX63490['object'] ) ); if ( $IX52212 && ( count( $IX52212 ) > 0 ) ) { $IX25937 = isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : ''; foreach ( $IX52212 as $IX82064 ) { $IX97626 = ( $IX25937 == $IX82064->ID ) ? true : false; $IX31120[] = array ( 'ID' => $IX82064->ID, 'title' => $IX82064->post_title, 'selected' => $IX97626 ); } } $IX71082 = array(); if ( !empty( $IX63490['taxonomy'] ) && taxonomy_exists( $IX63490['taxonomy'] ) ) { $IX36002 = get_terms( array( 'taxonomy' => $IX63490['taxonomy'] ) ); if ( $IX36002 && ( count( $IX36002 ) > 0 ) ) { $IX41749 = isset( $_REQUEST['term_id'] ) ? $_REQUEST['term_id'] : ''; foreach ( $IX36002 as $IX67469 ) { $IX97626 = ( $IX41749 == $IX67469->term_id ) ? true : false; $IX71082[] = array ( 'ID' => $IX67469->term_id, 'title' => $IX67469->name, 'selected' => $IX97626 ); } } } $IX27954 = wp_json_encode( array( 'posts' => $IX31120, 'terms' => $IX71082 ) ); } break; } ob_end_clean(); echo $IX27954; wp_die(); }

	public static function affiliates_admin_menu() { $IX98108 = add_submenu_page( 'affiliates-admin', __( '價格', 'affiliates' ), __( '價格', 'affiliates' ), AFFILIATES_ADMINISTER_OPTIONS, 'affiliates-admin-rates', array( __CLASS__, 'affiliates_admin_rates' ) ); $IX78977[] = $IX98108; add_action( 'admin_print_styles-' . $IX98108, 'affiliates_admin_print_styles' ); add_action( 'admin_print_scripts-' . $IX98108, 'affiliates_admin_print_scripts' ); add_action( 'admin_print_styles-' . $IX98108, 'affiliates_pro_admin_print_styles' ); add_action( 'admin_print_scripts-' . $IX98108, 'affiliates_pro_admin_print_scripts' ); }

	public static function admin_print_styles() { global $affiliates_pro_version; if ( !wp_style_is( 'chosen' ) ) { wp_enqueue_style( 'chosen', AFFILIATES_ENTERPRISE_PLUGIN_URL . 'css/chosen/chosen.min.css', array(), $affiliates_pro_version ); } }

	public static function admin_print_scripts() { global $affiliates_pro_version; if ( !wp_script_is( 'chosen' ) ) { wp_enqueue_script( 'chosen', AFFILIATES_ENTERPRISE_PLUGIN_URL . 'js/chosen/chosen.jquery.min.js', array( 'jquery' ), $affiliates_pro_version ); } }

	public static function affiliates_admin_rates() { if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) { wp_die( __( '拒絕訪問。', 'affiliates' ) ); } echo '<h1>'; echo __( '價格', 'affiliates' ); echo '</h1>'; if ( get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY, null ) ) { echo '<div class="error">'; echo '<h2>'; echo __( 'Important', 'affiliates' ); echo '</h2>'; echo '<p>'; echo __( '僅當用於計算佣金的方法是<em>費率</em>時，此處定義的費率才有效。', 'affiliates' ); echo ' '; printf( __( '要啟用此處定義的費率，請轉至<a href="%s">佣金</a>並選擇<em>費率</em>作為方法。', 'affiliates' ), add_query_arg( 'section', 'commissions', admin_url( 'admin.php?page=affiliates-admin-settings' ) ) ); echo '</p>'; echo '</div>'; } Affiliates_Rates_Table::render();  }

}
add_action( 'init', array( 'Affiliates_Rates_WordPress', 'init' ) );
