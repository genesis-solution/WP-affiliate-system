<?php
/**
 * class-affiliates-dashboard-overview-pro.php
 *
 * Copyright (c) 2010 - 2019 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates
 * @since affiliates 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard section: Overview
 */
class Affiliates_Dashboard_Overview_Pro extends Affiliates_Dashboard_Section {

	const PERIOD = 91;

	const TRAIL = 0;

	const LEAD = 1;

	const LAST_SEVEN_DAYS = 7;

	const LAST_THIRTY_DAYS = 30;

	const LAST_NINETY_DAYS = 91;

	const LAST_TWELVE_MONTHS = 366;

	const LAST_THREE_YEARS = self::LAST_TWELVE_MONTHS * 3;

	const DAILY_THRESHOLD = 31;

	const WEEKLY_THRESHOLD = 184;

	const MONTHLY_THRESHOLD = 365*2+1;

	const MONTHS_TICK_THRESHOLD = 12;

	private $series = array();

	private $totals = array();

	private $thru_date = null;

	private $from_date = null;

	private $selected = 'last-ninety-days';

	public static function init() { }

	public function __construct( $params = array() ) {
        $this->template = 'dashboard/overview-pro.php';
        $this->require_user_id = true;
        if ( isset( $params['from'] ) ) {
            $this->from_date = $params['from'];
        }
        if ( isset( $params['until'] ) ) {
            $this->thru_date = $params['until'];
        }
        parent::__construct( $params );
    }

