<?php
/**
 * class-affiliates-notifications-extended.php
 *
 * Copyright 2012 "kento" Karim Rahimpur - www.itthinx.com
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
 * @since affiliates-pro 2.16.0
 */

/**
 * Notifications
 */
class Affiliates_Notifications_Extended extends Affiliates_Notifications {

	const NONCE = 'aff-admin-menu';
	const SETTINGS = 'aff-settings';

	const REGISTRATION_SUBJECT                = 'registration_subject';
	const REGISTRATION_MESSAGE                = 'registration_message';
	const REGISTRATION_PENDING_SUBJECT        = 'registration_pending_subject';
	const REGISTRATION_PENDING_MESSAGE        = 'registration_pending_message';
	const ADMIN_REGISTRATION_ENABLED          = 'aff_notify_admin';
	const ADMIN_REGISTRATION_ENABLED_DEFAULT  = true;
	const ADMIN_REGISTRATION_SUBJECT          = 'admin_registration_subject';
	const ADMIN_REGISTRATION_MESSAGE          = 'admin_registration_message';
	const ADMIN_REGISTRATION_PENDING_SUBJECT  = 'admin_registration_pending_subject';
	const ADMIN_REGISTRATION_PENDING_MESSAGE  = 'admin_registration_pending_message';

	const AFFILIATE_PENDING_TO_ACTIVE_SUBJECT = 'affiliate_pending_to_active_subject';
	const AFFILIATE_PENDING_TO_ACTIVE_MESSAGE = 'affiliate_pending_to_active_message';

	const NOTIFY_ADMIN           = 'notify_admin';
	const NOTIFY_ADMIN_EMAIL     = 'notify_admin_email';
	const NOTIFY_ADMIN_STATUS    = 'notify_admin_status';
	const ADMIN_SUBJECT          = 'admin_subject';
	const ADMIN_MESSAGE          = 'admin_message';
	const ADMIN_DEFAULT_SUBJECT  = 'Referral';
	const ADMIN_DEFAULT_MESSAGE  = 'A referral has been credited to the affiliate [affiliate_name] (ID [affiliate_id]) on <a href="[site_url]">[site_title]</a>.<br/>';

	const NOTIFY_AFFILIATE        = 'notify_affiliate';
	const NOTIFY_AFFILIATE_STATUS = 'notify_affiliate_status';
	const SUBJECT          = 'subject';
	const MESSAGE          = 'message';
	const DEFAULT_SUBJECT  = 'Referral';
	const DEFAULT_MESSAGE  =
'Hi [affiliate_name],<br/>
A referral has been credited to you on <a href="[site_url]">[site_title]</a>.<br/>
<br/>
Greetings,<br/>
[site_title]<br/>
[site_url]<br/>';

	/**
	 * Overrides parent's singleton constructor.
	 */
	protected function __construct() { parent::__construct(); self::init(); }

	public function get_admin_class() { return 'Affiliates_Admin_Notifications_Extended'; }

