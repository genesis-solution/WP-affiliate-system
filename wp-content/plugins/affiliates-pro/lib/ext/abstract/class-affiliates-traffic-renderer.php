<?php
/**
 * class-affiliates-traffic-renderer.php
 *
 * Copyright 2011-2017 "kento" Karim Rahimpur - www.itthinx.com
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
 * @since affiliates-pro 2.17.0
 */

/**
 * Abstract class traffic rendering.
 * Defines default values used.
 */
abstract class Affiliates_Traffic_Renderer implements I_Affiliates_Traffic_Renderer {

	/**
	 * Default values for rendering options.
	 * Used for the [affiliates_traffic] shortcode.
	 * @var array of string-value pairs
	 */
	protected static $traffic_defaults = array(
		'affiliate_id'       => null,
		'show_dates'         => true,
		'show_visits'        => true,
		'show_hits'          => true,
		'show_referrals'     => true,
		'show_src_uris'      => true,
		'show_dest_uris'     => true,
		'show_filters'       => true,
		'show_pagination'    => true,
		'src_uri_maxlength'  => 33,
		'dest_uri_maxlength' => 33,
		'per_page'           => 50,
		'status'             => array( AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED )
	);
}
