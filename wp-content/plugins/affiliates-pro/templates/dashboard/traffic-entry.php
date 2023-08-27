<?php
/**
 * traffic-entry.php
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
 *   mytheme/affiliates/dashboard/traffic-entry.php
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
 * @var array $entry Current traffic entry data available for use in the template.
 * @var int $index Index number of the current traffic entry: 0, 1, 2, ... < $section->get_per_page()
 */

$columns = $section->get_columns();
?>
<?php foreach ( $columns as $key => $column ) : ?>
	<div class="cell <?php echo ( $index === 0 ? 'first' : '' ) . ' ' . ( ( $index + 1 ) % 2 === 0 ? 'even' : 'odd' ); ?> <?php echo esc_attr( $key ); ?>" data-heading="<?php echo esc_attr( $column['title'] ); ?>">
		<?php
		switch ( $key ) {
			case 'date' :
				echo esc_html( $entry->date );
				break;
			case 'visits' :
				echo esc_html( $entry->visits );
				break;
			case 'hits' :
				echo esc_html( $entry->hits );
				break;
			case 'referrals' :
				echo esc_html( $entry->referrals );
				break;
			case 'src_uri' :
				$src_uri = $entry->src_uri;
				if ( $entry->src_uri !== null && strlen( $entry->src_uri ) > $section->get_src_uri_maxlength() ) {
					$src_uri = substr( $entry->src_uri, 0, $section->get_src_uri_maxlength() ) . '&hellip;';
				}
				if ( $src_uri === null || strlen( $src_uri ) === 0 ) {
					$src_uri = '&mdash;';
				}
				?><span title="<?php echo esc_attr( $entry->src_uri ); ?>"><?php echo esc_html( $src_uri ); ?></span><?php
				break;
			case 'dest_uri' :
				$dest_uri = $entry->dest_uri;
				if ( $entry->dest_uri !== null && strlen( $entry->dest_uri ) > $section->get_dest_uri_maxlength() ) {
					$dest_uri = substr( $entry->dest_uri, 0, $section->get_dest_uri_maxlength() ) . '&hellip;';
				}
				if ( $dest_uri === null || strlen( $dest_uri ) === 0 ) {
					$dest_uri = '&mdash;';
				}
				?><span title="<?php echo esc_attr( $entry->dest_uri ); ?>"><?php echo esc_html( $dest_uri ); ?></span><?php
				break;
			default :
				echo '';
		}
		?>
	</div>
<?php endforeach;
