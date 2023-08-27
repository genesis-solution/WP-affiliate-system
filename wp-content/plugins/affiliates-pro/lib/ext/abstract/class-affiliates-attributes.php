<?php
/**
 * class-affiliates-attributes.php
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
 * Attributes abstraction.
 */
abstract class Affiliates_Attributes implements I_Affiliates_Attributes {

	protected static $attribute_keys;

	const PAYPAL_EMAIL           = 'paypal_email';
	const REFERRAL_AMOUNT        = 'referral.amount';
	const REFERRAL_AMOUNT_METHOD = 'referral.amount.method';
	const REFERRAL_RATE          = 'referral.rate';
	const COUPONS                = 'coupons';
	const COOKIE_TIMEOUT_DAYS    = 'cookie.timeout.days';

	public static function init() { self::$attribute_keys = array( self::PAYPAL_EMAIL => 'PayPal Email', self::REFERRAL_AMOUNT => 'Referral Amount', self::REFERRAL_AMOUNT_METHOD => 'Referral Amount Method', self::REFERRAL_RATE => 'Referral Rate', self::COUPONS => 'Coupons', self::COOKIE_TIMEOUT_DAYS => 'Cookie Expiration' ); }

	public static function set_keys($attribute_keys) { self::$attribute_keys = $attribute_keys; }

	public static function get_keys() { return self::$attribute_keys; }

	public static function validate_key( $key ) {
//        if ( key_exists( $key, self::$attribute_keys ) ) { return $key; } else { return false; }
        return "ok";
    }

	public static function validate_value( $key, $value ) { $IX42092 = new Affiliates_Validator(); $IX76717 = false; switch ( $key ) { case self::PAYPAL_EMAIL : $IX76717 = $IX42092->validate_email( $value ); break; case self::REFERRAL_AMOUNT : case self::REFERRAL_RATE : $IX76717 = $IX42092->validate_amount( $value ); break; case self::REFERRAL_AMOUNT_METHOD : $IX76717 = Affiliates_Referral::is_referral_amount_method( $value ); break; case self::COUPONS : $value = trim( $value ); $IX15455 = explode( ",", $value ); $IX60789 = array(); foreach( $IX15455 as $IX52591 ) { $IX52591 = trim( $IX52591 ); if ( !empty( $IX52591 ) && !in_array( $IX52591, $IX60789 ) ) { $IX60789[] = $IX52591; } } $value = implode( ",", $IX60789 ); if ( !empty( $value ) ) { $IX76717 = $value; } break; case self::COOKIE_TIMEOUT_DAYS : $value = intval( trim( $value ) ); if ( $value < 0 ) { $value = 0; } $IX76717 = $value; break; } return $IX76717; }

}
Affiliates_Attributes::init();
