<?php
/**
 * class-affiliates-affiliate-profile-wordpress.php
 *
 * Copyright 2011 "kento" Karim Rahimpur - www.itthinx.com
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
 * @since affiliates-pro 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Profile renderer implementation.
 */
class Affiliates_Affiliate_Profile_WordPress extends Affiliates_Affiliate_Profile {

	const NONCE               = 'affiliate-profile-nonce';
	const EDIT_PROFILE_ACTION = 'edit-profile';

	/**
	 * Class initialization.
	 */
	static function init() { add_shortcode( 'affiliates_affiliate_profile', array( __CLASS__, 'profile_shortcode' ) ); }

	static function profile_shortcode( $atts, $content = null ) { $IX80807 = shortcode_atts( self::$option_defaults, $atts ); return self::render_profile( $IX80807 ); }

	static function render_profile( $options = array() ) { global $affiliates_db; wp_enqueue_style( 'affiliates' ); $IX31828 = ''; $IX78824 = Affiliates_Affiliate_WordPress::get_user_affiliate_id(); if ( $IX78824 === false ) { return $IX31828; } $IX87192 = Affiliates_Affiliate_WordPress::get_affiliate( $IX78824 ); $IX91871 = isset( $options['show_name'] ) ? $options['show_name'] : self::$option_defaults['show_name']; $IX16206 = $IX91871 && isset( $options['edit_name'] ) ? $options['edit_name'] : self::$option_defaults['edit_name']; $IX34519 = isset( $options['show_email'] ) ? $options['show_email'] : self::$option_defaults['show_email']; $IX82810 = $IX34519 && isset( $options['edit_email'] ) ? $options['edit_email'] : self::$option_defaults['edit_email']; $IX24167 = isset( $options['show_attributes'] ) ? $options['show_attributes'] : self::$option_defaults['show_attributes']; if ( $IX24167 ) { $IX24167 = explode( ",", $IX24167 ); $IX39179 = array(); foreach ( $IX24167 as $IX98802 ) { $IX98802 = trim( $IX98802 ); if ( Affiliates_Attributes::validate_key( $IX98802 ) ) { $IX39179[] = $IX98802; } } $IX24167 = $IX39179; } else { $IX24167 = array(); } $IX70119 = isset( $options['edit_attributes'] ) ? $options['edit_attributes'] : self::$option_defaults['edit_attributes']; if ( $IX70119 ) { $IX39179 = explode( ",", $IX70119 ); $IX70119 = array(); foreach ( $IX39179 as $IX98802 ) { if ( in_array( $IX98802, $IX24167 ) ) { $IX70119[] = $IX98802; } } } else { $IX70119 = array(); } if ( isset( $_POST[self::NONCE] ) ) { if ( !wp_verify_nonce( $_POST[self::NONCE], self::EDIT_PROFILE_ACTION ) ) { wp_die( __( '拒絕訪問。', 'affiliates' ) ); } if ( $IX16206 && isset( $_POST['first_name'] ) && ( $_POST['last_name'] ) ) { $IX35665 = $_POST['first_name'] . " " . $_POST['last_name']; if ( $IX87192->name != $IX35665 ) { if ( $IX39315 = Affiliates_Affiliate_WordPress::get_affiliate_user_id( $IX78824 ) ) { if ( $IX42241 = Affiliates_Utility::filter( $_POST['first_name'] ) ) { update_user_meta( $IX39315, 'first_name', $IX42241 ); } if ( $IX56550 = Affiliates_Utility::filter( $_POST['last_name'] ) ) { update_user_meta( $IX39315, 'last_name', $IX56550 ); } } Affiliates_Affiliate_WordPress::update_name( $IX78824, $IX35665 ); } } if ( $IX82810 && isset( $_POST['affiliate_email'] ) && ( $_POST['affiliate_email'] != $IX87192->email ) ) { if ( ( $IX95979 = Affiliates_Validator::validate_email( $_POST['affiliate_email'] ) ) && !email_exists( $IX95979 ) ) { if ( $IX95979 = Affiliates_Affiliate_WordPress::update_email( $IX78824, $IX95979 ) ) { if ( $IX39315 = Affiliates_Affiliate_WordPress::get_affiliate_user_id( $IX78824 ) ) { $IX33545 = array( 'ID' => $IX39315, 'user_email' => $IX95979 ); wp_update_user( $IX33545 ); } } } } foreach ( $IX70119 as $IX98802 ) { $IX44632 = "aff_attr_" . $IX98802; if ( isset( $_POST[$IX44632] ) ) { Affiliates_Affiliate_WordPress::update_attribute( $IX78824, $IX98802, $_POST[$IX44632] ); } } } $IX87192 = Affiliates_Affiliate_WordPress::get_affiliate( $IX78824 ); $IX31828 .= '<div class="affiliate-profile">' . '<form id="affiliate-profile" action="" method="post">'; if ( $IX91871 ) { $IX58256 = !$IX16206 ? ' readonly="readonly" ' : ''; if ( $IX39315 = Affiliates_Affiliate_WordPress::get_affiliate_user_id( $IX78824 ) ) { $IX42241 = get_user_meta( $IX39315, 'first_name', true ); $IX56550 = get_user_meta( $IX39315, 'last_name', true ); } else { $IX42241 = ''; $IX56550 = ''; } $IX31828 .= '<div class="field first-name">' . '<label for="first_name">' . __( '名', 'affiliates' ) . '</label>' . '<input ' . $IX58256 . ' name="first_name" type="text" value="' . esc_attr( $IX42241 ) . '"/>'. '</div>'; $IX31828 .= '<div class="field last-name">' . '<label for="last_name">' . __( '姓', 'affiliates' ) . '</label>' . '<input ' . $IX58256 . ' name="last_name" type="text" value="' . esc_attr( $IX56550 ) . '"/>'. '</div>'; } if ( $IX34519 ) { $IX58256 = !$IX82810 ? ' readonly="readonly" ' : ''; $IX31828 .= '<div class="field affiliate-email">' . '<label for="affiliate_email">' . __('電子郵件', 'affiliates' ) . '</label>' . '<input ' . $IX58256 . ' name="affiliate_email" type="text" value="' . esc_attr( $IX87192->email ) . '"/>'. '</div>'; } if ( $IX24167 ) { $IX11173 = $affiliates_db->get_tablename( 'affiliates_attributes' ); $IX45524 = $affiliates_db->get_objects( "SELECT * FROM $IX11173 WHERE affiliate_id = %d", $IX78824 ); $IX23454 = array(); foreach ( $IX45524 as $IX98802 ) { $IX23454[$IX98802->attr_key] = $IX98802->attr_value; } $IX89179 = Affiliates_Attributes::get_keys(); foreach ( $IX24167 as $IX23195 ) { $IX41738 = isset( $IX23454[$IX23195] ) ? $IX23454[$IX23195] : ''; $IX58256 = !in_array( $IX23195, $IX70119 ) ? ' readonly="readonly" ' : ''; $IX44632 = "aff_attr_" . $IX23195; $IX31828 .= '<div class="field affiliate-attribute ' . esc_attr( $IX23195 ) . '">' . '<label for="' . esc_attr( $IX44632 ) . '">' . __( $IX89179[$IX23195], 'affiliates' ) . '</label>' . '<input ' . $IX58256 . ' name="' . esc_attr( $IX44632 ) . '" type="text" value="' . esc_attr( $IX41738 ) . '"/>'. '</div>'; } } if ( $IX16206 || $IX82810 || $IX70119 ) { $IX31828 .= '<div class="submit">' . wp_nonce_field( self::EDIT_PROFILE_ACTION, self::NONCE, true, false ) . '<input type="submit" value="' . __( '節省', 'affiliates' ) . '"/>' . '<input type="hidden" value="submitted" name="submitted"/>' . '</div>'; } $IX31828 .= '</form>'; $IX31828 .= '</div>'; return $IX31828; }

}
Affiliates_Affiliate_Profile_WordPress::init();
