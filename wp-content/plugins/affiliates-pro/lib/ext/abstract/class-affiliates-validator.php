<?php
/**
 * class-affiliates-validator.php
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
 * Validation functions.
 */
class Affiliates_Validator implements I_Affiliates_Validator {

	public static function validate_amount( $amount ) { $IX79143 = null; $IX59385 = array(); if ( preg_match( "/([0-9,]+)?(\.[0-9]+)?/", $amount, $IX59385 ) ) { if ( is_array( $IX59385 ) ) { if ( isset( $IX59385[1] ) ) { $IX15209 = str_replace(",", "", $IX59385[1] ); } else { $IX15209 = "0"; } if ( isset( $IX59385[2] ) ) { $IX36873 = substr( $IX59385[2], 1, affiliates_get_referral_amount_decimals() ); } else { $IX36873 = "0"; } if ( isset( $IX59385[0] ) && count( $IX59385 ) > 1 && ( isset( $IX59385[1] ) || isset( $IX59385[2] ) ) ) { $IX79143 = $IX15209 . "." . $IX36873; } } } return $IX79143; }

	public static function validate_email( $email ) { $IX83582 = false; $IX16886 = filter_var( $email, FILTER_VALIDATE_EMAIL ); if ( ( $IX16886 !== false ) && ( $IX16886 === $email ) ) { $IX83582 = $IX16886; } return $IX83582; }
}
