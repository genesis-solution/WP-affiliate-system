<?php
/**
 * class-affiliates-dashboard-traffic.php
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
 * @package affiliates-pro
 * @since affiliates-pro 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard section: Referrals
 */
class Affiliates_Dashboard_Traffic extends Affiliates_Dashboard_Section_Table {

	const MAXLENGTH_DEFAULT = 120;

	protected static $section_order = 400;

	private $src_uri = null;

	private $dest_uri = null;

	private $min_referrals = null;

	private $show_dates = true;

	private $show_hits = true;

	private $show_referrals = true;

	private $show_visits = true;

	private $show_src_uris = true;

	private $show_dest_uris = true;

	private $show_filters = true;

	private $show_pagination = true;

	private $get_src_uri_maxlength = self::MAXLENGTH_DEFAULT;

	private $get_dest_uri_maxlength = self::MAXLENGTH_DEFAULT;

	protected static $defaults = array(

		'from_date'          => null,
		'thru_date'          => null,
		'src_uri'            => null,
		'dest_uri'           => null,
		'min_referrals'      => null,

		'show_dates'         => true,
		'show_visits'        => true,
		'show_hits'          => true,
		'show_referrals'     => true,
		'show_src_uris'      => true,
		'show_dest_uris'     => true,
		'show_filters'       => true,
		'show_pagination'    => true,
		'src_uri_maxlength'  => self::MAXLENGTH_DEFAULT,
		'dest_uri_maxlength' => self::MAXLENGTH_DEFAULT,
		'per_page'           => self::PER_PAGE_DEFAULT,
		'status'             => array( AFFILIATES_REFERRAL_STATUS_ACCEPTED, AFFILIATES_REFERRAL_STATUS_CLOSED )
	);

	/**
	 * {@inheritDoc}
	 */
	public static function get_section_order() { return self::$section_order; }

	/**
	 * {@inheritDoc}
	 */
	public static function get_name() { return __( '交通', 'affiliates' ); }

	/**
	 * {@inheritDoc}
	 */
	public static function get_key() { return 'traffic'; }

	/**
	 * Filter by source URI.
	 *
	 * @return string
	 */
	public function get_src_uri() { return $this->src_uri; }

	/**
	 * Filter by destination URI.
	 *
	 * @return string
	 */
	public function get_dest_uri() { return $this->dest_uri; }

	/**
	 * Filter by minimum referrals.
	 *
	 * @return int
	 */
	public function get_min_referrals() { return $this->min_referrals; }

	public function get_url( $params = array() ) { $IX10555 = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; $IX10555 = remove_query_arg( 'clear_filters', $IX10555 ); $IX10555 = remove_query_arg( 'apply_filters', $IX10555 ); foreach ( $this->url_parameters as $IX63484 ) { $IX10555 = remove_query_arg( $IX63484, $IX10555 ); $IX69748 = null; switch ( $IX63484 ) { case 'per_page' : $IX69748 = $this->get_per_page(); break; case 'from_date' : $IX69748 = $this->get_from_date(); break; case 'thru_date' : $IX69748 = $this->get_thru_date(); break; case 'src_uri' : $IX69748 = $this->get_src_uri(); break; case 'dest_uri' : $IX69748 = $this->get_dest_uri(); break; case 'min_referrals' : $IX69748 = $this->get_min_referrals(); break; case 'orderby' : $IX69748 = $this->get_orderby(); break; case 'order' : $IX69748 = $this->get_sort_order(); break; } if ( $IX69748 !== null ) { $IX10555 = add_query_arg( $IX63484, $IX69748, $IX10555 ); } } foreach ( $params as $IX31967 => $IX69748 ) { $IX10555 = remove_query_arg( $IX31967, $IX10555 ); if ( $IX69748 !== null ) { $IX10555 = add_query_arg( $IX31967, $IX69748, $IX10555 ); } } return $IX10555; }

	/**
	 * @return boolean
	 */
	public function get_show_dates() { return $this->show_dates; }

	/**
	 * @return boolean
	 */
	public function get_show_hits() { return $this->show_hits; }

	/**
	 * @return boolean
	 */
	public function get_show_referrals() { return $this->show_referrals; }

	/**
	 * @return boolean
	 */
	public function get_show_visits() { return $this->show_visits; }

	/**
	 * @return boolean
	 */
	public function get_show_src_uris() { return $this->show_src_uris; }

