<?php
/**
 * class-affiliates-admin-menu-wordpress.php
 *
 * Copyright (c) 2011 "kento" Karim Rahimpur www.itthinx.com
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
 * @since affiliates-pro 1.0.2
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Menu.
 */
class Affiliates_Admin_Menu_WordPress {

	const NONCE = 'aff-admin-menu';
	const SETTINGS = 'aff-settings';

	public static function init() { add_action( 'affiliates_admin_menu', array( __CLASS__, 'affiliates_admin_menu' ) ); add_action( 'affiliates_admin_menu', array( __CLASS__, 'affiliates_admin_menu_sort' ), 999 ); add_filter( 'affiliates_settings_sections', array( __CLASS__, 'affiliates_settings_sections' ) ); add_action( 'affiliates_settings_section', array( __CLASS__, 'affiliates_settings_section' ) ); add_filter( 'affiliates_help_tab_footer', array( __CLASS__, 'affiliates_help_tab_footer' ) ); add_filter( 'affiliates_help_tab_title', array( __CLASS__, 'affiliates_help_tab_title' ) ); }

	public static function affiliates_settings_sections( $sections ) { $sections['commissions'] = __( '佣金', 'affiliates' ); return $sections; }

	public static function affiliates_settings_section( $section ) { if ( $section == 'commissions' ) { self::affiliates_admin_settings(); } }

	public static function affiliates_admin_menu() { global $submenu; $IX93863 = get_post_type_object( 'affiliates_banner' ); $IX85196 = add_submenu_page( 'affiliates-admin', $IX93863->labels->name, $IX93863->labels->all_items, $IX93863->cap->edit_posts, "edit.php?post_type=affiliates_banner" ); $IX33238[] = $IX85196; $IX85196 = add_submenu_page( 'affiliates-admin', __( '總計', 'affiliates' ), __( '總計', 'affiliates' ), AFFILIATES_ACCESS_AFFILIATES, 'affiliates-admin-totals', array( 'Affiliates_Totals_WordPress', 'view' ) ); $IX33238[] = $IX85196; add_action( 'admin_print_styles-' . $IX85196, 'affiliates_admin_print_styles' ); add_action( 'admin_print_scripts-' . $IX85196, 'affiliates_admin_print_scripts' ); add_action( 'admin_print_styles-' . $IX85196, 'affiliates_pro_admin_print_styles' ); add_action( 'admin_print_scripts-' . $IX85196, 'affiliates_pro_admin_print_scripts' ); }

	public static function affiliates_admin_menu_sort() {
        global $submenu;
        if ( isset( $submenu['affiliates-admin'] ))
        {
            usort( $submenu['affiliates-admin'], array( __CLASS__, 'menu_sort' ) );
        }
    }

	public static function menu_sort( $o1, $o2 ) {
        global $submenu;
        $IX83259 = 0;
        $IX18839 = array( 'affiliates-admin' => 0,
            'affiliates-admin-affiliates' => 1,
            'affiliates-admin-share-token-affiliates' => 2,
            'affiliates-admin-hits' => 3,
            'affiliates-admin-hits-affiliate' => 4,
            'affiliates-admin-hits-uri' => 5,
            'affiliates-admin-referrals' => 6,
            'affiliates-admin-totals' => 7,
            'edit.php?post_type=affiliates_banner' => 8,
            'affiliates-admin-options' => 9,
            'affiliates-admin-settings' => 10,
            'affiliates-admin-rates' => 11,
            'affiliates-admin-notifications' => 12,
            'affiliates-admin-user-registration' => 13,
            'affiliates-admin-tiers' => 14,
            'affiliates-admin-campaigns' => 15
            //'affiliates-admin-add-ons' => 999
        );
        $IX30900 = isset( $o1[2] ) && isset( $IX18839[$o1[2]] ) ? $IX18839[$o1[2]] : 100;
        $IX83950 = isset( $o2[2] ) && isset( $IX18839[$o2[2]] ) ? $IX18839[$o2[2]] : 100;
        $IX83259 = $IX30900 - $IX83950;
        return $IX83259;
    }

