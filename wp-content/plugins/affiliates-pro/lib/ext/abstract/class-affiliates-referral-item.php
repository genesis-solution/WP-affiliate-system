<?php
/**
 * class-affiliates-referral-item.php
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
 * @author Karim Rahimpur
 * @package affiliates-pro
 * @since affiliates-pro 3.0.0
 */

/**
 * Implements the referral item object.
 */
class Affiliates_Referral_Item implements I_Affiliates_Referral_Item {

	/**
	 * The referral item's ID.
	 *
	 * @var int $referral_item_id
	 */
	private $referral_item_id = null;

	/**
	 * The related referral's ID.
	 * @var int $referral_id
	 */
	private $referral_id = null;

	/**
	 * The referral item's amount.
	 * @var string
	 */
	private $amount = null;

	/**
	 * The three-letter currency ID.
	 * @var string $currency_id
	 */
	private $currency_id = null;

	/**
	 * The ID of the rate used to calculate the amount of this referral item.
	 * @var int
	 */
	private $rate_id = null;

	/**
	 * The type of this referral item.
	 * @var string
	 */
	private $type = null;

	/**
	 * The line item reference related to this referral item. For example, the ID
	 * of the line item in an order, the form submission ID, the ID of a booking, ...
	 *
	 * @var string
	 */
	private $reference = null;

	/**
	 * The amount of the corresponding line item.
	 *
	 * @var string
	 */
	private $line_amount = null;

	/**
	 * The ID of the object related to this referral item, for example,
	 * the ID of the product, the form, the event, ...
	 *
	 * @var int
	 */
	private $object_id = null;

	/**
	 * Initializes the $referral_item with the values from $o.
	 *
	 * @param Affiliates_Referral_Item $referral_item
	 * @param Affiliates_Referral_Item $o
	 */
	private static function initialize( &$referral_item, $o ) { if ( isset( $o->referral_item_id ) ) { $referral_item->referral_item_id = $o->referral_item_id; } if ( isset( $o->referral_id ) ) { $referral_item->referral_id = $o->referral_id; } if ( isset( $o->amount ) ) { $referral_item->amount = $o->amount; } if ( isset( $o->currency_id ) ) { $referral_item->currency_id = $o->currency_id; } if ( isset( $o->rate_id ) ) { $referral_item->rate_id = $o->rate_id; } if ( isset( $o->type ) ) { $referral_item->type = $o->type; } if ( isset( $o->reference ) ) { $referral_item->reference = $o->reference; } if ( isset( $o->line_amount ) ) { $referral_item->line_amount = $o->line_amount; } if ( isset( $o->object_id ) ) { $referral_item->object_id = $o->object_id; } }

	/**
	 * Create the object with the properties provided in $attributes.
	 * $attributes can hold values for these keys:
	 * - referral_item_id
	 * - referral_id
	 * - rate_id
	 * - amount
	 * - currency_id
	 * - type
	 * - reference
	 * - object_id
	 *
	 * @param array|object $attributes array of key-value pairs or object with appropriate properties
	 */
	public function __construct( $attributes = array() ) { if ( is_object( $attributes ) ) { $attributes = (array) $attributes; } foreach( $attributes as $IX67168 => $IX58366 ) { switch( $IX67168 ) { case 'referral_item_id' : case 'referral_id' : case 'rate_id' : case 'amount' : case 'currency_id' : case 'type' : case 'reference' : case 'line_amount' : case 'object_id' : $this->$IX67168 = $IX58366; break; } } }

	public function __get( $name ) { $IX47476 = null; switch( $name ) { case 'referral_item_id' : case 'referral_id' : case 'rate_id' : case 'amount' : case 'currency_id' : case 'type' : case 'reference' : case 'line_amount' : case 'object_id' : $IX47476 = $this->$name; break; } return $IX47476; }

	public function __set( $name, $value ) { switch( $name ) { case 'referral_item_id' : case 'referral_id' : case 'rate_id' : case 'object_id' : $this->$name = ( $value !== null ? intval( $value ) : null ); break; case 'amount' : $this->amount = Affiliates_Math::add( '0', $value , affiliates_get_referral_amount_decimals() ); break; case 'currency_id' : $this->currency_id = Affiliates_Utility::verify_currency_id( $value ); break; case 'type' : if ( is_string( $value ) ) { $this->type = $value; } break; case 'reference' : if ( is_string( $value ) || is_numeric( $value ) ) { $this->reference = $value; } case 'line_amount' : $this->line_amount = Affiliates_Math::add( '0', $value , affiliates_get_referral_amount_decimals() ); break; } return $value; }

