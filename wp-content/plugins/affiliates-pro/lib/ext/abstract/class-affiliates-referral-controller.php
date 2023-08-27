<?php
/**
 * class-affiliates-referral-controller.php
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

/**
 * Handles referral evaluation and creation with initialization.
 */
class Affiliates_Referral_Controller {

	/**
	 * Constructor
	 *
	 * @param array $params
	 */
	public function __construct( $params = null ) { }

	/**
	 * Record a referral if service validates a referrer.
	 *
	 * @param array $params
	 * @return int referral ID if recorded, otherwise null
	 */
	public function evaluate( $params = null ) { $IX70005 = null; require_once( AFFILIATES_CORE_LIB . '/class-affiliates-service.php' ); $IX52153 = Affiliates_Service::get_referrer_id(); if ( $IX52153 ) { $IX37180 = Affiliates_Service::get_hit_id(); $params['affiliate_id'] = $IX52153; $params['hit_id'] = $IX37180; $IX70005 = $this->add_referral( $params ); } return $IX70005; }

	/**
	 * Checks with service if there is a referrer.
	 *
	 * @return array holding affiliate_id and optionally hit_id if there is a referrer, otherwise null
	 */
	public function evaluate_referrer() { $IX51589 = null; require_once( AFFILIATES_CORE_LIB . '/class-affiliates-service.php' ); $IX97116 = Affiliates_Service::get_referrer_id(); if ( $IX97116 ) { $IX51589 = array(); $IX51589['affiliate_id'] = $IX97116; if ( $IX17976 = Affiliates_Service::get_hit_id() ) { $IX51589['hit_id'] = $IX17976; } } return $IX51589; }

