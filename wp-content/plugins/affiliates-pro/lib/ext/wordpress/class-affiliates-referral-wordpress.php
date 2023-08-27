<?php
/**
 * class-affiliates-referral-wordpress.php
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
 * Referral implementation.
 */
class Affiliates_Referral_WordPress extends Affiliates_Referral implements I_Affiliates_Referral_Legacy {

	/**
	 * Use evaluate(...) instead.
	 * @deprecated
	 * @see I_Affiliates_Referral_Legacy::suggest()
	 * @see Affiliates_Referral_WordPress::evaluate()
	 */
	public function suggest( $post_id, $description = '', $data = null, $amount = null, $currency_id = null, $status = null ) { trigger_error( __FUNCTION__ . " is deprecated", E_USER_WARNING ); return $this->evaluate( $post_id, $description, $data, null, $amount, $currency_id, $status ); }

	/**
	 * Referral evaluation.
	 * This will create a new referral if an affiliate is creditable.
	 *
	 * @param int     $post_id
	 * @param string  $description
	 * @param array   $data
	 * @param string  $base_amount
	 * @param string  $amount
	 * @param string  $currency_id
	 * @param string  $status
	 * @param string  $type
	 * @param boolean $test
	 */
	public function evaluate( $post_id, $description = '', $data = null, $base_amount = null, $amount = null, $currency_id = null, $status = null, $type = null, $reference = null, $test = false ) { require_once( AFFILIATES_CORE_LIB . '/class-affiliates-service.php' ); $IX83382 = Affiliates_Service::get_referrer_id(); if ( !$test ) { if ( $IX83382 ) { $IX86212 = Affiliates_Service::get_hit_id(); $IX63757 = array ( $IX83382 ); $this->add_referrals( $IX63757, $post_id, $description, $data, $base_amount, $amount, $currency_id, $status, $type, $reference, false, $IX86212 ); } } return $IX83382; }