	/**
	 * Create the referral item in the database.
	 *
	 * @return int referral_item_id on success or null on failure
	 */
	public function create() { global $affiliates_db; if ( $this->referral_item_id === null ) { if ( !empty( $this->referral_id ) ) { $IX33086 = array(); $IX97669 = array(); if ( $this->referral_id !== null ) { $IX33086[] = 'referral_id = %d'; $IX97669[] = intval( $this->referral_id ); } else { $IX33086[] = 'referral_id = NULL'; } if ( $this->amount !== null ) { $IX33086[] = 'amount = %s'; $IX97669[] = $this->amount; } else { $IX33086[] = 'amount = NULL'; } if ( $this->currency_id !== null ) { $IX33086[] = 'currency_id = %s'; $IX97669[] = $this->currency_id; } else { $IX33086[] = 'currency_id = NULL'; } if ( $this->rate_id !== null ) { $IX33086[] = 'rate_id = %d'; $IX97669[] = intval( $this->rate_id ); } else { $IX33086[] = 'rate_id = NULL'; } if ( $this->type !== null ) { $IX33086[] = 'type = %s'; $IX97669[] = $this->type; } else { $IX33086[] = 'type = NULL'; } if ( $this->reference !== null ) { $IX33086[] = 'reference = %s'; $IX97669[] = $this->reference; } else { $IX33086[] = 'reference = NULL'; } if ( $this->line_amount !== null ) { $IX33086[] = 'line_amount = %s'; $IX97669[] = $this->line_amount; } else { $IX33086[] = 'line_amount = NULL'; } if ( $this->object_id !== null ) { $IX33086[] = 'object_id = %d'; $IX97669[] = intval( $this->object_id ); } else { $IX33086[] = 'object_id = NULL'; } $IX47508 = $affiliates_db->get_tablename( 'referral_items' ); $IX75791 = "INSERT INTO $IX47508 SET " . implode( ',', $IX33086 ); if ( $affiliates_db->query( $IX75791, $IX97669 ) ) { $this->referral_item_id = $affiliates_db->get_value( "SELECT LAST_INSERT_ID()" ); } } } return $this->referral_item_id; }

	/**
	 * Read a referral item from the database.
	 *
	 * @param int $referral_item_id
	 *
	 * @return Affiliates_Referral_Item on success or null
	 */
	public function read( $referral_item_id ) { global $affiliates_db; $IX79331 = null; $IX57993 = $affiliates_db->get_tablename( 'referral_items' ); if ( $IX16585 = $affiliates_db->get_objects( "SELECT * FROM $IX57993 WHERE referral_item_id = %d", intval( $referral_item_id ) ) ) { if ( $IX92322 = array_shift( $IX16585 ) ) { self::initialize( $this, $IX92322 ); $IX79331 = $this; } } return $IX79331; }

	/**
	 * Update the database entry based on this object's current values.
	 *
	 * @return boolean true on success
	 */
	public function update() { global $affiliates_db; $IX32582 = false; if ( $this->referral_item_id !== null ) { $IX59506 = array(); $IX92384 = array(); if ( $this->referral_id !== null ) { $IX59506[] = 'referral_id = %d'; $IX92384[] = intval( $this->referral_id ); } else { $IX59506[] = 'referral_id = NULL'; } if ( $this->amount !== null ) { $IX59506[] = 'amount = %s'; $IX92384[] = $this->amount; } else { $IX59506[] = 'amount = NULL'; } if ( $this->currency_id !== null ) { $IX59506[] = 'currency_id = %s'; $IX92384[] = $this->currency_id; } else { $IX59506[] = 'currency_id = NULL'; } if ( $this->rate_id !== null ) { $IX59506[] = 'rate_id = %d'; $IX92384[] = intval( $this->rate_id ); } else { $IX59506[] = 'rate_id = NULL'; } if ( $this->type !== null ) { $IX59506[] = 'type = %s'; $IX92384[] = $this->type; } else { $IX59506[] = 'type = NULL'; } if ( $this->reference !== null ) { $IX59506[] = 'reference = %s'; $IX92384[] = $this->reference; } else { $IX59506[] = 'reference = NULL'; } if ( $this->line_amount !== null ) { $IX59506[] = 'line_amount = %s'; $IX92384[] = $this->line_amount; } else { $IX59506[] = 'line_amount = NULL'; } if ( $this->object_id !== null ) { $IX59506[] = 'object_id = %d'; $IX92384[] = intval( $this->object_id ); } else { $IX59506[] = 'object_id = NULL'; } $IX92384[] = intval( $this->referral_item_id ); $IX54640 = $affiliates_db->get_tablename( 'referral_items' ); $IX65184 = "UPDATE $IX54640 SET " . implode( ',', $IX59506 ) . " WHERE referral_item_id = %d"; if ( $affiliates_db->query( $IX65184, $IX92384 ) ) { $IX32582 = true; } } return $IX32582; }

	/**
	 * Delete the entry from the database corresponding to the current object.
	 * Requires this object's referral_item_id to be set.
	 *
	 * @return boolean true on success
	 */
	public function delete() { global $affiliates_db; $IX23369 = false; if ( $this->referral_item_id !== null ) { $IX38429 = $affiliates_db->get_tablename( 'referral_items' ); if ( $affiliates_db->query( "DELETE FROM $IX38429 " . "WHERE referral_item_id = %d", intval( $this->referral_item_id ) ) ) { $IX23369 = true; } } return $IX23369; }

}