	/**
	 * @return boolean
	 */
	public function get_show_dest_uris() { return $this->show_dest_uris; }

	/**
	 * @return boolean
	 */
	public function get_show_filters() { return $this->show_filters; }

	/**
	 * @return boolean
	 */
	public function get_show_pagination() { return $this->show_pagination; }

	/**
	 * @return int
	 */
	public function get_src_uri_maxlength() { return $this->get_src_uri_maxlength; }

	/**
	 * @return int
	 */
	public function get_dest_uri_maxlength() { return $this->get_dest_uri_maxlength; }

	public static function init() { require_once( AFFILIATES_CORE_LIB . '/class-affiliates-date-helper.php' ); }

	public function __construct( $params = array() ) { $this->template = 'dashboard/traffic.php'; $this->require_user_id = true; parent::__construct( $params ); $this->url_parameters = array( 'traffic-page', 'per_page', 'from_date', 'thru_date', 'src_uri', 'dest_uri', 'min_referrals', 'orderby', 'order' ); $params = shortcode_atts( self::$defaults, $params ); foreach ( $params as $IX68965 => $IX64336 ) { switch( $IX68965 ) { case 'show_dates' : case 'show_visits' : case 'show_hits' : case 'show_referrals' : case 'show_src_uris' : case 'show_dest_uris' : case 'show_filters' : case 'show_pagination' : if ( is_string( $IX64336 ) ) { $IX64336 = strtolower( $IX64336 ); } switch( $IX64336 ) { case 'yes' : case 'true' : case true : $IX64336 = true; break; case 'no' : case 'false' : case false : $IX64336 = false; break; default : $IX64336 = false; } break; case 'src_uri_maxlength' : $IX64336 = intval( $IX64336 ); if ( $IX64336 < 0 ) { $IX64336 = self::$defaults['src_uri_maxlength']; } break; case 'dest_uri_maxlength' : $IX64336 = intval( $IX64336 ); if ( $IX64336 < 0 ) { $IX64336 = self::$defaults['dest_uri_maxlength']; } break; case 'per_page' : $IX64336 = intval( $IX64336 ); if ( $IX64336 < 0 ) { $IX64336 = self::$defaults['per_page']; } break; case 'status' : if ( !is_array( $IX64336 ) ) { if ( is_string( $IX64336 ) ) { $IX64336 = array_map( 'trim', explode( ',', $IX64336 ) ); } else { $IX64336 = self::$defaults['status']; } } $IX56642 = array(); foreach ( $IX64336 as $IX94212 ) { switch ( $IX94212 ) { case AFFILIATES_REFERRAL_STATUS_ACCEPTED : case AFFILIATES_REFERRAL_STATUS_CLOSED : case AFFILIATES_REFERRAL_STATUS_PENDING : case AFFILIATES_REFERRAL_STATUS_REJECTED : $IX56642[] = $IX94212; break; } } $IX64336 = $IX56642; break; } $params[$IX68965] = $IX64336; } $this->show_dates = $params['show_dates']; $this->show_visits = $params['show_visits']; $this->show_hits = $params['show_hits']; $this->show_referrals = $params['show_referrals']; $this->show_src_uris = $params['show_src_uris']; $this->show_dest_uris = $params['show_dest_uris']; $this->show_filters = $params['show_filters']; $this->show_pagination = $params['show_pagination']; $this->src_uri_maxlength = $params['src_uri_maxlength']; $this->dest_uri_maxlength = $params['dest_uri_maxlength']; $this->per_page = $params['per_page']; $this->status = $params['status']; $this->column_display_names = array(); $IX41516 = DateHelper::getServerDateTimeZone();
        if ( $this->show_dates ) {
            $this->columns['date'] = array( 'title' => __( '日期', 'affiliates' ),
                'description' => sprintf( __( "* 日期是針對服務器時區 : %s 給出的，相對於 GMT 有 %s 小時的偏移。", 'affiliates' ), $IX41516->getName(), $IX41516->getOffset( new DateTime() ) / 3600.0 ) ); }
        if ( $this->show_visits ) {
            $this->columns['visits'] = array( 'title' => __( '訪問量', 'affiliates' ),
                'description' => __( '獨立訪問次數。', 'affiliates' ) );
        }
        if ( $this->show_hits ) {
            $this->columns['hits'] = array( 'title' => __( '點擊數', 'affiliates' ),
                'description' => __( '點擊數或點擊數。', 'affiliates' ) );
        }
        if ( $this->show_referrals ) {
            $this->columns['referrals'] = array( 'title' => __( '推薦人', 'affiliates' ),
                'description' => __( '相應的推薦或轉化數量。', 'affiliates' ) );
        }
        if ( $this->show_src_uris ) {
            $this->columns['src_uri'] = array( 'title' => __( '來源', 'affiliates' ),
                'description' => __( '流量源自哪裡。', 'affiliates' ) );
        }
        if ( $this->show_dest_uris ) {
            $this->columns['dest_uri'] = array( 'title' => __( '目標', 'affiliates' ),
                'description' => __( '交通通向哪裡。', 'affiliates' ) );
        }
    }

