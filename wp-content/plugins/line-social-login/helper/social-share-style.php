<?php
defined('ABSPATH') || exit;
function wp_social_share_style_settings( $post_type, $post ){
    add_meta_box( 'wp-social-plugin', esc_html__('WP Social Share Style Settings', 'wp-social'), 'social_share_style_markup', 'post', 'normal', 'high' );

    function social_share_style_markup(){
        // $post is already set, and contains an object: the WordPress post
        global $post;
        $values = get_post_custom( $post->ID );
        $check = isset( $values['social_share_style'] ) ? esc_attr( $values['social_share_style'][0] ) : 'global';
        // We'll use this nonce field later on when saving.
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

    ?>
        <ul>
            <li>
                <strong>Choose where to show share buttons.</strong>
            </li>
            <li>
                <input type="radio" id="social_share_global" name="social_share_style" value="global" 
                    <?php checked( $check, 'global') ?>
                 />
                <label for="social_share_global">Global Setting</label>
            </li>

            <li>
                <input type="radio" id="social_share_after_content" name="social_share_style" value="after_content"
                    <?php checked( $check, 'after_content') ?>
                    
                />
                <label for="social_share_after_content">After Content</label>
            </li>

            <li>
                <input type="radio" id="social_share_before_content" name="social_share_style" value="before_content"
                    <?php checked( $check, 'before_content') ?>
                />
                <label for="social_share_before_content">Before Content</label>
            </li>

            <li>
                <input type="radio" id="social_share_both" name="social_share_style" value="both_content"
                    <?php checked( $check, 'both_content') ?>  
                />
                <label for="social_share_both">Both</label>
            </li>

            <li>
                <input type="radio" id="social_share_disable" name="social_share_style" value="no_content"
                    <?php checked( $check, 'no_content') ?>
                />
                <label for="social_share_disable">Disable</label>
            </li>
        </ul>

    <?php    
    }


}

add_action( 'add_meta_boxes', 'wp_social_share_style_settings', 10, 2 );
/*
    -------------------------
    Save data
    -------------------------
*/ 

function wp_social_share_save( $post_id ){

    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
    
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    if( isset( $_POST['social_share_style'] ) ){
        update_post_meta( $post_id, 'social_share_style', sanitize_text_field( $_POST['social_share_style'] ) );
    }else{
        update_post_meta( $post_id, 'social_share_style', esc_attr( 'global' ) );
    }
}
add_action( 'save_post', 'wp_social_share_save');

