<?php
/**
 * class-affiliates-graph-renderer.php
 *
 * Copyright 2012 "kento" Karim Rahimpur - www.itthinx.com
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
 * @since affiliates-pro 2.2.1
 */

/**
 * Graph renderer base.
 */
abstract class Affiliates_Graph_Renderer implements I_Affiliates_Graph_Renderer {

	protected static $graph_options = array(
		'from_date' => null,
		'thru_date' => null,
		'days_back' => null,
		'interval'  => null,
		'legend'    => true,
		'render'    => 'graph'

	);

	protected static $today;
	protected static $day_interval  = 7;
	protected static $min_days_back = 7;
	protected static $max_days_back = 1100;

	public static function init() { self::$today = date( 'Y-m-d', time() ); }

	static function render_graph( $options = array() ) { global $affiliates_db, $affiliate_graph_count; $affiliate_graph_count++; self::init(); $IX23478 = ''; $IX43336 = Affiliates_Affiliate_WordPress::get_user_affiliate_id(); if ( $IX43336 === false ) { return $IX23478; } $IX82062 = isset( $options['interval'] ) && ( $options['interval'] !== null ) ? $options['interval'] : null; $IX21127 = isset( $options['render'] ) ? $options['render'] : self::$graph_options['render']; switch( $IX21127 ) { case 'graph' : case 'hits' : case 'visits' : case 'referrals' : case 'accepted' : case 'closed' : case 'pending' : case 'rejected' : break; default : $IX21127 = self::$graph_options['render']; } $IX48763 = isset( $options['legend'] ) && ( ( $options['legend'] === true ) || ( $options['legend'] === 'true' ) ); if ( $IX48763 ) { $IX78501 = 'true'; } else { $IX78501 = 'false'; } $IX41434 = isset( $options['days_back'] ) && ( $options['days_back'] !== null ) ? $options['days_back'] : self::$min_days_back; if ( $IX41434 < self::$min_days_back ) { $IX41434 = self::$min_days_back; } if ( $IX41434 > self::$max_days_back ) { $IX41434 = self::$max_days_back; } $IX85126 = isset( $options['from_date'] ) && ( $options['from_date'] !== null ) ? $options['from_date'] : null; $IX48232 = isset( $options['thru_date'] ) && ( $options['thru_date'] !== null ) ? $options['thru_date'] : null; switch( $IX82062 ) { case 'month' : $IX85126 = date( 'Y-m-d', strtotime( 'first day of' ) ); $IX48232 = date( 'Y-m-d', strtotime( 'last day of' ) ); $IX41434 = 1 + ( strtotime( $IX48232 ) - strtotime( $IX85126 ) ) / ( 3600 * 24 ); break; case 'year' : $IX85126 = date( 'Y-m-d', strtotime( 'first day of January' ) ); $IX48232 = date( 'Y-m-d', strtotime( 'last day of December' ) ); $IX41434 = 1 + ( strtotime( $IX48232 ) - strtotime( $IX85126 ) ) / ( 3600 * 24 ); break; } if ( empty( $IX48232 ) ) { $IX48232 = self::$today; } if ( empty( $IX85126 ) ) { $IX85126 = date( 'Y-m-d', strtotime( $IX48232 ) - $IX41434 * 3600 * 24 ); } $IX92292 = $affiliates_db->get_tablename( 'affiliates' ); $IX45884 = $affiliates_db->get_tablename( 'hits' ); $IX87292 = $affiliates_db->get_tablename( 'referrals' ); $IX50985 = "SELECT date, COUNT(*) as hits FROM $IX45884 WHERE date >= %s AND date <= %s AND affiliate_id = %d GROUP BY date"; $IX59658 = $affiliates_db->get_objects( $IX50985, $IX85126, $IX48232, intval( $IX43336 ) ); $IX22134 = array(); foreach( $IX59658 as $IX80310 ) { $IX22134[$IX80310->date] = $IX80310->hits; } $IX50985 = "SELECT count(DISTINCT IP) visits, date FROM $IX45884 WHERE date >= %s AND date <= %s AND affiliate_id = %d GROUP BY date"; $IX48568 = $affiliates_db->get_objects( $IX50985, $IX85126, $IX48232, intval( $IX43336 ) ); $IX26014 = array(); foreach( $IX48568 as $IX25411 ) { $IX26014[$IX25411->date] = $IX25411->visits; } $IX50985 = "SELECT count(referral_id) referrals, date(datetime) date FROM $IX87292 WHERE status = %s AND date(datetime) >= %s AND date(datetime) <= %s AND affiliate_id = %d GROUP BY date"; $IX49944 = $affiliates_db->get_objects( $IX50985, AFFILIATES_REFERRAL_STATUS_ACCEPTED, $IX85126, $IX48232, intval( $IX43336 ) ); $IX28873 = array(); foreach( $IX49944 as $IX47944 ) { $IX28873[$IX47944->date] = $IX47944->referrals; } $IX49944 = $affiliates_db->get_objects( $IX50985, AFFILIATES_REFERRAL_STATUS_CLOSED, $IX85126, $IX48232, intval( $IX43336 ) ); $IX87103 = array(); foreach( $IX49944 as $IX47944 ) { $IX87103[$IX47944->date] = $IX47944->referrals; } $IX49944 = $affiliates_db->get_objects( $IX50985, AFFILIATES_REFERRAL_STATUS_PENDING, $IX85126, $IX48232, intval( $IX43336 ) ); $IX67963 = array(); foreach( $IX49944 as $IX47944 ) { $IX67963[$IX47944->date] = $IX47944->referrals; } $IX49944 = $affiliates_db->get_objects( $IX50985, AFFILIATES_REFERRAL_STATUS_REJECTED, $IX85126, $IX48232, intval( $IX43336 ) ); $IX60000 = array(); foreach( $IX49944 as $IX47944 ) { $IX60000[$IX47944->date] = $IX47944->referrals; } $IX69016 = array(); $IX68653 = array(); $IX47200 = array(); $IX50496 = array(); $IX77012 = array(); $IX78482 = array(); $IX15388 = array(); $IX47380 = array(); for ( $IX44559 = -$IX41434; $IX44559 <= 0; $IX44559++ ) { $IX65283 = date( 'Y-m-d', strtotime( $IX48232 ) + $IX44559 * 3600 * 24 ); $IX47380[$IX44559] = $IX65283; if ( isset( $IX28873[$IX65283] ) ) { $IX69016[] = array( $IX44559, intval( $IX28873[$IX65283] ) ); } if ( isset( $IX67963[$IX65283] ) ) { $IX68653[] = array( $IX44559, intval( $IX67963[$IX65283] ) ); } if ( isset( $IX60000[$IX65283] ) ) { $IX47200[] = array( $IX44559, intval( $IX60000[$IX65283] ) ); } if ( isset( $IX87103[$IX65283] ) ) { $IX50496[] = array( $IX44559, intval( $IX87103[$IX65283] ) ); } if ( isset( $IX22134[$IX65283] ) ) { $IX77012[] = array( $IX44559, intval( $IX22134[$IX65283] ) ); } if ( isset( $IX26014[$IX65283] ) ) { $IX78482[] = array( $IX44559, intval( $IX26014[$IX65283] ) ); } if ( $IX41434 <= ( self::$day_interval + self::$min_days_back ) ) { $IX13982 = date( 'm-d', strtotime( $IX65283 ) ); $IX15388[] = array( $IX44559, $IX13982 ); } else if ( $IX41434 <= 91 ) { $IX51503 = date( 'd', strtotime( $IX65283 ) ); if ( $IX51503 == '1' || $IX51503 == '15' ) { $IX13982 = date( 'm-d', strtotime( $IX65283 ) ); $IX15388[] = array( $IX44559, $IX13982 ); } } else { if ( date( 'd', strtotime( $IX65283 ) ) == '1' ) { if ( date( 'm', strtotime( $IX65283 ) ) == '1' ) { $IX13982 = '<strong>' . date( 'Y', strtotime( $IX65283 ) ) . '</strong>'; } else { $IX13982 = date( 'm-d', strtotime( $IX65283 ) ); } $IX15388[] = array( $IX44559, $IX13982 ); } } } $IX98215 = json_encode( $IX69016 ); $IX48539 = json_encode( $IX68653 ); $IX47664 = json_encode( $IX47200 ); $IX89970 = json_encode( $IX50496 ); $IX37991 = json_encode( $IX77012 ); $IX92987 = json_encode( $IX78482 ); $IX27279 = json_encode( array( array( intval( -$IX41434 ), 0 ), array( 0, 0 ) ) ); $IX53591 = json_encode( $IX15388 ); $IX15547 = json_encode( $IX47380 ); $IX49353 = isset( $options['class'] ) ? $options['class'] : 'affiliate-graph'; $IX89631 = isset( $options['id'] ) ? $options['id'] : 'affiliate-graph-' . $affiliate_graph_count; $IX84434 = isset( $options['style'] ) ? $options['style'] : ''; ob_start(); $IX41601 = $IX41434 <= 61 ? 'true' : 'false'; ?>
		<div id="<?php echo $IX89631; ?>" class="<?php echo $IX49353; ?>" style="<?php echo $IX84434; ?>"></div>
		<script type="text/javascript">
		document.addEventListener( "DOMContentLoaded", function() {
		if ( typeof jQuery !== "undefined" ) {
			(function($){
					var data = [
						<?php if ( $IX21127 == 'graph' || $IX21127 == 'hits' ) : ?>
						{
							label : "<?php __('點擊數', AFFILIATES_PLUGIN_DOMAIN ); ?>",
							data : <?php echo $IX37991; ?>,
							lines : { show : true },
							points : { show : <?php echo $IX41601; ?> },
							yaxis : 2,
							color : '#ccddff'
						},
						<?php endif; ?>
						<?php if ( $IX21127 == 'graph' || $IX21127 == 'visits' ) : ?>
						{
							label : "<?php _e( 'Visits', AFFILIATES_PLUGIN_DOMAIN ); ?>",
							data : <?php echo $IX92987; ?>,
							lines : { show : true },
							points : { show : <?php echo $IX41601; ?> },
							yaxis : 2,
							color : '#ffddcc'
						},
						<?php endif; ?>
						<?php if ( $IX21127 == 'graph' || $IX21127 == 'accepted' || $IX21127 == 'referrals' ) : ?>
						{
							label : "<?php _e( 'Accepted', AFFILIATES_PLUGIN_DOMAIN ); ?>",
							data : <?php echo $IX98215; ?>,
							color : '#009900',
							bars : { align : "center", show : true, barWidth : 1 },
							hoverable : true,
							yaxis : 1
						},
						<?php endif; ?>
						<?php if ( $IX21127 == 'graph' || $IX21127 == 'pending' || $IX21127 == 'referrals' ) : ?>
						{
							label : "<?php _e( 'Pending', AFFILIATES_PLUGIN_DOMAIN ); ?>",
							data : <?php echo $IX48539; ?>,
							color : '#0000ff',
							bars : { align : "center", show : true, barWidth : 0.6 },
							yaxis : 1
						},
						<?php endif; ?>
						<?php if ( $IX21127 == 'graph' || $IX21127 == 'rejected' || $IX21127 == 'referrals' ) : ?>
						{
							label : "<?php _e( 'Rejected', AFFILIATES_PLUGIN_DOMAIN ); ?>",
							data : <?php echo $IX47664; ?>,
							color : '#ff0000',
							bars : { align : "center", show : true, barWidth : .3 },
							yaxis : 1
						},
						<?php endif; ?>
						<?php if ( $IX21127 == 'graph' || $IX21127 == 'closed' || $IX21127 == 'referrals' ) : ?>
						{
							label : "<?php _e( 'Closed', AFFILIATES_PLUGIN_DOMAIN ); ?>",
							data : <?php echo $IX89970; ?>,
							color : '#333333',
							points : { show : true },
							yaxis : 1
						},
						<?php endif; ?>
						{
							data : <?php echo $IX27279; ?>,
							lines : { show : false },
							yaxis : 1
						}
					];

					var options = {
						xaxis : {
							ticks : <?php echo $IX53591; ?>
						},
						yaxis : {
							min : 0,
							tickDecimals : 0
						},
						yaxes : [
							{},
							{ position : 'right' }
						],
						grid : {
							hoverable : true
						},
						legend : {
							show : <?php echo $IX78501; ?>,
							position : 'nw'
						}
					};

					$.plot($("#<?php echo $IX89631; ?>"),data,options);

					function statsTooltip(x, y, contents) {
						var tooltip = $('<div id="<?php echo $IX89631; ?>-tooltip">' + contents + '</div>').css( {
							position: 'absolute',
							display: 'none',
							top: y + 5,
							left: x + 5,
							border: '1px solid #333',
							'border-radius' : '4px',
							padding: '6px',
							'background-color': '#ccc',
							opacity: 0.90
						}).appendTo("body").fadeIn(200);
						if ( tooltip.position().left >= tooltip.parent().width() / 2 ) {
							tooltip.css({left:x-tooltip.outerWidth()});
						}
					}

					var tooltipItem = null;
					var statsDates = <?php echo $IX15547; ?>;
					$("#<?php echo $IX89631; ?>").bind("plothover", function (event, pos, item) {
						if (item) {
							if (tooltipItem === null || item.dataIndex != tooltipItem.dataIndex || item.seriesIndex != tooltipItem.seriesIndex) {
								tooltipItem = item;
								$("#<?php echo $IX89631; ?>-tooltip").remove();
								var x = item.datapoint[0];
									y = item.datapoint[1];
								statsTooltip(
									item.pageX,
									item.pageY,
									item.series.label + " : " + y +  '<br/>' + statsDates[x]
								);
							}
						} else {
							$("#<?php echo $IX89631;?>-tooltip").remove();
							tooltipItem = null;
						}
					});
			})(jQuery);
		}
		} );
		</script>
		<?php
 $IX23478 .= ob_get_contents(); ob_end_clean(); return $IX23478; }

	static function render_hits( $options = array() ) { self::init(); $options['render'] = 'hits'; return self::render_graph( $options ); }

	static function render_visits( $options = array() ) { self::init(); $options['render'] = 'visits'; return self::render_graph( $options ); }

	static function render_referrals( $options = array() ) { self::init(); $options['render'] = 'referrals'; return self::render_graph( $options ); }

	static function render_totals( $options = array() ) { self::init(); }
}