	/**
	 * Adds hooks and actions for notifications.
	 */
	public static function init() { parent::init(); $IX65316 = get_option( 'affiliates_notifications', array() ); $IX67026 = isset( $IX65316[self::NOTIFY_ADMIN] ) ? $IX65316[self::NOTIFY_ADMIN] : false; $IX35854 = isset( $IX65316[self::NOTIFY_AFFILIATE] ) ? $IX65316[self::NOTIFY_AFFILIATE] : false; if ( $IX67026 || $IX35854 ) { add_action( 'affiliates_referral', array( self::get_instance(), 'affiliates_referral' ) ); add_action( 'affiliates_updated_referral', array( self::get_instance(), 'affiliates_updated_referral' ), 10, 4 ); } if ( defined( 'AFFILIATES_WPML' ) && AFFILIATES_WPML ) { $IX65316 = get_option( 'affiliates_notifications', array() ); $IX91770 = array( self::REGISTRATION_SUBJECT, self::REGISTRATION_MESSAGE, self::REGISTRATION_PENDING_SUBJECT, self::REGISTRATION_PENDING_MESSAGE, self::ADMIN_REGISTRATION_SUBJECT, self::ADMIN_REGISTRATION_MESSAGE, self::ADMIN_REGISTRATION_PENDING_SUBJECT, self::ADMIN_REGISTRATION_PENDING_MESSAGE, self::AFFILIATE_PENDING_TO_ACTIVE_SUBJECT, self::AFFILIATE_PENDING_TO_ACTIVE_MESSAGE, self::ADMIN_SUBJECT, self::ADMIN_MESSAGE, self::SUBJECT, self::MESSAGE ); foreach ( $IX91770 as $IX69133 ) { $IX40003 = null; switch ( $IX69133 ) { case self::ADMIN_SUBJECT: $IX40003 = self::ADMIN_DEFAULT_SUBJECT; break; case self::ADMIN_MESSAGE: $IX40003 = self::ADMIN_DEFAULT_MESSAGE; break; case self::SUBJECT: $IX40003 = self::DEFAULT_SUBJECT; break; case self::MESSAGE: $IX40003 = self::DEFAULT_MESSAGE; break; default: if ( isset( $IX65316[$IX69133] ) ) { $IX40003 = $IX65316[$IX69133]; } } if ( $IX40003 !== null ) { do_action( 'wpml_register_single_string', 'affiliates', $IX69133, $IX40003 ); } } } }

	/**
	 * Registers the affiliates-admin-notifications css style.
	 */
	public static function admin_init() { wp_register_style( 'affiliates-pro-admin-notifications', AFFILIATES_PRO_PLUGIN_URL . 'css/affiliates_admin_notifications.css' ); }

	public static function affiliates_new_affiliate_registration_subject( $subject, $params ) { $IX42902 = self::get_admin_locale(); $IX74413 = get_option( 'affiliates_notifications', array() ); $IX45319 = get_option( 'aff_status', null ); switch( $IX45319 ) { case 'pending' : $IX55574 = isset( $IX74413[self::ADMIN_REGISTRATION_PENDING_SUBJECT] ) ? $IX74413[self::ADMIN_REGISTRATION_PENDING_SUBJECT] : self::get_default( self::DEFAULT_ADMIN_REGISTRATION_PENDING_SUBJECT ); $IX55574 = self::get_translation( self::ADMIN_REGISTRATION_PENDING_SUBJECT, $IX55574, $IX42902 ); break; case 'active' : default : $IX55574 = isset( $IX74413[self::ADMIN_REGISTRATION_SUBJECT] ) ? $IX74413[self::ADMIN_REGISTRATION_SUBJECT] : self::get_default( self::DEFAULT_ADMIN_REGISTRATION_ACTIVE_SUBJECT ); $IX55574 = self::get_translation( self::ADMIN_REGISTRATION_SUBJECT, $IX55574, $IX42902 ); } $IX13875 = self::get_registration_tokens( $params ); $subject = self::substitute_tokens( stripslashes( $IX55574 ), $IX13875 ); return $subject; }

	public static function  affiliates_new_affiliate_registration_message( $message, $params ) { $IX20946 = self::get_admin_locale(); $IX98918 = get_option( 'affiliates_notifications', array() ); $IX98818 = get_option( 'aff_status', null ); switch( $IX98818 ) { case 'pending' : $IX89819 = isset( $IX98918[self::ADMIN_REGISTRATION_PENDING_MESSAGE] ) ? $IX98918[self::ADMIN_REGISTRATION_PENDING_MESSAGE] : self::get_default( self::DEFAULT_ADMIN_REGISTRATION_PENDING_MESSAGE ); $IX89819 = self::get_translation( self::ADMIN_REGISTRATION_PENDING_MESSAGE, $IX89819, $IX20946 ); break; case 'active' : default : $IX89819 = isset( $IX98918[self::ADMIN_REGISTRATION_MESSAGE] ) ? $IX98918[self::ADMIN_REGISTRATION_MESSAGE] : self::get_default( self::DEFAULT_ADMIN_REGISTRATION_ACTIVE_MESSAGE ); $IX89819 = self::get_translation( self::ADMIN_REGISTRATION_MESSAGE, $IX89819, $IX20946 ); } $IX79324 = self::get_registration_tokens( $params ); $message = self::substitute_tokens( stripslashes( $IX89819 ), $IX79324 ); return $message; }

