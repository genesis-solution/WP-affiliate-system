<?php
/**
 * class-affiliates-settings-pages.php
 *
 * Copyright (c) 2010 - 2015 "kento" Karim Rahimpur www.itthinx.com
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
 * @since affiliates 2.8.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Integration section.
 */
class Affiliates_Settings_Pages extends Affiliates_Settings {

	/**
	 * Renders the generator form and handles page
	 * generation form submission.
	 */
	public static function section() {

		global $wpdb;

		$pages_generated_info = '';

		//
		// handle page generation form submission
		//
		if ( isset( $_POST['generate'] ) ) {
			if (
				isset( $_POST[AFFILIATES_ADMIN_SETTINGS_GEN_NONCE] ) &&
				wp_verify_nonce( $_POST[AFFILIATES_ADMIN_SETTINGS_GEN_NONCE], 'admin' )
			) {
				require_once AFFILIATES_CORE_LIB . '/class-affiliates-generator.php';
				$post_ids = Affiliates_Generator::setup_pages();
				foreach ( $post_ids as $post_id ) {
					$link = '<a href="' . get_permalink( $post_id ) . '" target="_blank">' . esc_html( get_the_title( $post_id ) ) . '</a>';
					$pages_generated_info .= '<div class="info">' . wp_kses( __( sprintf( 'The %s page has been created.', $link ), 'affiliates' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ) . '</div>';
				}
			}
		}

		echo '<h3>' . esc_html__( '發電機', 'affiliates' ) . '</h3>';

		//
		// Generator form
		//
		echo
			'<form action="" name="options" method="post">' .
			'<div>' .
			'<p>' .
			esc_html__( '按按鈕生成默認聯屬網絡區域。', 'affiliates' ) .
			' ' .
			'<input class="generate button" name="generate" type="submit" value="' . __( '產生', 'affiliates' ) .'" />' .
			wp_nonce_field( 'admin', AFFILIATES_ADMIN_SETTINGS_GEN_NONCE, true, false ) .
			'</p>' .
			$pages_generated_info . // @codingStandardsIgnoreLine
			'</div>' .
			'</form>';

		echo '<p>';
		echo esc_html__( '生成的頁麵包含聯屬營銷短代碼，可用作開箱即用的聯屬營銷區域或用作自定義聯屬營銷區域和頁面的框架。', 'affiliates' );
		echo '</p>';

		//
		// Pages containing affiliates shortcodes
		//
		echo '<h3>' . esc_html__( '頁數', 'affiliates' ) . '</h3>';

		$post_ids = array();
		// We also have [referrer], [referrer_id] and [referrer_user] but these are not essential in
		// determining whether an affiliate page has been set up.
		$posts = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%[affiliates\_%' AND post_status = 'publish'" );
		foreach( $posts as $post ) {
			$post_ids[] = $post->ID;
		}

		if ( count( $posts ) == 0 ) {
			echo '<p>';
			echo esc_html__( '您似乎還沒有為您的聯屬會員設置任何頁面。', 'affiliates' );
			echo '</p>';
			echo '<p>';
			echo esc_html__( '您可以使用頁面生成選項為您的聯屬會員創建默認聯屬會員區域。', 'affiliates' );
			echo '</p>';
		} else {
			echo '<p>';
			echo esc_html( _n(
				'已檢測到此頁麵包含附屬機構短代碼：',
				'已檢測到包含附屬機構短代碼的這些頁面：',
				count( $posts ),
				'affiliates'
			) );
			echo '</p>';
			$post_list = '<ul>';
			foreach( $post_ids as $post_id ) {
				$post_title = get_the_title( $post_id );
				$post_list .= sprintf(
					'<li><a href="%s">%s</a></li>',
					esc_url( get_permalink( $post_id ) ),
					esc_html( $post_title )
				);
			}
			$post_list .= '</ul>';
			echo $post_list;
		}

		echo '<p>';
		esc_html_e( '您可以修改默認的聯屬網絡營銷區域，還可以使用短代碼為您的聯屬營銷網絡創建自定義頁面。', 'affiliates' );
		echo '</p>';
		

	}
}
