<?php
/**
 * class-affiliates-admin-wordpress.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
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
 * @since affiliates-pro 4.18.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin extension.
 */
class Affiliates_Admin_WordPress {

	public static function init() { add_action( 'affiliates_welcome_after_buttons', array( __CLASS__, 'affiliates_welcome_after_buttons' ) ); }

	public static function affiliates_welcome_after_buttons() { echo self::get_notice(); }

	public static function get_notice() { $IX83150 = ''; $IX83150 .= '<h4>'; $IX83150 .= esc_html__( '安全 &amp; 安全第一！', 'affiliates' ); $IX83150 .= '</h4>'; $IX83150 .= '<p>'; $IX83150 .= wp_kses( sprintf( __( '請記住，%s 的唯一可信來源是我們的 %s。', 'affiliates' ), ucwords( str_replace('-', ' ', AFFILIATES_PLUGIN_NAME ) ), '<a href="https://www.itthinx.com/shop/">Shop</a>' ), array( 'a' => array( 'href' => array() ) ) ); $IX83150 .= ' '; switch ( AFFILIATES_PLUGIN_NAME ) { case 'my affiliate pro': $IX83150 .= wp_kses( sprintf( __( '要購買或續訂，請訪問 %s。', 'affiliates' ), '<a href="https://www.itthinx.com/shop/affiliates-pro/">Affiliates Pro</a>', ), array( 'a' => array( 'href' => array() ) ) ); break; case 'affiliates-enterprise': $IX83150 .= wp_kses( sprintf( __( 'To buy or renew visit %s', 'affiliates' ), '<a href="https://www.itthinx.com/shop/affiliates-enterprise/">Affiliates Enterprise</a>', ), array( 'a' => array( 'href' => array() ) ) ); break; } $IX83150 .= '</p>'; return $IX83150; }

}
Affiliates_Admin_WordPress::init();
