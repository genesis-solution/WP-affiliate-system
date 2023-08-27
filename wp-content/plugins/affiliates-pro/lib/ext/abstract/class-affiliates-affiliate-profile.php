<?php
/**
 * class-affiliates-affiliate-profile.php
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
 * Affiliate profile abstraction.
 */
abstract class Affiliates_Affiliate_Profile implements I_Affiliates_Affiliate_Profile {

	protected static $option_defaults = array(
		'show_name' => true,
		'edit_name' => false,
		'show_email' => true,
		'edit_email' => false,
		'show_attributes' => null,
		'edit_attributes' => null
	);
}