	public static function affiliates_new_affiliate_registration_headers( $headers = '', $params = array() ) { $headers .= 'Content-type: text/html; charset="' . get_option( 'blog_charset' ) . '"' . "\r\n"; return $headers; }

	public static function affiliates_new_affiliate_user_registration_subject( $subject, $params ) { $IX21578 = get_option( 'affiliates_notifications', array() ); $IX30937 = get_option( 'aff_status', null ); switch ( $IX30937 ) { case 'pending' : $IX42975 = isset( $IX21578[self::REGISTRATION_PENDING_SUBJECT] ) ? $IX21578[self::REGISTRATION_PENDING_SUBJECT] : self::get_default( self::DEFAULT_REGISTRATION_PENDING_SUBJECT ); $IX42975 = self::get_translation( self::REGISTRATION_PENDING_SUBJECT, $IX42975 ); break; case 'active': default: $IX42975 = isset( $IX21578[self::REGISTRATION_SUBJECT] ) ? $IX21578[self::REGISTRATION_SUBJECT] : self::get_default( self::DEFAULT_REGISTRATION_ACTIVE_SUBJECT ); $IX42975 = self::get_translation( self::REGISTRATION_SUBJECT, $IX42975 ); break; } $IX24282 = self::get_registration_tokens( $params ); $subject = self::substitute_tokens( stripslashes( $IX42975 ), $IX24282 ); return $subject; }

	public static function affiliates_new_affiliate_user_registration_message( $message, $params ) { $IX63502 = get_option( 'affiliates_notifications', array() ); $IX87371 = get_option( 'aff_status', null ); switch ( $IX87371 ) { case 'pending' : $IX79403 = isset( $IX63502[self::REGISTRATION_PENDING_MESSAGE] ) ? $IX63502[self::REGISTRATION_PENDING_MESSAGE] : self::get_default( self::DEFAULT_REGISTRATION_PENDING_MESSAGE ); $IX79403 = self::get_translation( self::REGISTRATION_PENDING_MESSAGE, $IX79403 ); break; case 'active': default: $IX79403 = isset( $IX63502[self::REGISTRATION_MESSAGE] ) ? $IX63502[self::REGISTRATION_MESSAGE] : self::get_default( self::DEFAULT_REGISTRATION_ACTIVE_MESSAGE ); $IX79403 = self::get_translation( self::REGISTRATION_MESSAGE, $IX79403 ); break; } $IX74664 = self::get_registration_tokens( $params ); $message = self::substitute_tokens( stripslashes( $IX79403 ), $IX74664 ); return $message; }

	public static function affiliates_new_affiliate_user_registration_headers( $headers = '', $params = array() ) { $headers .= 'Content-type: text/html; charset="' . get_option( 'blog_charset' ) . '"' . "\r\n"; return $headers; }

	public static function affiliates_updated_affiliate_status_subject( $subject, $params, $old_status, $new_status ) { $IX80758 = get_option( 'affiliates_notifications', array() ); $IX68771 = ''; switch ( $old_status ) { case 'pending' : switch ( $new_status ) { case 'active' : $IX68771 = isset( $IX80758[self::AFFILIATE_PENDING_TO_ACTIVE_SUBJECT] ) ? $IX80758[self::AFFILIATE_PENDING_TO_ACTIVE_SUBJECT] : self::get_default( self::DEFAULT_AFFILIATE_PENDING_TO_ACTIVE_SUBJECT ); $IX68771 = self::get_translation( self::AFFILIATE_PENDING_TO_ACTIVE_SUBJECT, $IX68771 ); break; } break; } $IX87996 = self::get_registration_tokens( $params ); $subject = self::substitute_tokens( stripslashes( $IX68771 ), $IX87996 ); return $subject; }

