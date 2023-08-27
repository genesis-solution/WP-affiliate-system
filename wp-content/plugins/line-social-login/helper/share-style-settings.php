<?php
namespace WP_Social\Helper;
use WP_Social\Traits\Singleton;

defined('ABSPATH') || exit;

class Share_Style_Settings{

    use Singleton;

    public static $post_type = ['post', 'page'];
    public function social_share_style_markup(){
           
        // $post is already set, and contains an object: the WordPress post
        global $post;
        $values = get_post_custom( $post->ID );
        $check = isset( $values['social_share_style'] ) ? esc_attr( $values['social_share_style'][0] ) : 'global';
        // We'll use this nonce field later on when saving.
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

        ?>
            <ul>
                <li>
                    <strong><?php echo esc_html__('Choose where to show share buttons.', 'wp-social') ?></strong>
                </li>
                <li>
                    <input type="radio" id="social_share_global" name="social_share_style" value="global" 
                        <?php checked( $check, 'global') ?>
                    />
                    <label for="social_share_global"> <?php echo esc_html__('Global Setting', 'wp-social') ?> </label>
                </li>

                <li>
                    <input type="radio" id="social_share_after_content" name="social_share_style" value="after_content"
                        <?php checked( $check, 'after_content') ?>
                        
                    />
                    <label for="social_share_after_content"><?php echo esc_html__('After Content', 'wp-social') ?></label>
                </li>

                <li>
                    <input type="radio" id="social_share_before_content" name="social_share_style" value="before_content"
                        <?php checked( $check, 'before_content') ?>
                    />
                    <label for="social_share_before_content"><?php echo esc_html__('Before Content', 'wp-social') ?></label>
                </li>

                <li>
                    <input type="radio" id="social_share_both" name="social_share_style" value="both_content"
                        <?php checked( $check, 'both_content') ?>  
                    />
                    <label for="social_share_both"><?php echo esc_html__('Before & After Content', 'wp-social') ?></label>
                </li>

                <li>
                    <input type="radio" id="social_share_disable" name="social_share_style" value="no_content"
                        <?php checked( $check, 'no_content') ?>
                    />
                    <label for="social_share_disable"><?php echo esc_html__('Disable', 'wp-social') ?></label>
                </li>
            </ul>

        <?php    
        
    }

    public function wp_social_share_save( $post_id ){
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


    public function wp_social_share_style_settings ($post_type, $id) {
        if( in_array($post_type, self::$post_type) ){
            add_meta_box( 'wp-social-plugin', esc_html__('WP Social Share Style Settings', 'wp-social'), [$this, 'social_share_style_markup'], $post_type , 'normal', 'high');
        }  
    }

    public function init(){
        add_action( 'add_meta_boxes', [ $this, 'wp_social_share_style_settings'] , 10, 2 );
        add_action( 'save_post', [$this, 'wp_social_share_save']);
    
    }

    public static function instance() {
		if(!self::$instance) {
			self::$instance = new static();
		}

		return self::$instance;
    }
    
}