	public function render() { global $affiliates_db, $affiliates_version; wp_enqueue_script( 'datepicker', AFFILIATES_PLUGIN_URL . 'js/jquery-ui.min.js', array( 'jquery', 'jquery-ui-core' ), $affiliates_version ); wp_enqueue_script( 'datepickers', AFFILIATES_PLUGIN_URL . 'js/datepickers.js', array( 'jquery', 'jquery-ui-core', 'datepicker' ), $affiliates_version ); wp_enqueue_style( 'smoothness', AFFILIATES_PLUGIN_URL . 'css/smoothness/jquery-ui.min.css', array(), $affiliates_version ); $IX59292 = !empty( $_REQUEST['per_page'] ) ? min( max( 1, intval( trim( $_REQUEST['per_page'] ) ) ), self::MAX_PER_PAGE ) : null; if ( $IX59292 !== null ) { $this->per_page = intval( $IX59292 ); } $IX97205 = isset( $_REQUEST['traffic-page'] ) ? max( 0, intval( $_REQUEST['traffic-page'] ) ) : 0; $IX55353 = isset( $_REQUEST['from_date'] ) ? trim( $_REQUEST['from_date'] ) : null; $IX74179 = isset( $_REQUEST['thru_date'] ) ? trim( $_REQUEST['thru_date'] ) : null; $IX98066 = isset( $_REQUEST['src_uri'] ) ? trim( $_REQUEST['src_uri'] ) : null; $IX38328 = isset( $_REQUEST['dest_uri'] ) ? trim( $_REQUEST['dest_uri'] ) : null; $IX74011 = isset( $_REQUEST['min_referrals'] ) ? trim( $_REQUEST['min_referrals'] ) : null; if ( isset( $_REQUEST['clear_filters'] ) ) { unset( $_REQUEST['from_date'] ); unset( $_REQUEST['thru_date'] ); unset( $_REQUEST['src_uri'] ); unset( $_REQUEST['dest_uri'] ); unset( $_REQUEST['min_referrals'] ); $IX55353 = null; $IX74179 = null; $IX98066 = null; $IX38328 = null; $IX74011 = null; } else { if ( !empty( $_REQUEST['from_date'] ) ) { $IX55353 = date( 'Y-m-d', strtotime( $_REQUEST['from_date'] ) ); } else { $IX55353 = null; } if ( !empty( $_REQUEST['thru_date'] ) ) { $IX74179 = date( 'Y-m-d', strtotime( $_REQUEST['thru_date'] ) ); } else { $IX74179 = null; } if ( $IX55353 && $IX74179 ) { if ( strtotime( $IX55353 ) > strtotime( $IX74179 ) ) { $IX74179 = null; } } if ( !empty( $_REQUEST['src_uri'] ) ) { $IX98066 = trim( $_REQUEST['src_uri'] ); } else if ( isset( $_REQUEST['src_uri'] ) ) { $IX98066 = null; } if ( !empty( $_REQUEST['dest_uri'] ) ) { $IX38328 = trim( $_REQUEST['dest_uri'] ); } else if ( isset( $_REQUEST['dest_uri'] ) ) { $IX38328 = null; } if ( !empty( $_REQUEST['min_referrals'] ) ) { $IX74011 = max( 0, intval( $_REQUEST['min_referrals'] ) ); } else if ( isset( $_REQUEST['min_referrals'] ) ) { $IX74011 = null; } } $this->from_date = $IX55353; $this->thru_date = $IX74179; $this->src_uri = $IX98066; $this->dest_uri = $IX38328; $this->min_referrals = $IX74011; $this->current_page = $IX97205; $IX37690 = $affiliates_db->get_tablename( 'affiliates' ); $IX61468 = $affiliates_db->get_tablename( 'referrals' ); $IX39506 = $affiliates_db->get_tablename( 'hits' ); $IX79603 = $affiliates_db->get_tablename( 'uris' ); $this->orderby = isset( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : $this->orderby; switch ( $this->orderby ) { case 'date' : case 'visits' : case 'hits' : case 'referrals' : case 'src_uri' : case 'dest_uri' : break; default: $this->orderby = 'date'; } $this->sort_order = isset( $_REQUEST['order'] ) ? $_REQUEST['order'] : $this->sort_order; switch ( $this->sort_order ) { case 'asc' : case 'ASC' : $this->switch_sort_order = 'DESC'; break; case 'desc' : case 'DESC' : $this->switch_sort_order = 'ASC'; break; default: $this->sort_order = 'DESC'; $this->switch_sort_order = 'ASC'; } $IX18043 = null; $IX61906 = null; $this->setup_query_filters( $IX18043, $IX61906 ); $IX34210 = ''; if ( $this->min_referrals ) { $IX34210 = " HAVING COUNT(r.hit_id) >= " . intval( $this->min_referrals ). " "; } $IX51241 = $this->per_page * $this->current_page; $IX17065 = "SELECT SQL_CALC_FOUND_ROWS " . "h.date date, " . "su.uri src_uri, " . "du.uri dest_uri, " . "COUNT(distinct h.ip) visits, " . "COUNT(*) hits, " . "COUNT(r.hit_id) referrals " . "FROM $IX39506 h " . "LEFT JOIN $IX37690 a ON h.affiliate_id = a.affiliate_id " . "LEFT JOIN $IX79603 su ON h.src_uri_id = su.uri_id " . "LEFT JOIN $IX79603 du ON h.dest_uri_id = du.uri_id " . "LEFT JOIN $IX61468 r ON r.hit_id = h.hit_id " . "$IX18043 " . "GROUP BY h.affiliate_id, h.date, su.uri_id, du.uri_id " . "$IX34210 "; $IX58380 = "ORDER BY %s %s LIMIT %d OFFSET %d"; $IX16957 = $IX17065 . sprintf( $IX58380, $this->orderby, $this->sort_order, intval( $this->per_page ), intval( $IX51241 ) ); $this->entries = $affiliates_db->get_objects( $IX16957, $IX61906 ); $this->count = intval( $affiliates_db->get_value( "SELECT FOUND_ROWS()" ) ); if ( count( $this->entries ) === 0 && $this->count > 0 ) { $this->current_page = 0; $IX16957 = $IX17065 . sprintf( $IX58380, $this->orderby, $this->sort_order, intval( $this->per_page ), 0 ); $this->entries = $affiliates_db->get_objects( $IX16957, $IX61906 ); $this->count = intval( $affiliates_db->get_value( "SELECT FOUND_ROWS()" ) ); } parent::render(); }

	protected function setup_query_filters( &$filters, &$filter_params ) { global $wpdb; $IX79274 = $this->get_affiliate_id(); $filters = " WHERE 1=%d "; $filter_params = array( 1 ); if ( $this->from_date ) { $IX12655 = DateHelper::u2s( $this->from_date ); } if ( $this->thru_date ) { $IX70558 = DateHelper::u2s( $this->thru_date, 24*3600 ); } if ( $this->from_date && $this->thru_date ) { $filters .= " AND h.datetime >= %s AND h.datetime <= %s "; $filter_params[] = $IX12655; $filter_params[] = $IX70558; } else if ( $this->from_date ) { $filters .= " AND h.datetime >= %s "; $filter_params[] = $IX12655; } else if ( $this->thru_date ) { $filters .= " AND h.datetime < %s "; $filter_params[] = $IX70558; } $filters .= " AND h.affiliate_id = %d "; $filter_params[] = $IX79274; if ( $this->src_uri ) { $filters .= " AND su.uri LIKE %s "; $filter_params[] = '%' . $wpdb->esc_like( $this->src_uri ) . '%'; } if ( $this->dest_uri ) { $filters .= " AND du.uri LIKE %s "; $filter_params[] = '%' . $wpdb->esc_like( $this->dest_uri ) . '%'; } $IX29218 = ''; if ( is_array( $this->status ) && count( $this->status ) > 0 ) { $IX29218 = " AND ( r.status IS NULL OR r.status IN ('" . implode( "','", array_map( 'esc_sql', $this->status ) ) . "') ) "; $filters .= $IX29218; } }
}
Affiliates_Dashboard_Traffic::init();
