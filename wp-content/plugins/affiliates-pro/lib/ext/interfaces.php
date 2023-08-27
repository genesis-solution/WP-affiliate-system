<?php
/**
 * interfaces.php
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
 * Database interface for an implementation-independent system basis.
 */
interface I_Affiliates_Database {

	public function create_tables( $charset = null, $collation = null );

	public function drop_tables();

	public function start_transaction();

	public function commit();

	public function rollback();

	public function get_tablename( $name );

	public function get_value( $query );

	public function get_objects( $query );

	public function query( $query );

	public function esc_like( $s );
}

/**
 * Basis for the affiliate entity.
 */
interface I_Affiliates_Affiliate {

	/**
	 * Return the affiliate by unencoded affiliate id.
	 * @param int $affiliate_id
	 */
	public static function get_affiliate( $affiliate_id );

	/**
	 * Returns the unencoded affiliate id of the user.
	 * @param int|object $user (optional) specify a user or use current if none given
	 * @return int affiliate id or false if not an affiliate
	 */
	public static function get_user_affiliate_id( $user_id = null );

}

interface I_Affiliates_Affiliates {

}

interface I_Affiliates_Affiliate_Profile {

}

interface I_Affiliates_Attributes {

}

interface I_Affiliates_Referral_Legacy {

	public function add_referrals( $affiliate_ids, $post_id, $description = '', $data = null, $base_amount = null, $amount = null, $currency_id = null, $status = null, $type = null, $reference = null, $test = false );

	public function suggest( $post_id, $description = '', $data = null, $amount = null, $currency_id = null, $status = null );

	public function suggest_by_attribute( $attribute_key, $attribute_value, $post_id, $description = '', $data = null, $base_amount = null, $amount = null, $currency_id = null, $status = null, $type = null, $test = false );

	public function update();
}

interface I_Affiliates_Referral_Item {

}

interface I_Affiliates_Renderer {

	const RENDER_CODE = 'code';
	const RENDER_HTML = 'html';

	const TYPE_APPEND    = 'append';
	const TYPE_AUTO      = 'auto';
	const TYPE_PARAMETER = 'parameter';
	const TYPE_PRETTY    = 'pretty';

}

interface I_Affiliates_Link_Renderer extends I_Affiliates_Renderer {

	/**
	 * Renders an affiliate link.
	 *
	 * @param array $options rendering options
	 */
	static function render_affiliate_link( $options = array(), $content = null );

}

interface I_Affiliates_Stats_Renderer extends I_Affiliates_Renderer {

	const AFFILIATES_STATS_PER_PAGE = 10;

	const RATIO_DECIMALS = 3;

	const STATS_SUMMARY   = 'stats-summary';
	const STATS_REFERRALS = 'stats-referrals';

	/**
	 * Renders affiliate stats.
	 *
	 * @param array $options rendering options
	 */
	static function render_affiliate_stats( $options = array() );

}

interface I_Affiliates_Traffic_Renderer extends I_Affiliates_Renderer {

	const AFFILIATES_TRAFFIC_PER_PAGE = 10;

	const RATIO_DECIMALS = 3;

	const TRAFFIC_SUMMARY   = 'traffic-summary';
	const TRAFFIC_REFERRALS = 'traffic-referrals';

	/**
	 * Renders affiliate traffic.
	 *
	 * @param array $options rendering options
	 */
	static function render_affiliate_traffic( $options = array() );

}

interface I_Affiliates_Graph_Renderer extends I_Affiliates_Renderer {
	/**
	 * Renders combined affiliate graph.
	 *
	 * @param array $options rendering options
	 */
	static function render_graph( $options = array() );

	static function render_hits( $options = array() );

	static function render_visits( $options = array() );

	static function render_referrals( $options = array() );

	static function render_totals( $options = array() );
}

interface I_Affiliates_Totals {
}

interface I_Affiliates_Url_Renderer extends I_Affiliates_Renderer {

	/**
	 * Renders an affiliate URL.
	 *
	 * @param array $options rendering options
	 */
	static function render_affiliate_url( $options = array() );
}

interface I_Affiliates_Affiliate_Stats_Renderer {
	const AFFILIATES_STATS_PER_PAGE = 10;
}

interface I_Affiliates_Validator {
	static function validate_amount( $amount );
	static function validate_email( $email );
}