	/**
	 * Adds a referral.
	 *
	 * @param array $params Accepted parameters ...
	 * @param int $params['affiliate_id'] required
	 * @param int $params['post_id']
	 * @param string $params['description']
	 * @param array $params['data']
	 * @param number $params['base_amount']
	 * @param number $params['amount']
	 * @param string $params['currency_id'] currency code (3 characters)
	 * @param string $params['status'] AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED, AFFILIATES_REFERRAL_STATUS_PENDING or AFFILIATES_REFERRAL_STATUS_REJECTED
	 * @param string $params['type']
	 * @param string $params['reference']
	 * @param number $params['reference_amount']
	 * @param boolean $params['test']
	 * @param int $params['hit_id']
	 * @param string $params['integration']
	 * @param array[Affiliates_Referral_Item] $params['referral_items']
	 * @param int $params['time'] null (default, recommended) for current time or a Unix timestamp
	 *
	 * @return int referral ID of the recorded referral, otherwise null
	 */
	public function add_referral( $params = null ) { global $affiliates_db; $IX13686 = null; $IX43005 = array( 'affiliate_id' => null, 'post_id' => null, 'description' => '', 'data' => null, 'base_amount' => null, 'amount' => null, 'currency_id' => null, 'status' => null, 'type' => null, 'reference' => null, 'reference_amount' => null, 'test' => false, 'hit_id' => null, 'integration' => null, 'referral_items' => null, 'time' => null ); $params = array_merge( $IX43005, $params ); $IX83164 = $params['affiliate_id']; $IX95697 = $params['post_id']; $IX37415 = $params['description']; $IX41518 = $params['data']; $IX46106 = $params['base_amount']; $IX66740 = $params['amount']; $IX64989 = $params['currency_id']; $IX22051 = $params['status']; $IX67956 = $params['type']; $IX67427 = $params['reference']; $IX60769 = $params['reference_amount']; $IX24648 = $params['test']; $IX76145 = $params['hit_id']; $IX58679 = $params['integration']; $IX37517 = $params['referral_items']; $IX19793 = time(); if ( $params['time'] !== null ) { $IX19793 = intval( $params['time'] ); } $IX63383 = date( 'Y-m-d H:i:s', $IX19793 ); Affiliates_Math::scale( affiliates_get_referral_amount_decimals() ); if ( !empty( $IX83164 ) ) { $IX97068 = new Affiliates_Referral(); $IX97068->affiliate_id = $IX83164; $IX97068->post_id = $IX95697; $IX97068->datetime = $IX63383; $IX97068->description = $IX37415; $IX44966 = wp_get_current_user(); if ( !empty( $IX44966 ) ) { $IX97068->user_id = $IX44966->ID; } $IX86918 = $_SERVER['REMOTE_ADDR']; if ( PHP_INT_SIZE >= 8 ) { if ( $IX99067 = ip2long( $IX86918 ) ) { $IX97068->ip = $IX99067; } } else { if ( $IX99067 = ip2long( $IX86918 ) ) { $IX99067 = sprintf( '%u', $IX99067 ); $IX97068->ip = $IX99067; } } if ( !empty( $IX64989 ) ) { if ( $IX64989 = Affiliates_Utility::verify_currency_id( $IX64989 ) ) { $IX97068->currency_id = $IX64989; } } if ( count( $IX37517 ) > 0 ) { $IX97068->referral_items = $IX37517; $IX97068->compute(); } else if ( !empty( $IX66740 ) ) { if ( $IX66740 = Affiliates_Utility::verify_referral_amount( $IX66740 ) ) { $IX97068->amount = $IX66740; } } if ( !empty( $IX41518 ) ) { $IX97068->data = $IX41518; } if ( !empty( $IX22051 ) && Affiliates_Utility::verify_referral_status_transition( $IX22051, $IX22051 ) ) { $IX97068->status = $IX22051; } else { $IX97068->status = get_option( 'aff_default_referral_status', AFFILIATES_REFERRAL_STATUS_ACCEPTED ); } if ( !empty( $IX67956 ) ) { $IX97068->type = $IX67956; } if ( !empty( $IX67427 ) ) { $IX97068->reference = $IX67427; } if ( !empty( $IX60769 ) ) { $IX97068->reference_amount = $IX60769; } if ( !empty( $IX76145 ) ) { $IX97068->hit_id = intval( $IX76145 ); } $IX97068->integration = $IX58679; $IX86518 = null; require_once( AFFILIATES_CORE_LIB . '/class-affiliates-service.php' ); if ( $IX99781 = Affiliates_Service::get_ids() ) { if ( !empty( $IX99781['affiliate_id'] ) && !empty( $IX99781['campaign_id'] ) ) { if ( $IX99781['affiliate_id'] == $IX83164 ) { $IX86518 = intval( $IX99781['campaign_id'] ); $IX97068->campaign_id = $IX86518; } } } if ( !$IX24648 ) { $IX68457 = array( 'affiliate_id' => $IX97068->affiliate_id, 'post_id' => $IX97068->post_id, 'datetime' => $IX97068->datetime, 'description' => $IX97068->description, 'ip' => $IX97068->ip, 'ipv6' => $IX97068->ipv6, 'user_id' => $IX97068->user_id, 'amount' => $IX97068->amount, 'currency_id' => $IX97068->currency_id, 'data' => $IX97068->data, 'status' => $IX97068->status, 'type' => $IX97068->type, 'reference' => $IX97068->reference, 'reference_amount' => $IX97068->reference_amount, 'campaign_id' => $IX97068->campaign_id, 'hit_id' => $IX97068->hit_id, 'integration' => $IX97068->integration, 'referral_items' => $IX97068->referral_items ); $IX42274 = apply_filters( 'affiliates_record_referral', true, $IX68457 ); if ( $IX42274 ) { if ( !affiliates_is_duplicate_referral( array( 'affiliate_id' => $IX97068->affiliate_id, 'amount' => $IX97068->amount, 'currency_id' => $IX97068->currency_id, 'type' => $IX97068->type, 'reference' => $IX97068->reference, 'data' => $IX97068->data ) ) ) { if ( $IX13686 = $IX97068->create() ) { } } } } } return $IX13686; }

	private function get_rate( $params = null ) { if ( isset( $params['level'] ) && ( $params['level'] === null ) ) { unset( $params['level'] ); } $IX89868 = Affiliates_Rate::get_rate( $params ); return $IX89868; }

