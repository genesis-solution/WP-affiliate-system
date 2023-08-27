<?php
/**
 * affiliates-admin-user-registration.php
 *
 * Copyright (c) 2010 - 2014 "kento" Karim Rahimpur www.itthinx.com
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
 * @since 2.7.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

require_once AFFILIATES_CORE_LIB . '/class-affiliates-user-registration.php';

function affiliates_admin_user_registration() {

	if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) {
		wp_die( __( '拒絕訪問。', 'affiliates' ) );
	}

	echo '<h1>';
	echo __( '用戶註冊', 'affiliates' );
	echo '</h1>';

	echo '<p class="description">';
	echo __( '在這裡，您可以啟用內置的用戶註冊集成，該集成允許在關聯公司推薦新用戶時向其授予佣金。', 'affiliates' );
	echo '</p>';

	// save
	if ( isset( $_POST['action'] ) && $_POST['action'] == 'save' ) {
		if ( isset( $_POST['affiliates-user-registraton-admin'] ) && wp_verify_nonce( $_POST['affiliates-user-registraton-admin'], 'save' ) ) {

			delete_option( 'aff_user_registration_enabled' );
			if ( !empty( $_POST['enabled'] ) ) {
				add_option( 'aff_user_registration_enabled', 'yes', '', 'no' );
			}

			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				delete_option( 'aff_customer_registration_enabled' );
				if ( !empty( $_POST['customer_enabled'] ) ) {
					add_option( 'aff_customer_registration_enabled', 'yes', '', 'no' );
				}
			}

			if ( AFFILIATES_PLUGIN_NAME != 'affiliates' ) {
				delete_option( 'aff_user_registration_base_amount' );
				if ( !empty( $_POST['base_amount'] ) ) {
					$base_amount = floatval( $_POST['base_amount'] );
					if ( $base_amount < 0 ) {
						$base_amount = 0;
					}
					add_option( 'aff_user_registration_base_amount', $base_amount, '', 'no' );
				}
			}

			delete_option( 'aff_user_registration_amount' );
			if ( !empty( $_POST['amount'] ) ) {
				$amount = floatval( $_POST['amount'] );
				if ( $amount < 0 ) {
					$amount = 0;
				}
				add_option( 'aff_user_registration_amount', $amount, '', 'no' );
			}

			delete_option( 'aff_user_registration_currency' );
			if ( !empty( $_POST['currency'] ) ) {
				add_option( 'aff_user_registration_currency', $_POST['currency'], '', 'no' );
			}

			delete_option( 'aff_user_registration_referral_status' );
			if ( !empty( $_POST['status'] ) ) {
				add_option( 'aff_user_registration_referral_status', $_POST['status'], '', 'no' );
			}
		}
	}

	$user_registration_enabled     = get_option( 'aff_user_registration_enabled', 'no' );
	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		$customer_registration_enabled = get_option( 'aff_customer_registration_enabled', 'no' );
	}
	if ( AFFILIATES_PLUGIN_NAME != 'affiliates' ) {
		$user_registration_base_amount = get_option( 'aff_user_registration_base_amount', '' );
	}
	$user_registration_amount      = get_option( 'aff_user_registration_amount', '0' );
	$user_registration_currency    = get_option( 'aff_user_registration_currency', Affiliates::DEFAULT_CURRENCY );
	$user_registration_referral_status = get_option(
		'aff_user_registration_referral_status',
		get_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED )
	);

	echo '<style type="text/css">';
	echo 'div.field { padding: 0 1em 1em 0; }';
	echo 'div.field.user-registration-base-amount input { width: 5em; text-align: right;}';
	echo 'div.field.user-registration-amount input { width: 5em; text-align: right;}';
	echo 'div.field span.label { display: inline-block; width: 20%; }';
	echo 'div.field span.description { display: block; }';
	echo 'div.buttons { padding-top: 1em; }';
	echo '</style>';

	echo '<form action="" name="user_registration" method="post">';
	echo '<div>';

	// enable
	echo '<div class="field user-registration-enabled">';
	echo '<label>';
	printf( '<input type="checkbox" name="enabled" value="1" %s />', $user_registration_enabled == 'yes' ? ' checked="checked" ' : '' );
	echo ' ';
	echo __( '啟用用戶註冊集成', 'affiliates' );
	echo '</label>';
	echo '</div>';

	// enable customer
	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		echo '<div class="field customer-registration-enabled">';
		echo '<label>';
		printf( '<input type="checkbox" name="customer_enabled" value="1" %s />', $customer_registration_enabled == 'yes' ? ' checked="checked" ' : '' );
		echo ' ';
		echo __( '啟用 WooCommerce 客戶註冊集成', '附屬機構', 'affiliates' );
		echo '</label>';
		echo ' ';
		echo '<span class="description">';
		echo __( '如果用戶註冊集成應為結賬時註冊的新客戶創建推薦，則應啟用此選項。', 'affiliates' );
		echo '</span>';
		echo '</div>';
	}

	// base amount
	if ( AFFILIATES_PLUGIN_NAME != 'affiliates' ) {
		echo '<div class="field user-registration-base-amount">';
		echo '<label>';
		echo '<span class="label">';
		echo __( '基礎金額', 'affiliates' );
		echo '</span>';
		echo ' ';
		printf( '<input type="text" name="base_amount" value="%s"/>', esc_attr( $user_registration_base_amount ) );
		echo '</label>';
		echo '<span class="description">';
		echo __( '當聯屬會員推薦新用戶時，系統會記錄推薦，並以所選貨幣向聯屬會員授予一定金額。 該金額的計算考慮了該基本金額。 例如，如果設置了一般推薦率，則推薦金額等於該基本金額乘以推薦率。', 'affiliates' );
		echo ' ';
		echo __( '如果設置，此<strong>基本金額</strong>優先於<strong>金額</strong>。', 'affiliates' );
		if ( AFFILIATES_PLUGIN_NAME == 'affiliates-enterprise' ) {
			echo ' ';
			echo __( '如果啟用了多層推薦並且等級率不是相對的，則必須使用此<strong>基本金額</strong>而不是<strong>金額</strong>。', 'affiliates' );
		}
		echo '</span>';
		echo '</div>';
	}

	// amount
	echo '<div class="field user-registration-amount">';
	echo '<label>';
	echo '<span class="label">';
	echo __('數量', 'affiliates' );
	echo '</span>';
	echo ' ';
	printf( '<input type="text" name="amount" value="%s"/>', esc_attr( $user_registration_amount ) );
	echo '</label>';
	echo '<span class="description">';
	echo __( '當聯屬會員推薦新用戶時，系統會記錄推薦，並以所選貨幣向聯屬會員授予這筆金額。', 'affiliates' );
	echo '</span>';
	echo '</div>';

	// currency
	$currency_select = '<select name="currency">';
	foreach( apply_filters( 'affiliates_supported_currencies', Affiliates::$supported_currencies ) as $cid ) {
		$selected = ( $user_registration_currency == $cid ) ? ' selected="selected" ' : '';
		$currency_select .= '<option ' . $selected . ' value="' .esc_attr( $cid ).'">' . $cid . '</option>';
	}
	$currency_select .= '</select>';
	echo '<div class="field user-registration-currency">';
	echo '<label>';
	echo '<span class="label">';
	echo __('貨幣', 'affiliates' );
	echo '</span>';
	echo ' ';
	echo $currency_select;
	echo '</label>';
	echo '</div>';

	$status_descriptions = array(
		AFFILIATES_REFERRAL_STATUS_ACCEPTED => __('已接受', 'affiliates' ),
		AFFILIATES_REFERRAL_STATUS_CLOSED   => __('關閉', 'affiliates' ),
		AFFILIATES_REFERRAL_STATUS_PENDING  => __('待辦的', 'affiliates' ),
		AFFILIATES_REFERRAL_STATUS_REJECTED => __('拒絕', 'affiliates' ),
	);
	$status_select = "<select name='status'>";
	foreach ( $status_descriptions as $status_key => $status_value ) {
		if ( $status_key == $user_registration_referral_status ) {
			$selected = "selected='selected'";
		} else {
			$selected = "";
		}
		$status_select .= "<option value='$status_key' $selected>$status_value</option>";
	}
	$status_select .= "</select>";
	echo '<div class="field user-registration-referral-status">';
	echo '<label>';
	echo '<span class="label">';
	echo __('推薦狀態', 'affiliates' );
	echo '</span>';
	echo ' ';
	echo $status_select;
	echo '</label>';
	echo '<p class="description">';
	echo __( '當聯營公司推薦新用戶時記錄佣金的推薦狀態。', 'affiliates' );
	echo '</p>';
	echo '</div>';

	echo '<p>';
	echo __( '推薦狀態的推薦選擇為“已接受”和“待處理”。', 'affiliates' );
	echo '</p>';

	echo '<ul>';
	echo '<li>';
	echo __( '<strong>接受</strong>，如果這些推薦應向聯營公司提供應付佣金，而無需進一步審核。', 'affiliates' );
	echo '</li>';

	echo '<li>';
	echo __( '<strong>待定</strong>，如果在將佣金計入聯屬網絡營銷支出之前要對這些推薦進行審核。', 'affiliates' );
	echo '</li>';
	echo '</ul>';

	echo '<div class="buttons">';
	wp_nonce_field( 'save', 'affiliates-user-registraton-admin', true, true );
	echo '<input class="button button-primary" type="submit" name="submit" value="' . __('節省', 'affiliates' ) . '"/>';
	echo '<input type="hidden" name="action" value="save"/>';
	echo '</div>';

	echo '</div>';
	echo '</form>';

	
}
