<?php
/**
 * class-affiliates-referral.php
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
 * Referral base.
 */
class Affiliates_Referral {

	private $referral_id = null;
	private $affiliate_id = null;
	private $post_id = null;
	private $datetime = null;
	private $description = null;
	private $ip = null;
	private $ipv6 = null;
	private $user_id = null;
	private $amount = null;
	private $currency_id = null;
	private $data = null;
	private $status = null;
	private $type = null;
	private $reference = null;
	private $reference_amount = null;
	private $campaign_id = null;
	private $hit_id = null;
	private $integration = null;

	/**
	 * Related referral items.
	 *
	 * @var array of Affiliates_Referral_Item $referral_items
	 */
	private $referral_items = null;

	const DEFAULT_REFERRAL_CALCULATION_KEY   = 'aff_def_ref_calc_key';
	const DEFAULT_REFERRAL_CALCULATION_VALUE = 'aff_def_ref_calc_value';

	/**
	 * @legacy used in Affiliates_Referral_WordPress
	 */
	private $referral = null;

	private static $referral_amount_methods = array();

	public static function init() { self::register_referral_amount_method( array( __CLASS__, 'example_referral_amount_method' ) ); }

	/**
	 * Initializes the $referral with the values from $o.
	 *
	 * @param Affiliates_Referral $referral_item
	 * @param object $o
	 */
	private static function initialize( &$referral, $o ) { if ( isset( $o->referral_id ) ) { $referral->referral_id = $o->referral_id; } if ( isset( $o->affiliate_id ) ) { $referral->affiliate_id = $o->affiliate_id; } if ( isset( $o->post_id ) ) { $referral->post_id = $o->post_id; } if ( isset( $o->datetime ) ) { $referral->datetime = $o->datetime; } if ( isset( $o->description ) ) { $referral->description = $o->description; } if ( isset( $o->ip ) ) { $referral->ip = $o->ip; } if ( isset( $o->ipv6 ) ) { $referral->ipv6 = $o->ipv6; } if ( isset( $o->user_id ) ) { $referral->user_id = $o->user_id; } if ( isset( $o->amount ) ) { $referral->amount = $o->amount; } if ( isset( $o->currency_id ) ) { $referral->currency_id = $o->currency_id; } if ( isset( $o->data ) ) { if ( $IX73398 = @unserialize( $o->data ) ) { $referral->data = $IX73398; } else { $referral->data = $o->data; } } if ( isset( $o->status ) ) { $referral->status = $o->status; } if ( isset( $o->type ) ) { $referral->type = $o->type; } if ( isset( $o->reference ) ) { $referral->reference = $o->reference; } if ( isset( $o->reference_amount ) ) { $referral->reference_amount = $o->reference_amount; } if ( isset( $o->campaign_id ) ) { $referral->campaign_id = $o->campaign_id; } if ( isset( $o->hit_id ) ) { $referral->hit_id = $o->hit_id; } if ( isset( $o->integration ) ) { $referral->integration = $o->integration; } if ( isset( $o->referral_items ) ) { if ( is_array( $o->referral_items ) ) { $referral->referral_items = array(); foreach( $o->referral_items as $IX27216 ) { if ( $IX27216 instanceof Affiliates_Referral_item ) { $referral->referral_items[] = $IX27216; } } } } if ( isset( $o->referral ) ) { $referral->referral = $o->referral; } }

	/**
	 * Create the object with the properties provided in $attributes.
	 * $attributes can hold values for these keys:
	 * - referral_id
	 * - affiliate_id
	 * - post_id
	 * - datetime
	 * - description
	 * - ip
	 * - ipv6
	 * - user_id
	 * - amount
	 * - currency_id
	 * - data
	 * - status
	 * - type
	 * - reference
	 * - reference_amount
	 * - campaign_id
	 * - hit_id
	 * - integration
	 *
	 * @legacy
	 * - referral
	 *
	 * @param array|object $attributes array of key-value pairs or object with appropriate properties
	 */
	public function __construct( $attributes = array() ) { if ( is_object( $attributes ) ) { $attributes = (array) $attributes; } foreach( $attributes as $IX19196 => $IX23610 ) { switch( $IX19196 ) { case 'referral_id' : case 'affiliate_id' : case 'post_id' : case 'datetime' : case 'description' : case 'ip' : case 'ipv6' : case 'user_id' : case 'amount' : case 'currency_id' : case 'data' : case 'status' : case 'type' : case 'reference' : case 'reference_amount' : case 'campaign_id' : case 'hit_id' : case 'integration' : case 'referral_items' : case 'referral' : $this->$IX19196 = $IX23610; break; } } }

