<?php

namespace ShopEngine\Compatibility\Migrations;

defined( 'ABSPATH' ) || exit;

use ShopEngine\Core\Builders\Action;
use ShopEngine\Core\Template_Cpt;

/**
 * This migrate is run to push the direct checkout button item inside the archive product widget
 * @since 3.0.1
 */
class Direct_Checkout
{
    public function __construct()
    {
        $is_run_direct_checkout_migration = get_option( 'shopengine_direct_checkout_migration' );
        if ( !$is_run_direct_checkout_migration ) {
            $args = [
                'post_type'      => Template_Cpt::TYPE,
                'post_status'    => ['publish', 'draft', 'trash'],
                'posts_per_page' => -1,
                'meta_query'     => [
                    [
                        'key'     => Action::get_meta_key_for_type(),
                        'value'   => ['shop', 'archive'],
                        'compare' => 'IN'
                    ]
                ]
            ];

            $wp_query  = new \WP_Query( $args );
            $templates = $wp_query->posts;

            $direct_checkout = (object) [
                'list_title' => 'Direct Checkout (PRO)',
                'list_key'   => 'direct-checkout',
                '_id'        => '9c46638'
            ];

            foreach ( $templates as $template ) {
                $elementor_json = get_post_meta( $template->ID, '_elementor_data', true );
                if ( !empty( $elementor_json ) ) {
                    $elementor_demo_array = json_decode( $elementor_json );
                    foreach ( $elementor_demo_array as $section_key => $section ) {
                        foreach ( $section->elements as $column_key => $column ) {
                            foreach ( $column->elements as $widget_key => $widget ) {
                                if ( isset( $widget->widgetType ) && 'shopengine-archive-products' === $widget->widgetType ) {

                                    
                                    // Return if the settings not found
                                    if(!isset($widget->settings->shopengine_custom_ordering_list)) return;

                                    /**
                                     * Convert std object to array
                                     */
                                    $button_items = json_decode( json_encode( $widget->settings->shopengine_custom_ordering_list ), true );

                                    /**
                                     * Check if direct checkout doesn't already exist
                                     */
                                    if ( !is_int( array_search( 'direct-checkout', array_column( $button_items, 'list_key' ) ) ) ) {
                                        array_push( $elementor_demo_array[$section_key]->elements[$column_key]->elements[$widget_key]->settings->shopengine_custom_ordering_list, $direct_checkout );
                                    }


                                }
                            }
                        }
                    }
                    update_post_meta( $template->ID, '_elementor_data', json_encode( $elementor_demo_array ) );
                }
            }
            update_option( 'shopengine_direct_checkout_migration', true );
        }
    }
}
