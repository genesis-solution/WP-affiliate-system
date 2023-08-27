<?php
/**
 * traffic.php
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
 *
 * This is a template file. You can customize it by copying it
 * into the appropriate subfolder of your theme:
 *
 *   mytheme/affiliates/dashboard/traffic.php
 *
 * It is highly recommended to use a child theme for such customizations.
 * Child themes are suitable to keep things up-to-date when the parent
 * theme is updated, while any customizations in the child theme are kept.
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var Affiliates_Dashboard_Traffic $section Section object available for use in the template.
 */
?>
<h2><?php esc_html_e( '交通', 'affiliates' ); ?></h2>
<?php
	//
	// Render the traffic filter form
	//
?>
<div class="dashboard-section dashboard-section-traffic">
	<?php if ( $section->get_show_filters() ) : ?>
		<form id="setfilters" class="filters capsule-container" action="" method="post">
			<?php $columns = $section->get_columns(); ?>
			<?php if ( isset( $columns['date'] ) ) : ?>
				<div class="capsule half left">
					<label for="from_date" class="from-date-filter"><?php _e( '從', 'affiliates' ); ?></label>
					<input class="datefield from-date-filter" name="from_date" type="date" value="<?php echo esc_attr( $section->get_from_date() ); ?>"/>
				</div>
				<div class="capsule half right">
					<label for="thru_date" class="thru-date-filter"><?php esc_html_e( '直到', 'affiliates' ); ?></label>
					<input class="datefield thru-date-filter" name="thru_date" type="date" class="datefield" value="<?php echo esc_attr( $section->get_thru_date() ); ?>"/>
				</div>
			<?php endif; ?>
			<?php if ( isset( $columns['referrals'] ) ) : ?>
				<div class="capsule full">
					<label for="min_referrals" class="min-referrals-filter"><?php esc_html_e( '推薦人', 'affiliates' ); ?></label>
					<input class="input-text min-referrals-filter" title="<?php echo esc_attr( __( 'Minimum number of referrals', 'affiliates' ) ); ?>" name="min_referrals" type="number" value="<?php echo esc_attr( $section->get_min_referrals() ); ?>" min="0"/>
				</div>
			<?php endif; ?>
			<?php if ( isset( $columns['src_uri'] ) ) : ?>
				<div class="capsule full">
					<label for="src_uri" class="src-uri-filter"><?php esc_html_e( '來源', 'affiliates' ); ?></label>
					<input class="src-uri-filter" name="src_uri" type="text" value="<?php echo esc_attr( $section->get_src_uri() !== null ? stripslashes( $section->get_src_uri() ) : '' ); ?>"/>
				</div>
			<?php endif; ?>
			<?php if ( isset( $columns['dest_uri'] ) ) : ?>
				<div class="capsule full">
					<label for="dest_uri" class="dest-uri-filter"><?php esc_html_e( '目標', 'affiliates' ); ?></label>
					<input class="dest-uri-filter" name="dest_uri" type="text" value="<?php echo esc_attr( $section->get_dest_uri() !== null ? stripslashes( $section->get_dest_uri() ) : '' ); ?>"/>
				</div>
			<?php endif; ?>
			<div class="filter-buttons">
				<input class="button apply-button" type="submit" name="apply_filters" style="width: 100px" value="<?php esc_html_e( '申請', 'affiliates' ); ?>"/>
				<input class="button clear-button" type="submit" name="clear_filters" style="width: 100px" value="<?php esc_html_e( '清除', 'affiliates' ); ?>"/>
			</div>
		</form>
		<?php
			//
			// Filter styles
			//
		?>
		<style type="text/css">
		.dashboard-section-traffic form.filters {
			background-color: #f2f2f2;
			border-radius: 4px;
			margin: 4px;
			padding: 4px;
		}
		.dashboard-section-traffic .capsule-container {
			width: 100%;
			display: grid;
			grid-template-columns: repeat(auto-fill, 25%);
		}
		.dashboard-section-traffic .capsule-container .capsule.half.left {
			grid-column: 1 / 3;
		}
		.dashboard-section-traffic .capsule-container .capsule.half.right {
			grid-column: 3 / 5;
		}
		.dashboard-section-traffic .capsule-container .capsule.full {
			grid-column: 1 / 5;
		}
		.dashboard-section-traffic .capsule-container .capsule {
			display: flex;
			padding: 4px;
			margin: 4px;
			align-items: center;
		}
		.dashboard-section-traffic .capsule-container .capsule label {
			padding: 0 4px;
		}
		.dashboard-section-traffic .capsule-container .capsule input {
			flex: 1;
			overflow: hidden;
		}
		.dashboard-section-traffic .filters .filter-buttons {
			display: flex;
			flex-wrap: wrap;
			margin: 4px;
			grid-column: 1 / 5;
		}
		.dashboard-section-traffic .filters .filter-buttons input {
			flex-shrink: 1;
			margin: 4px;
		}
		</style>
	<?php endif; ?>
