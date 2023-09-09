<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
# Social Login Shortcode
# [xs_social_login], [xs_social_login provider="facebook,twitter" class="test-class"]Login with Facebook[/xs_social_login]
*/ 
add_shortcode( 'xs_social_login', 'xs_create_dynamic_shortcode' );

function line_user_avatar_shortcode($atts) {
    if (is_user_logged_in()) {
        $atts = shortcode_atts(array(
            'size' => 32, // Default size is 32 pixels
        ), $atts);

        $current_user = wp_get_current_user();
        // $avatar = get_avatar($current_user->ID, $atts['size']);

        $avatar = get_user_meta($current_user->ID, 'line_app_profile_image', true);

        //  $output = '<div class="user-avatar-with-display-name" style="margin-bottom: 10px">';
        $output = '<img src="'.$avatar.'" alt="Avatar" width="'.$atts['size'].'" height="'.$atts['size'].'" style="border-radius: 50%;" width="'.$atts['size'].'"/>';
        //  $output .= '</div>';

        if ($avatar != null)
            return $output;
        else
            return "<span>No Avatar</span>";
    }
    else {
        return "";
    }
}

function line_user_display_name_shortcode($atts) {
    if (is_user_logged_in()) {

        $current_user = wp_get_current_user();

        $display_name = $current_user->first_name .' '.$current_user->last_name;

        $output = '<span class="display-name" style="margin-left: 5px">' . $display_name . '</span>';


        return $output;
    }
    else {
        return "";
    }
}

add_shortcode('line_user_avatar', 'line_user_avatar_shortcode');
add_shortcode('line_user_display_name', 'line_user_display_name_shortcode');
