<?php

namespace WP_Social\Helper;

defined('ABSPATH') || exit;

class View_Helper {

    /*
        --------------------------------------
        for differet tyep of yes/no switches
        -------------------------------------
    */ 

    public static function get_enable_switch($identifier, $checked = false, $onchange_dom_handler = '', $extra_class = '') {

        $id = $identifier.'_enable'; 
        $nm = 'xs_social['. $identifier .'][enable]'; ?>
        
        <input 
            class="social_switch_button social_switch_button <?php echo esc_attr($extra_class) ?>" 
            type="checkbox"
            value="1" 
            id="<?php echo esc_attr($id) ?>"           
            name="<?php echo esc_attr($nm); ?>"  
            data-key="<?php echo esc_attr($identifier); ?>" 
            <?php if(!empty($onchange_dom_handler)): ?> 
                onchange="<?php echo esc_html($onchange_dom_handler);?>(this)" 
            <?php endif;   ?>

            <?php echo esc_attr($checked ? '' : 'checked') ?> />             

            <label for="<?php echo esc_attr($id); ?>" class="social_switch_button_label"></label>
                
        <?php
    }

    /*
        --------------------------------------
        for page or post select2 dropdown list
        -------------------------------------
    */ 
    public static function get_select2_dropdown( $post_type = 'page', $status = 'publish', $default = '', $name = '' ) {

        $args = array(
            'sort_order'    => 'asc',
            'sort_column'   => 'post_title',
            'post_type'     =>  $post_type,
            'post_status'   =>  $status
        ); 

        ?> 
        <div class="wp-social-select-2-dropdown--wrapper">
            <select name="<?php echo esc_attr($name) ?>" class="wp-social-select-2-dropdown"> 
                <?php foreach( get_pages($args) as $page ): ?>
                    <option <?php echo esc_attr($page->guid == $default ? 'selected' : '')  ?>  value="<?php echo esc_url( $page->guid ) ?>"> <?php echo esc_html( $page->post_title ) ?> </option>
                <?php endforeach; ?>
            </select> 
        </div>
        <?php 
        
    } // end of get_select2_dropdown

     /*
        -----------------------
        for style card design
        -----------------------
    */ 
    public static function get_style_card( $arg ) { 

        extract($arg);
        $is_active = (isset($saved_style) && $saved_style == $style ) ? 'wslu-active' : ''; 
        $is_checked = (isset($saved_style) && $saved_style == $style ) ? 'checked' : ''; 
        $parentClass =  $is_active . ' ' . 'wslu--'.$package;
 
        ?>  
            <div class="wslu-style-card <?php echo esc_attr($parentClass) ?> ">
                <label 
                    class="wslu-style-card__label" 
                    for="wslu-style-card--<?php echo esc_attr($key) ?>"> 

                    <div class="wslu-style-card__label--image">
                        <img 
                            src="<?php echo esc_url( $image ); ?>" 
                            alt="<?php echo esc_attr( $title) ?>">
                    </div>

                    <div class="wslu-style-card__label__input">
                        <input <?php echo esc_attr( $is_checked ) ?>
                            class   = "wslu-style-card__label__input--radio" 
                            type    = "radio" 
                            id      = "wslu-style-card--<?php echo esc_attr($key) ?>" 
                            name    = "<?php echo esc_attr( $name ) ?>"
                            value   = "<?php echo esc_attr( $style ) ?>" 
                        />
                        
                        <?php 
                            echo esc_html__($title, 'wp-social');
                            if( $package == 'pro' ) echo wp_kses('<strong >(Pro Only)</strong>' , \WP_Social\Helper\Helper::get_kses_array());
                        ?>
                    </div>

                </label>
            </div>
        <?php 
    }

}