<?php
	//
	// Render the traffic section
	//
?>
<div class="traffic-container">
	<?php $primary_columns = 0; ?>
	<?php foreach ( $section->get_columns() as $key => $column ) : ?>
		<?php
		$primary_columns++;
		$order_options = array(
			'orderby' => $key,
			'order' => $section->get_switch_sort_order()
		);
		$class = '';
		$arrow = '';
		if ( strcmp( $key, $section->get_orderby() ) == 0 ) {
			$lorder = strtolower( $section->get_sort_order() );
			$class = "$key manage-column sorted $lorder";
			switch( $lorder ) {
				case 'asc' :
					$arrow = ' &uarr;';
					break;
				case 'desc' :
					$arrow = ' &darr;';
					break;
			}
		} else {
			$class = "$key manage-column sortable";
		}
		$link = $section->get_url( $order_options );
		?>
		<div class="cell heading <?php echo esc_attr( $class ); ?>">
			<a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_html( $column['description'] ); ?>">
				<span><?php echo esc_html( $column['title'] ); ?></span><span class="sorting-indicator"><?php echo $arrow; ?></span>
			</a>
		</div>
	<?php endforeach; ?>
	<?php // Render the entries ?>
	<?php if ( $section->get_count() > 0 ) :
		$i = 0;
		foreach ( $section->get_entries() as $entry ) :
			Affiliates_Templates::include_template(
				'dashboard/traffic-entry.php',
				array(
					'section' => $section,
					'entry'   => $entry,
					'index'   => $i
				)
			);
			$i++;
		endforeach;
	?>
	<?php else : ?>
		<div class="cell full odd">
			<?php esc_html_e( 'There are no results.', 'affiliates' ); ?>
		</div>
	<?php endif; ?>

</div><?php // .traffic-container ?>
<?php
	//
	// Render the section navigation
	//
?>
<?php if ( $section->get_show_pagination() && $section->get_count() > 0 ) : ?>
	<div class="section-navigation">
		<?php if ( $section->get_current_page() > 0 ) : ?>
			<a style="margin: 4px;" class="button" href="<?php echo esc_url( $section->get_url( array( 'traffic-page' => $section->get_current_page() - 1 ) ) ); ?>"><?php echo esc_html_x( 'Previous', 'Label used to show previous page of affiliate earnings results', 'affiliates' ); ?></a>
		<?php endif; ?>
		<?php if ( $section->get_current_page() < $section->get_pages() - 1 ) : ?>
			<a style="margin: 4px;" class="button" href="<?php echo esc_url( $section->get_url( array( 'traffic-page' => $section->get_current_page() + 1 ) ) ); ?>"><?php echo esc_html_x( 'Next', 'Label used to show next page of affiliate earnings results', 'affiliates' ); ?></a>
		<?php endif; ?>
	</div>
	<div class="section-navigation-options">
		<form action="<?php echo esc_url( $section->get_url( array( 'per_page' => null ) ) ); ?>" method="post">
			<label class="row-count">
				<?php esc_html_e( '每頁結果', 'affiliates' ); ?>
				<input class="per-page" name="per_page" type="text" value="<?php echo esc_attr( $section->get_per_page() ); ?>" placeholder="<?php echo esc_attr( $section::PER_PAGE_DEFAULT ); ?>" />
				<input class="button" type="submit" style="width: 100px" value="<?php esc_attr_e( '申請', 'affiliates' ); ?>"/>
			</label>
		</form>
	</div>
