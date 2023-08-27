<?php
/**
 * class-affiliates-referrals-export.php
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
 * Referral exports
 */
class Affiliates_Referrals_Export {

	private $charset = 'UTF-8';

	public function __construct() { $this->charset = get_option( 'blog_charset' ); }

	public function __set( $name, $value ) { switch( $name ) { case 'charset' : $this->charset = $value; break; } }

	public function __get( $name ) { $IX93543 = null; switch( $name ) { case 'charset' : $IX93543 = $this->charset; break; } return $IX93543; }

	public function request() { $IX81713 = date( 'Y-m-d-H-i-s', time() ); header( 'Content-Description: File Transfer' ); if ( !empty( $this->charset ) ) { header( 'Content-Type: text/tab-separated-values; charset=' . $this->charset ); } else { header( 'Content-Type: text/tab-separated-values' ); } header( "Content-Disposition: attachment; filename=\"affiliates-export-$IX81713.tsv\"" ); $this->entries(); echo "\n"; }

	private function entries() { global $wpdb, $affiliates_db, $affiliates_options; $IX92678 = $affiliates_db->get_tablename( 'affiliates' ); $IX15723 = $affiliates_db->get_tablename( 'affiliates_users' ); $IX13732 = $affiliates_db->get_tablename( 'affiliates_attributes' ); $IX53907 = $affiliates_db->get_tablename( 'referrals' ); $IX32896 = $affiliates_db->get_tablename( 'hits' ); $IX54962 = $wpdb->prefix . 'posts'; $IX18613 = date( 'Y-m-d', time() ); $IX12012 = array( 'referral_id' => __( 'Referral ID', 'affiliates' ), 'reference' => __( '參考', 'affiliates' ), 'amount' => __('數量', 'affiliates' ), 'currency_id' => __('貨幣', 'affiliates' ), 'status' => __('地位', 'affiliates' ), 'type' => __('類型', 'affiliates' ), 'datetime' => __('日期', 'affiliates' ), 'description' => __( 'Description', 'affiliates' ), 'post_id' => __( 'Post ID', 'affiliates' ), 'post_title' => __('郵政', 'affiliates' ), 'ip' => __( 'IP', 'affiliates' ), 'affiliate_id' => __( 'Affiliate ID', 'affiliates' ), 'name' => __('附屬機構', 'affiliates' ), 'user_id' => __( 'User ID', 'affiliates' ), ); if ( AFFILIATES_PLUGIN_NAME == 'affiliates-enterprise' ) { $IX12012['campaign_id'] = __( 'Campaign ID', 'affiliates' ); } $IX12012['data'] = __( 'Data', 'affiliates' ); $IX57540 = count( $IX12012 ); $IX30275 = 0; foreach( $IX12012 as $IX40468 => $IX43890 ) { echo $IX43890; $IX30275++; if ( $IX30275 < $IX57540 ) { echo "\t"; } } echo "\n"; $IX70032 = $affiliates_options->get_option( 'referrals_from_date', null ); $IX21936 = $affiliates_options->get_option( 'referrals_thru_date', null ); $IX81340 = $affiliates_options->get_option( 'referrals_affiliate_id', null ); $IX60273 = $affiliates_options->get_option( 'referrals_status', null ); $IX49881 = $affiliates_options->get_option( 'referrals_search', null ); $IX86362 = $affiliates_options->get_option( 'referrals_search_description', null ); $IX98589 = $affiliates_options->get_option( 'referrals_expanded', null ); $IX28672 = $affiliates_options->get_option( 'referrals_expanded_description', null ); $IX21271 = $affiliates_options->get_option( 'referrals_expanded_data', null ); $IX41707 = $affiliates_options->get_option( 'referrals_show_inoperative', null ); $IX16360 = " WHERE 1=%d "; $IX27852 = array( 1 ); if ( $IX70032 ) { $IX87690 = DateHelper::u2s( $IX70032 ); } if ( $IX21936 ) { $IX79334 = DateHelper::u2s( $IX21936, 24*3600 ); } if ( $IX70032 && $IX21936 ) { $IX16360 .= " AND datetime >= %s AND datetime < %s "; $IX27852[] = $IX87690; $IX27852[] = $IX79334; } else if ( $IX70032 ) { $IX16360 .= " AND datetime >= %s "; $IX27852[] = $IX87690; } else if ( $IX21936 ) { $IX16360 .= " AND datetime < %s "; $IX27852[] = $IX79334; } if ( $IX81340 ) { $IX16360 .= " AND r.affiliate_id = %d "; $IX27852[] = $IX81340; } if ( $IX60273 ) { $IX16360 .= " AND r.status = %s "; $IX27852[] = $IX60273; } if ( $IX49881 ) { if ( $IX86362 ) { $IX16360 .= " AND ( r.data LIKE %s OR r.description LIKE %s ) "; $IX27852[] = '%' . $wpdb->esc_like( $IX49881 ) . '%'; $IX27852[] = '%' . $wpdb->esc_like( $IX49881 ) . '%'; } else { $IX16360 .= " AND r.data LIKE %s "; $IX27852[] = '%' . $wpdb->esc_like( $IX49881 ) . '%'; } } $IX25468 = $wpdb->prepare("
			SELECT r.*, a.affiliate_id, a.name
			FROM $IX53907 r
			LEFT JOIN $IX92678 a ON r.affiliate_id = a.affiliate_id
			LEFT JOIN $IX54962 p ON r.post_id = p.ID
			$IX16360
			", $IX27852 + $IX27852 ); $IX68525 = $wpdb->get_results( $IX25468, OBJECT ); foreach( $IX68525 as $IX83207 ) { $IX87306 = array(); $IX87306[] = $IX83207->referral_id; $IX87306[] = $IX83207->reference; $IX87306[] = $IX83207->amount; $IX87306[] = $IX83207->currency_id; $IX87306[] = $IX83207->status; $IX87306[] = $IX83207->type; $IX87306[] = $IX83207->datetime; $IX87306[] = stripslashes( $IX83207->description ); $IX87306[] = $IX83207->post_id; $IX87306[] = stripslashes( get_the_title( $IX83207->post_id ) ); $IX87306[] = $IX83207->ip; $IX87306[] = $IX83207->affiliate_id; $IX87306[] = stripslashes( $IX83207->name ); $IX87306[] = $IX83207->user_id; if ( AFFILIATES_PLUGIN_NAME == 'affiliates-enterprise' ) { $IX87306[] = $IX83207->campaign_id; } $IX40017 = $IX83207->data; if ( empty( $IX40017 ) ) { $IX87306[] = ''; } else { $IX40017 = unserialize( $IX40017 ); if ( $IX40017 ) { if ( is_array( $IX40017 ) ) { foreach ( $IX40017 as $IX40468 => $IX99669 ) { $IX90394 = __( $IX99669['title'], $IX99669['domain'] ); $IX90394 = stripslashes( wp_filter_nohtml_kses( $IX90394 ) ); $IX87306[] = $IX90394 . ' : ' . stripslashes( $IX99669['value'] ); } } else if ( is_string( $IX40017 ) ) { $IX87306[] = stripslashes( $IX40017 ); } else { $IX87306[] = stripslahes( var_export( $IX40017, true ) ); } } } $IX57540 = count( $IX87306 ); for ( $IX30275 = 0; $IX30275 < $IX57540; $IX30275++ ) { echo $IX87306[$IX30275]; echo "\t"; } echo "\n"; } }

	public static function init() { add_action( 'init', array(__CLASS__,'wp_init' ) ); add_filter( 'affiliates_admin_referrals_secondary_actions', array( __CLASS__, 'affiliates_admin_referrals_secondary_actions' ) ); }

	public static function affiliates_admin_referrals_secondary_actions( $output ) { $output .= '<div style="display:inline">'; $output .= '<form style="display:inline" id="export-referrals" action="" method="post">'; $output .= sprintf( '<input class="button" type="submit" value="%s" />', __('出口', 'affiliates' ) ); $output .= '<input type="hidden" name="action" value="export-referrals" />'; $output .= wp_nonce_field( 'export-referrals', 'export-nonce', true, false ); $output .= '</form>'; $output .= '</div>'; return $output; }

	public static function wp_init() { if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'export-referrals' && isset( $_REQUEST['export-nonce'] ) && wp_verify_nonce( $_REQUEST['export-nonce'], 'export-referrals' ) ) { if ( !current_user_can( AFFILIATES_ADMINISTER_AFFILIATES ) ) { wp_die( __( '拒絕訪問。', 'affiliates' ) ); } $IX84382 = new Affiliates_Referrals_Export(); $IX84382->request(); die; } }

}
Affiliates_Referrals_Export::init();