	/**
	 * @deprecated since 4.0.0 - use rate formulas instead
	 */
	public static function example_referral_amount_method( $affiliate_id = null, $parameters = null ) { $IX14301 = "0"; if ( isset( $parameters['base_amount'] ) ) { $IX14301 = bcmul( "0.1", $parameters['base_amount'] ); } return $IX14301; }

	/**
	 * Registers a referral amount method.
	 *
	 * The method must take two parameters:
	 * 1. int the affiliate id which can be null
	 * 2. array parameters indexed by their name (arguments to add_referral(...)
	 *
	 * @param string|array $method
	 *
	 * @return boolean true if the method is accepted, false otherwise
	 *
	 * @deprecated since 4.0.0 - use rate formulas instead
	 */
	public static function register_referral_amount_method( $method ) { $IX38151 = false; if ( is_string( $method ) ) { $method = explode( "::", $method ); if ( count( $method ) == 1 ) { $method = $method[0]; } } if ( in_array( $method, self::$referral_amount_methods ) ) { $IX38151 = true; } else if ( ( ( is_array( $method ) && ( count( $method ) == 2 ) && method_exists( $method[0], $method[1] ) ) ) || ( is_string( $method ) && function_exists( $method ) ) ) { $IX32440 = bcadd( "0", call_user_func( $method, null, null ) ); if ( $IX32440 !== false ) { self::$referral_amount_methods[] = $method; $IX38151 = true; } } return $IX38151; }

	/**
	 * @deprecated since 4.0.0 - use rate formulas instead
	 */
	public static function get_referral_amount_methods() { return self::$referral_amount_methods; }

	/**
	 * @deprecated since 4.0.0 - use rate formulas instead
	 */
	public static function is_referral_amount_method( $method ) { return self::get_referral_amount_method( $method ); }

	/**
	 * @deprecated since 4.0.0 - use rate formulas instead
	 */
	public static function get_referral_amount_method( $method ) { if ( is_string( $method ) ) { $IX42978 = @unserialize( $method ); if ( $IX42978 !== false ) { $method = $IX42978; } } if ( is_string( $method ) ) { $method = explode( "::", $method ); if ( count( $method ) == 1 ) { $method = $method[0]; } } if ( in_array( $method, self::$referral_amount_methods ) ) { return $method; } else { return false; } }

	/**
	 * Returns the named property's value if valid.
	 *
	 * @param string $name property name
	 *
	 * @return mixed property value
	 */
	public function __get( $name ) { $IX11787 = null; switch( $name ) { case 'referral_id' : case 'affiliate_id' : case 'post_id' : case 'datetime' : case 'description' : case 'ip' : case 'ipv6' : case 'user_id' : case 'amount' : case 'currency_id' : case 'data' : case 'status' : case 'type' : case 'reference' : case 'reference_amount' : case 'campaign_id' : case 'hit_id' : case 'integration' : case 'referral_items' : case 'referral' : $IX11787 = $this->$name; break; } return $IX11787; }

	/**
	 * Sets the named property's value if valid.
	 *
	 * @param string $name property's name
	 * @param mixed $value property's value to set
	 */
	public function __set( $name, $value ) { switch( $name ) { case 'referral_id' : case 'affiliate_id' : case 'post_id' : case 'datetime' : case 'description' : case 'ip' : case 'ipv6' : case 'user_id' : case 'amount' : case 'currency_id' : case 'data' : case 'status' : case 'type' : case 'reference' : case 'reference_amount' : case 'campaign_id' : case 'hit_id' : case 'integration' : case 'referral' : $this->$name = $value; break; case 'referral_items' : if ( is_array( $value ) ) { $this->referral_items = array(); foreach( $value as $IX64738 ) { if ( $IX64738 instanceof Affiliates_Referral_item ) { $this->referral_items[] = $IX64738; } } } break; } }

