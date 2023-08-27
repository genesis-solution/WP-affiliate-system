<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
# Social Login Shortcode
# [xs_social_login], [xs_social_login provider="facebook,twitter" class="test-class"]Login with Facebook[/xs_social_login]
*/ 
add_shortcode( 'xs_social_login', 'xs_create_dynamic_shortcode' );
