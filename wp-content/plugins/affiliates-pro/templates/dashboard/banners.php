<?php
/**
 * banners.php
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
 *   mytheme/affiliates/dashboard/banners.php
 *
 * It is highly recommended to use a child theme for such customizations.
 * Child themes are suitable to keep things up-to-date when the parent
 * theme is updated, while any customizations in the child theme are kept.
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Banners template
 *
 * @var Affiliates_Dashboard_Banners $section Section object available for use in the template.
 */

$banners = $section->get_entries();
?>
<h2><?php esc_html_e( '橫幅', 'affiliates' ); ?></h2>
<div class="dashboard-section dashboard-section-banners">
	<form id="dashboard-banners-search" class="filters capsule-container" action="" method="post" >
		<div class="capsule full">
			<label for="banner-url"><?php esc_html_e( '將橫幅鏈接至 &hellip;', 'affiliates' ); ?></label>
			<input type="text" placeholder="<?php echo esc_url( home_url() ); ?>" value="<?php echo esc_url( $section->get_banner_url() ); ?>" name="banner-url" title="<?php printf( esc_html__( 'The main site URL is used by default or you can paste a link to a specific page on %s here.', 'affiliates' ), esc_url( home_url() ) ); ?>">
		</div>
		<div class="capsule full">
			<input name="banner-search" type="text" placeholder="<?php esc_attr_e( '搜索 &hellip;', 'affiliates' ); ?>" value="<?php echo esc_attr( $section->get_search() !== null ? stripslashes( $section->get_search() ) : '' ); ?>">
		</div>
		<div class="filter-buttons">
			<input class="button apply-button" type="submit" style="width: 100px" name="apply_filters" value="<?php esc_html_e( '申請', 'affiliates' ); ?>"/>
			<input class="button clear-button" type="submit" style="width: 100px" name="clear_filters" value="<?php esc_html_e( '清除', 'affiliates' ); ?>"/>
		</div>
	</form>
	<?php
		//
		// Filter styles
		//
	?>
	<style type="text/css">
	.dashboard-section-banners form.filters {
		background-color: #f2f2f2;
		border-radius: 4px;
		margin: 4px;
		padding: 4px;
	}
	.dashboard-section-banners .capsule-container {
		width: 100%;
		display: grid;
		grid-template-columns: repeat(auto-fill, 25%);
	}
	.dashboard-section-banners .capsule-container .capsule.half.left {
		grid-column: 1 / 3;
	}
	.dashboard-section-banners .capsule-container .capsule.half.right {
		grid-column: 3 / 5;
	}
	.dashboard-section-banners .capsule-container .capsule.full {
		grid-column: 1 / 5;
	}
	.dashboard-section-banners .capsule-container .capsule {
		display: flex;
		flex-wrap: wrap;
		padding: 4px;
		margin: 4px;
		align-items: center;
	}
	.dashboard-section-banners .capsule-container .capsule label {
		padding: 0 4px;
	}
	.dashboard-section-banners .capsule-container .capsule input {
		flex-grow: 1;
		overflow: hidden;
	}
	.dashboard-section-banners .filters .filter-buttons {
		display: flex;
		flex-wrap: wrap;
		margin: 4px;
		grid-column: 1 / 5;
	}
	.dashboard-section-banners .filters .filter-buttons input {
		flex-shrink: 1;
		margin: 4px;
	}
	</style>
	<?php
	if ( count( $banners ) > 0 ) :
		$i = 0;
		foreach ( $banners as $banner ) : ?>
			<div class="banners-container"">
				<div class="cell banner-image">
					<?php
						echo wp_kses(
							$banner->image,
							array(
								'img' => array(
									'src'    => array(),
									'width'  => array(),
									'height' => array(),
									'alt'    => array(),
								)
							)
						);
					?>
				</div>
				<div class="cell banner-link">
					<div>
						<label for="copy-to-clipboard-source-<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Banner Code', 'affiliates' ); ?></label>
						<textarea id="copy-to-clipboard-source-<?php echo esc_attr( $i ); ?>" class="affiliate-url" readonly="readonly" onmouseover="this.focus();" onfocus="this.select();"><?php echo esc_html( '<a href="' . esc_url( $banner->url ) . '">' . $banner->image . '</a>' ); ?></textarea>
					</div>
					<div>
						<span class="button copy-to-clipboard-trigger" data-source="copy-to-clipboard-source-<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Copy to Clipboard', 'affiliates' ); ?></span>
					</div>
				</div>
			</div><!-- banners-container -->
			<?php
			$i++;
		endforeach;
	endif; ?>
	<?php
	//
	// Render the section navigation
	//
	?>
	<?php if ( $section->get_count() > 0 ) : ?>
		<div class="section-navigation">
			<?php if ( $section->get_current_page() > 0 ) : ?>
				<a style="margin: 4px;" class="button" href="<?php echo esc_url( $section->get_url( array( 'banners-page' => $section->get_current_page() - 1 ) ) ); ?>"><?php echo esc_html_x( 'Previous', 'Link label to go back to previous page', 'affiliates' ); ?></a>
			<?php endif; ?>
			<?php if ( $section->get_current_page() < $section->get_pages() - 1 ) : ?>
				<a style="margin: 4px;" class="button" href="<?php echo esc_url( $section->get_url( array( 'banners-page' => $section->get_current_page() + 1 ) ) ); ?>"><?php echo esc_html_x( 'Next', 'Link label to go to the next page', 'affiliates' ); ?></a>
			<?php endif; ?>
		</div>
		<div class="section-navigation-options">
			<form action="<?php echo esc_url( $section->get_url( array( 'per_page' => null ) ) ); ?>" method="post">
				<label class="row-count">
					<?php esc_html_e( 'Results per page', 'affiliates' ); ?>
					<input class="per-page" name="per_page" type="text" value="<?php echo esc_attr( $section->get_per_page() ); ?>" placeholder="<?php echo esc_attr( $section::PER_PAGE_DEFAULT ); ?>" />
					<input class="button" type="submit" value="<?php esc_attr_e( 'Apply', 'affiliates' ); ?>"/>
				</label>
			</form>
		</div>
	<?php endif; ?>