	/**
	 * Create the referral (and its referral items) in the database.
	 * This will update the referral's amount automatically if there
	 * are any referral items.
	 *
	 * @return int referral_id on success or null on failure
	 */
	public function create() { global $affiliates_db; if ( $this->referral_id === null ) { $this->compute(); $IX82389 = array(); $IX68711 = array(); if ( $this->affiliate_id !== null ) { $IX82389[] = 'affiliate_id = %d'; $IX68711[] = intval( $this->affiliate_id ); } else { } if ( $this->post_id !== null ) { $IX82389[] = 'post_id = %d'; $IX68711[] = intval( $this->post_id ); } else { } if ( $this->datetime !== null ) { $IX82389[] = 'datetime = %s'; $IX68711[] = $this->datetime; } else { $IX82389[] = 'datetime = %s'; $IX68711[] = date( 'Y-m-d H:i:s', time() ); } if ( $this->description !== null ) { $IX82389[] = 'description = %s'; $IX68711[] = $this->description; } else { $IX82389[] = 'description = NULL'; } if ( $this->ip !== null ) { $IX82389[] = 'ip = %d'; $IX68711[] = intval( $this->ip ); } else { $IX82389[] = 'ip = NULL'; } if ( $this->ipv6 !== null ) { $IX82389[] = 'ipv6 = %s'; $IX68711[] = $this->ipv6; } else { $IX82389[] = 'ipv6 = NULL'; } if ( $this->user_id !== null ) { $IX82389[] = 'user_id = %d'; $IX68711[] = intval( $this->user_id ); } else { $IX82389[] = 'user_id = NULL'; } if ( $this->amount !== null ) { $IX82389[] = 'amount = %s'; $IX68711[] = $this->amount; } else { $IX82389[] = 'amount = NULL'; } if ( $this->currency_id !== null ) { $IX82389[] = 'currency_id = %s'; $IX68711[] = $this->currency_id; } else { $IX82389[] = 'currency_id = NULL'; } if ( $this->data !== null ) { $IX82389[] = 'data = %s'; if ( !empty( $this->data ) && is_array( $this->data ) ) { $IX68711[] = serialize( $this->data ); } else if ( !empty( $this->data ) && is_string( $this->data ) ) { $IX68711[] = $this->data; } else { $IX68711[] = ''; } } else { $IX82389[] = 'data = NULL'; } if ( $this->status !== null ) { $IX82389[] = 'status = %s'; $IX68711[] = $this->status; } else { } if ( $this->type !== null ) { $IX82389[] = 'type = %s'; $IX68711[] = $this->type; } else { $IX82389[] = 'type = NULL'; } if ( $this->reference !== null ) { $IX82389[] = 'reference = %s'; $IX68711[] = $this->reference; } else { $IX82389[] = 'reference = NULL'; } if ( $this->reference_amount !== null ) { $IX82389[] = 'reference_amount = %s'; $IX68711[] = $this->reference_amount; } else { $IX82389[] = 'reference_amount = NULL'; } if ( $this->campaign_id !== null ) { $IX82389[] = 'campaign_id = %d'; $IX68711[] = intval( $this->campaign_id ); } else { $IX82389[] = 'campaign_id = NULL'; } if ( $this->hit_id !== null ) { $IX82389[] = 'hit_id = %d'; $IX68711[] = intval( $this->hit_id ); } else { $IX82389[] = 'hit_id = NULL'; } if ( $this->integration !== null ) { $IX82389[] = 'integration = %s'; $IX68711[] = $this->integration; } else { $IX82389[] = 'integration = NULL'; } $IX65191 = $affiliates_db->get_tablename( 'referrals' ); $IX38148 = "INSERT INTO $IX65191 SET " . implode( ',', $IX82389 ); if ( $affiliates_db->query( $IX38148, $IX68711 ) ) { if ( $this->referral_id = $affiliates_db->get_value( "SELECT LAST_INSERT_ID()" ) ) { if ( !empty( $this->referral_items ) && is_array( $this->referral_items ) ) { foreach( $this->referral_items as $IX41519 ) { $IX41519->referral_id = $this->referral_id; $IX41519->create(); } } do_action( 'affiliates_referral', $this->referral_id, array( 'affiliate_id' => $this->affiliate_id, 'post_id' => $this->post_id, 'description' => $this->description, 'data' => $this->data, 'amount' => $this->amount, 'currency_id' => $this->currency_id, 'status' => $this->status, 'type' => $this->type, 'reference' => $this->reference, 'reference_amount' => $this->reference_amount, 'hit_id' => $this->hit_id, 'integration' => $this->integration, 'campaign_id' => $this->campaign_id ) ); } } } return $this->referral_id; }