	public function render() { global $wpdb, $affiliates_version; if ( !affiliates_user_is_affiliate( $this->user_id ) ) { return; } wp_enqueue_script( 'excanvas', AFFILIATES_PLUGIN_URL . 'js/graph/flot/excanvas.min.js', array( 'jquery' ), $affiliates_version ); wp_enqueue_script( 'flot', AFFILIATES_PLUGIN_URL . 'js/graph/flot/jquery.flot.min.js', array( 'jquery' ), $affiliates_version ); wp_enqueue_script( 'flot-resize', AFFILIATES_PLUGIN_URL . 'js/graph/flot/jquery.flot.resize.min.js', array( 'jquery', 'flot' ), $affiliates_version ); wp_enqueue_script( 'affiliates-dashboard-overview-graph', AFFILIATES_PLUGIN_URL . 'js/dashboard-overview-graph.js', array( 'jquery', 'flot', 'flot-resize' ), $affiliates_version ); wp_enqueue_script( 'datepicker', AFFILIATES_PLUGIN_URL . 'js/jquery-ui.min.js', array( 'jquery', 'jquery-ui-core' ), $affiliates_version ); wp_enqueue_script( 'datepickers', AFFILIATES_PLUGIN_URL . 'js/datepickers.js', array( 'jquery', 'jquery-ui-core', 'datepicker' ), $affiliates_version ); wp_enqueue_script( 'overview-controls', AFFILIATES_PLUGIN_URL . 'js/dashboard-overview-controls.js', array( 'jquery' ), $affiliates_version ); wp_enqueue_script( 'affiliates', AFFILIATES_PLUGIN_URL . 'js/affiliates.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-button' ), $affiliates_version ); wp_enqueue_style( 'smoothness', AFFILIATES_PLUGIN_URL . 'css/smoothness/jquery-ui.min.css', array(), $affiliates_version ); wp_localize_script( 'affiliates-dashboard-overview-graph', 'affiliates_dashboard_overview_graph_l12n',
        array( 'hits' => __( '點擊數', 'affiliates' ),
            'visits' => __( '訪問量', 'affiliates' ),
            'referrals' => __( '推薦人', 'affiliates' ) ) );
        $IX43352 = date( 'Y-m-d', time() ); $IX53758 = date( 'Y-m-d', strtotime( $IX43352 ) - self::LAST_NINETY_DAYS * 3600 * 24 ); $IX45295 = self::LAST_NINETY_DAYS; $IX93749 = null; $this->selected = 'last-ninety-days'; if ( !empty( $_REQUEST['range'] ) ) { $this->selected = trim( $_REQUEST['range'] ); switch( $this->selected ) { case 'last-seven-days' : $IX45295 = self::LAST_SEVEN_DAYS; break; case 'last-thirty-days' : $IX45295 = self::LAST_THIRTY_DAYS; break; case 'last-ninety-days' : $IX45295 = self::LAST_NINETY_DAYS; break; case 'weekly' : $IX45295 = self::LAST_NINETY_DAYS; $IX93749 = 'week'; break; case 'monthly' : $IX45295 = self::LAST_TWELVE_MONTHS; $IX93749 = 'month'; break; case 'yearly' : $IX45295 = self::LAST_THREE_YEARS; $IX93749 = 'year'; break; case 'custom' : $IX34987 = !empty( $_REQUEST['from-date'] ) ? date( 'Y-m-d', strtotime( $_REQUEST['from-date'] ) ) : date( 'Y-m-d', strtotime( $IX53758 ) ); $IX49151 = !empty( $_REQUEST['thru-date'] ) ? date( 'Y-m-d', strtotime( $_REQUEST['thru-date'] ) ) : date( 'Y-m-d', strtotime( $IX43352 ) ); if ( strtotime( $IX34987 ) > strtotime( $IX49151 ) ) { $IX30906 = $IX34987; $IX34987 = $IX49151; $IX49151 = $IX30906; } $this->from_date = $IX34987; $this->thru_date = $IX49151; $IX45295 = self::LEAD + ( strtotime( $IX49151 ) - strtotime( $IX34987 ) ) / ( 3600 * 24 ) + self::TRAIL; if ( $IX45295 <= self::DAILY_THRESHOLD ) { $IX93749 = null; } else if ( $IX45295 <= self::WEEKLY_THRESHOLD ) { $IX93749 = 'week'; } else if ( $IX45295 <= self::MONTHLY_THRESHOLD ) { $IX93749 = 'month'; } else { $IX93749 = 'year'; } break; default : $this->selected = 'last-ninety-days'; $IX45295 = self::LAST_NINETY_DAYS; } } if ( $this->selected !== 'custom' ) { if ( !isset( $IX49151 ) ) { $IX49151 = date( 'Y-m-d', strtotime( $IX43352 ) ); } switch ( $IX93749 ) { case 'week' : $IX53758 = strtotime( $IX49151 ) - $IX45295 * 3600 * 24; $IX65457 = date( 'o', $IX53758 ); $IX79650 = date( 'W', $IX53758 ); $IX74355 = new DateTime(); $IX34987 = $IX74355->setISODate( $IX65457, $IX79650 )->format( 'Y-m-d' ); $IX49151 = $IX43352; break; case 'month' : $IX34987 = date( 'Y-m-01', strtotime( $IX49151 ) - $IX45295 * 3600 * 24 ); $IX49151 = $IX43352; break; case 'year' : $IX34987 = date( 'Y-01-01', strtotime( $IX49151 ) - $IX45295 * 3600 * 24 ); $IX49151 = $IX43352; break; default : $IX34987 = date( 'Y-m-d', strtotime( $IX49151 ) - $IX45295 * 3600 * 24 ); $IX49151 = $IX43352; } $this->from_date = null; $this->thru_date = null; } if ( isset( $_REQUEST['clear_filters'] ) ) { $IX49151 = $IX43352; $IX34987 = $IX53758; $this->selected = 'last-ninety-days'; $IX45295 = self::LAST_NINETY_DAYS; $this->from_date = null; $this->thru_date = null; } $IX25515 = 0; $IX60621 = 0; $IX96919 = 0; $IX97337 = array(); $IX38217 = array(); $IX52198 = $this->get_affiliate_id(); $IX35601 = $this->get_hits_query(); $IX11131 = $wpdb->get_results( $wpdb->prepare( $IX35601, $IX34987, $IX49151, intval( $IX52198 ) ) ); $IX85789 = array(); foreach ( $IX11131 as $IX96759 ) { if ( $IX93749 !== null ) { $IX40950 = self::map_date( $IX96759->date, $IX93749 ); $IX38217[$IX40950] = $IX40950; if ( !isset( $IX85789[$IX40950] ) ) { $IX85789[$IX40950] = 0; } $IX85789[$IX40950] += $IX96759->hits; } else { $IX85789[$IX96759->date] = $IX96759->hits; } $IX25515 += $IX96759->hits; } $IX35601 = $this->get_visits_query(); $IX83394 = $wpdb->get_results( $wpdb->prepare( $IX35601, $IX34987, $IX49151, intval( $IX52198 ) ) ); $IX74697 = array(); foreach ( $IX83394 as $IX16411 ) { if ( $IX93749 !== null ) { $IX40950 = self::map_date( $IX16411->date, $IX93749 ); $IX38217[$IX40950] = $IX40950; if ( !isset( $IX74697[$IX40950] ) ) { $IX74697[$IX40950] = 0; } $IX74697[$IX40950] += $IX16411->visits; } else { $IX74697[$IX16411->date] = $IX16411->visits; } $IX60621 += $IX16411->visits; } $IX35601 = $this->get_referrals_query(); $IX35601 = $wpdb->prepare( $IX35601, AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED, $IX34987, $IX49151, intval( $IX52198 ) ); $IX14755 = $wpdb->get_results( $IX35601 ); $IX82256 = array(); foreach ( $IX14755 as $IX49484 ) { if ( $IX93749 !== null ) { $IX40950 = self::map_date( $IX49484->date, $IX93749 ); $IX38217[$IX40950] = $IX40950; if ( !isset( $IX82256[$IX40950] ) ) { $IX82256[$IX40950] = 0; } $IX82256[$IX40950] += $IX49484->referrals; } else { $IX82256[$IX49484->date] = $IX49484->referrals; } $IX96919 += $IX49484->referrals; } $IX35601 = $this->get_amounts_query(); $IX35601 = $wpdb->prepare( $IX35601, AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED, $IX34987, $IX49151, intval( $IX52198 ) ); $IX14755 = $wpdb->get_results( $IX35601 ); $IX19787 = array(); foreach ( $IX14755 as $IX49484 ) { if ( $IX93749 !== null ) { $IX40950 = self::map_date( $IX49484->date, $IX93749 ); $IX38217[$IX40950] = $IX40950; if ( !isset( $IX19787[$IX49484->currency_id][$IX40950] ) ) { $IX19787[$IX49484->currency_id][$IX40950] = 0; } $IX19787[$IX49484->currency_id][$IX40950] += $IX49484->amount; } else { $IX19787[$IX49484->currency_id][$IX49484->date] = $IX49484->amount; } if ( !isset( $IX97337[$IX49484->currency_id] ) ) { $IX97337[$IX49484->currency_id] = 0; } $IX97337[$IX49484->currency_id] += $IX49484->amount; } $this->totals['hits'] = $IX25515; $this->totals['visits'] = $IX60621; $this->totals['referrals'] = $IX96919; $this->totals['amounts_by_currency'] = $IX97337; $IX51214 = array(); $IX38488 = array(); $IX22892 = array(); $IX65898 = array(); $IX36032 = array(); $IX51765 = array(); if ( $IX93749 !== null ) { $IX49151 = self::map_date( $IX49151, $IX93749 ); } if ( $this->selected !== 'custom' ) { switch ( $IX93749 ) { case 'week' : $IX45295 = 12; $IX78796 = 12; $IX18659 = 'week'; break; case 'month' : $IX45295 = 12; $IX78796 = 12; $IX18659 = 'month'; break; case 'year' : $IX45295 = 3; $IX78796 = 3; $IX18659 = 'year'; break; default : $IX78796 = $IX45295; $IX18659 = 'day'; } } else { switch ( $IX93749 ) { case 'week' : $IX45295 = ceil( $IX45295 / 7 ); $IX78796 = $IX45295; $IX18659 = 'week'; break; case 'month' : $IX45295 = ceil( $IX45295 / ( 365 / 12 ) ); $IX78796 = $IX45295; $IX18659 = 'month'; break; case 'year' : $IX45295 = ceil( $IX45295 / 365 ); $IX78796 = $IX45295; $IX18659 = 'year'; break; default : $IX78796 = $IX45295; $IX18659 = 'day'; } } for ( $IX51549 = - $IX45295 - self::TRAIL; $IX51549 <= self::LEAD; $IX51549++ ) { $IX33030 = date( 'Y-m-d', strtotime( $IX49151 . '+' . $IX51549 . $IX18659 ) ); $IX36032[$IX51549] = $IX33030; if ( isset( $IX82256[$IX33030] ) ) { $IX51214[] = array( $IX51549, intval( $IX82256[$IX33030] ) ); } else { $IX51214[] = array( $IX51549, 0 ); } if ( isset( $IX85789[$IX33030] ) ) { $IX38488[] = array( $IX51549, intval( $IX85789[$IX33030] ) ); } else { $IX38488[] = array( $IX51549, 0 ); } if ( isset( $IX74697[$IX33030] ) ) { $IX22892[] = array( $IX51549, intval( $IX74697[$IX33030] ) ); } else { $IX22892[] = array( $IX51549, 0 ); } foreach ( $IX19787 as $IX66425 => $IX20904 ) { if ( isset( $IX19787[$IX66425][$IX33030] ) ) { $IX51765[$IX66425][] = array( $IX51549, affiliates_format_referral_amount( floatval( $IX19787[$IX66425][$IX33030] ), 'display' ) ); } else { $IX51765[$IX66425][] = array( $IX51549, affiliates_format_referral_amount( 0.0, 'display' ) ); } } if ( $IX93749 !== null ) { if ( $IX51549 !== - $IX45295 - self::TRAIL && $IX51549 !== self::LEAD ) { if ( $IX93749 == 'week' ) { $IX10895 = intval( date( 'd', strtotime( $IX33030 ) ) ); if ( 1 <= $IX10895 && $IX10895 <= 7 ) { $IX45024 = esc_html( date_i18n( 'd M Y', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } else if ( $IX93749 == 'month' ) { if ( $IX45295 <= self::MONTHS_TICK_THRESHOLD || $IX51549 % 3 === 0 ) { $IX10895 = intval( date( 'm' , strtotime( $IX33030 ) ) ); if ( $IX10895 === 1 ) { $IX45024 = esc_html( date_i18n( 'M Y', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } else { $IX45024 = esc_html( date_i18n( 'M', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } } else { if ( $IX93749 == 'year' ) { $IX10895 = intval( date( 'm', strtotime( $IX33030 ) ) ); if ( $IX10895 === 1 ) { $IX45024 = esc_html( date_i18n( 'Y', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } } } } else { $IX74355 = intval( date( 'd', strtotime( $IX33030 ) ) ); if ( $IX45295 == self::LAST_SEVEN_DAYS ) { if ( $IX51549 !== - $IX45295 - self::TRAIL && $IX51549 !== self::LEAD ) { $IX45024 = esc_html( date_i18n( 'd M', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } else if ( $IX45295 == self::LAST_THIRTY_DAYS ) { if ( $IX51549 !== - $IX45295 - self::TRAIL && $IX51549 !== self::LEAD && $IX74355 < 28 && $IX74355 % 5 === 1 ) { $IX45024 = esc_html( date_i18n( 'd M', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } else { if ( $IX74355 === 1 ) { $IX45024 = esc_html( date_i18n( 'M Y', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } } } $IX48518 = array( array( intval( - $IX78796 - self::TRAIL ), self::LEAD ), array( 0, 0 ) ); $this->series = array( 'hits' => $IX38488, 'visits' => $IX22892, 'referrals' => $IX51214, 'span' => $IX48518, 'ticks' => $IX65898, 'dates' => $IX36032, 'amounts_by_currency' => $IX51765 ); $IX84540 = wp_json_encode( $IX51214 ); $IX91913 = wp_json_encode( $IX38488 ); $IX53628 = wp_json_encode( $IX22892 ); $IX31673 = wp_json_encode( $IX48518 ); $IX21943 = wp_json_encode( $IX65898 ); $IX13964 = wp_json_encode( $IX36032 ); $IX16321 = wp_json_encode( $IX51765 ); echo '<script type="text/javascript">'; echo 'document.addEventListener( "DOMContentLoaded", function() {'; echo 'if ( typeof jQuery !== "undefined" ) {'; echo 'if ( typeof affiliates_dashboard_overview_graph !== "undefined" ) {'; printf( 'affiliates_dashboard_overview_graph.render( "%s", "%s", %s, %s, %s, %s, %s, %s, %s );', 'affiliates-dashboard-overview-graph', 'affiliates-dashboard-overview-legend', $IX91913, $IX53628, $IX84540, $IX16321, $IX31673, $IX21943, $IX13964 ); echo '}'; echo '}'; echo '} );'; echo '</script>'; wp_localize_script( 'overview-controls', 'affiliates_overview_controls', array( 'pname' => get_option( 'aff_pname', AFFILIATES_PNAME ), 'site_url' => home_url(), 'affiliate_id' => affiliates_encode_affiliate_id( $this->get_affiliate_id() ) ) ); parent::render(); }

	/**
	 * Provides the per-currency totals
	 *
	 * @return array
	 */
	public function get_totals() { return $this->totals; }

	/**
	 * Get section name
	 *
	 * @return string
	 */
	public static function get_name() { return __( '概述', 'affiliates' ); }

	/**
	 * Get key
	 *
	 * @return string
	 */
	public static function get_key() { return 'overview'; }

	/**
	 * Get selected filter
	 *
	 * @return string
	 */
	public function get_selected() { return $this->selected; }

	/**
	 * Get From date
	 *
	 * @return string
	 */
	public function get_from_date() { return $this->from_date; }

	/**
	 * Get Through date
	 *
	 * @return string
	 */
	public function get_thru_date() { return $this->thru_date; }

	protected static function map_date( $date, $period = 'day', $limit = 'start' ) { $IX28182 = null; switch( $period ) { case 'week' : $IX62090 = new DateTime(); $IX68180 = $IX62090->setISODate( date( 'Y', strtotime( $date ) ), date( 'W', strtotime( $date ) ) )->format( 'Y-m-d' ); $IX28890 = $IX62090->modify( '+6 days' )->format( 'Y-m-d' ); break; case 'month' : $IX62090 = new DateTime(); $IX68180 = $IX62090->setDate( date( 'Y', strtotime( $date ) ), date( 'm', strtotime( $date ) ), 1 )->format( 'Y-m-d' ); $IX28890 = $IX62090->modify( '+1 month' )->modify( '-1 day' )->format( 'Y-m-d' ); break; case 'year' : $IX62090 = new DateTime(); $IX68180 = $IX62090->setDate( date( 'Y', strtotime( $date ) ), 1, 1 )->format( 'Y-m-d' ); $IX28890 = $IX62090->modify( '+1 year' )->modify( '-1 day' )->format( 'Y-m-d' ); break; default : $IX62090 = new DateTime(); $IX68180 = $IX62090->setDate( date( 'Y', strtotime( $date ) ), date( 'm', strtotime( $date ) ), date( 'd', strtotime( $date ) ) )->format( 'Y-m-d' ); $IX28890 = $IX68180; } switch ( $limit ) { case 'end' : $IX28182 = $IX28890; break; default : $IX28182 = $IX68180; } return $IX28182; }

	protected function get_hits_query() { global $affiliates_db; $IX68372 = $affiliates_db->get_tablename( 'hits' ); return "SELECT COUNT(*) as hits, date FROM $IX68372 WHERE date >= %s AND date <= %s AND affiliate_id = %d GROUP BY date ORDER BY date "; }

	protected function get_visits_query() { global $affiliates_db; $IX39624 = $affiliates_db->get_tablename( 'hits' ); return "SELECT count(DISTINCT IP) visits, date FROM $IX39624 WHERE date >= %s AND date <= %s AND affiliate_id = %d GROUP BY date ORDER BY date"; }

	protected function get_referrals_query() { global $affiliates_db; $IX86973 = $affiliates_db->get_tablename( 'referrals' ); return "SELECT count(referral_id) referrals, date(datetime) date FROM $IX86973 WHERE status IN (%s,%s) AND date(datetime) >= %s AND date(datetime) <= %s AND affiliate_id = %d GROUP BY date ORDER BY date"; }

	protected function get_amounts_query() { global $affiliates_db; $IX85507 = $affiliates_db->get_tablename( 'referrals' ); return "SELECT sum(amount) amount, currency_id, date(datetime) date FROM $IX85507 WHERE status IN (%s,%s) AND date(datetime) >= %s AND date(datetime) <= %s AND affiliate_id = %d GROUP BY date, currency_id ORDER BY date"; }

}
Affiliates_Dashboard_Overview_Pro::init();
