<?php
/**
 * class-affiliates-stats-renderer.php
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
 * Statistics renderer basis providing defaults.
 */
abstract class Affiliates_Stats_Renderer implements I_Affiliates_Stats_Renderer {
	protected static $stats_defaults = array(
		'show_referral_id'     => false,
		'show_reference'       => false,
		'data'                 => null,
		'show_accepted'        => true,
		'show_amount'          => true,
		'show_closed'          => true,
		'show_currency_id'     => true,
		'show_pending'         => false,
		'show_post'            => true,
		'show_rejected'        => false,
		'show_status'          => true,
		'show_totals'          => true,
		'show_totals_accepted' => true,
		'show_totals_closed'   => true,
		'show_totals_pending'  => false,
		'show_totals_rejected' => false,
		'type'                 => self::STATS_SUMMARY
	);
}
