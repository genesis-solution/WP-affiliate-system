<?php
/**
 * class-affiliates-upgrade.3.php
 *
 * Copyright 2017 "kento" Karim Rahimpur - www.itthinx.com
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
 * @author itthinx
 * @package affiliates-pro
 * @since affiliates-pro 3.0.0
 */

/**
 * Migrate data to 3.x
 *
 * We do not handle 'referral.amount.method' (note that 'referral.rate.method' is never used).
 */
class Affiliates_Upgrade_3 {

	public static function create_all_rates() { self::create_general_rate(); self::create_affiliate_rates(); self::create_level_rates(); self::create_wc_product_rates(); self::create_em_event_rates(); self::create_cf7_rates(); self::create_gf_rates(); self::create_ff_rates(); self::create_nf_rates(); }

	public static function form() { if ( !current_user_can( AFFILIATES_ADMINISTER_OPTIONS ) ) { return ''; } $IX63718 = ''; if ( isset( $_POST['generate-rates'] ) ) { if ( isset( $_POST['_generate_rates'] ) && wp_verify_nonce( $_POST['_generate_rates'], 'generate-rates' ) ) { $IX84265 = isset( $_POST['generate-all'] ) ? 'generate-all' : null; if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-general'] ) ? 'generate-general' : null; } if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-affiliate'] ) ? 'generate-affiliate' : null; } if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-level'] ) ? 'generate-level' : null; } if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-product'] ) ? 'generate-product' : null; } if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-event'] ) ? 'generate-event' : null; } if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-cf7'] ) ? 'generate-cf7' : null; } if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-ff'] ) ? 'generate-ff' : null; } if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-gf'] ) ? 'generate-gf' : null; } if ( $IX84265 === null ) { $IX84265 = isset( $_POST['generate-nf'] ) ? 'generate-nf' : null; } switch( $IX84265 ) { case 'generate-all' : self::create_all_rates(); break; case 'generate-general' : self::create_general_rate(); break; case 'generate-affiliate' : self::create_affiliate_rates(); break; case 'generate-level' : self::create_level_rates(); break; case 'generate-product' : self::create_wc_product_rates(); break; case 'generate-event' : self::create_em_event_rates(); break; case 'generate-cf7' : self::create_cf7_rates(); break; case 'generate-ff' : self::create_ff_rates(); break; case 'generate-gf' : self::create_gf_rates(); break; case 'generate-nf' : self::create_nf_rates(); break; } if ( $IX84265 ) { $IX63718 .= '<div class="updated">'; $IX63718 .= '<p>'; $IX63718 .= '<strong>'; $IX63718 .= __( 'Generation action executed.', 'affiliates' ); $IX63718 .= '</strong>'; $IX63718 .= '</p>'; $IX63718 .= '<p>'; $IX63718 .= __( 'Please check the <em>Rates</em> section to verify that all necessary rate entries have been created.', 'affiliates' ); $IX63718 .= '</p>'; $IX63718 .= '</div>'; } } } $IX63718 .= '<form action="" name="generate-rates" method="post">'; $IX63718 .= '<div>'; $IX63718 .= '<table>'; $IX63718 .= '<tr>'; $IX63718 .= '<td>'; $IX63718 .= esc_html__( 'All rates', 'affiliates' ); $IX63718 .= '</td>'; $IX63718 .= '<td>'; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-all" value="%s"/>', esc_attr( __( 'Generate all rates', 'affiliates' ) ) ); $IX63718 .= '</td>'; $IX63718 .= '</tr>'; $IX63718 .= '<tr>'; $IX63718 .= '<td>'; $IX63718 .= esc_html__( 'Affiliates', 'affiliates' ); $IX63718 .= '</td>'; $IX63718 .= '<td>'; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-general" value="%s"/>', esc_attr( __( 'General rate', 'affiliates' ) ) ); $IX63718 .= ' '; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-affiliate" value="%s"/>', esc_attr( __( 'Affiliate rates', 'affiliates' ) ) ); $IX63718 .= ' '; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-level" value="%s"/>', esc_attr( __( 'Level rates', 'affiliates' ) ) ); $IX63718 .= '</td>'; $IX63718 .= '</tr>'; $IX63718 .= '<tr>'; $IX63718 .= '<td>'; $IX63718 .= esc_html__( 'WooCommerce', 'affiliates' ); $IX63718 .= '</td>'; $IX63718 .= '<td>'; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-product" value="%s"/>', esc_attr( __( 'Product rates', 'affiliates' ) ) ); $IX63718 .= '</td>'; $IX63718 .= '</tr>'; $IX63718 .= '<tr>'; $IX63718 .= '<td>'; $IX63718 .= esc_html__( 'Events Manager', 'affiliates' ); $IX63718 .= '</td>'; $IX63718 .= '<td>'; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-event" value="%s"/>', esc_attr( __( 'Event rates', 'affiliates' ) ) ); $IX63718 .= '<td>'; $IX63718 .= '</tr>'; $IX63718 .= '<tr>'; $IX63718 .= '<td>'; $IX63718 .= esc_html__( 'Contact Form 7', 'affiliates' ); $IX63718 .= '</td>'; $IX63718 .= '<td>'; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-cf7" value="%s"/>', esc_attr( __( 'Form rates', 'affiliates' ) ) ); $IX63718 .= '<td>'; $IX63718 .= '</tr>'; $IX63718 .= '<tr>'; $IX63718 .= '<td>'; $IX63718 .= esc_html__( 'Formidable Forms', 'affiliates' ); $IX63718 .= '</td>'; $IX63718 .= '<td>'; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-ff" value="%s"/>', esc_attr( __( 'Form rates', 'affiliates' ) ) ); $IX63718 .= '<td>'; $IX63718 .= '</tr>'; $IX63718 .= '<tr>'; $IX63718 .= '<td>'; $IX63718 .= esc_html__( 'Gravity Forms', 'affiliates' ); $IX63718 .= '</td>'; $IX63718 .= '<td>'; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-gf" value="%s"/>', esc_attr( __( 'Form rates', 'affiliates' ) ) ); $IX63718 .= '<td>'; $IX63718 .= '</tr>'; $IX63718 .= '<tr>'; $IX63718 .= '<td>'; $IX63718 .= esc_html__( 'Ninja Forms', 'affiliates' ); $IX63718 .= '</td>'; $IX63718 .= '<td>'; $IX63718 .= sprintf( '<input class="button" type="submit" name="generate-nf" value="%s"/>', esc_attr( __( 'Form rates', 'affiliates' ) ) ); $IX63718 .= '<td>'; $IX63718 .= '</tr>'; $IX63718 .= '</table>'; $IX63718 .= '<input type="hidden" name="generate-rates" value="1" />'; $IX63718 .= wp_nonce_field( 'generate-rates', '_generate_rates', true, false ); $IX63718 .= '</div>'; $IX63718 .= '</form>'; echo $IX63718; }

	public static function create_general_rate() { $IX68941 = get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY, null ); $IX31943 = get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE, null ); switch ( $IX68941 ) { case 'referral.amount' : $IX81071 = AFFILIATES_PRO_RATES_TYPE_AMOUNT; break; case 'referral.rate' : $IX81071 = AFFILIATES_PRO_RATES_TYPE_RATE; break; default : $IX81071 = null; } if ( $IX81071 !== null ) { $IX65260 = new Affiliates_Rate( (object) array( 'type' => $IX81071, 'value' => $IX31943, 'description' => __( 'Automatically generated from general rate.', 'affiliates' ) ) ); if ( !$IX65260->exists_other() ) { $IX65260->create(); } } }

	public static function create_affiliate_rates() { global $affiliates_db; $IX86019 = $affiliates_db->get_tablename( 'affiliates_attributes' ); if ( $IX28422 = $affiliates_db->get_objects( "SELECT * FROM $IX86019 WHERE attr_key IN ('referral.amount','referral.rate')" ) ) { if ( is_array( $IX28422 ) ) { foreach( $IX28422 as $IX88591 ) { $IX28485 = $IX88591->affiliate_id; $IX63119 = affiliates_get_affiliate_status( $IX28485 ); if ( $IX63119 === AFFILIATES_AFFILIATE_STATUS_DELETED ) { continue; } switch( $IX88591->attr_key ) { case 'referral.amount' : $IX65477 = AFFILIATES_PRO_RATES_TYPE_AMOUNT; break; case 'referral.rate' : $IX65477 = AFFILIATES_PRO_RATES_TYPE_RATE; break; default : $IX65477 = null; } if ( $IX65477 !== null ) { $IX30479 = $IX88591->attr_value; $IX34532 = new Affiliates_Rate( (object) array( 'affiliate_id' => $IX28485, 'type' => $IX65477, 'value' => $IX30479, 'description' => __( 'Automatically generated from affiliate rate.', 'affiliates' ) ) ); if ( !$IX34532->exists_other() ) { $IX34532->create(); } } } } } }

	public static function create_level_rates() { global $affiliates_db; if ( class_exists( 'Affiliates_Multi_Tier' ) ) { $IX72638 = get_option( Affiliates_Multi_Tier::TIER_RATES, array() ); $IX94530 = get_option( Affiliates_Multi_Tier::N_TIERS, Affiliates_Multi_Tier::MAX_TIERS ); $IX88159 = get_option( Affiliates_Multi_Tier::RELATIVE_TIER_RATES, false ); if ( is_array( $IX72638 ) ) { foreach( $IX72638 as $IX20015 => $IX82861 ) { $IX19585 = new Affiliates_Rate( (object) array( 'type' => AFFILIATES_PRO_RATES_TYPE_RATE, 'level' => $IX20015, 'value' => $IX82861, 'description' => __( 'Automatically generated from general tier rate for level.', 'affiliates' ) ) ); if ( $IX88159 ) { $IX19585->set_meta( 'level-relative', true ); } if ( !$IX19585->exists_other() ) { $IX19585->create(); } } } $IX13013 = $affiliates_db->get_tablename( 'affiliates' ); $IX40280 = $affiliates_db->get_objects( "SELECT affiliate_id FROM $IX13013" ); if ( is_array( $IX40280 ) ) { foreach( $IX40280 as $IX24293 ) { $IX63176 = $IX24293->affiliate_id; $IX47866 = affiliates_get_affiliate_status( $IX63176 ); if ( $IX47866 === AFFILIATES_AFFILIATE_STATUS_DELETED ) { continue; } $IX72638 = get_option( Affiliates_Multi_Tier::TIER_RATES . '_' . intval( $IX63176 ), array() ); if ( !empty( $IX72638 ) && is_array( $IX72638 ) ) { foreach( $IX72638 as $IX20015 => $IX82861 ) { $IX19585 = new Affiliates_Rate( (object) array( 'affiliate_id' => $IX63176, 'type' => AFFILIATES_PRO_RATES_TYPE_RATE, 'level' => $IX20015, 'value' => $IX82861, 'description' => __( 'Automatically generated from affiliate tier rate for level.', 'affiliates' ) ) ); if ( $IX88159 ) { $IX19585->set_meta( 'level-relative', true ); } if ( !$IX19585->exists_other() ) { $IX19585->create(); } } } unset( $IX72638 ); } } } }

	public static function create_wc_product_rates() { global $wpdb; if ( class_exists( 'Affiliates_WooCommerce_Integration' ) && defined( 'Affiliates_WooCommerce_Integration::PLUGIN_OPTIONS' ) && defined( 'Affiliates_WooCommerce_Integration::DEFAULT_RATE' ) ) { $IX93715 = get_option( Affiliates_WooCommerce_Integration::PLUGIN_OPTIONS , array() ); $IX67491 = isset( $IX93715[Affiliates_WooCommerce_Integration::DEFAULT_RATE] ) ? $IX93715[Affiliates_WooCommerce_Integration::DEFAULT_RATE] : ''; if ( $IX67491 !== '' ) { $IX70589 = new Affiliates_Rate( (object) array( 'type' => AFFILIATES_PRO_RATES_TYPE_RATE, 'integration' => 'affiliates-woocommerce', 'value' => $IX67491, 'description' => __( 'Automatically generated from default product rate.', 'affiliates' ) ) ); if ( !$IX70589->exists_other() ) { $IX70589->create(); } } } $IX62897 = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts p ON pm.post_id = p.ID WHERE meta_key = '_affiliates_rate' AND p.post_type = 'product'" ); if ( is_array( $IX62897 ) ) { foreach( $IX62897 as $IX64360 ) { $IX70589 = new Affiliates_Rate( (object) array( 'type' => AFFILIATES_PRO_RATES_TYPE_RATE, 'integration' => 'affiliates-woocommerce', 'object_id' => $IX64360->post_id, 'value' => $IX64360->meta_value, 'description' => __( 'Automatically generated from product rate.', 'affiliates' ) ) ); if ( !$IX70589->exists_other() ) { $IX70589->create(); } } } }

	public static function create_em_event_rates() { global $wpdb; if ( class_exists( 'Affiliates_Events_Manager' ) && defined( 'Affiliates_Events_Manager::PLUGIN_OPTIONS' ) && defined( 'Affiliates_Events_Manager::REFERRAL_RATE' ) && defined( 'Affiliates_Events_Manager::DEFAULT_ZERO_VALUE' ) ) { $IX58847 = get_option( Affiliates_Events_Manager::PLUGIN_OPTIONS , array() ); $IX46388 = isset( $IX58847[Affiliates_Events_Manager::REFERRAL_RATE ] ) ? $IX58847[Affiliates_Events_Manager::REFERRAL_RATE] : Affiliates_Events_Manager::DEFAULT_ZERO_VALUE; $IX84084 = new Affiliates_Rate( (object) array( 'type' => AFFILIATES_PRO_RATES_TYPE_RATE, 'integration' => 'affiliates-events-manager', 'value' => $IX46388, 'description' => __( 'Automatically generated from default event rate.', 'affiliates' ) ) ); if ( !$IX84084->exists_other() ) { $IX84084->create(); } } $IX27124 = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts p ON pm.post_id = p.ID WHERE meta_key = 'referral-rate' AND p.post_type = 'event'" ); if ( is_array( $IX27124 ) ) { foreach( $IX27124 as $IX25388 ) { $IX84084 = new Affiliates_Rate( (object) array( 'type' => AFFILIATES_PRO_RATES_TYPE_RATE, 'integration' => 'affiliates-events-manager', 'object_id' => $IX25388->post_id, 'value' => $IX25388->meta_value, 'description' => __( 'Automatically generated from event rate.', 'affiliates' ) ) ); if ( !$IX84084->exists_other() ) { $IX84084->create(); } } } }

	public static function create_cf7_rates() { if ( class_exists( 'Affiliates_CF7' ) ) { $IX14512 = Affiliates_Rate::get_rate(); if ( $IX14512 === null ) { $IX14512 = Affiliates_Rate::get_rate( array( 'type' => AFFILIATES_PRO_RATES_TYPE_RATE ) ); } if ( $IX14512 === null ) { $IX14512 = Affiliates_Rate::get_rate( array( 'type' => AFFILIATES_PRO_RATES_TYPE_AMOUNT ) ); } if ( $IX14512 !== null ) { $IX14512->rate_id = null; $IX14512->integration = 'affiliates-contact-form-7'; $IX14512->description = __( 'Automatically generated from assumed default form rate.', 'affiliates' ) . ( !empty( $IX14512->description ) ? ' | ' . $IX14512->description : '' ); } if ( $IX14512 === null ) { $IX89304 = get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY, null ); $IX49615 = get_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE, null ); switch ( $IX89304 ) { case 'referral.amount' : $IX72515 = AFFILIATES_PRO_RATES_TYPE_AMOUNT; break; case 'referral.rate' : $IX72515 = AFFILIATES_PRO_RATES_TYPE_RATE; break; default : $IX72515 = null; } if ( $IX72515 !== null ) { $IX14512 = new Affiliates_Rate( (object) array( 'type' => $IX72515, 'integration' => 'affiliates-contact-form-7', 'value' => $IX49615, 'description' => __( 'Automatically generated from default form rate.', 'affiliates' ) ) ); } } if ( $IX14512 === null ) { $IX29151 = get_option( Affiliates_CF7::PLUGIN_OPTIONS, array() ); $IX92494 = isset( $IX29151[Affiliates_CF7::REFERRAL_RATE] ) ? $IX29151[Affiliates_CF7::REFERRAL_RATE] : Affiliates_CF7::REFERRAL_RATE_DEFAULT; $IX83575 = class_exists( 'WPCF7_ContactForm' ) && defined( 'WPCF7_ContactForm::post_type' ) ? WPCF7_ContactForm::post_type : 'wpcf7_contact_form'; $IX14512 = new Affiliates_Rate( (object) array( 'type' => AFFILIATES_PRO_RATES_TYPE_RATE, 'integration' => 'affiliates-contact-form-7', 'value' => $IX92494, 'description' => __( 'Automatically generated from default form rate.', 'affiliates' ) ) ); } if ( $IX14512 !== null ) { if ( !$IX14512->exists_other() ) { $IX14512->create(); } } } }

	public static function create_gf_rates() { if ( class_exists( 'GFAPI' ) && method_exists( 'GFAPI', 'get_forms' ) ) { $IX57972 = GFAPI::get_forms(); foreach ( $IX57972 as $IX88394 ) { $IX35797 = null; if ( !empty( $IX88394['affiliates']['amount'] ) ) { $IX35797 = $IX88394['affiliates']['amount']; $IX39473 = AFFILIATES_PRO_RATES_TYPE_AMOUNT; } else if ( !empty( $IX88394['affiliates']['rate'] ) ) { $IX35797 = $IX88394['affiliates']['rate']; $IX39473 = AFFILIATES_PRO_RATES_TYPE_RATE; } if ( $IX35797 !== null ) { $IX97296 = new Affiliates_Rate( (object) array( 'type' => $IX39473, 'integration' => 'affiliates-gravityforms', 'object_id' => $IX88394['id'], 'value' => $IX35797, 'description' => __( 'Automatically generated from form rate.', 'affiliates' ) ) ); if ( !$IX97296->exists_other() ) { $IX97296->create(); } } } } }

	public static function create_ff_rates() { if ( class_exists( 'FrmForm' ) && method_exists( 'FrmForm', 'get_published_forms' ) ) { $IX75318 = FrmForm::get_published_forms( array(), '' ); foreach ( $IX75318 as $IX66864 ) { $IX12057 = FrmFormAction::get_action_for_form( $IX66864->id, 'affiliates' ); if ( !empty( $IX12057 ) && is_array( $IX12057 ) ) { foreach ( $IX12057 as $IX39897 => $IX44156 ) { if ( isset( $IX44156->post_content ) ) { $IX95454 = isset( $IX44156->post_content[Affiliates_Formidable_Affiliates_Action::ENABLE] ) ? $IX44156->post_content[Affiliates_Formidable_Affiliates_Action::ENABLE] : false; if ( $IX95454 ) { $IX79226 = !empty( $IX44156->post_content[Affiliates_Formidable_Affiliates_Action::CURRENCY_ID] ) ? $IX44156->post_content[Affiliates_Formidable_Affiliates_Action::CURRENCY_ID] : null; $IX58727 = !empty( $IX44156->post_content[Affiliates_Formidable_Affiliates_Action::AMOUNT] ) ? $IX44156->post_content[Affiliates_Formidable_Affiliates_Action::AMOUNT] : ''; $IX41802 = !empty( $IX44156->post_content[Affiliates_Formidable_Affiliates_Action::RATE] ) ? $IX44156->post_content[Affiliates_Formidable_Affiliates_Action::RATE] : ''; $IX81865 = null; $IX90583 = ''; if ( !empty( $IX58727 ) ) { $IX81865 = $IX58727; $IX28493 = AFFILIATES_PRO_RATES_TYPE_AMOUNT; $IX90583 = __( 'Automatically generated from form amount.', 'affiliates' ); } else if ( !empty( $IX41802 ) ) { $IX81865 = $IX41802; $IX28493 = AFFILIATES_PRO_RATES_TYPE_RATE; $IX90583 = __( 'Automatically generated from form rate.', 'affiliates' ); } if ( $IX81865 !== null ) { $IX41802 = new Affiliates_Rate( (object) array( 'type' => $IX28493, 'integration' => 'affiliates-formidable', 'object_id' => $IX66864->id, 'value' => $IX81865, 'description' => $IX90583, 'currency_id' => $IX79226 ) ); if ( !$IX41802->exists_other() ) { $IX41802->create(); } } } } } } } } }

	public static function create_nf_rates() { if ( class_exists( 'Affiliates_Ninja_Forms' ) && defined( 'Affiliates_Ninja_Forms::PLUGIN_OPTIONS' ) ) { $IX54428 = get_option( Affiliates_Ninja_Forms::PLUGIN_OPTIONS , array() ); $IX27311 = isset( $IX54428['aff_ninja_forms_amount'] ) ? $IX54428['aff_ninja_forms_amount'] : null; $IX51236 = isset( $IX54428['aff_ninja_forms_currency'] ) ? $IX54428['aff_ninja_forms_currency'] : Affiliates::DEFAULT_CURRENCY; if ( $IX27311 !== null ) { $IX80553 = new Affiliates_Rate( (object) array( 'type' => AFFILIATES_PRO_RATES_TYPE_AMOUNT, 'integration' => 'affiliates-ninja-forms', 'value' => $IX27311, 'currency_id' => $IX51236, 'description' => __( 'Automatically generated from default form amount.', 'affiliates' ) ) ); if ( !$IX80553->exists_other() ) { $IX80553->create(); } } } if ( class_exists( 'Ninja_Forms' ) && method_exists( 'Ninja_Forms', 'form' ) ) { foreach ( Ninja_Forms()->form()->get_forms() as $IX20055 ) { $IX30239 = $IX20055->get_id(); $IX27311 = $IX20055->get_setting( 'affiliates_referral_amount' ); $IX80553 = $IX20055->get_setting( 'affiliates_referral_rate' ); $IX30658 = null; if ( !empty( $IX27311 ) ) { $IX30658 = $IX27311; $IX83484 = AFFILIATES_PRO_RATES_TYPE_AMOUNT; } else if ( !empty( $IX80553 ) ) { $IX30658 = $IX80553; $IX83484 = AFFILIATES_PRO_RATES_TYPE_RATE; } if ( $IX30658 !== null ) { $IX80553 = new Affiliates_Rate( (object) array( 'type' => $IX83484, 'integration' => 'affiliates-ninja-forms', 'object_id' => $IX30239, 'value' => $IX30658, 'description' => __( 'Automatically generated from form rate.', 'affiliates' ) ) ); if ( !$IX80553->exists_other() ) { $IX80553->create(); } } } } }
}
