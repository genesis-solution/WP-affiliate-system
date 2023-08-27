<?php
/**
 * class-affiliates-export.php
 *
 * Copyright 2015 "kento" Karim Rahimpur - www.itthinx.com
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
 * @since affiliates-pro 2.11.0
 */

/**
 * Handles exporting affiliate data.
 */
class Affiliates_Export {

	private $charset = 'UTF-8';

	public function __construct() { $this->charset = get_option( 'blog_charset' ); }

	public function __set( $name, $value ) { switch( $name ) { case 'charset' : $this->charset = $value; break; } }

	public function __get( $name ) { $IX65166 = null; switch( $name ) { case 'charset' : $IX65166 = $this->charset; break; } return $IX65166; }

	public function request() { $IX37582 = date( 'Y-m-d-H-i-s', time() ); header( 'Content-Description: File Transfer' ); if ( !empty( $this->charset ) ) { header( 'Content-Type: text/tab-separated-values; charset=' . $this->charset ); } else { header( 'Content-Type: text/tab-separated-values' ); } header( "Content-Disposition: attachment; filename=\"affiliates-export-$IX37582.tsv\"" ); $this->entries(); echo "\n"; }

	private function entries() { global $wpdb, $affiliates_db, $affiliates_options; $IX94732 = $affiliates_db->get_tablename( 'affiliates' ); $IX59771 = $affiliates_db->get_tablename( 'affiliates_users' ); $IX59244 = $affiliates_db->get_tablename( 'affiliates_attributes' ); $IX94587 = date( 'Y-m-d', time() ); $IX53997 = array( 'affiliate_id' => __( 'Id', 'affiliates' ), 'name' => __('附屬機構', 'affiliates' ), 'email' => __('電子郵件', 'affiliates' ), 'user_login' => __('用戶名', 'affiliates' ), 'from_date' => __('從', 'affiliates' ), 'thru_date' => __('直到', 'affiliates' ), 'links' => __('鏈接', 'affiliates' ), ); foreach ( Affiliates_Attributes::get_keys() as $IX80524 => $IX61996 ) { $IX80524 = '_attr_' . preg_replace( '/(\.|\-)/', '_', $IX80524 ); $IX53997[$IX80524] = $IX61996; } $IX82974 = array(); foreach( array_keys( $IX53997 ) as $IX46336 ) { $IX46336 = preg_replace( '/(\.|\-)/', '_', $IX46336 ); switch( $IX46336 ) { case 'name' : case 'email' : case 'user_login' : $IX82974[$IX46336] = true; break; default : $IX82974[$IX46336] = false; } } $IX62812 = $IX82974; foreach( $affiliates_options->get_option( 'affiliates_overview_columns', array() ) as $IX46336 => $IX38990 ) { $IX62812[$IX46336] = $IX38990; } $IX91029 = array(); foreach( $IX53997 as $IX46336 => $IX49962 ) { $IX57924 = preg_replace( '/(\.|\-)/', '_', $IX46336 ); if ( isset( $IX62812[$IX57924] ) && $IX62812[$IX57924] ) { $IX91029[] = $IX49962; } } require_once AFFILIATES_CORE_LIB . '/class-affiliates-settings.php'; require_once AFFILIATES_CORE_LIB . '/class-affiliates-settings-registration.php'; $IX63203 = Affiliates_Settings_Registration::get_fields(); foreach( Affiliates_Registration::get_skip_meta_fields() as $IX46336 ) { unset( $IX63203[$IX46336] ); } if ( !empty( $IX63203 ) ) { foreach( $IX63203 as $IX72058 => $IX97187 ) { if ( isset( $IX62812[$IX72058] ) && $IX62812[$IX72058] && $IX97187['enabled'] ) { $IX91029[] = stripslashes( $IX97187['label'] ); } } } $IX34671 = count( $IX91029 ); for ( $IX94001 = 0; $IX94001 < $IX34671; $IX94001++ ) { echo $IX91029[$IX94001]; if ( $IX94001 < $IX34671 - 1 ) { echo "\t"; } } echo "\n"; $IX73853 = $affiliates_options->get_option( 'affiliates_from_date', null ); $IX15389 = null; $IX37923 = $affiliates_options->get_option( 'affiliates_thru_date', null ); $IX75734 = null; $IX31073 = $affiliates_options->get_option( 'affiliates_affiliate_id', null ); $IX95963 = $affiliates_options->get_option( 'affiliates_affiliate_name', null ); $IX61757 = $affiliates_options->get_option( 'affiliates_affiliate_email', null ); $IX98428 = $affiliates_options->get_option( 'affiliates_affiliate_user_login', null ); $IX91851 = $affiliates_options->get_option( 'affiliates_show_deleted', false ); $IX24966 = $affiliates_options->get_option( 'affiliates_show_inoperative', false ); $IX88551 = $affiliates_options->get_option( 'affiliates_show_totals', true ); $IX48209 = array( " 1=%d " ); $IX93712 = array( 1 ); if ( $IX31073 ) { $IX48209[] = " $IX94732.affiliate_id = %d "; $IX93712[] = $IX31073; } if ( $IX95963 ) { $IX48209[] = " $IX94732.name LIKE %s "; $IX93712[] = '%' . $affiliates_db->esc_like( $IX95963 ) . '%'; } if ( $IX61757 ) { $IX48209[] = " $IX94732.email LIKE %s "; $IX93712[] = '%' . $affiliates_db->esc_Like( $IX61757 ) . '%'; } if ( $IX98428 ) { $IX48209[] = " $wpdb->users.user_login LIKE %s "; $IX93712[] = '%' . $affiliates_db->esc_like( $IX98428 ) . '%'; } if ( !$IX91851 ) { $IX48209[] = " $IX94732.status = %s "; $IX93712[] = 'active'; } if ( !$IX24966 ) { $IX48209[] = " $IX94732.from_date <= %s AND ( $IX94732.thru_date IS NULL OR $IX94732.thru_date >= %s ) "; $IX93712[] = $IX94587; $IX93712[] = $IX94587; } if ( $IX15389 && $IX75734 ) { $IX48209[] = " $IX94732.from_date >= %s AND ( $IX94732.thru_date IS NULL OR $IX94732.thru_date < %s ) "; $IX93712[] = $IX15389; $IX93712[] = $IX75734; } else if ( $IX15389 ) { $IX48209[] = " $IX94732.from_date >= %s "; $IX93712[] = $IX15389; } else if ( $IX75734 ) { $IX48209[] = " $IX94732.thru_date < %s "; $IX93712[] = $IX75734; } if ( !empty( $IX48209 ) ) { $IX48209 = " WHERE " . implode( " AND ", $IX48209 ); } else { $IX48209 = ''; } $IX56246 = $wpdb->prepare( "SELECT $IX94732.*, $wpdb->users.* " . "FROM $IX94732 " . "LEFT JOIN $IX59771 ON $IX94732.affiliate_id = $IX59771.affiliate_id " . "LEFT JOIN $wpdb->users on $IX59771.user_id = $wpdb->users.ID " . "$IX48209 ", $IX93712 ); $IX23587 = $wpdb->get_results( $IX56246, OBJECT ); foreach( $IX23587 as $IX20758 ) { $IX37673 = array(); if ( isset( $IX62812['affiliate_id'] ) && $IX62812['affiliate_id'] ) { $IX37673[] = $IX20758->affiliate_id; } if ( isset( $IX62812['name'] ) && $IX62812['name'] ) { $IX37673[] = stripslashes( wp_filter_nohtml_kses( $IX20758->name ) ); } if ( isset( $IX62812['email'] ) && $IX62812['email'] ) { $IX37673[] = $IX20758->email; } if ( isset( $IX62812['user_login'] ) && $IX62812['user_login'] ) { $IX37673[] = $IX20758->user_login; } if ( isset( $IX62812['from_date'] ) && $IX62812['from_date'] ) { $IX37673[] = $IX20758->from_date; } if ( isset( $IX62812['thru_date'] ) && $IX62812['thru_date'] ) { $IX37673[] = $IX20758->thru_date; } if ( isset( $IX62812['links'] ) && $IX62812['links'] ) { $IX37673[] = Affiliates_Url_Renderer::get_affiliate_url( home_url(), $IX20758->affiliate_id ); } foreach( Affiliates_Attributes::get_keys() as $IX80524 => $IX61996 ) { $IX77125 = $IX80524; $IX80524 = '_attr_' . preg_replace( '/(\.|\-)/', '_', $IX80524 ); if ( isset( $IX62812[$IX80524] ) && $IX62812[$IX80524] ) { $IX82363 = $affiliates_db->get_value( "SELECT attr_value FROM $IX59244 WHERE affiliate_id = %d AND attr_key = %s", $IX20758->affiliate_id, $IX77125 ); $IX37673[] = wp_filter_nohtml_kses( $IX82363 ); } } if ( !empty( $IX63203 ) ) { foreach( $IX63203 as $IX72058 => $IX97187 ) { if ( isset( $IX62812[$IX72058] ) && $IX62812[$IX72058] && $IX97187['enabled'] ) { $IX33042 = isset( $IX97187['type'] ) ? $IX97187['type'] : 'text'; $IX38990 = ''; switch( $IX72058 ) { case 'user_login' : $IX38990 = $IX59153->user_login; break; case 'user_email' : $IX38990 = $IX59153->user_email; break; case 'user_url' : $IX38990 = $IX59153->user_url; break; case 'password' : $IX38990 = ''; break; default : $IX38990 = get_user_meta( $IX20758->ID, $IX72058 , true ); } $IX37673[] = stripslashes( $IX38990 ); } } } $IX34671 = count( $IX37673 ); for ( $IX94001 = 0; $IX94001 < $IX34671; $IX94001++ ) { echo $IX37673[$IX94001]; echo "\t"; } echo "\n"; } }

	public static function init() { add_action( 'init', array(__CLASS__,'wp_init' ) ); }

	public static function wp_init() { if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'export' && isset( $_REQUEST['export-nonce'] ) && wp_verify_nonce( $_REQUEST['export-nonce'], 'export-affiliates' ) ) { if ( !current_user_can( AFFILIATES_ADMINISTER_AFFILIATES ) ) { wp_die( __( '拒絕訪問。', 'affiliates' ) ); } $IX41158 = new Affiliates_Export(); $IX41158->request(); die; } }

}
Affiliates_Export::init();
