<?php
/**
 * class-affiliates-affiliate-stats-widget.php
 *
 * Copyright (c) 2011 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates
 * @since affiliates 1.1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Affiliate stats widget.
 *
 * @link http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Affiliates_Affiliate_Stats_Widget extends WP_Widget {

	/**
	 * Creates an affiliate stats widget.
	 */
	function __construct() { parent::__construct( false, $IX48819 = 'Affiliates Affiliate Stats' ); }

	/**
	 * Widget output
	 *
	 * @see WP_Widget::widget()
	 */
	function widget( $args, $instance ) { if ( !affiliates_user_is_affiliate() ) { return; } $IX18132 = isset( $args['before_widget'] ) ? $args['before_widget'] : ''; $IX46743 = isset( $args['after_widget'] ) ? $args['after_widget'] : ''; $IX16583 = isset( $args['before_title'] ) ? $args['before_title'] : ''; $IX69029 = isset( $args['after_title'] ) ? $args['after_title'] : ''; $IX27470 = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : ''; $IX96533 = $args['widget_id']; echo $IX18132; if ( !empty( $IX27470 ) ) { echo $IX16583 . $IX27470 . $IX69029; } $IX93537 = '-' . $IX96533; $IX10534 = array( 'is_widget' => true ); $IX10534 = array_merge( $IX10534, $instance ); echo $this->render_affiliate_stats( $IX10534, $IX96533 ); echo $IX46743; }

	/**
	 * Save widget options
	 *
	 * @see WP_Widget::update()
	 */
	function update( $new_instance, $old_instance ) { $IX60381 = $old_instance; if ( !empty( $new_instance['title'] ) ) { $IX60381['title'] = strip_tags( $new_instance['title'] ); } else { unset( $IX60381['title'] ); } $IX15937 = array( 'show_totals_accepted', 'show_totals_pending', 'show_totals_closed', 'show_totals_rejected' ); foreach ( $IX15937 as $IX93851 ) { if ( !empty( $new_instance[$IX93851] ) ) { $IX60381[$IX93851] = true; } else { unset( $IX60381[$IX93851] ); } } return $IX60381; }

	/**
	 * Output admin widget options form
	 *
	 * @see WP_Widget::form()
	 */
	function form( $instance ) { $IX13445 = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : ''; ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'affiliates' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $IX13445; ?>" />
		</p>
		<?php
 $IX56712 = isset( $instance['show_totals_accepted'] ) ? $instance['show_totals_accepted'] : false; echo '<input type="checkbox" ' . ( $IX56712 ? ' checked="checked" ' : '' ) . ' name="' . $this->get_field_name( 'show_totals_accepted' ) . '" id="' . $this->get_field_id( 'show_totals_accepted' ) . '"/>'; echo '<label for="' . $this->get_field_name( 'show_totals_accepted' ) . '">' . __('顯示已接受推薦的總數', 'affiliates' ) . '</label>'; echo '<br/>'; $IX96566 = isset( $instance['show_totals_pending'] ) ? $instance['show_totals_pending'] : false; echo '<input type="checkbox" ' . ( $IX96566 ? ' checked="checked" ' : '' ) . ' name="' . $this->get_field_name( 'show_totals_pending' ) . '" id="' . $this->get_field_id( 'show_totals_pending' ) . '"/>'; echo '<label for="' . $this->get_field_name( 'show_totals_pending' ) . '">' . __('顯示待處理推薦的總數', 'affiliates' ) . '</label>'; echo '<br/>'; $IX36704 = isset( $instance['show_totals_closed'] ) ? $instance['show_totals_closed'] : false; echo '<input type="checkbox" ' . ( $IX36704 ? ' checked="checked" ' : '' ) . ' name="' . $this->get_field_name( 'show_totals_closed' ) . '" id="' . $this->get_field_id( 'show_totals_closed' ) . '"/>'; echo '<label for="' . $this->get_field_name( 'show_totals_closed' ) . '">' . __('顯示已關閉推薦的總數', 'affiliates' ) . '</label>'; echo '<br/>'; $IX72964 = isset( $instance['show_totals_rejected'] ) ? $instance['show_totals_rejected'] : false; echo '<input type="checkbox" ' . ( $IX72964 ? ' checked="checked" ' : '' ) . ' name="' . $this->get_field_name( 'show_totals_rejected' ) . '" id="' . $this->get_field_id( 'show_totals_rejected' ) . '"/>'; echo '<label for="' . $this->get_field_name( 'show_totals_rejected' ) . '">' . __('顯示被拒絕推薦的總數', 'affiliates' ) . '</label>'; }

	/**
	 * Renders affiliate stats.
	 *
	 * @param array $options rendering options
	 */
	public static function render_affiliate_stats( $options = array() ) { global $affiliates_db; $IX90066 = ''; $IX29815 = Affiliates_Affiliate_WordPress::get_user_affiliate_id(); if ( $IX29815 === false ) { return $IX90066; } wp_enqueue_style( 'affiliates' ); wp_enqueue_style( 'my affiliate pro' ); $IX41822 = $affiliates_db->get_tablename( 'affiliates' ); $IX51979 = $affiliates_db->get_tablename( 'referrals' ); $IX79019 = $affiliates_db->get_tablename( 'hits' ); $IX78550 = affiliates_get_affiliate_visits( $IX29815 ); $IX46525 = affiliates_get_affiliate_hits( $IX29815 ); $IX30320 = affiliates_get_affiliate_referrals( $IX29815 ); if ( $IX78550 > 0 ) { $IX82889 = round( $IX30320 / $IX78550, I_Affiliates_Stats_Renderer::RATIO_DECIMALS ); } else { $IX82889 = 0; } $IX90066 .= '<div class="visits">' . sprintf( _n( '%d Visit', '%d Visits', $IX78550, 'affiliates' ), $IX78550 ) . '</div>'; $IX90066 .= '<div class="hits">' . sprintf( _n( '%d Hit', '%d Hits', $IX46525, 'affiliates' ), $IX46525 ) . '</div>'; $IX90066 .= '<div class="referrals">' . sprintf( _n( '%d Referral', '%d Referrals', $IX30320, 'affiliates' ), $IX30320 ) . '</div>'; $IX90066 .= '<div class="ratio">' . sprintf( __( '%.3f 比率', 'affiliates' ), $IX82889 ) . '</div>'; $IX28630 = isset( $options['show_totals'] ) ? ( $options['show_totals'] !== 'false' ) : true; $IX62932 = isset( $options['show_totals_accepted'] ) ? ( $options['show_totals_accepted'] === true || $options['show_totals_accepted'] === 'true' ) : false; $IX70744 = isset( $options['show_totals_pending'] ) ? ( $options['show_totals_pending'] === true || $options['show_totals_pending'] === 'true' ) : false; $IX83211 = isset( $options['show_totals_closed'] ) ? ( $options['show_totals_closed'] === true || $options['show_totals_closed'] === 'true' ) : false; $IX69332 = isset( $options['show_totals_rejected'] ) ? ( $options['show_totals_rejected'] === true || $options['show_totals_rejected'] === 'true' ) : false; if ( $IX28630 && ( $IX62932 || $IX70744 || $IX83211 || $IX69332 ) ) { $IX80154 = $affiliates_db->get_objects( "SELECT SUM(amount) AS total, currency_id FROM $IX51979 WHERE affiliate_id = %d AND status = %s AND amount IS NOT NULL AND currency_id IS NOT NULL GROUP BY currency_id", $IX29815, AFFILIATES_REFERRAL_STATUS_ACCEPTED ); $IX83240 = $affiliates_db->get_objects( "SELECT SUM(amount) AS total, currency_id FROM $IX51979 WHERE affiliate_id = %d AND status = %s AND amount IS NOT NULL AND currency_id IS NOT NULL GROUP BY currency_id", $IX29815, AFFILIATES_REFERRAL_STATUS_PENDING ); $IX15492 = $affiliates_db->get_objects( "SELECT SUM(amount) AS total, currency_id FROM $IX51979 WHERE affiliate_id = %d AND status = %s AND amount IS NOT NULL AND currency_id IS NOT NULL GROUP BY currency_id", $IX29815, AFFILIATES_REFERRAL_STATUS_CLOSED ); $IX31726 = $affiliates_db->get_objects( "SELECT SUM(amount) AS total, currency_id FROM $IX51979 WHERE affiliate_id = %d AND status = %s AND amount IS NOT NULL AND currency_id IS NOT NULL GROUP BY currency_id", $IX29815, AFFILIATES_REFERRAL_STATUS_REJECTED ); $IX90066 .= '<div class="totals">'; $IX90066 .= '<table cellpadding="0" cellspacing="0">'; $IX90066 .= '<thead>'; $IX90066 .= '<tr>'; $IX90066 .= "<th scope='col' class='total'>" . __('全部的', 'affiliates' ) . "</th>"; $IX90066 .= "<th scope='col' class='amount'>" . __('數量', 'affiliates' ) . "</th>"; $IX90066 .= "<th scope='col' class='currency'>" . __('貨幣', 'affiliates' ) . "</th>"; $IX90066 .= '</tr>'; $IX90066 .= '</thead>'; $IX90066 .= '<tbody>'; if ( $IX62932 ) { if ( count( $IX80154 ) == 0 ) { $IX80154[] = (object) array( 'total' => '--', 'currency_id' => '--' ); } foreach ( $IX80154 as $IX52029 ) { $IX90066 .= '<tr>'; $IX90066 .= "<td class='total accepted'>" . __('已接受', 'affiliates' ) . "</td>"; $IX90066 .= "<td class='amount'>$IX52029->total</td>"; $IX90066 .= "<td class='currency'>$IX52029->currency_id</td>"; $IX90066 .= '</tr>'; } } if ( $IX70744 ) { if ( count( $IX83240 ) == 0 ) { $IX83240[] = (object) array( 'total' => '--', 'currency_id' => '--' ); } foreach ( $IX83240 as $IX52029 ) { $IX90066 .= '<tr>'; $IX90066 .= "<td class='total pending'>" . __('待辦的', 'affiliates' ) . "</td>"; $IX90066 .= "<td class='amount'>$IX52029->total</td>"; $IX90066 .= "<td class='currency'>$IX52029->currency_id</td>"; $IX90066 .= '</tr>'; } } if ( $IX83211 ) { if ( count( $IX15492 ) == 0 ) { $IX15492[] = (object) array( 'total' => '--', 'currency_id' => '--' ); } foreach ( $IX15492 as $IX52029 ) { $IX90066 .= '<tr>'; $IX90066 .= "<td class='total closed'>" . __('關閉', 'affiliates' ) . "</td>"; $IX90066 .= "<td class='amount'>$IX52029->total</td>"; $IX90066 .= "<td class='currency'>$IX52029->currency_id</td>"; $IX90066 .= '</tr>'; } } if ( $IX69332 ) { if ( count( $IX31726 ) == 0 ) { $IX31726[] = (object) array( 'total' => '--', 'currency_id' => '--' ); } foreach ( $IX31726 as $IX52029 ) { $IX90066 .= '<tr>'; $IX90066 .= "<td class='total rejected'>" . __('拒絕', 'affiliates' ) . "</td>"; $IX90066 .= "<td class='amount'>$IX52029->total</td>"; $IX90066 .= "<td class='currency'>$IX52029->currency_id</td>"; $IX90066 .= '</tr>'; } } $IX90066 .= '</tbody>'; $IX90066 .= '</table>'; $IX90066 .= '</div>'; } return $IX90066; }
}