</div><?php // .dashboard-section-banners ?>

<style type="text/css">
.dashboard-section-banners .banners-container {
	width: 100%;
	display: grid;
	grid-template-columns: 50% 50%;
	margin: 32px 0;
}
.dashboard-section-banners .banners-container .cell {
	word-break: break-all;
	margin: 4px;
	padding: 4px;
}
.dashboard-section-banners .banners-container .cell.full {
	grid-column: 1 / -1;
}
.dashboard-section-banners .banners-container .banner-image {
	grid-column: 1 / 2;
}
.dashboard-section-banners .banners-container .banner-link {
	grid-column: 2 / 3;
	display: flex;
	flex-direction: column;
}
.dashboard-section-banners .banners-container .banner-link div:first-child {
	flex-grow: 2;
	display: flex;
	flex-direction: column;
}
.dashboard-section-banners .banners-container .banner-link div:first-child textarea {
	flex-grow: 1;
}
.dashboard-section-banners .banners-container .banner-link div:nth-child(2) {
	flex-grow: 1;
	display: inline-block;
	margin: 1em 0 0 0;
	align-items: center;
}
.dashboard-section-banners .banners-container .heading {
	background-color: #ffffff;
	color: 171717;
	font-weight: bold;
	word-break: break-word;
	border-bottom: 4px solid #9e9e9e;
}
.dashboard-section-banners .section-navigation-options {
	margin: 4px;
}
.dashboard-section-banners .section-navigation-options input.per-page {
	width: 4em;
}
.dashboard-section-banners .copy-to-clipboard-trigger {
	cursor: pointer;
}
.dashboard-section-banners .banners-container .button.copy-to-clipboard-trigger {
	white-space: nowrap;
}
@media only screen and (max-width: 768px) {
	.dashboard-section-banners .banners-container .heading {
		border: none;
	}
	.dashboard-section-banners .banners-container div.cell:nth-child(4) {
		border-bottom: 4px solid #9e9e9e;
	}
	.dashboard-section-banners .banners-container {
		grid-template-columns: 100%;
	}
	.dashboard-section-banners .banners-container .banner-image {
		grid-column: 1;
	}
	.dashboard-section-banners .banners-container .banner-link {
		grid-column: 1;
	}
}
</style>