<?php endif; ?>
</div><?php // .dashboard-section-traffic ?>
<?php
	//
	// Section styles
	//
?>
<style type="text/css">
.dashboard-section-traffic .traffic-container {
	width: 100%;
	display: grid;
	grid-template-columns: repeat(auto-fill, 25%);
}
.dashboard-section-traffic .traffic-container .cell {
	word-break: break-all;
	padding: 4px;
	background-color: #f0f0f0;
	padding: 4px;
}
.dashboard-section-traffic .traffic-container div:nth-child(5),
.dashboard-section-traffic .traffic-container div:nth-child(6) {
	border-bottom: 4px solid #9e9e9e;
}
.dashboard-section-traffic .traffic-container .cell.full {
	grid-column: 1 / -1;
}
.dashboard-section-traffic .traffic-container .date {
	grid-column: 1 / 2;
	word-break: break-word;
	font-size: larger;
}
.dashboard-section-traffic .traffic-container .visits {
	grid-column: 2 / 3;
	font-size: larger;
}
.dashboard-section-traffic .traffic-container .hits {
	grid-column: 3 / 4;
	font-size: larger;
}
.dashboard-section-traffic .traffic-container .referrals {
	grid-column: 4 / 5;
	font-size: larger;
}
.dashboard-section-traffic .traffic-container .src_uri {
	grid-column: 1 / 3;
}
.dashboard-section-traffic .traffic-container .dest_uri {
	grid-column: 3 / 5;
}

.dashboard-section-traffic .traffic-container .heading {
	background-color: #ffffff;
	color: 171717;
	font-weight: bold;
	word-break: break-word;
}
.dashboard-section-traffic .traffic-container .odd {
	background-color: #ffffff;
	color: #252525;
}
.dashboard-section-traffic .traffic-container .even {
	background-color: #e0e0e0;
	color: #171717;
}
.dashboard-section-traffic .section-navigation-options {
	margin: 4px;
}
.dashboard-section-traffic .section-navigation-options input.per-page {
	width: 4em;
}
@media only screen and (max-width: 768px) {
	.dashboard-section-traffic .traffic-container div:nth-child(5) {
		border: none;
	}
	.dashboard-section-traffic .traffic-container {
		grid-template-columns: 50% 50%;
	}
	.dashboard-section-traffic .traffic-container .date {
		grid-column: 1 / 2;
		word-break: break-word;
	}
	.dashboard-section-traffic .traffic-container .visits {
		grid-column: 2 / 3;
	}
	.dashboard-section-traffic .traffic-container .hits {
		grid-column: 1 / 2;
	}
	.dashboard-section-traffic .traffic-container .referrals {
		grid-column: 2 / 3;
	}
	.dashboard-section-traffic .traffic-container .src_uri {
		grid-column: 1 / 3;
	}
	.dashboard-section-traffic .traffic-container .dest_uri {
		grid-column: 1 / 3;
	}
	.dashboard-section-traffic .traffic-container .heading {
		font-size: small;
	}
	.dashboard-section-traffic .traffic-container .cell::before {
		display: block;
		font-size: smaller;
		font-weight: bolder;
		content: attr(data-heading);
	}
}
</style>
