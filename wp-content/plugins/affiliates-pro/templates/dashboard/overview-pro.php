<?php
/**
 * overview.php
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
 *
 * This is a template file. You can customize it by copying it
 * into the appropriate subfolder of your theme:
 *
 *   mytheme/affiliates/dashboard/overview-pro.php
 *
 * It is highly recommended to use a child theme for such customizations.
 * Child themes are suitable to keep things up-to-date when the parent
 * theme is updated, while any customizations in the child theme are kept.
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Overview Pro template
 *
 * @var Affiliates_Dashboard_Overview_Pro $section Section object available for use in the template.
 */

$totals    = $section->get_totals();
$from_date = $section->get_from_date();
$thru_date = $section->get_thru_date();
$selected  = $section->get_selected();
$visits    = isset( $totals['visits'] ) ? intval( $totals['visits'] ) : 0;
$referrals = isset( $totals['referrals'] ) ? intval( $totals['referrals'] ) : 0;
?>
<h2><?php esc_html_e( '查看次数', 'affiliates' ); ?></h2>
<div class="dashboard-section dashboard-section-overview">
	<div class="stats-container">
		<div class="stats-item">
			<div class="stats-item-heading"><?php _e( '訪問量', 'affiliates' ); ?></div>
			<div class="stats-item-value"><?php echo esc_html( $visits ); ?></div>
		</div>
		<div class="stats-item">
			<div class="stats-item-heading"><?php _e( '推薦人', 'affiliates' ); ?></div>
			<div class="stats-item-value"><?php echo esc_html( $referrals ); ?></div>
		</div>
		<div class="stats-item">
			<div class="stats-item-heading"><?php _e( '收益', 'affiliates' ); ?></div>
			<?php if ( count( $totals['amounts_by_currency'] ) > 0 ) : ?>
				<?php foreach ( $totals['amounts_by_currency'] as $currency_id => $amount ) : ?>
					<div class="stats-item-value">
						<span class="stats-item-currency"><?php echo esc_html( $currency_id ); ?></span> <span class="stats-item-amount"><?php echo esc_html( Affiliates_Math::add( '0', $amount , affiliates_get_referral_amount_decimals( 'display' ) ) ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="stats-item-value">
					<span class="stats-item-currency"><span class="stats-item-amount">0</span>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div id="affiliates-dashboard-overview-graph" class="graph"></div>
	<div id="affiliates-dashboard-overview-legend" class="legend"></div>
	<?php
		//
		// Choice of range and filters
		//
	?>
	<div class="affiliates-dashboard-overview-filters">
		<form class="filters" method="post" action="">
			<div class="capsule-container">
				<div class="capsule">
					<select name="range">
						<option <?php echo ( $selected === 'last-seven-days' ? ' selected="selected" ' : '' ); ?> value="last-seven-days"><?php esc_html_e( '過去 7 天', 'affiliates' ); ?></option>
						<option <?php echo ( $selected === 'last-thirty-days' ? ' selected="selected" ' : '' ); ?> value="last-thirty-days"><?php esc_html_e( '過去 30 天', 'affiliates' ); ?></option>
						<option <?php echo ( $selected === 'last-ninety-days' ? ' selected="selected" ' : '' ); ?> value="last-ninety-days"><?php esc_html_e( '過去 90 天', 'affiliates' ); ?></option>
						<option <?php echo ( $selected === 'weekly' ? ' selected="selected" ' : '' ); ?> value="weekly"><?php esc_html_e( '每週', 'affiliates' ); ?></option>
						<option <?php echo ( $selected === 'monthly' ? ' selected="selected" ' : '' ); ?> value="monthly"><?php esc_html_e( '每月', 'affiliates' ); ?></option>
						<option <?php echo ( $selected === 'yearly' ? 'selected="selected" ' : '' ); ?> value="yearly"><?php esc_attr_e( '每年', 'affiliates' ); ?></option>
						<option <?php echo ( $selected === 'custom' ? 'selected="selected" ' : '' ); ?> value="custom"><?php esc_attr_e( '自定義日期範圍', 'affiliates' ); ?></option>
					</select>
				</div>
				<div class="capsule">
					<div class="capsule-atom">
						<label class="from-date-filter" for="from_date"><?php esc_html_e( '從', 'affiliates' ); ?></label>
						<input class="datefield from-date-filter" name="from-date" type="date" value="<?php echo !empty( $from_date ) ? esc_attr( $from_date ) : ''; ?>" >
					</div>
					<div class="capsule-atom">
						<label class="thru-date-filter" for="thru_date"><?php esc_html_e( '直到', 'affiliates' ); ?></label>
						<input class="datefield thru-date-filter" name="thru-date" type="date" value="<?php echo !empty( $thru_date ) ? esc_attr( $thru_date ) : ''; ?>" >
					</div>
				</div>
			</div>
			<div class="filter-buttons">
				<input type="submit" name="apply_filters" value="<?php esc_attr_e( '申請', 'affiliates' ); ?>" >
				<input type="submit" name="clear_filters" value="<?php esc_attr_e( '清除', 'affiliates' ); ?>" >
			</div>
		</form>
	</div>
	<?php
		//
		// Link Generator
		//
	?>
<!--	<h3>--><?php //esc_html_e( 'Links', 'affiliates' ); ?><!--</h3>-->
<!--	<div class="affiliates-dashboard-overview-link link-generator capsule-container">-->
<!--		<div class="capsule full">-->
<!--			<label for="generate-aff-url">--><?php //printf( esc_html__( 'Paste a URL on %s here', 'affiliates' ), esc_url( home_url() ) ); ?><!--</label>-->
<!--			<input class="affiliates-generate-url" id="overview-pro-generate-url" type="text" placeholder="--><?php //echo esc_url( home_url() ); ?><!--" value="--><?php //echo isset( $_REQUEST['generate-aff-url'] ) ? esc_url( trim( $_REQUEST['generate-aff-url'] ) ) : ''; ?><!--" name="generate-aff-url" >-->
<!--		</div>-->
<!--		<div class="capsule full">-->
<!--			<label>-->
<!--				<textarea id="copy-to-clipboard-source" class="affiliate-url" readonly="readonly" onmouseover="this.focus();" onfocus="this.select();">--><?php //echo esc_html( Affiliates_Shortcodes::affiliates_url( array() ) ); ?><!--</textarea>-->
<!--				--><?php //esc_html_e( 'Your affiliate URL', 'affiliates' ); ?><!--</p>-->
<!--			</label>-->
<!--		</div>-->
<!--		<div class="capsule full">-->
<!--			<span class="button copy-to-clipboard-trigger" data-source="copy-to-clipboard-source">--><?php //esc_html_e( 'Copy to Clipboard', 'affiliates' ); ?><!--</span>-->
<!--		</div>-->
<!--	</div>-->
<!--	<div class="affiliates-dashboard-logout">-->
<!--		<a href="--><?php //echo esc_url( wp_logout_url( home_url() ) ) ?><!--">--><?php //esc_html_e( 'Log out', 'affiliates' ); ?><!--</a>-->
<!--	</div>-->
</div><?php // .dashboard-section-overview ?>
<?php
	//
	// Section styling
	//
?>
<style type="text/css">
.dashboard-section-overview {
	display: grid;
}
.dashboard-section-overview .stats-container {
	margin: 0;
	display: flex;
	flex-wrap: wrap;
}
.dashboard-section-overview .stats-item {
	background-color: #f2f2f2;
	border-radius: 4px;
	margin: 4px;
	padding: 4px;
	text-align: center;
	font-size: 16px;
	flex-grow: 1;
}
.dashboard-section-overview .stats-item .stats-item-heading {
	font-weight: bold;
}
.dashboard-section-overview .stats-item .stats-item-value {
	font-size: 24px;
}
.dashboard-section-overview .graph {
	background-color: #fafafa;
	border-radius: 4px;
	margin: 4px;
	width: 100%;
	height: 400px;
}
.dashboard-section-overview .legend {
	display: flex;
	flex-wrap: wrap;
	text-align: center;
	background-color: #f2f2f2;
	border-radius: 4px;
	margin: 4px;
}
.dashboard-section-overview .legend-item {
	flex-grow: 1;
}
.dashboard-section-overview .legend-item.active {
	background-color: #e0e0e0;
	border-radius: 2px;
}
.dashboard-section-overview .legend-item-label {
	font-size: 14px;
	display:inline-block;
	vertical-align:middle;
	padding: 4px;
}
.dashboard-section-overview .legend-item-color {
	width: 16px;
	height: 16px;
	display:inline-block;
	vertical-align:middle;
}
.dashboard-section-overview form.filters {
	background-color: #f2f2f2;
	border-radius: 4px;
	margin: 4px;
	padding: 4px;
}
.dashboard-section-overview form.filters .capsule-container {
	width: 100%;
	display: flex;
	flex-wrap: wrap;
	align-items: baseline;
}
.dashboard-section-overview form.filters .capsule-container .capsule {
	margin: 4px;
	white-space: nowrap;
	display: flex;
	flex-wrap: wrap;
}
.dashboard-section-overview form.filters .capsule-container .capsule .capsule-atom {
	margin-bottom: 4px;
}
.dashboard-section-overview form.filters .capsule-container .capsule .capsule-atom:first-child {
	margin-right: 4px;
}
.dashboard-section-overview form.filters .capsule-container .capsule .capsule-atom:last-child {
	margin-left: 4px;
	margin-bottom: unset;
}
.dashboard-section-overview form.filters .filter-buttons {
	display: flex;
	flex-wrap: wrap;
}
.dashboard-section-overview form.filters .filter-buttons input {
	flex-shrink: 1;
	margin: 4px;
}
.dashboard-section-overview .link-generator.capsule-container {
	width: 100%;
	display: grid;
	grid-template-columns: 100%;
}
.dashboard-section-overview .link-generator.capsule-container .capsule {
	grid-column: 1;
	margin: 4px;
}
.dashboard-section-overview .link-generator.capsule-container .capsule.full input,
.dashboard-section-overview .link-generator.capsule-container .capsule.full textarea {
	width: 100%;
}
.flot-x-axis .flot-tick-label.tickLabel {
	margin: 2px 0;
	transform: translate(0px,2px) rotate(-20deg);
	font-size: smaller;
}
.dashboard-section-overview .affiliates-dashboard-logout {
	margin: 4px;
	padding: 4px;
	text-align: right;
}
.dashboard-section-overview .copy-to-clipboard-trigger {
	cursor: pointer;
}
</style>
