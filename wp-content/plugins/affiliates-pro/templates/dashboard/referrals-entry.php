<?php
/**
 * referrals-entry.php
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
 *   mytheme/affiliates/dashboard/referrals-entry.php
 *
 * It is highly recommended to use a child theme for such customizations.
 * Child themes are suitable to keep things up-to-date when the parent
 * theme is updated, while any customizations in the child theme are kept.
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var Affiliates_Dashboard_Referrals $section Section object available for use in the template.
 * @var array $entry Current referrals entry data available for use in the template.
 * @var int $index Index number of the current referrals entry: 0, 1, 2, ... < $section->get_per_page()
 */

$columns = $section->get_columns();
?>
<?php foreach ( $columns as $key => $column ) : ?>
	<div class="cell <?php echo ( $index === 0 ? 'first' : '' ) . ' ' . ( ( $index + 1 ) % 2 === 0 ? 'even' : 'odd' ); ?> <?php echo esc_attr( $key ); ?>" data-heading="<?php echo esc_attr( $column['title'] ); ?>">
		<?php
		switch ( $key ) {
			case 'date' :
				echo esc_html( date_i18n('Y-m-d', strtotime( $entry->datetime ) ) );
				break;
			case 'amount' :
				$display_amount = sprintf( '%.' . affiliates_get_referral_amount_decimals( 'display' ) . 'f', $entry->amount );
				echo esc_html( $entry->currency_id ) . ' ' . esc_html( $display_amount );
				break;
			case 'status' :
				switch( $entry->status ) {
					case AFFILIATES_REFERRAL_STATUS_ACCEPTED :
						$status = __( '未付', 'affiliates' );
						break;
					case AFFILIATES_REFERRAL_STATUS_CLOSED :
						$status = __( '有薪酬的', 'affiliates' );
						break;
					case AFFILIATES_REFERRAL_STATUS_PENDING :
						$status = __( '待辦的', 'affiliates' );
						break;
					case AFFILIATES_REFERRAL_STATUS_REJECTED :
						$status = __( '拒絕', 'affiliates' );
						break;
					default :
						$status = __( '未知', 'affiliates' );
				}
				echo esc_html( $status );
				break;
			case 'items' :
				if ( isset( $entry->items ) && is_array( $entry->items ) && count( $entry->items ) > 0 ) : ?>
					<div class="referral-items">
					<?php foreach ( $entry->items as $item ) :?>
						<?php $item_display_amount = sprintf( '%.' .affiliates_get_referral_amount_decimals( 'display' ) . 'f', $item['referral_item']->amount ); ?>
						<div class="referral-item">
							<div class="referral-item-title"><?php echo esc_html( $item['post']->post_title ); ?></div>
							<div class="referral-item-amount"><?php echo esc_html( $item['referral_item']->currency_id ) . ' ' . esc_html( $item_display_amount ); ?></div>
						</div>
					<?php endforeach; ?>
					</div>
				<?php else : ?>
					<div class="referral-items"><?php echo '&mdash;'; ?></div>
				<?php endif;
				break;
			default :
				echo '';
		}
		?>
	</div>
<?php endforeach;
