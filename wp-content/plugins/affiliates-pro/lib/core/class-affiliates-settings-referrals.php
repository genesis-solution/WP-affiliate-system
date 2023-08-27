<?php
/**
 * class-affiliates-settings-general.php
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
 * Referral settings section.
 */
class Affiliates_Settings_Referrals extends Affiliates_Settings {

	/**
	 * Renders the referrals section.
	 */
	public static function section() {

		if ( isset( $_POST['submit'] ) ) {

			if (
				isset( $_POST[AFFILIATES_ADMIN_SETTINGS_NONCE] ) &&
				wp_verify_nonce( $_POST[AFFILIATES_ADMIN_SETTINGS_NONCE], 'admin' )
			) {

				// timeout
				$timeout = intval ( $_POST['timeout'] );
				if ( $timeout < 0 ) {
					$timeout = 0;
				}
				update_option( 'aff_cookie_timeout_days', $timeout );

				// direct referrals?
				delete_option( 'aff_use_direct' );
				add_option( 'aff_use_direct', !empty( $_POST['use-direct'] ), '', 'no' );

				// default status
				if ( !empty( $_POST['status'] ) && ( Affiliates_Utility::verify_referral_status_transition( $_POST['status'], $_POST['status'] ) ) ) {
					update_option( 'aff_default_referral_status', $_POST['status'] );
				} else {
					update_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED );
				}

				// allow duplicates?
				delete_option( 'aff_duplicates' );
				add_option( 'aff_duplicates', !empty( $_POST['duplicates'] ), '', 'no' );

				// auto
				delete_option( 'aff_allow_auto' );
				add_option( 'aff_allow_auto', !empty( $_POST['allow_auto'] ) ? 'yes' : 'no', '', 'no' );

				delete_option( 'aff_allow_auto_coupons' );
				add_option( 'aff_allow_auto_coupons', !empty( $_POST['allow_auto_coupons'] ) ? 'yes' : 'no', '', 'no' );

				self::settings_saved_notice();
			}
		}

		$timeout         = 100; // get_option( 'aff_cookie_timeout_days', AFFILIATES_COOKIE_TIMEOUT_DAYS );
		$use_direct      = get_option( 'aff_use_direct', false );
		$duplicates      = get_option( 'aff_duplicates', false );
		$allow_auto      = get_option( 'aff_allow_auto', 'no' ) == 'yes';
		$allow_auto_coupons = get_option( 'aff_allow_auto_coupons', 'no' ) == 'yes';
		$default_status  = get_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED );
		$status_descriptions = array(
			AFFILIATES_REFERRAL_STATUS_ACCEPTED => __('已接受', 'affiliates' ),
			AFFILIATES_REFERRAL_STATUS_CLOSED   => __('關閉', 'affiliates' ),
			AFFILIATES_REFERRAL_STATUS_PENDING  => __('待辦的', 'affiliates' ),
			AFFILIATES_REFERRAL_STATUS_REJECTED => __('拒絕', 'affiliates' ),
		);
		$status_select = "<select name='status'>";
		foreach ( $status_descriptions as $status_key => $status_value ) {
			if ( $status_key == $default_status ) {
				$selected = "selected='selected'";
			} else {
				$selected = "";
			}
			$status_select .= "<option value='$status_key' $selected>$status_value</option>";
		}
		$status_select .= "</select>";

		echo
			'<form action="" name="options" method="post">' .
				'<div>' .
				'<h3>' . __( 'Referral timeout', 'affiliates' ) . '</h3>' .
				'<p>' .
				'<label>' .
				'<input class="timeout" name="timeout" type="text" value="' . esc_attr( intval( $timeout ) ) . '" />' .
				' ' .
				__( '天', 'affiliates' ) .
				'</label>' .
				'</p>' .
				'<p class="description">' .
				__( '這是自訪問者通過聯屬鏈接訪問您的網站以來的天數，在此期間建議的推薦將有效。', 'affiliates' ) .
				'</p>' .
				'<p>' .
				__( '如果您輸入 0，則推薦僅在訪問者關閉瀏覽器（會話）之前有效。', 'affiliates' ) .
				'</p>' .
				'<p>' .
				sprintf(
					__( '默認值為 %d。 在這種情況下，如果訪問者通過聯屬鏈接訪問您的網站，則建議的推薦將在她或他點擊該聯屬鏈接後 %d 天內有效。', 'affiliates' ),
					AFFILIATES_COOKIE_TIMEOUT_DAYS,
					AFFILIATES_COOKIE_TIMEOUT_DAYS
				) .
				'</p>';

		echo
			'<h3>' . __( '直接推薦', 'affiliates' ) . '</h3>' .
			'<p>' .
			'<label>' .
			'<input name="use-direct" type="checkbox" ' . ( $use_direct ? 'checked="checked"' : '' ) . '/>' .
			' ' .
			__( '存儲直接推薦', 'affiliates' ) .
			'</label>' .
			'</p>' .
			'<p class="description">' .
			__( '如果啟用此選項，則每當建議推薦且沒有聯屬會員歸因時，該推薦將歸因於 Direct。', 'affiliates' ) .
			'</p>';

		echo
			'<h3>' . __( '默認推薦狀態', 'affiliates' ) . '</h3>' .
			'<p>' .
			$status_select .
			'</p>';

		echo
			'<h3>' . __( '重複推薦', 'affiliates' ) . '</h3>' .
			'<p>' .
			'<label>' .
			'<input name="duplicates" type="checkbox" ' . ( $duplicates ? 'checked="checked"' : '' ) . '/>' .
			' ' .
			__( '允許重複推薦', 'affiliates' ) .
			'</label>' .
			'</p>' .
			'<p class="description">' .
			__( '允許記錄同一附屬機構的重複推薦（基於金額、貨幣、內部類型和參考）。', 'affiliates' ) .
			'</p>';

		echo
			'<h3>' . __( 'Auto-referrals', 'affiliates' ) . '</h3>' .
			'<p>' .
			'<label>' .
			sprintf( '<input type="checkbox" name="allow_auto" %s" />', $allow_auto == 'yes' ? ' checked="checked" ' : '' ) .
			' ' .
			__( '允許自動推薦', 'affiliates' ) .
			'</label>' .
			'</p>' .
			'<p class="description">' .
			__( '如果啟用此選項，則允許附屬機構自行推薦。', 'affiliates' ) .
			' ' .
			__( '此選項允許聯屬公司在涉及該聯屬公司作為客戶或潛在客戶的交易中賺取佣金。', 'affiliates' ) .
			' ' .
			__( '當針對與聯營公司相同的用戶或用戶電子郵件處理交易時，或者當涉及使用分配給聯營公司的優惠券時，自動推薦即被識別。', 'affiliates' ) .
			'</p>' .
			'<p>' .
			'<label>' .
			sprintf( '<input type="checkbox" name="allow_auto_coupons" %s" />', $allow_auto_coupons ? ' checked="checked" ' : '' ) .
			' ' .
			__( '允許自動優惠券', 'affiliates' ) .
			'</label>' .
			'</p>' .
			'<p class="description">' .
			__( '允許聯營公司應用分配給他們的優惠券。', 'affiliates' ) .
			' ' .
			__( '通過 WooCommerce 管理的優惠券支持驗證。', 'affiliates' ) .
			'</p>';

		echo
			'<p>' .
			wp_nonce_field( 'admin', AFFILIATES_ADMIN_SETTINGS_NONCE, true, false ) .
			'<input class="button button-primary" type="submit" name="submit" value="' . __('節省', 'affiliates' ) . '"/>' .
			'</p>' .
			'</div>' .
			'</form>';

		
	}
}
