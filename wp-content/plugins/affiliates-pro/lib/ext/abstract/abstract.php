<?php
/**
 * abstract.php
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

include_once dirname( __FILE__ ) . '/class-affiliates-database.php';
include_once dirname( __FILE__ ) . '/class-affiliates-validator.php';
include_once dirname( __FILE__ ) . '/class-affiliates-affiliate.php';
include_once dirname( __FILE__ ) . '/class-affiliates-affiliate-profile.php';
include_once dirname( __FILE__ ) . '/class-affiliates-attributes.php';
include_once dirname( __FILE__ ) . '/class-affiliates-referral.php';
include_once dirname( __FILE__ ) . '/class-affiliates-referral-item.php';
include_once dirname( __FILE__ ) . '/class-affiliates-referral-controller.php';
include_once dirname( __FILE__ ) . '/class-affiliates-affiliates.php';
include_once dirname( __FILE__ ) . '/class-affiliates-totals.php';

include_once( dirname( __FILE__ ) . '/class-affiliates-graph-renderer.php' );
include_once( dirname( __FILE__ ) . '/class-affiliates-link-renderer.php' );
include_once( dirname( __FILE__ ) . '/class-affiliates-stats-renderer.php' );
include_once( dirname( __FILE__ ) . '/class-affiliates-traffic-renderer.php' );
include_once( dirname( __FILE__ ) . '/class-affiliates-url-renderer.php' );
include_once( dirname( __FILE__ ) . '/class-affiliates-affiliate-stats-renderer.php' );
