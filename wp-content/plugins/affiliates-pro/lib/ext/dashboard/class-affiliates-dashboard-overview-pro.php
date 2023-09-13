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

    const PER_PAGE_DEFAULT = 20;

    /**
     * @var int maximum number of entries shown per page
     */
    const MAX_PER_PAGE = 1000;

	private $series = array();

    /**
     * Key-value pairs with default values used for filter and view attributes.
     *
     * @var string[int|array|object|null]
     */
    //protected static $defaults = array();

    /**
     * @var int how many entries there are in total (including and beyond those shown on the current page)
     */
    protected $count = 0;

    /**
     * @var int number of entries to show per page
     */
    protected $per_page = self::PER_PAGE_DEFAULT;

    /**
     * @var int the current page index: 0, 1, 2, ...
     */
    protected $current_page = 0;

    /**
     * @var string used as date filter if not null
     */
    protected $from_date = null;

    /**
     * @var string used as date filter if not null
     */
    protected $thru_date = null;

    /**
     * @var string indicates sort order 'ASC' or 'DESC'
     */
    protected $sort_order = 'DESC';

    /**
     * @var string indicates inverted sort order 'ASC' or 'DESC'
     */
    protected $switch_sort_order = 'ASC';

    /**
     * @var string sort entries by ...
     */
    protected $orderby = 'date';

    /**
     * @var array maps column keys to translated column heading titles and descriptions
     */
    protected $columns = array();

    /**
     * @var array holds entries to show for the current results page
     */
    protected $entries = null;

    /**
     * @return int
     */
    public function get_per_page() {
        return $this->per_page;
    }

    /**
     * @return int
     */
    public function get_current_page() {
        return $this->current_page;
    }

    /**
     * @return int
     */
    public function get_pages() {
        $n = 0;
        if ( $this->count > 0 && $this->per_page > 0 ) {
            $n = ceil( $this->count / $this->per_page );
        }
        return $n;
    }

    /**
     * Provides the total number of entries available.
     *
     * @return int
     */
    public function get_count() {
        return $this->count;
    }

    /**
     * Filter by from date.
     *
     * @return string
     */
    public function get_from_date() {
        return $this->from_date;
    }

    /**
     * Filter by thru date.
     *
     * @return string
     */
    public function get_thru_date() {
        return $this->thru_date;
    }

    /**
     * @return int
     */
    public function get_sort_order() {
        return $this->sort_order;
    }

    /**
     * @return string
     */
    public function get_switch_sort_order() {
        return $this->switch_sort_order;
    }

    /**
     * @return string
     */
    public function get_orderby() {
        return $this->orderby;
    }

    /**
     * @return array column keys mapped to translated column heading labels and descriptions
     */
    public function get_columns() {
        return $this->columns;
    }

    /**
     * Provides the entries to display for the current page.
     *
     * @return array of entries
     */
    public function get_entries() {
        $result = array();
        if ( $this->entries !== null && is_array( $this->entries ) ) {
            $result = $this->entries;
        }
        return $result;
    }

    protected static $defaults = array(

        'from_date'          => null,
        'thru_date'          => null,

        'per_page'           => 20,
        'status'             => array( AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED )
    );

	private $totals = array();

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
        $this->url_parameters = array( 'referrals-page', 'per_page', 'from_date', 'thru_date', 'orderby', 'order', 'referral-search', 'search' );
        $params = shortcode_atts( self::$defaults, $params );
        foreach ( $params as $IX15589 => $IX25184 ) {
            switch( $IX15589 ) {
                case 'per_page' : $IX25184 = intval( $IX25184 );
                    if ( $IX25184 < 0 ) { $IX25184 = self::$defaults['per_page'];
                    } break; case 'status' : if ( !is_array( $IX25184 ) ) { if ( is_string( $IX25184 ) ) { $IX25184 = array_map( 'trim', explode( ',', $IX25184 ) ); } else { $IX25184 = self::$defaults['status']; } } $IX87642 = array(); foreach ( $IX25184 as $IX14910 ) { switch ( $IX14910 ) { case AFFILIATES_REFERRAL_STATUS_ACCEPTED : case AFFILIATES_REFERRAL_STATUS_CLOSED : case AFFILIATES_REFERRAL_STATUS_PENDING : case AFFILIATES_REFERRAL_STATUS_REJECTED : $IX87642[] = $IX14910; break; } } $IX25184 = $IX87642; break; } $params[$IX15589] = $IX25184; } $this->per_page = $params['per_page']; $this->status = $params['status']; $this->column_display_names = array(); $IX27411 = DateHelper::getServerDateTimeZone();
        $this->columns['date'] = array( 'title' => __( '日期', 'affiliates' ),
            'description' => sprintf( __( "* 日期是針對服務器時區 : %s 給出的，相對於 GMT 有 %s 小時的偏移。", 'affiliates' ), $IX27411->getName(),
                $IX27411->getOffset( new DateTime() ) / 3600.0 ) );
        $this->columns['amount'] = array( 'title' => __( '數量', 'affiliates' ),
            'description' => __( '推薦金額或佣金總額。', 'affiliates' ) );
        $this->columns['status'] = array( 'title' => __( '地位', 'affiliates' ),
            'description' => __( '推薦的當前狀態。', 'affiliates' ) );
        $this->columns['items'] = array( 'title' => __( '項目', 'affiliates' ),
            'description' => __( '與轉介相關的項目。', 'affiliates' ) );
    }

	public function render() {
        global $wpdb, $affiliates_db, $affiliates_version;
        if ( !affiliates_user_is_affiliate( $this->user_id ) ) { return; }
        wp_enqueue_script( 'excanvas', AFFILIATES_PLUGIN_URL . 'js/graph/flot/excanvas.min.js', array( 'jquery' ), $affiliates_version );
        wp_enqueue_script( 'flot', AFFILIATES_PLUGIN_URL . 'js/graph/flot/jquery.flot.min.js', array( 'jquery' ), $affiliates_version );
        wp_enqueue_script( 'flot-resize', AFFILIATES_PLUGIN_URL . 'js/graph/flot/jquery.flot.resize.min.js', array( 'jquery', 'flot' ), $affiliates_version );
        wp_enqueue_script( 'affiliates-dashboard-overview-graph', AFFILIATES_PLUGIN_URL . 'js/dashboard-overview-graph.js', array( 'jquery', 'flot', 'flot-resize' ), $affiliates_version ); wp_enqueue_script( 'datepicker', AFFILIATES_PLUGIN_URL . 'js/jquery-ui.min.js', array( 'jquery', 'jquery-ui-core' ), $affiliates_version ); wp_enqueue_script( 'datepickers', AFFILIATES_PLUGIN_URL . 'js/datepickers.js', array( 'jquery', 'jquery-ui-core', 'datepicker' ), $affiliates_version ); wp_enqueue_script( 'overview-controls', AFFILIATES_PLUGIN_URL . 'js/dashboard-overview-controls.js', array( 'jquery' ), $affiliates_version ); wp_enqueue_script( 'affiliates', AFFILIATES_PLUGIN_URL . 'js/affiliates.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-button' ), $affiliates_version ); wp_enqueue_style( 'smoothness', AFFILIATES_PLUGIN_URL . 'css/smoothness/jquery-ui.min.css', array(), $affiliates_version );
        wp_localize_script( 'affiliates-dashboard-overview-graph', 'affiliates_dashboard_overview_graph_l12n',
        array( 'hits' => __( '點擊數', 'affiliates' ),
            'visits' => __( '訪問量', 'affiliates' ),
            'referrals' => __( '推薦人', 'affiliates' ) ) );
        $IX43352 = date( 'Y-m-d', time() );
        $IX53758 = date( 'Y-m-d', strtotime( $IX43352 ) - self::LAST_NINETY_DAYS * 3600 * 24 );
        $IX45295 = self::LAST_NINETY_DAYS; $IX93749 = null;
        $this->selected = 'last-ninety-days';
        if ( !empty( $_REQUEST['range'] ) ) {
            $this->selected = trim( $_REQUEST['range'] );
            switch( $this->selected ) {
                case 'last-seven-days' :
                    $IX45295 = self::LAST_SEVEN_DAYS; break;
                case 'last-thirty-days' : $IX45295 = self::LAST_THIRTY_DAYS; break;
                case 'last-ninety-days' : $IX45295 = self::LAST_NINETY_DAYS; break;
                case 'weekly' : $IX45295 = self::LAST_NINETY_DAYS; $IX93749 = 'week'; break;
                case 'monthly' : $IX45295 = self::LAST_TWELVE_MONTHS; $IX93749 = 'month'; break;
                case 'yearly' : $IX45295 = self::LAST_THREE_YEARS; $IX93749 = 'year'; break;
                case 'custom' : $IX34987 = !empty( $_REQUEST['from-date'] ) ? date( 'Y-m-d', strtotime( $_REQUEST['from-date'] ) ) : date( 'Y-m-d', strtotime( $IX53758 ) ); $IX49151 = !empty( $_REQUEST['thru-date'] ) ? date( 'Y-m-d', strtotime( $_REQUEST['thru-date'] ) ) : date( 'Y-m-d', strtotime( $IX43352 ) );
                if ( strtotime( $IX34987 ) > strtotime( $IX49151 ) ) { $IX30906 = $IX34987; $IX34987 = $IX49151; $IX49151 = $IX30906; }
                $this->from_date = $IX34987;
                $this->thru_date = $IX49151;
                $IX45295 = self::LEAD + ( strtotime( $IX49151 ) - strtotime( $IX34987 ) ) / ( 3600 * 24 ) + self::TRAIL;
                if ( $IX45295 <= self::DAILY_THRESHOLD ) { $IX93749 = null; } else if ( $IX45295 <= self::WEEKLY_THRESHOLD ) { $IX93749 = 'week'; } else if ( $IX45295 <= self::MONTHLY_THRESHOLD ) { $IX93749 = 'month'; } else { $IX93749 = 'year'; } break; default : $this->selected = 'last-ninety-days'; $IX45295 = self::LAST_NINETY_DAYS; } } if ( $this->selected !== 'custom' ) { if ( !isset( $IX49151 ) ) { $IX49151 = date( 'Y-m-d', strtotime( $IX43352 ) ); }
            switch ( $IX93749 ) { case 'week' : $IX53758 = strtotime( $IX49151 ) - $IX45295 * 3600 * 24;
                    $IX65457 = date( 'o', $IX53758 );
                    $IX79650 = date( 'W', $IX53758 );
                    $IX74355 = new DateTime();
                    $IX34987 = $IX74355->setISODate( $IX65457, $IX79650 )->format( 'Y-m-d' );
                    $IX49151 = $IX43352;
                    break;
                    case 'month' :
                        $IX34987 = date( 'Y-m-01', strtotime( $IX49151 ) - $IX45295 * 3600 * 24 );
                        $IX49151 = $IX43352;
                        break;
                        case 'year' : $IX34987 = date( 'Y-01-01', strtotime( $IX49151 ) - $IX45295 * 3600 * 24 );
                        $IX49151 = $IX43352; break;
                        default : $IX34987 = date( 'Y-m-d', strtotime( $IX49151 ) - $IX45295 * 3600 * 24 );
                        $IX49151 = $IX43352; } $this->from_date = null; $this->thru_date = null;
        }
        if ( isset( $_REQUEST['clear_filters'] ) ) { $IX49151 = $IX43352; $IX34987 = $IX53758;
            $this->selected = 'last-ninety-days'; $IX45295 = self::LAST_NINETY_DAYS; $this->from_date = null; $this->thru_date = null;
        } $IX25515 = 0; $IX60621 = 0; $IX96919 = 0; $IX97337 = array(); $IX38217 = array();
        $IX52198 = $this->get_affiliate_id();
        $IX35601 = $this->get_hits_query();
        $IX11131 = $wpdb->get_results( $wpdb->prepare( $IX35601, $IX34987, $IX49151, intval( $IX52198 ) ) );
        $IX85789 = array();
        foreach ( $IX11131 as $IX96759 ) {
            if ( $IX93749 !== null ) {
                $IX40950 = self::map_date( $IX96759->date, $IX93749 ); $IX38217[$IX40950] = $IX40950;
                if ( !isset( $IX85789[$IX40950] ) ) { $IX85789[$IX40950] = 0; } $IX85789[$IX40950] += $IX96759->hits; }
            else { $IX85789[$IX96759->date] = $IX96759->hits; } $IX25515 += $IX96759->hits; } $IX35601 = $this->get_visits_query();
        $IX83394 = $wpdb->get_results( $wpdb->prepare( $IX35601, $IX34987, $IX49151, intval( $IX52198 ) ) );
        $IX74697 = array();
        foreach ( $IX83394 as $IX16411 ) { if ( $IX93749 !== null ) {
            $IX40950 = self::map_date( $IX16411->date, $IX93749 ); $IX38217[$IX40950] = $IX40950;
            if ( !isset( $IX74697[$IX40950] ) ) { $IX74697[$IX40950] = 0; }
            $IX74697[$IX40950] += $IX16411->visits; }
        else { $IX74697[$IX16411->date] = $IX16411->visits; } $IX60621 += $IX16411->visits; }
        $IX35601 = $this->get_referrals_query();
        $IX35601 = $wpdb->prepare( $IX35601, AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED, $IX34987, $IX49151, intval( $IX52198 ) ); $IX14755 = $wpdb->get_results( $IX35601 ); $IX82256 = array(); foreach ( $IX14755 as $IX49484 ) { if ( $IX93749 !== null ) { $IX40950 = self::map_date( $IX49484->date, $IX93749 ); $IX38217[$IX40950] = $IX40950; if ( !isset( $IX82256[$IX40950] ) ) { $IX82256[$IX40950] = 0; } $IX82256[$IX40950] += $IX49484->referrals; } else { $IX82256[$IX49484->date] = $IX49484->referrals; } $IX96919 += $IX49484->referrals; } $IX35601 = $this->get_amounts_query(); $IX35601 = $wpdb->prepare( $IX35601, AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED, $IX34987, $IX49151, intval( $IX52198 ) ); $IX14755 = $wpdb->get_results( $IX35601 ); $IX19787 = array(); foreach ( $IX14755 as $IX49484 ) { if ( $IX93749 !== null ) { $IX40950 = self::map_date( $IX49484->date, $IX93749 ); $IX38217[$IX40950] = $IX40950; if ( !isset( $IX19787[$IX49484->currency_id][$IX40950] ) ) { $IX19787[$IX49484->currency_id][$IX40950] = 0; } $IX19787[$IX49484->currency_id][$IX40950] += $IX49484->amount; } else { $IX19787[$IX49484->currency_id][$IX49484->date] = $IX49484->amount; } if ( !isset( $IX97337[$IX49484->currency_id] ) ) { $IX97337[$IX49484->currency_id] = 0; } $IX97337[$IX49484->currency_id] += $IX49484->amount; } $this->totals['hits'] = $IX25515; $this->totals['visits'] = $IX60621; $this->totals['referrals'] = $IX96919;
        $this->totals['amounts_by_currency'] = $IX97337; $IX51214 = array();
        $IX38488 = array();
        $IX22892 = array();
        $IX65898 = array();
        $IX36032 = array();
        $IX51765 = array();
        if ( $IX93749 !== null ) {
            $IX49151 = self::map_date( $IX49151, $IX93749 );
        } if ( $this->selected !== 'custom' ) {
            switch ( $IX93749 ) { case 'week' : $IX45295 = 12; $IX78796 = 12; $IX18659 = 'week'; break;
                case 'month' : $IX45295 = 12; $IX78796 = 12; $IX18659 = 'month'; break;
                case 'year' : $IX45295 = 3; $IX78796 = 3; $IX18659 = 'year'; break;
                default : $IX78796 = $IX45295; $IX18659 = 'day'; } }
        else { switch ( $IX93749 ) {
            case 'week' : $IX45295 = ceil( $IX45295 / 7 ); $IX78796 = $IX45295; $IX18659 = 'week'; break;
            case 'month' : $IX45295 = ceil( $IX45295 / ( 365 / 12 ) ); $IX78796 = $IX45295; $IX18659 = 'month'; break;
            case 'year' : $IX45295 = ceil( $IX45295 / 365 ); $IX78796 = $IX45295; $IX18659 = 'year'; break;
            default : $IX78796 = $IX45295; $IX18659 = 'day'; } }
        for ( $IX51549 = - $IX45295 - self::TRAIL; $IX51549 <= self::LEAD; $IX51549++ ) { $IX33030 = date( 'Y-m-d', strtotime( $IX49151 . '+' . $IX51549 . $IX18659 ) ); $IX36032[$IX51549] = $IX33030; if ( isset( $IX82256[$IX33030] ) ) { $IX51214[] = array( $IX51549, intval( $IX82256[$IX33030] ) ); } else { $IX51214[] = array( $IX51549, 0 ); } if ( isset( $IX85789[$IX33030] ) ) { $IX38488[] = array( $IX51549, intval( $IX85789[$IX33030] ) ); } else { $IX38488[] = array( $IX51549, 0 ); } if ( isset( $IX74697[$IX33030] ) ) { $IX22892[] = array( $IX51549, intval( $IX74697[$IX33030] ) ); } else { $IX22892[] = array( $IX51549, 0 ); } foreach ( $IX19787 as $IX66425 => $IX20904 ) { if ( isset( $IX19787[$IX66425][$IX33030] ) ) { $IX51765[$IX66425][] = array( $IX51549, affiliates_format_referral_amount( floatval( $IX19787[$IX66425][$IX33030] ), 'display' ) ); } else { $IX51765[$IX66425][] = array( $IX51549, affiliates_format_referral_amount( 0.0, 'display' ) ); } } if ( $IX93749 !== null ) { if ( $IX51549 !== - $IX45295 - self::TRAIL && $IX51549 !== self::LEAD ) { if ( $IX93749 == 'week' ) { $IX10895 = intval( date( 'd', strtotime( $IX33030 ) ) ); if ( 1 <= $IX10895 && $IX10895 <= 7 ) { $IX45024 = esc_html( date_i18n( 'd M Y', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } else if ( $IX93749 == 'month' ) { if ( $IX45295 <= self::MONTHS_TICK_THRESHOLD || $IX51549 % 3 === 0 ) { $IX10895 = intval( date( 'm' , strtotime( $IX33030 ) ) ); if ( $IX10895 === 1 ) { $IX45024 = esc_html( date_i18n( 'M Y', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } else { $IX45024 = esc_html( date_i18n( 'M', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } } else { if ( $IX93749 == 'year' ) { $IX10895 = intval( date( 'm', strtotime( $IX33030 ) ) ); if ( $IX10895 === 1 ) { $IX45024 = esc_html( date_i18n( 'Y', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } } } } else { $IX74355 = intval( date( 'd', strtotime( $IX33030 ) ) ); if ( $IX45295 == self::LAST_SEVEN_DAYS ) { if ( $IX51549 !== - $IX45295 - self::TRAIL && $IX51549 !== self::LEAD ) { $IX45024 = esc_html( date_i18n( 'd M', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } else if ( $IX45295 == self::LAST_THIRTY_DAYS ) { if ( $IX51549 !== - $IX45295 - self::TRAIL && $IX51549 !== self::LEAD && $IX74355 < 28 && $IX74355 % 5 === 1 ) { $IX45024 = esc_html( date_i18n( 'd M', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } else { if ( $IX74355 === 1 ) { $IX45024 = esc_html( date_i18n( 'M Y', strtotime( $IX33030 ) ) ); $IX65898[] = array( $IX51549, $IX45024 ); } } } } $IX48518 = array( array( intval( - $IX78796 - self::TRAIL ), self::LEAD ), array( 0, 0 ) ); $this->series = array( 'hits' => $IX38488, 'visits' => $IX22892, 'referrals' => $IX51214, 'span' => $IX48518, 'ticks' => $IX65898, 'dates' => $IX36032, 'amounts_by_currency' => $IX51765 ); $IX84540 = wp_json_encode( $IX51214 ); $IX91913 = wp_json_encode( $IX38488 ); $IX53628 = wp_json_encode( $IX22892 ); $IX31673 = wp_json_encode( $IX48518 ); $IX21943 = wp_json_encode( $IX65898 ); $IX13964 = wp_json_encode( $IX36032 ); $IX16321 = wp_json_encode( $IX51765 ); echo '<script type="text/javascript">'; echo 'document.addEventListener( "DOMContentLoaded", function() {'; echo 'if ( typeof jQuery !== "undefined" ) {'; echo 'if ( typeof affiliates_dashboard_overview_graph !== "undefined" ) {'; printf( 'affiliates_dashboard_overview_graph.render( "%s", "%s", %s, %s, %s, %s, %s, %s, %s );', 'affiliates-dashboard-overview-graph', 'affiliates-dashboard-overview-legend', $IX91913, $IX53628, $IX84540, $IX16321, $IX31673, $IX21943, $IX13964 ); echo '}'; echo '}'; echo '} );'; echo '</script>'; wp_localize_script( 'overview-controls', 'affiliates_overview_controls', array( 'pname' => get_option( 'aff_pname', AFFILIATES_PNAME ), 'site_url' => home_url(), 'affiliate_id' => affiliates_encode_affiliate_id( $this->get_affiliate_id() ) ) );

        wp_enqueue_script( 'datepicker', AFFILIATES_PLUGIN_URL . 'js/jquery-ui.min.js', array( 'jquery', 'jquery-ui-core' ), $affiliates_version );
        wp_enqueue_script( 'datepickers', AFFILIATES_PLUGIN_URL . 'js/datepickers.js', array( 'jquery', 'jquery-ui-core', 'datepicker' ), $affiliates_version );
        wp_enqueue_style( 'smoothness', AFFILIATES_PLUGIN_URL . 'css/smoothness/jquery-ui.min.css', array(), $affiliates_version );
        $IX76446 = !empty( $_REQUEST['per_page'] ) ? min( max( 1, intval( trim( $_REQUEST['per_page'] ) ) ), 1000 ) : null;
        if ( $IX76446 !== null ) { $this->per_page = intval( $IX76446 ); }
        $this->current_page = isset( $_REQUEST['referrals-page'] ) ? max( 0, intval( $_REQUEST['referrals-page'] ) ) : 0;
        $IX29675 = isset( $_REQUEST['from_date'] ) ? trim( $_REQUEST['from_date'] ) : null;
        $IX38970 = isset( $_REQUEST['thru_date'] ) ? trim( $_REQUEST['thru_date'] ) : null;
        $IX92575 = null;
        if ( isset( $_REQUEST['clear_filters'] ) ) { unset( $_REQUEST['from_date'] );
            unset( $_REQUEST['thru_date'] );
            unset( $_REQUEST['search'] );
            unset( $_REQUEST['referral-search'] );
            $IX29675 = null; $IX38970 = null; $IX92575 = null;
        }
        else {
            if ( !empty( $_REQUEST['from_date'] ) ) {
                $IX29675 = date( 'Y-m-d', strtotime( $_REQUEST['from_date'] ) ); }
            else { $IX29675 = null; } if ( !empty( $_REQUEST['thru_date'] ) ) { $IX38970 = date( 'Y-m-d', strtotime( $_REQUEST['thru_date'] ) ); }
            else { $IX38970 = null; } if ( $IX29675 && $IX38970 ) { if ( strtotime( $IX29675 ) > strtotime( $IX38970 ) ) { $IX38970 = null; } }
            if ( !empty( $_REQUEST['search'] ) ) { $IX92575 = trim( $_REQUEST['search'] ); } if ( !empty( $_REQUEST['referral-search'] ) ) {
                $IX92575 = trim( $_REQUEST['referral-search'] ); } if ( $IX92575 !== null ) { $IX92575 = wp_check_invalid_utf8( $IX92575 ); $IX92575 = preg_replace( '/[\r\n\t ]+/', ' ', $IX92575 ); $IX92575 = trim( $IX92575 ); if ( strlen( $IX92575 ) === 0 ) { $IX92575 = null; } } } $this->from_date = $IX29675; $this->thru_date = $IX38970; $this->search = $IX92575; $this->orderby = isset( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : $this->orderby; switch ( $this->orderby ) { case 'referral_id' : case 'reference' : case 'datetime' : case 'post_title' : case 'amount' : case 'currency_id' : case 'status' : break; default : $this->orderby = 'datetime'; } $this->sort_order = isset( $_REQUEST['order'] ) ? $_REQUEST['order'] : $this->sort_order; switch ( $this->sort_order ) { case 'asc' : case 'ASC' : $this->switch_sort_order = 'DESC'; break; case 'desc' : case 'DESC' : $this->switch_sort_order = 'ASC'; break; default: $this->sort_order = 'DESC'; $this->switch_sort_order = 'ASC'; } $IX57878 = null; $IX19171 = null; $this->setup_query_filters( $IX57878, $IX19171 ); $IX86739 = $this->per_page * $this->current_page; $IX91426 = $wpdb->posts; $IX10416 = $affiliates_db->get_tablename( 'affiliates' ); $IX80720 = $affiliates_db->get_tablename( 'referrals' ); $IX64318 = $affiliates_db->get_tablename( 'referral_items' ); $IX62808 = "SELECT SQL_CALC_FOUND_ROWS " . "r.* " . "FROM $IX80720 r " . "LEFT JOIN $IX10416 a ON r.affiliate_id = a.affiliate_id " . "LEFT JOIN $IX91426 p ON r.post_id = p.ID " . "$IX57878"; $IX73558 = "ORDER BY %s %s LIMIT %d OFFSET %d"; $IX59170 = $IX62808 . sprintf( $IX73558, $this->orderby, $this->sort_order, intval( $this->per_page ), intval( $IX86739 ) ); $this->entries = $affiliates_db->get_objects( $IX59170, $IX19171 ); $this->count = intval( $affiliates_db->get_value( "SELECT FOUND_ROWS()" ) ); if ( count( $this->entries ) === 0 && $this->count > 0 ) { $this->current_page = 0; $IX59170 = $IX62808 . sprintf( $IX73558, $this->orderby, $this->sort_order, intval( $this->per_page ), 0 ); $this->entries = $affiliates_db->get_objects( $IX59170, $IX19171 ); $this->count = intval( $affiliates_db->get_value( "SELECT FOUND_ROWS()" ) ); } if ( count( $this->entries ) > 0 ) { foreach ( $this->entries as $IX21075 ) { $IX43826 = $affiliates_db->get_objects( "SELECT * FROM $IX64318 WHERE referral_id = %d", $IX21075->referral_id ); if ( count( $IX43826 ) > 0 ) { foreach ( $IX43826 as $IX89642 ) { if ( isset( $IX89642->object_id ) && $IX89642->object_id !== null && isset( $IX89642->type ) && $IX89642->type !== null ) { $IX22730 = get_posts( array( 'p' => $IX89642->object_id, 'post_type' => $IX89642->type, 'post_status' => 'publish' ) ); if ( count( $IX22730 ) > 0 ) { $IX45861 = array_shift( $IX22730 ); $IX21075->items[] = array( 'referral_item' => $IX89642, 'post' => $IX45861 ); } } } } } }
        parent::render();
    }

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
	public static function get_name() { return __( '查看次数', 'affiliates' ); }

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

	protected static function map_date( $date, $period = 'day', $limit = 'start' ) { $IX28182 = null; switch( $period ) { case 'week' : $IX62090 = new DateTime(); $IX68180 = $IX62090->setISODate( date( 'Y', strtotime( $date ) ), date( 'W', strtotime( $date ) ) )->format( 'Y-m-d' ); $IX28890 = $IX62090->modify( '+6 days' )->format( 'Y-m-d' ); break; case 'month' : $IX62090 = new DateTime(); $IX68180 = $IX62090->setDate( date( 'Y', strtotime( $date ) ), date( 'm', strtotime( $date ) ), 1 )->format( 'Y-m-d' ); $IX28890 = $IX62090->modify( '+1 month' )->modify( '-1 day' )->format( 'Y-m-d' ); break; case 'year' : $IX62090 = new DateTime(); $IX68180 = $IX62090->setDate( date( 'Y', strtotime( $date ) ), 1, 1 )->format( 'Y-m-d' ); $IX28890 = $IX62090->modify( '+1 year' )->modify( '-1 day' )->format( 'Y-m-d' ); break; default : $IX62090 = new DateTime(); $IX68180 = $IX62090->setDate( date( 'Y', strtotime( $date ) ), date( 'm', strtotime( $date ) ), date( 'd', strtotime( $date ) ) )->format( 'Y-m-d' ); $IX28890 = $IX68180; } switch ( $limit ) { case 'end' : $IX28182 = $IX28890; break; default : $IX28182 = $IX68180; } return $IX28182; }

	protected function get_hits_query() { global $affiliates_db; $IX68372 = $affiliates_db->get_tablename( 'hits' ); return "SELECT COUNT(*) as hits, date FROM $IX68372 WHERE date >= %s AND date <= %s AND affiliate_id = %d GROUP BY date ORDER BY date "; }

	protected function get_visits_query() { global $affiliates_db; $IX39624 = $affiliates_db->get_tablename( 'hits' ); return "SELECT count(DISTINCT IP) visits, date FROM $IX39624 WHERE date >= %s AND date <= %s AND affiliate_id = %d GROUP BY date ORDER BY date"; }

	protected function get_referrals_query() { global $affiliates_db; $IX86973 = $affiliates_db->get_tablename( 'referrals' ); return "SELECT count(referral_id) referrals, date(datetime) date FROM $IX86973 WHERE status IN (%s,%s) AND date(datetime) >= %s AND date(datetime) <= %s AND affiliate_id = %d GROUP BY date ORDER BY date"; }

	protected function get_amounts_query() { global $affiliates_db; $IX85507 = $affiliates_db->get_tablename( 'referrals' ); return "SELECT sum(amount) amount, currency_id, date(datetime) date FROM $IX85507 WHERE status IN (%s,%s) AND date(datetime) >= %s AND date(datetime) <= %s AND affiliate_id = %d GROUP BY date, currency_id ORDER BY date"; }

    protected function setup_query_filters( &$filters, &$filter_params ) { global $wpdb, $affiliates_db; $IX92454 = $this->get_affiliate_id(); $filters = " WHERE 1=%d "; $filter_params = array( 1 ); if ( $this->from_date ) { $IX31829 = DateHelper::u2s( $this->from_date ); } if ( $this->thru_date ) { $IX82275 = DateHelper::u2s( $this->thru_date, 24*3600 ); } if ( $this->from_date && $this->thru_date ) { $filters .= " AND r.datetime >= %s AND r.datetime <= %s "; $filter_params[] = $IX31829; $filter_params[] = $IX82275; } else if ( $this->from_date ) { $filters .= " AND r.datetime >= %s "; $filter_params[] = $IX31829; } else if ( $this->thru_date ) { $filters .= " AND r.datetime < %s "; $filter_params[] = $IX82275; } $filters .= " AND r.affiliate_id = %d "; $filter_params[] = $IX92454; $IX57366 = ''; if ( is_array( $this->status ) && count( $this->status ) > 0 ) { $IX57366 = " AND ( r.status IS NULL OR r.status IN ('" . implode( "','", array_map( 'esc_sql', $this->status ) ) . "') ) "; $filters .= $IX57366; } $IX16460 = $wpdb->posts; $IX29658 = $affiliates_db->get_tablename( 'referral_items' ); if ( $this->search !== null ) { $filters .= " AND r.referral_id IN ( SELECT DISTINCT ri.referral_id FROM $IX29658 ri LEFT JOIN $IX16460 p ON p.ID = ri.object_id AND ri.type = p.post_type WHERE p.post_title LIKE %s ) "; $filter_params[] = '%' . $wpdb->esc_like( $this->search ) . '%'; } }
}
Affiliates_Dashboard_Overview_Pro::init();