	public static function affiliates_admin_settings() {
        if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) {
            wp_die( __( '拒絕訪問。', 'affiliates' ) ); } $IX13168 = Affiliates_Referral::get_referral_amount_methods(); $IX74635 = array(); foreach ( $IX13168 as $IX44916 ) { if ( is_array( $IX44916 ) ) { $IX95052 = implode( "::", $IX44916 ); } else { $IX95052 = $IX44916; } $IX74635[$IX95052] = $IX95052; } $IX74635 = array_merge( array( '' => __( '沒有任何', 'affiliates' ) ), $IX74635 ); if ( isset( $_POST['submit'] ) ) { if ( isset( $_POST[self::NONCE] ) && wp_verify_nonce( $_POST[self::NONCE], self::SETTINGS ) ) { if ( !empty( $_POST[Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY] ) ) { $IX15898 = trim( $_POST[Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY] ); if ( $IX15898 = Affiliates_Attributes::validate_key( $IX15898 ) ) { update_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY, $IX15898 ); } else { $IX15898 = ''; delete_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY ); } } else { $IX15898 = ''; delete_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY ); } if ( !empty( $_POST[Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE] ) ) { $IX64645 = trim( $_POST[Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE] ); if ( $IX64645 = Affiliates_Attributes::validate_value( $IX15898, $IX64645 ) ) { update_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE, $IX64645 ); } else { $IX64645 = ''; delete_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE ); } } else { $IX64645 = ''; delete_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE ); } Affiliates_Settings::settings_saved_notice(); } } $IX15898 = get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY, '' );
        $IX64645 = get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE, '' );
        $IX12025 = array_merge( array( '' => __( '價格', 'affiliates' ) ), Affiliates_Attributes::get_keys() );
        unset( $IX12025[Affiliates_Attributes::PAYPAL_EMAIL] ); unset( $IX12025[Affiliates_Attributes::COUPONS] ); unset( $IX12025[Affiliates_Attributes::COOKIE_TIMEOUT_DAYS] ); $IX66289 = '<select id ="' . Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY . '" name="' . Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY . '">'; foreach ( $IX12025 as $IX40180 => $IX30638 ) { $IX33288 = ( $IX40180 == $IX15898 ) ? ' selected="selected" ' : ''; $IX66289 .= '<option value="' . $IX40180 . '" ' . $IX33288 . '>' . $IX30638 . '</option>'; } $IX66289 .= '</select>'; $IX95838 = ''; $IX48283 = '<input name="' . Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE . '" type="text" value="' . esc_attr( !is_array( $IX64645 ) ? $IX64645 : '' ) . '" />'; $IX76104 = '<select name="' . Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE . '">'; foreach ( $IX74635 as $IX40180 => $IX95052 ) { $IX33288 = ( Affiliates_Referral::get_referral_amount_method( $IX40180 ) == Affiliates_Referral::get_referral_amount_method( $IX64645 ) ) ? ' selected="selected" ' : ''; $IX76104 .= '<option value="' . $IX40180 . '" ' . $IX33288 . '>' . $IX95052 . '</option>'; } $IX76104 .= '</select>'; switch ( $IX15898 ) { case '' : $IX20284 = $IX95838; break; case Affiliates_Attributes::REFERRAL_AMOUNT_METHOD : $IX20284 = $IX76104; break; default: $IX20284 = $IX48283; } echo '<form action="" name="options" method="post">' . '<div>' . '<p class="description">' . __( '這些設置通常用於計算聯營公司的佣金。', 'affiliates' ) . '</p>' . '<p>' . sprintf( '<label title="%s" for="' . Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY . '">', __( '默認推薦計算', 'affiliates' ) ) . __( '方法', 'affiliates' ) . ' ' . $IX66289 . '</label>' . '</p>' . '<p>' . sprintf( '<label title="%s" for="' . Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE . '">', __( '默認推薦計算值', 'affiliates' ) ) . __( '價值', 'affiliates' ) . ' <span id="method-value-input-container">'. $IX20284 . '</span>' . '</label>' . '</p>' . '<p>' . wp_nonce_field( self::SETTINGS, self::NONCE, true, false ) . '<input class="button button-primary" type="submit" name="submit" value="' . __( '節省', 'affiliates' ) . '"/>' . '</p>' . '</div>' . '</form>'; echo '<script type="text/javascript">'; echo 'document.addEventListener( "DOMContentLoaded", function() {'; echo 'if (typeof jQuery !== "undefined" ) {'; echo 'jQuery("#'.Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY.'").change(function(e){'; echo sprintf( 'if ( jQuery(this).val() == "%s" ) {', Affiliates_Attributes::REFERRAL_AMOUNT_METHOD ); echo sprintf( 'jQuery("#method-value-input-container").html(\'%s\');', $IX76104 ); echo '} else if ( jQuery(this).val() == "" ) {'; echo sprintf( 'jQuery("#method-value-input-container").html(\'%s\');', $IX95838 ); echo '} else {'; echo sprintf( 'jQuery("#method-value-input-container").html(\'%s\');', $IX48283 ); echo '}'; echo '});'; echo '}'; echo '} );'; echo '</script>'; echo '<div style="margin: 1em 1em 1em inherit; padding:0.31em 0.62em; background-color:#fff;">'; echo '<p>'; echo '<strong>'; echo __( '選擇哪種方法;', 'affiliates' ); echo '</strong>'; echo '</p>'; echo '<p>'; printf( __( '推薦的方法是<em>費率</em>，它根據<a href="%s">費率</a>部分中的定義計算佣金。', 'affiliates' ), esc_url( admin_url( 'admin.php?page=affiliates-admin-rates' ) ) ); echo ' '; echo __( '所有其他選擇均代表遺留選項。', 'affiliates' ); echo '</p>'; echo '<ul>'; echo '<li>'; echo '<em>' . __( '價格', 'affiliates' ) . '</em>'; echo ' &mdash; '; printf( __( '根據<a href="%s">費率</a>部分中的定義計算佣金。', 'affiliates' ), esc_url( admin_url( 'admin.php?page=affiliates-admin-rates' ) ) ); echo '</li>'; echo '<li>'; echo '<em>' . __( '推薦率', 'affiliates' ) . '</em>'; echo ' &mdash; '; echo __( '(遺產)', 'affiliates' ); echo ' '; echo __( '佣金金額與原始交易金額成正比。', 'affiliates' ); echo ' '; echo __( '如果佣金佔銷售額的百分比，則建議這樣做。', 'affiliates' ); echo ' '; echo __( '請注意，指示的值是一個費率，例如，要授予 10% 的銷售佣金，請指示 <code>0.10</code> 作為該值。', 'affiliates' ); echo ' '; echo __( '另請注意，如果該值等於或大於 <code>1</code>，則將授予高於實際（淨）購買金額的佣金金額 - 通常不希望出現這種情況。', 'affiliates' ); echo ' '; echo __( '使用 <code>0</code> 會導致佣金金額為零。', 'affiliates' ); echo '</li>'; echo '<li>'; echo '<em>' . __( '推薦金額', 'affiliates' ) . '</em>'; echo ' &mdash; '; echo __( '(遺產)', 'affiliates' ); echo ' '; echo __( '每次推薦都會獲得固定的佣金金額。', 'affiliates' ); echo '</li>'; echo '<li>'; echo '<em>' . __( '推薦金額方法', 'affiliates' ) . '</em>'; echo ' &mdash; '; echo __( '(遺產)', 'affiliates' ); echo ' '; echo __( '佣金金額是通過特定算法計算的。', 'affiliates' ); echo '</li>'; echo '</ul>'; echo '</div>'; echo '<h3>'; echo __( '遷移率 2.x', 'affiliates' ); echo '</h3>'; echo '<p>'; echo __( '從舊選項切換到<em>費率</em>之前，請使用這些按鈕從現有數據生成費率條目。', 'affiliates' ); echo '</p>'; require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/class-affiliates-upgrade-3.php'; Affiliates_Upgrade_3::form(); echo '<p class="description">'; echo __( '使用這些按鈕可從 2.x 版本遷移推薦率。', 'affiliates' ); echo '</p>'; echo '<p>'; echo __( '創建費率條目後，您可以將上面的<em>方法</em>設置切換為<em>費率</em>。', 'affiliates' ); echo ' '; echo __( '請注意，這僅支持<em>推薦金額</em>和<em>推薦費率</em>類型的方法，不會為<em>推薦金額方法</em>創建費率條目。', 'affiliates' ); echo ' '; echo __( '如果一般或某些聯營公司使用<em>推薦金額方法</em>，目前不建議切換到<em>費率</em>。', 'affiliates' ); echo '</p>';  }

	public static function affiliates_admin_totals() { }

	public static function get_help_tab_footer() {
        return "";
    }

	public static function affiliates_help_tab_footer( $footer ) { return self::get_help_tab_footer(); }

	public static function affiliates_help_tab_title( $title ) {
        return "";
    }
}
Affiliates_Admin_Menu_WordPress::init();
