<?php
/**
 * class-affiliates-affiliate.php
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
 * Affiliate abstraction.
 */
abstract class Affiliates_Affiliate implements I_Affiliates_Affiliate {

	/**
	 * Returns affiliate object or null if affiliate not exists.
	 *
	 * @param int $affiliate_id
	 */
	public static function get_affiliate( $affiliate_id ) { global $affiliates_db; $IX76851 = $affiliates_db->get_tablename( 'affiliates' ); $IX83256 = $affiliates_db->get_objects( "SELECT * FROM $IX76851 WHERE affiliate_id = %d", $affiliate_id ); if ( !empty( $IX83256 ) ) { return $IX83256[0]; } else { return null; } }

	/**
	 * Returns the user id for the affiliate.
	 *
	 * @param int $affiliate_id unencoded affiliate id
	 *
	 * @return int user id or false
	 */
	public static function get_affiliate_user_id( $affiliate_id ) { global $affiliates_db; $IX30663 = $affiliates_db->get_tablename( 'affiliates' ); $IX59252 = $affiliates_db->get_tablename( 'affiliates_users' ); return $affiliates_db->get_value( "SELECT $IX59252.user_id FROM $IX59252 LEFT JOIN $IX30663 ON $IX59252.affiliate_id = $IX30663.affiliate_id WHERE $IX59252.affiliate_id = %d AND $IX30663.status ='active'", intval( $affiliate_id ) ); }

	/**
	 * Returns the unencoded affiliate id of the user.
	 *
	 * @param int|object $user (optional) specify a user, if none given false is returned
	 *
	 * @return int affiliate id or false if not an affiliate
	 */
	public static function get_user_affiliate_id( $user_id = null ) { global $affiliates_db; $IX80737 = false; if ( $user_id !== null ) { $IX33742 = $affiliates_db->get_tablename( 'affiliates' ); $IX80967 = $affiliates_db->get_tablename( 'affiliates_users' ); if ( $IX41633 = $affiliates_db->get_value( "SELECT $IX80967.affiliate_id FROM $IX80967 LEFT JOIN $IX33742 ON $IX80967.affiliate_id = $IX33742.affiliate_id WHERE $IX80967.user_id = %d AND $IX33742.status ='active'", intval( $user_id ) ) ) { $IX80737 = $IX41633; } } return $IX80737; }

	/**
	 * Retrieves the value of an affiliate attribute.
	 *
	 * @param int $affiliate_id
	 * @param string $key attribute key
	 *
	 * @return mixed|null
	 */
	public static function get_attribute( $affiliate_id, $key ) { global $affiliates_db; $IX78353 = null; if ( $key = Affiliates_Attributes::validate_key( $key ) ) { $IX13476 = $affiliates_db->get_tablename( "affiliates_attributes" ); $IX78353 = $affiliates_db->get_value( "SELECT attr_value FROM $IX13476 WHERE affiliate_id = %d AND attr_key = %s", intval( $affiliate_id ), $key ); } global $affiliates_attribute_filter; if ( !empty( $affiliates_attribute_filter ) && is_array( $affiliates_attribute_filter ) ) { foreach( $affiliates_attribute_filter as $IX49049 ) { $IX78353 = call_user_func( $IX49049, $IX78353, $affiliate_id, $key ); } } return $IX78353; }

	/**
	 * Can modify the value returned when get_attribute is called.
	 *
	 * @param callable $filter
	 *
	 * @return mixed
	 */
	public static function register_attribute_filter( $filter ) { global $affiliates_attribute_filter; if ( empty( $affiliates_attribute_filter ) ) { $affiliates_attribute_filter = array(); } $affiliates_attribute_filter[] = $filter; }
}