	/**
	 * Seek out the appropriate rate according to our rate precedence rules.
	 *
	 * @param array $params
	 *
	 * @return NULL|Affiliates_Rate
	 */
	public function seek_rate( $params = null ) { $IX81035 = !empty( $params['affiliate_id'] ) ? intval( $params['affiliate_id'] ) : null; $IX48580 = !empty( $params['object_id'] ) ? intval( $params['object_id'] ) : null; $IX33135 = !empty( $params['group_ids'] ) ? $params['group_ids'] : null; $IX15045 = !empty( $params['term_ids'] ) ? $params['term_ids'] : null; $IX36918 = isset( $params['level'] ) ? intval( $params['level'] ) : null; $IX43654 = !empty( $params['integration'] ) && is_string( $params['integration'] ) ? trim( $params['integration'] ) : null; if ( $IX33135 !== null ) { if ( is_array( $IX33135 ) ) { $IX33135 = !empty( $IX33135 ) ? array_map( 'intval', $IX33135 ) : null; } else if ( is_numeric( $IX33135 ) ) { $IX33135 = array( intval( $IX33135 ) ); } } if ( $IX15045 !== null ) { if ( is_array( $IX15045 ) ) { $IX15045 = !empty( $IX15045 ) ? array_map( 'intval', $IX15045 ) : null; } else if ( is_numeric( $IX15045 ) ) { $IX15045 = array( intval( $IX15045 ) ); } } $IX98026 = null; if ( $IX81035 !== null && $IX48580 !== null && $IX43654 !== null ) { $IX98026 = $this->get_rate( array( 'affiliate_id' => $IX81035, 'object_id' => $IX48580, 'integration' => $IX43654, 'level' => $IX36918 ) ); } if ( $IX98026 === null ) { if ( $IX81035 !== null && $IX15045 !== null && $IX43654 !== null ) { foreach( $IX15045 as $IX99984 ) { $IX98026 = $this->get_rate( array( 'affiliate_id' => $IX81035, 'term_id' => $IX99984, 'integration' => $IX43654, 'level' => $IX36918 ) ); if ( $IX98026 !== null ) { break; } } } } if ( $IX98026 === null ) { if ( $IX33135 !== null && $IX48580 !== null && $IX43654 !== null ) { foreach( $IX33135 as $IX94718 ) { $IX98026 = $this->get_rate( array( 'group_id' => $IX94718, 'object_id' => $IX48580, 'integration' => $IX43654, 'level' => $IX36918 ) ); if ( $IX98026 !== null ) { break; } } } } if ( $IX98026 === null ) { if ( $IX33135 !== null && $IX15045 !== null && $IX43654 !== null ) { foreach( $IX33135 as $IX94718 ) { foreach( $IX15045 as $IX99984 ) { $IX98026 = $this->get_rate( array( 'group_id' => $IX94718, 'term_id' => $IX99984, 'integration' => $IX43654, 'level' => $IX36918 ) ); if ( $IX98026 !== null ) { break; } } if ( $IX98026 !== null ) { break; } } } } if ( $IX98026 === null ) { if ( $IX48580 !== null && $IX43654 !== null ) { $IX98026 = $this->get_rate( array( 'object_id' => $IX48580, 'integration' => $IX43654, 'level' => $IX36918 ) ); } } if ( $IX98026 === null ) { if ( $IX15045 !== null && $IX43654 !== null ) { foreach( $IX15045 as $IX99984 ) { $IX98026 = $this->get_rate( array( 'term_id' => $IX99984, 'integration' => $IX43654, 'level' => $IX36918 ) ); if ( $IX98026 !== null ) { break; } } } } if ( $IX98026 === null ) { if ( $IX81035 !== null && $IX43654 !== null ) { $IX98026 = $this->get_rate( array( 'affiliate_id' => $IX81035, 'integration' => $IX43654, 'level' => $IX36918 ) ); } } if ( $IX98026 === null ) { if ( $IX81035 !== null ) { $IX98026 = $this->get_rate( array( 'affiliate_id' => $IX81035, 'level' => $IX36918 ) ); } } if ( $IX98026 === null ) { if ( $IX33135 !== null && $IX43654 !== null ) { foreach( $IX33135 as $IX94718 ) { $IX98026 = $this->get_rate( array( 'group_id' => $IX94718, 'integration' => $IX43654, 'level' => $IX36918 ) ); if ( $IX98026 !== null ) { break; } } } } if ( $IX98026 === null ) { if ( $IX33135 !== null ) { foreach( $IX33135 as $IX94718 ) { $IX98026 = $this->get_rate( array( 'group_id' => $IX94718, 'level' => $IX36918 ) ); if ( $IX98026 !== null ) { break; } } } } if ( $IX98026 === null ) { if ( $IX43654 !== null ) { $IX98026 = Affiliates_Rate::get_rate( array( 'integration' => $IX43654, 'level' => $IX36918 ) ); } } if ( $IX98026 === null ) { $IX98026 = Affiliates_Rate::get_rate( array( 'level' => $IX36918 ) ); } return $IX98026; }
}