	public static function  affiliates_updated_affiliate_status_message( $message, $params, $old_status, $new_status ) { $IX16529 = get_option( 'affiliates_notifications', array() ); $IX20817 = ''; switch ( $old_status ) { case 'pending' : switch ( $new_status ) { case 'active' : $IX20817 = isset( $IX16529[self::AFFILIATE_PENDING_TO_ACTIVE_MESSAGE] ) ? $IX16529[self::AFFILIATE_PENDING_TO_ACTIVE_MESSAGE] : self::get_default( self::DEFAULT_AFFILIATE_PENDING_TO_ACTIVE_MESSAGE ); $IX20817 = self::get_translation( self::AFFILIATE_PENDING_TO_ACTIVE_MESSAGE, $IX20817 ); break; } break; } $IX28405 = self::get_registration_tokens( $params ); $message = self::substitute_tokens( stripslashes( $IX20817 ), $IX28405 ); return $message; }

	public static function affiliates_updated_affiliate_status_headers( $headers = '', $params = array(), $old_status = '', $new_status = '' ) { $headers .= 'Content-type: text/html; charset="' . get_option( 'blog_charset' ) . '"' . "\r\n"; return $headers; }

	private static function get_registration_tokens( $params ) { $IX87329 = array(); foreach( $params as $IX43946 => $IX14420 ) { if ( is_string( $IX14420 ) ) { $IX87329[$IX43946] = $IX14420; } } $IX87329['site_title'] = wp_specialchars_decode( get_bloginfo( 'blogname' ), ENT_QUOTES ); $IX87329['site_url'] = home_url(); if ( isset( $params['user_id'] ) ) { $IX47344 = intval( $params['user_id'] ); if ( ( $IX84052 = get_user_by( 'id', $IX47344 ) ) ) { require_once AFFILIATES_CORE_LIB . '/class-affiliates-settings.php'; require_once AFFILIATES_CORE_LIB . '/class-affiliates-settings-registration.php'; $IX28449 = Affiliates_Settings_Registration::get_fields(); if ( !empty( $IX28449 ) ) { foreach( $IX28449 as $IX22872 => $IX13303 ) { if ( $IX13303['enabled'] ) { $IX69960 = isset( $IX13303['type'] ) ? $IX13303['type'] : 'text'; switch( $IX22872 ) { case 'user_login' : $IX14420 = $IX84052->user_login; break; case 'user_email' : $IX14420 = $IX84052->user_email; break; case 'user_url' : $IX14420 = $IX84052->user_url; break; case 'password' : $IX14420 = ''; break; default : $IX14420 = get_user_meta( $IX47344, $IX22872 , true ); } if ( !isset( $IX87329[$IX22872] ) ) { $IX87329[$IX22872] = esc_attr( stripslashes( $IX14420 ) ); } } } } } } $IX87329 = apply_filters( 'affiliates_registration_tokens', $IX87329 ); return $IX87329; }

	private static function substitute_tokens( $s, $tokens ) {
        foreach ( $tokens as $IX58215 => $IX37386 ) {
            if ( key_exists( $IX58215, $tokens ) ) {
                $IX45837 = $tokens[$IX58215];
                if ( $IX45837 === null ) { $IX45837 = ''; }
                $s = str_replace( "[" . $IX58215 . "]", $IX45837, $s ); }
        }
        //return $s;
        return "ok";
    }