	/**
	 * Read a referral (and its referral items) from the database.
	 *
	 * @param int $referral_id
	 * @return Affiliates_Referral on success or null
	 */
	public function read( $referral_id ) { global $affiliates_db; $IX95015 = null; $IX10522 = $affiliates_db->get_tablename( 'referrals' ); if ( $IX25789 = $affiliates_db->get_objects( "SELECT * FROM $IX10522 WHERE referral_id = %d", intval( $referral_id ) ) ) { if ( $IX22914 = array_shift( $IX25789 ) ) { self::initialize( $this, $IX22914 ); $this->referral_items = array(); $IX92583 = $affiliates_db->get_tablename( 'referral_items' ); if ( $IX65242 = $affiliates_db->get_objects( "SELECT * FROM $IX92583 WHERE referral_id = %d", intval( $referral_id ) ) ) { if ( !empty( $IX65242 ) && is_array( $IX65242 ) ) { foreach( $IX65242 as $IX97489 ) { $this->referral_items[] = new Affiliates_Referral_Item( $IX97489 ); } } } $IX95015 = $this; } } return $IX95015; }

	/**
	 * Retrieve an array of matching referral IDs.
	 *
	 * @param string $reference
	 *
	 * @return int[]
	 */
	public static function get_ids_by_reference( $reference ) { global $affiliates_db; $IX64754 = array(); $IX86210 = $affiliates_db->get_tablename( 'referrals' ); $IX45996 = $affiliates_db->get_objects( "SELECT referral_id FROM $IX86210 WHERE reference = %s", $reference ); if ( $IX45996 ) { foreach( $IX45996 as $IX66404 ) { $IX64754[] = $IX66404->referral_id; } } return $IX64754; }

	/**
	 * Retrieve an array of matching referral IDs.
	 *
	 * @since 4.19.0
	 *
	 * @param int $post_id
	 *
	 * @return int[]
	 */
	public static function get_ids_by_post_id( $post_id ) { global $affiliates_db; $IX64024 = array(); $IX58115 = $affiliates_db->get_tablename( 'referrals' ); $IX57957 = $affiliates_db->get_objects( "SELECT referral_id FROM $IX58115 WHERE post_id = %d", intval( $post_id ) ); if ( $IX57957 ) { foreach( $IX57957 as $IX18087 ) { $IX64024[] = $IX18087->referral_id; } } return $IX64024; }