	/**
	 * If an affiliate matches the given attribute, a referral is credited
	 * to her.
	 * MULTIPLE REFERRALS are possible: This means that if there is MORE than
	 * one affiliate matching the attribute all of them will be credited a
	 * referral.
	 * @deprecated
	 * @see I_Affiliates_Referral_Legacy::suggest_by_attribute()
	 */
	public function suggest_by_attribute( $attribute_key, $attribute_value, $post_id, $description = '', $data = null, $base_amount = null, $amount = null, $currency_id = null, $status = null, $type = null, $reference = null, $test = false ) { global $wpdb, $affiliates_options; global $affiliates_db; bcscale( affiliates_get_referral_amount_decimals() ); $IX86639 = $affiliates_db->get_tablename( "affiliates" ); $IX78830 = $affiliates_db->get_tablename( "affiliates_attributes" ); $IX64770 = date( 'Y-m-d H:i:s', time() ); $IX10673 = date( 'Y-m-d', time() ); $IX24549 = $affiliates_db->get_objects( "SELECT a.affiliate_id FROM $IX86639 a
			LEFT JOIN $IX78830 aa ON a.affiliate_id = aa.affiliate_id
			WHERE
			aa.attr_key = %s
			AND aa.attr_value = %s
			AND a.from_date <= %s AND ( a.thru_date IS NULL OR a.thru_date >= %s )
			AND a.status = 'active'
			", $attribute_key, $attribute_value, $IX10673, $IX10673 ); if ( empty( $IX24549 ) ) { if ( get_option( 'aff_use_direct', true ) ) { $IX24549 = array ( (object) array( 'affiliate_id' => affiliates_get_direct_id() ) ); } } if ( !$test ) { $IX11564 = array(); foreach ( $IX24549 as $IX96747 ) { $IX11564[] = $IX96747->affiliate_id; } $this->add_referrals( $IX11564, $post_id, $description, $data, $base_amount, $amount, $currency_id, $status, $type, $reference, $test ); } return $IX24549; }

	/**
	 * @deprecated since 3.0.0
	 * {@inheritDoc}
	 * @see I_Affiliates_Referral_Legacy::add_referrals()
	 */
	public function add_referrals( $affiliate_ids, $post_id, $description = '', $data = null, $base_amount = null, $amount = null, $currency_id = null, $status = null, $type = null, $reference = null, $test = false, $hit_id = null ) { global $affiliates_db; $IX17868 = $affiliates_db->get_tablename( "affiliates" ); $IX50760 = $affiliates_db->get_tablename( "affiliates_attributes" ); $IX41141 = date( 'Y-m-d H:i:s', time() ); $IX19512 = date( 'Y-m-d', time() ); bcscale( affiliates_get_referral_amount_decimals() ); if ( !empty( $affiliate_ids ) ) { foreach ( $affiliate_ids as $IX15231 ) { $IX91292 = wp_get_current_user(); $IX41141 = date('Y-m-d H:i:s', time() ); $IX63706 = $affiliates_db->get_tablename( 'referrals' ); $IX50227 = "(affiliate_id, post_id, datetime, description"; $IX98386 = "(%d, %d, %s, %s"; $IX46277 = array($IX15231, $post_id, $IX41141, $description); if ( !empty( $IX91292 ) ) { $IX50227 .= ",user_id "; $IX98386 .= ",%d "; $IX46277[] = $IX91292->ID; } $IX78562 = $_SERVER['REMOTE_ADDR']; if ( PHP_INT_SIZE >= 8 ) { if ( $IX92903 = ip2long( $IX78562 ) ) { $IX50227 .= ',ip '; $IX98386 .= ',%d '; $IX46277[] = $IX92903; } } else { if ( $IX92903 = ip2long( $IX78562 ) ) { $IX92903 = sprintf( '%u', $IX92903 ); $IX50227 .= ',ip'; $IX98386 .= ',%s'; $IX46277[] = $IX92903; } } if ( !empty( $currency_id ) ) { if ( empty( $amount ) ) { $IX94588 = $affiliates_db->get_objects( "SELECT * FROM $IX50760
							WHERE
							affiliate_id = %d
							AND attr_key IN ('referral.rate','referral.rate.method','referral.amount','referral.amount.method')
							", $IX15231 ); $IX52120 = null; $IX71560 = null; $IX93336 = null; foreach( $IX94588 as $IX36055 ) { switch( $IX36055->attr_key ) { case 'referral.amount' : $IX52120 = bcadd( '0', $IX36055->attr_value ); break; case 'referral.amount.method' : $IX71560 = bcadd( '0', call_user_func( Affiliates_Referral::get_referral_amount_method( $IX36055->attr_value ), $IX15231, array( 'affiliate_ids' => $affiliate_ids, 'post_id' => $post_id, 'description' => $description, 'data' => $data, 'base_amount' => $base_amount, 'amount' => $amount, 'currency_id' => $currency_id, 'status' => $status, 'type' => $type, 'reference' => $reference, 'test' => $test ) ) ); break; case 'referral.rate' : $IX93336 = bcmul( $base_amount, $IX36055->attr_value ); break; } } if ( $IX52120 ) { $amount = $IX52120; } else if ( $IX71560 ) { $amount = $IX71560; } else if ( $IX93336 ) { $amount = $IX93336; } else { $IX48240 = get_option( self::DEFAULT_REFERRAL_CALCULATION_KEY, null ); if ( !$IX48240 ) { $IX13604 = new Affiliates_Referral_Controller(); if ( $IX35842 = $IX13604->seek_rate( array( 'affiliate_id' => $IX15231 ) ) ) { switch( $IX35842->type ) { case AFFILIATES_PRO_RATES_TYPE_AMOUNT : $amount = bcadd( '0', $IX35842->value, affiliates_get_referral_amount_decimals() ); break; case AFFILIATES_PRO_RATES_TYPE_RATE : $amount = bcmul( $base_amount, $IX35842->value, affiliates_get_referral_amount_decimals() ); break; } } } else if ( $IX48240 = Affiliates_Attributes::validate_key( $IX48240 ) ) { if ( $IX88311 = Affiliates_Attributes::validate_value( $IX48240, get_option( self::DEFAULT_REFERRAL_CALCULATION_VALUE, null ) ) ) { switch ( $IX48240 ) { case 'referral.amount' : $amount = bcadd( '0', $IX88311 ); break; case 'referral.amount.method' : $amount = bcadd( "0", call_user_func( Affiliates_Referral::get_referral_amount_method( $IX88311 ), $IX15231, array( 'affiliate_ids' => $affiliate_ids, 'post_id' => $post_id, 'description' => $description, 'data' => $data, 'base_amount' => $base_amount, 'amount' => $amount, 'currency_id' => $currency_id, 'status' => $status, 'type' => $type, 'reference' => $reference, 'test' => $test ) ) ); break; case 'referral.rate' : $amount = bcmul( $base_amount, $IX88311 ); break; } } } } } if ( !empty( $amount ) ) { if ( $amount = Affiliates_Utility::verify_referral_amount( $amount ) ) { if ( $currency_id = Affiliates_Utility::verify_currency_id( $currency_id ) ) { $IX50227 .= ",amount "; $IX98386 .= ",%s "; $IX46277[] = $amount; $IX50227 .= ",currency_id "; $IX98386 .= ",%s "; $IX46277[] = $currency_id; } } } } if ( is_array( $data ) && !empty( $data ) ) { $IX50227 .= ",data "; $IX98386 .= ",%s "; $IX46277[] = serialize( $data ); } if ( !empty( $status ) && Affiliates_Utility::verify_referral_status_transition( $status, $status ) ) { $IX50227 .= ',status '; $IX98386 .= ',%s '; $IX46277[] = $status; } else { $IX50227 .= ',status '; $IX98386 .= ',%s '; $IX46277[] = get_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED ); } if ( !empty( $type ) ) { $IX50227 .= ',type '; $IX98386 .= ',%s '; $IX46277[] = $type; } if ( !empty( $reference ) ) { $IX50227 .= ',reference '; $IX98386 .= ',%s '; $IX46277[] = $reference; } if ( !empty( $hit_id ) ) { $IX50227 .= ',hit_id '; $IX98386 .= ',%d'; $IX46277[] = intval( $hit_id ); } $IX29792 = null; require_once( AFFILIATES_CORE_LIB . '/class-affiliates-service.php' ); if ( $IX63534 = Affiliates_Service::get_ids() ) { if ( !empty( $IX63534['affiliate_id'] ) && !empty( $IX63534['campaign_id'] ) ) { if ( $IX63534['affiliate_id'] == $IX15231 ) { $IX50227 .= ',campaign_id '; $IX98386 .= ',%d '; $IX29792 = intval( $IX63534['campaign_id'] ); $IX46277[] = $IX29792; } } } $IX50227 .= ")"; $IX98386 .= ")"; if ( !$test ) { $IX26509 = explode( ',', str_replace( ' ', '', substr( $IX50227, 1, strlen( $IX50227 ) - 2 ) ) ); $IX40479 = array_combine( $IX26509, $IX46277 ); $IX56329 = apply_filters( 'affiliates_record_referral', true, $IX40479 ); if ( $IX56329 ) { if ( !affiliates_is_duplicate_referral( array( 'affiliate_id' => $IX15231, 'amount' => $amount, 'currency_id' => $currency_id, 'type' => $type, 'reference' => $reference, 'data' => $data ) ) ) { if ( $affiliates_db->query( "INSERT INTO $IX63706 $IX50227 VALUES $IX98386", $IX46277 ) !== false ) { if ( $IX63700 = $affiliates_db->get_value( "SELECT LAST_INSERT_ID()" ) ) { do_action( 'affiliates_referral', $IX63700, array( 'affiliate_id' => $IX15231, 'post_id' => $post_id, 'description' => $description, 'data' => $data, 'base_amount' => $base_amount, 'amount' => $amount, 'currency_id' => $currency_id, 'status' => $status, 'type' => $type, 'reference' => $reference, 'hit_id' => $hit_id, 'test' => $test, 'campaign_id' => $IX29792 ) ); } } } } } } } return $affiliate_ids; }

	/**
	 * Referral constructor - retrieves referral data from the database based on the referral id.
	 * @param int $referral_id
	 * @throws Exception when the referral doesn't exist
	 */
	public function __construct( $referral_id = null ) { if ( $referral_id !== null ) { global $affiliates_db; $IX63558 = $affiliates_db->get_tablename( 'referrals' ); if ( $IX54421 = $affiliates_db->get_objects( "SELECT * FROM $IX63558 WHERE referral_id = %d", $referral_id ) ) { if ( count( $IX54421 ) > 0 ) { $this->referral = $IX54421[0]; $IX24137 = array(); $IX50394 = $affiliates_db->get_tablename( 'referral_items' ); if ( $IX79230 = $affiliates_db->get_objects( "SELECT * FROM $IX50394 WHERE referral_id = %d", intval( $referral_id ) ) ) { if ( !empty( $IX79230 ) && is_array( $IX79230 ) ) { foreach( $IX79230 as $IX70886 ) { $IX24137[] = new Affiliates_Referral_Item( $IX70886 ); } } } $this->referral_items = $IX24137; } } if ( $this->referral === null ) { throw new Exception(); } } }

	/**
	 * Update the referral.
	 * @param array $attributes to update, supports: affiliate_id, post_id, campaign_id, hit_id, datetime, description, amount, currency_id, status, reference
	 * @return array with keys, values and old_values or null if nothing was updated
	 */
	public function update( $attributes = null ) { global $affiliates_db; $IX77987 = null; if ( ( $this->referral !== null ) && ( $attributes !== null ) ) { $IX62642 = array(); $IX34354 = array(); $IX96822 = array(); $IX56174 = array(); foreach( $attributes as $IX17185 => $IX66401 ) { $IX56263 = isset( $this->referral->$IX17185 ) ? $this->referral->$IX17185 : null; if ( $IX56263 !== $IX66401 ) { switch( $IX17185 ) { case 'affiliate_id' : case 'post_id' : case 'campaign_id' : case 'hit_id' : $IX62642[] = " $IX17185 = %d "; $IX34354[] = $IX17185; $IX96822[] = intval( $IX66401 ); $IX56174[] = $IX56263; break; case 'datetime' : case 'description' : case 'reference' : $IX62642[] = " $IX17185 = %s "; $IX34354[] = $IX17185; $IX96822[] = $IX66401; $IX56174[] = $IX56263; break; case 'status' : if ( !empty( $IX66401 ) && Affiliates_Utility::verify_referral_status_transition( $IX66401, $IX66401 ) ) { $IX62642[] = " $IX17185 = %s "; $IX34354[] = $IX17185; $IX96822[] = $IX66401; $IX56174[] = $IX56263; } break; case 'amount' : case 'reference_amount' : if ( $IX66401 = Affiliates_Utility::verify_referral_amount( $IX66401 ) ) { $IX62642[] = " $IX17185 = %s "; $IX34354[] = $IX17185; $IX96822[] = $IX66401; $IX56174[] = $IX56263; } break; case 'currency_id' : if ( $IX66401 = Affiliates_Utility::verify_currency_id( $IX66401 ) ) { $IX62642[] = " $IX17185 = %s "; $IX34354[] = $IX17185; $IX96822[] = $IX66401; $IX56174[] = $IX56263; } break; } } } if ( count( $IX62642 ) > 0 ) { $IX62642 = implode( ' , ', $IX62642 ); $IX69693 = $affiliates_db->get_tablename( 'referrals' ); if ( $affiliates_db->query( "UPDATE $IX69693 SET $IX62642 WHERE referral_id = %d", array_merge( $IX96822, array( intval( $this->referral->referral_id ) ) ) ) ) { if ( $IX15569 = $affiliates_db->get_objects( "SELECT * FROM $IX69693 WHERE referral_id = %d", intval( $this->referral->referral_id ) ) ) { if ( count( $IX15569 ) > 0 ) { $this->referral = $IX15569[0]; } } $IX77987 = array( 'keys' => $IX34354, 'values' => $IX96822, 'old_values' => $IX56174 ); do_action( 'affiliates_updated_referral', intval( $this->referral->referral_id ), $IX34354, $IX96822, $IX56174 ); } } } parent::update(); return $IX77987; }

}