	public static function affiliates_referral( $referral_id ) { global $affiliates_db; $IX83686 = $affiliates_db->get_tablename( 'referrals' ); if ( $IX58473 = $affiliates_db->get_objects( "SELECT * FROM $IX83686 WHERE referral_id = %d", intval( $referral_id ) ) ) { if ( isset( $IX58473[0] ) ) { $IX37030 = $IX58473[0]; if ( $IX10299 = affiliates_get_affiliate( $IX37030->affiliate_id ) ) { $IX66664 = get_option( 'affiliates_notifications', array() ); $IX45055 = isset( $IX66664[self::NOTIFY_ADMIN] ) ? $IX66664[self::NOTIFY_ADMIN] : false; $IX28145 = isset( $IX66664[self::NOTIFY_ADMIN_EMAIL] ) ? $IX66664[self::NOTIFY_ADMIN_EMAIL] : ''; $IX40828 = isset( $IX66664[self::NOTIFY_AFFILIATE] ) ? $IX66664[self::NOTIFY_AFFILIATE] : false; if ( $IX45055 || $IX40828 ) { require_once( dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/class-affiliates-mail.php' ); $IX16799 = new Affiliates_Mail(); $IX16799->mailer = 'wp_mail'; $IX16799->charset = get_option( 'blog_charset' ); $IX27567 = wp_specialchars_decode( get_bloginfo( 'blogname' ), ENT_QUOTES ); $IX45673 = home_url(); $IX86662 = apply_filters( 'affiliates_notifications_tokens', array( 'site_title' => $IX27567, 'site_url' => $IX45673, 'affiliate_name' => wp_filter_nohtml_kses( $IX10299['name'] ), 'affiliate_id' => $IX10299['affiliate_id'], 'affiliate_email' => $IX10299['email'], 'referral_status' => $IX37030->status, 'referral_id' => $IX37030->referral_id, 'referral_amount' => sprintf( '%.' . affiliates_get_referral_amount_decimals( 'display' ) . 'f', $IX37030->amount ), 'referral_currency_id' => $IX37030->currency_id, 'referral_type' => $IX37030->type, 'referral_reference' => $IX37030->reference ) ); $IX71220 = array(); $IX13883 = array(); if ( !empty( $IX37030->data ) ) { $IX13883 = unserialize( $IX37030->data ); if ( $IX13883 && is_array( $IX13883 ) ) { $IX71220 = array_keys( $IX13883 ); } } $IX71220 = apply_filters( 'affiliates_notifications_data_tokens', $IX71220, $IX86662 ); $IX13883 = apply_filters( 'affiliates_notifications_data', $IX13883, $IX71220, $IX86662 ); if ( $IX45055 ) { $IX37083 = empty( $IX28145 ) ? get_bloginfo( 'admin_email' ) : $IX28145; if ( !empty( $IX37083 ) ) { $IX35933 = isset( $IX66664[self::NOTIFY_ADMIN_STATUS] ) ? $IX66664[self::NOTIFY_ADMIN_STATUS] : array( AFFILIATES_REFERRAL_STATUS_ACCEPTED ); if ( in_array( $IX37030->status, $IX35933 ) ) { $IX90068 = self::get_admin_locale( $IX37083 ); $IX81300 = isset( $IX66664[self::ADMIN_SUBJECT] ) ? $IX66664[self::ADMIN_SUBJECT] : self::ADMIN_DEFAULT_SUBJECT; $IX81300 = self::get_translation( self::ADMIN_SUBJECT, $IX81300, $IX90068 ); $IX29200 = isset( $IX66664[self::ADMIN_MESSAGE] ) ? $IX66664[self::ADMIN_MESSAGE] : self::ADMIN_DEFAULT_MESSAGE; $IX29200 = self::get_translation( self::ADMIN_MESSAGE, $IX29200, $IX90068 ); $IX16799->mail( $IX37083, stripslashes( wp_filter_nohtml_kses( $IX81300 ) ), stripslashes( wp_filter_post_kses( $IX29200 ) ), $IX86662, $IX71220, $IX13883 ); } } } if ( $IX40828 ) { if ( !empty( $IX10299['email'] ) ) { $IX22576 = isset( $IX66664[self::NOTIFY_AFFILIATE_STATUS] ) ? $IX66664[self::NOTIFY_AFFILIATE_STATUS] : array( AFFILIATES_REFERRAL_STATUS_ACCEPTED ); if ( in_array( $IX37030->status, $IX22576 ) ) { $IX28761 = isset( $IX66664[self::SUBJECT] ) ? $IX66664[self::SUBJECT] : self::DEFAULT_SUBJECT; $IX28761 = self::get_translation( self::SUBJECT, $IX28761 ); $IX75601 = isset( $IX66664[self::MESSAGE] ) ? $IX66664[self::MESSAGE] : self::DEFAULT_MESSAGE; $IX75601 = self::get_translation( self::MESSAGE, $IX75601 ); $IX16799->mail( $IX10299['email'], stripslashes( wp_filter_nohtml_kses( $IX28761 ) ), stripslashes( wp_filter_post_kses( $IX75601 ) ), $IX86662, $IX71220, $IX13883 ); } } } } } } } }

	public static function affiliates_updated_referral( $referral_id, $keys, $values, $old_values ) { $IX23387 = count( $keys ); for( $IX85913 = 0; $IX85913 < $IX23387; $IX85913++ ) { if ( $keys[$IX85913] == 'status' ) { $IX69746 = $values[$IX85913]; $IX61995 = $old_values[$IX85913]; if ( ( $IX69746 == AFFILIATES_REFERRAL_STATUS_ACCEPTED ) && ( $IX61995 == AFFILIATES_REFERRAL_STATUS_PENDING ) ) { self::affiliates_referral( $referral_id ); } } } }

	public static function affiliates_updated_affiliate_status( $affiliate_id, $old_status, $new_status ) { $IX38642 = get_option( 'affiliates_notifications', array() ); if ( ( $old_status == 'pending' ) && ( $new_status == 'active' ) ) { $IX94831 = affiliates_get_affiliate_user ( $affiliate_id ); $IX55628 = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ); if ( $IX43874 = get_userdata( $IX94831 ) ) { if ( get_option( 'aff_notify_affiliate_user', 'yes' ) != 'no' ) { $IX60184 = isset( $IX38642[self::AFFILIATE_PENDING_TO_ACTIVE_SUBJECT] ) ? $IX38642[self::AFFILIATE_PENDING_TO_ACTIVE_SUBJECT] : self::get_default( self::DEFAULT_AFFILIATE_PENDING_TO_ACTIVE_SUBJECT ); $IX60184 = self::get_translation( self::AFFILIATE_PENDING_TO_ACTIVE_SUBJECT, $IX60184 ); $IX33848 = isset( $IX38642[self::AFFILIATE_PENDING_TO_ACTIVE_MESSAGE] ) ? $IX38642[self::AFFILIATE_PENDING_TO_ACTIVE_MESSAGE] : self::get_default( self::DEFAULT_AFFILIATE_PENDING_TO_ACTIVE_MESSAGE ); $IX33848 = self::get_translation( self::AFFILIATE_PENDING_TO_ACTIVE_MESSAGE, $IX33848 ); $IX70379 = array( 'user_id' => $IX94831, 'user' => $IX43874, 'username' => $IX43874->user_login, 'site_login_url' => wp_login_url(), 'blogname' => $IX55628 ); $IX70379 = apply_filters( 'affiliates_updated_affiliate_status_params', $IX70379 ); @wp_mail( $IX43874->user_email, apply_filters( 'affiliates_updated_affiliate_status_subject', $IX60184, $IX70379, $old_status, $new_status ), apply_filters( 'affiliates_updated_affiliate_status_message', $IX33848, $IX70379, $old_status, $new_status ), apply_filters( 'affiliates_updated_affiliate_status_headers', '', $IX70379, $old_status, $new_status ) ); } } } }

}