	/**
	 * Update the database entry based on this object's current values.
	 * This also creates or updates this referral's referral items and deletes those
	 * that are not present in the object.
	 * This will update the referral's amount automatically if there
	 * are any referral items.
	 *
	 * @return boolean true on success
	 */
	public function update() { global $affiliates_db; $IX42200 = false; $IX42763 = array(); if ( is_array( $this->referral_items ) ) { foreach( $this->referral_items as $IX60398 ) { if ( is_int( $IX60398->referral_item_id ) ) { $IX60398->update(); } else { $IX60398->create(); } if ( $IX60398->referral_item_id ) { $IX42763[] = $IX60398->referral_item_id; } } } $IX19679 = $affiliates_db->get_tablename( 'referral_items' ); $IX42763 = array_map( 'intval', $IX42763 ); $IX46213 = "DELETE FROM $IX19679 WHERE referral_id = %d"; if ( count( $IX42763 ) > 0 ) { $IX46213 .= " AND referral_item_id NOT IN (" . implode( ',', $IX42763 ) . ")"; } $affiliates_db->query( $IX46213, intval( $this->referral_id ) ); if ( $this->referral_id !== null ) { $IX79389 = new Affiliates_Referral(); $IX79389->read( $this->referral_id ); $this->compute(); $IX23471 = array(); $IX71908 = array(); if ( $this->affiliate_id !== null ) { $IX23471[] = 'affiliate_id = %d'; $IX71908[] = intval( $this->affiliate_id ); } else { } if ( $this->post_id !== null ) { $IX23471[] = 'post_id = %d'; $IX71908[] = intval( $this->post_id ); } else { } if ( $this->datetime !== null ) { $IX23471[] = 'datetime = %s'; $IX71908[] = $this->datetime; } else { } if ( $this->description !== null ) { $IX23471[] = 'description = %s'; $IX71908[] = $this->description; } else { $IX23471[] = 'description = NULL'; } if ( $this->ip !== null ) { $IX23471[] = 'ip = %d'; $IX71908[] = intval( $this->ip ); } else { $IX23471[] = 'ip = NULL'; } if ( $this->ipv6 !== null ) { $IX23471[] = 'ipv6 = %s'; $IX71908[] = $this->ipv6; } else { $IX23471[] = 'ipv6 = NULL'; } if ( $this->user_id !== null ) { $IX23471[] = 'user_id = %d'; $IX71908[] = intval( $this->user_id ); } else { $IX23471[] = 'user_id = NULL'; } if ( $this->amount !== null ) { $IX23471[] = 'amount = %s'; $IX71908[] = $this->amount; } else { $IX23471[] = 'amount = NULL'; } if ( $this->currency_id !== null ) { $IX23471[] = 'currency_id = %s'; $IX71908[] = $this->currency_id; } else { $IX23471[] = 'currency_id = NULL'; } if ( $this->data !== null ) { $IX23471[] = 'data = %s'; if ( !empty( $this->data ) && is_array( $this->data ) ) { $IX71908[] = serialize( $this->data ); } else if ( !empty( $this->data ) && is_string( $this->data ) ) { $IX71908[] = $this->data; } else { $IX71908[] = ''; } } else { $IX23471[] = 'data = NULL'; } if ( $this->status !== null ) { $IX23471[] = 'status = %s'; $IX71908[] = $this->status; } else { } if ( $this->type !== null ) { $IX23471[] = 'type = %s'; $IX71908[] = $this->type; } else { $IX23471[] = 'type = NULL'; } if ( $this->reference !== null ) { $IX23471[] = 'reference = %s'; $IX71908[] = $this->reference; } else { $IX23471[] = 'reference = NULL'; } if ( $this->reference_amount !== null ) { $IX23471[] = 'reference_amount = %s'; $IX71908[] = $this->reference_amount; } else { $IX23471[] = 'reference_amount = NULL'; } if ( $this->campaign_id !== null ) { $IX23471[] = 'campaign_id = %d'; $IX71908[] = intval( $this->campaign_id ); } else { $IX23471[] = 'campaign_id = NULL'; } if ( $this->hit_id !== null ) { $IX23471[] = 'hit_id = %d'; $IX71908[] = intval( $this->hit_id ); } else { $IX23471[] = 'hit_id = NULL'; } if ( $this->integration !== null ) { $IX23471[] = 'integration = %s'; $IX71908[] = $this->integration; } else { $IX23471[] = 'integration = NULL'; } $IX71908[] = intval( $this->referral_id ); $IX54592 = $affiliates_db->get_tablename( 'referrals' ); $IX46213 = "UPDATE $IX54592 SET " . implode( ',', $IX23471 ) . " WHERE referral_id = %d"; if ( $IX92607 = $affiliates_db->query( $IX46213, $IX71908 ) ) { $IX42200 = true; $IX12048 = array( 'affiliate_id', 'post_id', 'datetime', 'description', 'ip', 'ipv6', 'user_id', 'amount', 'currency_id', 'data', 'status', 'type', 'reference', 'reference_amount', 'campaign_id', 'hit_id', 'integration' ); $IX84368 = array(); $IX62647 = array(); $IX46827 = array(); foreach( $IX12048 as $IX27089 ) { if ( $IX79389->$IX27089 != $this->$IX27089 ) { $IX84368[] = $IX27089; $IX62647[] = $this->$IX27089; $IX46827[] = $IX79389->$IX27089; } } do_action( 'affiliates_updated_referral', $this->referral_id, $IX84368, $IX62647, $IX46827 ); } } return $IX42200; }

	/**
	 * Delete the entry from the database corresponding to the current object.
	 * Also deletes any related referral items in the database.
	 * Requires this object's referral_id to be set.
	 * @return boolean true on success
	 */
	public function delete() { global $affiliates_db; $IX99845 = false; if ( $this->referral_id !== null ) { $IX79599 = $affiliates_db->get_tablename( 'referral_items' ); $affiliates_db->query( "DELETE FROM $IX79599 " . "WHERE referral_id = %d", intval( $this->referral_id ) ); $IX35729 = $affiliates_db->get_tablename( 'referrals' ); if ( $affiliates_db->query( "DELETE FROM $IX35729 " . "WHERE referral_id = %d", intval( $this->referral_id ) ) ) { $IX99845 = true; do_action( 'affiliates_deleted_referral', $this->referral_id ); } } return $IX99845; }

	/**
	 * Sums all the added referral items and updates the referral's amount.
	 * There must be at least one referral item with an amount for this to
	 * modify the referral's amount.
	 */
	public function compute() { if ( !empty( $this->referral_items ) ) { $this->amount = '0'; foreach( $this->referral_items as $IX28622 ) { if ( $IX28622->amount ) { $this->amount = Affiliates_Math::add( $this->amount, $IX28622->amount, affiliates_get_referral_amount_decimals() ); } } } }
}
Affiliates_Referral::init();
