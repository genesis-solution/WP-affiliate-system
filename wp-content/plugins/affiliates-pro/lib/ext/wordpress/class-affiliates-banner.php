<?php
/**
 * class-affiliates-banner.php
 *
 * Copyright 2014 "kento" Karim Rahimpur - www.itthinx.com
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
 * @package affiliates-pro
 * @since 2.7.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Banner post type and management.
 */
class Affiliates_Banner {

	public static function init() { add_action( 'init', array( __CLASS__, 'wp_init' ), 11 ); add_action( 'admin_init', array(__CLASS__, 'admin_init' ) ); add_shortcode( 'affiliates_banner', array( __CLASS__, 'affiliates_banner_shortcode' ) ); add_filter( 'media_view_strings', array( __CLASS__, 'media_view_strings' ), 10, 2 ); add_filter( 'upload_dir', array( __CLASS__, 'upload_dir' ) ); add_filter( 'affiliates_admin_help_show_screen', array( __CLASS__, 'affiliates_admin_help_show_screen' ), 10, 2 ); }

	public static function admin_init() { global $pagenow; add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ), 10, 2 ); add_filter( 'enter_title_here', array( __CLASS__, 'enter_title_here' ), 10, 2 ); add_action( 'edit_form_after_title', array( __CLASS__, 'edit_form_after_title' ) ); add_action( 'save_post', array( __CLASS__, 'save_post' ), 10, 2 ); add_filter( 'post_row_actions', array( __CLASS__, 'post_row_actions' ) ); add_filter( 'post_updated_messages', array( __CLASS__, 'post_updated_messages' ) ); add_filter( 'manage_affiliates_banner_posts_columns', array( __CLASS__, 'posts_columns' ) ); add_filter( 'manage_edit-affiliates_banner_columns', array( __CLASS__, 'edit_affiliates_banner_columns' ) ); add_filter( 'manage_affiliates_banner_posts_custom_column', array( __CLASS__, 'posts_custom_column' ), 10, 2 ); add_action( 'current_screen', array(__CLASS__, 'current_screen' ) ); add_filter( 'parent_file', array( __CLASS__, 'parent_file' ) ); $IX36070 = isset( $_REQUEST['screen_id'] ) ? $_REQUEST['screen_id'] : ''; $IX27059 = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : ''; if ( isset( $pagenow ) && ( $pagenow == 'admin-ajax.php' ) && ( ( $IX36070 == 'affiliates_banner' ) || ( $IX27059 == 'set-post-thumbnail' ) ) ) { if ( !has_filter( 'gettext', array( __CLASS__, 'gettext' ) ) ) { add_filter( 'gettext', array( __CLASS__, 'gettext' ), 10, 3 ); } } }

	public static function current_screen() { $IX69145 = get_current_screen(); if ( isset( $IX69145->id ) ) { switch( $IX69145->id ) { case 'edit-affiliates_banner' : case 'affiliates_banner' : if ( !has_filter( 'gettext', array( __CLASS__, 'gettext' ) ) ) { add_filter( 'gettext', array( __CLASS__, 'gettext' ), 10, 3 ); } break; } } }

	public static function parent_file( $parent_file ) { global $submenu_file; switch ( $submenu_file ) { case 'post-new.php?post_type=affiliates_banner' : case 'edit.php?post_type=affiliates_banner' : $parent_file = 'affiliates-admin'; $submenu_file = 'edit.php?post_type=affiliates_banner'; break; } return $parent_file; }

	public static function media_view_strings( $strings,  $post ) { if ( isset( $post->post_type ) && ( $post->post_type == 'affiliates_banner' ) ) { $strings['setFeaturedImageTitle'] = __( 'Set Banner Image', 'affiliates' ); $strings['setFeaturedImage'] = __( 'Set banner image', 'affiliates' ); } return $strings; }

	public static function gettext( $translations, $text, $domain ) { if ( $domain === 'affiliates' ) { remove_filter( 'gettext', array( __CLASS__, 'gettext' ) ); switch( $text ) { case '(no title)' : $translations = __( '(no reference)', 'affiliates' ); break; case 'Set featured image' : $translations = __( 'Set banner image', 'affiliates' ); break; case 'Remove featured image' : $translations = __( 'Remove banner image', 'affiliates' ); break; } add_filter( 'gettext', array( __CLASS__, 'gettext'), 10, 3 ); } return $translations; }

	public static function posts_columns( $posts_columns ) { foreach( $posts_columns as $IX19178 => $IX13722 ) { switch( $IX19178 ) { case 'title' : $posts_columns[$IX19178] = __( '橫幅', 'affiliates' ); break; } } return $posts_columns; }

	public static function edit_affiliates_banner_columns( $columns ) { if ( isset( $columns['date'] ) ) { $IX82912 = $columns['date']; unset( $columns['date'] ); } $columns['image'] = __( '圖像', 'affiliates' ); $columns['shortcode'] = __( '短代碼', 'affiliates' ); if ( isset( $IX82912 ) ) { $columns['date'] = $IX82912; } return $columns; }

	public static function posts_custom_column( $column_name, $post_id ) { global $affiliates_banner_admin_style_flag; if ( !isset( $affiliates_banner_admin_style_flag ) ) { $affiliates_banner_admin_style_flag = true; echo '<style type="text/css">'; echo 'th.column-title { width: 15%; }'; echo 'td.image.column-image { overflow: hidden; }'; echo '</style>'; } switch( $column_name ) { case 'image' : $IX28342 = get_the_post_thumbnail( $post_id ); if ( empty( $IX28342 ) ) { $IX28342 = self::get_url_thumbnail( $post_id ); } printf( '<a href="%s">%s</a>', esc_attr( get_edit_post_link( $post_id ) ), $IX28342 ); break; case 'shortcode' : echo '<p>'; printf( __( '<code>[affiliates_banner id="%d"]</code>', 'affiliates' ), $post_id ); echo '</p>'; break; } }

	public static function get_url_thumbnail( $post_id ) { $IX24524 = get_post_meta( $post_id, 'url', true ); $IX52763 = get_post_meta( $post_id, 'width', true ); $IX77297 = get_post_meta( $post_id, 'height', true ); if ( $IX52763 !== '' && $IX77297 !== '' ) { list( $IX52763, $IX77297 ) = image_constrain_size_for_editor( $IX52763, $IX77297, $IX50173 = 'thumbnail' ); } $IX21133 = sprintf( '<img src="%s" width="%d" height="%d" />', $IX24524, $IX52763, $IX77297 ); return $IX21133; }

	public static function get_url_image( $post_id, $alt ) { $IX67754 = get_post_meta( $post_id, 'url', true ); $IX19125 = get_post_meta( $post_id, 'width', true ); $IX82108 = get_post_meta( $post_id, 'height', true ); $IX26288 = sprintf( '<img src="%s" width="%d" height="%d" alt="%s" />', $IX67754, intval( $IX19125 ), intval( $IX82108 ), esc_attr( $alt ) ); return $IX26288; }

	public static function wp_init() { self::post_type(); }

	public static function post_type() { register_post_type( 'affiliates_banner',
        array( 'labels' => array( 'name' => __( '橫幅', 'affiliates' ),
            'singular_name' => __( '橫幅', 'affiliates' ),
            'all_items' => __( '橫幅', 'affiliates' ), 'add_new' => __( '新旗幟', 'affiliates' ),
            'add_new_item' => __( '添加新橫幅', 'affiliates' ), 'edit' => __( '編輯', 'affiliates' ),
            'edit_item' => __( '編輯橫幅', 'affiliates' ),
            'new_item' => __( '新旗幟', 'affiliates' ),
            'not_found' => __( '未找到橫幅', 'affiliates' ),
            'not_found_in_trash' => __( '垃圾箱中未發現橫幅', 'affiliates' ),
            'parent' => __( '家長橫幅', 'affiliates' ),
            'search_items' => __( '搜索橫幅', 'affiliates' ),
            'view' => __( '查看橫幅', 'affiliates' ),
            'view_item' => __( '查看橫幅', 'affiliates' ),
            'menu_name' => __( '橫幅', 'affiliates' ) ),
            'capability_type' => array( 'affiliates_banner', 'affiliates_banners' ),
            'description' => __( '聯盟橫幅', 'affiliates' ),
            'exclude_from_search' => true, 'has_archive' => false, 'hierarchical' => false, 'map_meta_cap' => true,
            'public' => false, 'publicly_queryable' => false, 'query_var' => true, 'rewrite' => false,
            'show_in_nav_menus' => false, 'show_ui' => true, 'supports' => array( 'title', 'thumbnail' ), 'show_in_menu' => false, ) );
        self::create_capabilities(); }

	public static function create_capabilities() { global $wp_roles; $IX21752 = $wp_roles->get_role( 'administrator' ); $IX24812 = self::get_capabilities(); foreach( $IX24812 as $IX53287 => $IX58421 ) { if ( !$IX21752->has_cap( $IX58421 ) ) { $IX21752->add_cap( $IX58421 ); } } }

	public static function get_capabilities() { return array( 'edit_posts' => 'edit_affiliates_banners', 'edit_others_posts' => 'edit_others_affiliates_banners', 'publish_posts' => 'publish_affiliates_banners', 'read_private_posts' => 'read_private_affiliates_banners', 'delete_posts' => 'delete_affiliates_banners', 'delete_private_posts' => 'delete_private_affiliates_banners', 'delete_published_posts' => 'delete_published_affiliates_banners', 'delete_others_posts' => 'delete_others_affiliates_banners', 'edit_private_posts' => 'edit_private_affiliates_banners', 'edit_published_posts' => 'edit_published_affiliates_banners', ); }

	public static function add_meta_boxes( $post_type, $post ) { if ( $post_type == 'affiliates_banner' ) { remove_meta_box( 'postimagediv', 'affiliates_banner', 'side' ); add_meta_box( 'postimagediv', __('橫幅圖片', 'affiliates' ), array( __CLASS__, 'post_thumbnail_meta_box' ), 'affiliates_banner', 'normal', 'high' ); add_meta_box( 'url', __('網址', 'affiliates' ), array( __CLASS__, 'url_meta_box' ), 'affiliates_banner', 'normal', 'high' ); } }

	public static function enter_title_here( $title, $post ) { if ( $post->post_type == 'affiliates_banner' ) { return __( '橫幅參考 &hellip;', 'affiliates' ); } return $title; }

	public static function edit_form_after_title( $post ) { if ( isset( $post->post_type ) && $post->post_type == 'affiliates_banner' ) { echo '<div style="padding:2px 1em 1em 1em;" class="description">'; echo '<p>'; echo __( '此橫幅的引用（也用作 URL 指定的圖像的 <em>alt</em> 屬性）。', 'affiliates' ); echo '</p>'; echo '<p>'; echo __( '使用<strong>橫幅圖像</strong>工具設置橫幅圖像並直接為圖像附件確定其標題和其他屬性。', 'affiliates' ); echo '</p>'; if ( isset( $post->ID ) ) { echo '<p>'; printf( __( '使用此短代碼嵌入橫幅：<code>[affiliates_banner id="%d"]</code>', 'affiliates' ), $post->ID ); echo '</p>'; } echo '</div>'; } }

	public static function url_meta_box( $post ) { $IX19953 = ''; $IX18362 = get_post_meta( $post->ID, 'url', true ); $IX59779 = get_post_meta( $post->ID, 'width', true ); $IX85908 = get_post_meta( $post->ID, 'height', true ); $IX98782 = get_post_meta( $post->ID, 'update_size', true ); if ( empty( $IX98782 ) ) { $IX98782 = 'yes'; } $IX19953 .= '<div>'; $IX19953 .= '<p>'; $IX19953 .= __( '或者，可以指定橫幅圖像 URL。', 'affiliates' ); $IX19953 .= ' '; $IX19953 .= __( '如果您想使用外部圖像或位於上傳目錄結構之外的圖像，這非常有用。', 'affiliates' ); $IX19953 .= ' '; $IX19953 .= __( '如果設置了橫幅圖像，則它優先 - 僅在未設置橫幅圖像時使用。', 'affiliates' ); $IX19953 .= '</p>'; $IX19953 .= '</div>'; $IX19953 .= '<div>'; $IX19953 .= self::get_url_thumbnail( $post->ID ); $IX19953 .= '</div>'; $IX19953 .= '<div>'; $IX19953 .= '<label>'; $IX19953 .= __('網址', 'affiliates' ); $IX19953 .= ' '; $IX19953 .= sprintf( '<input style="display:block; width:100%%" type="text" name="url" value="%s" />', esc_attr( $IX18362 ) ); $IX19953 .= '</label>'; $IX19953 .= '<p class="description">'; $IX19953 .= __( '橫幅圖像 URL。', 'affiliates' ); $IX19953 .= '</p>'; $IX19953 .= '</div>'; $IX19953 .= '<div>'; $IX19953 .= '<label>'; $IX19953 .= sprintf( '<input type="checkbox" name="update_size" value="1" %s />', $IX98782 == 'yes' ? ' checked="checked" ' : '' ); $IX19953 .= ' '; $IX19953 .= __( '更新大小', 'affiliates' ); $IX19953 .= '</label>'; $IX19953 .= '<p class="description">'; $IX19953 .= __( 'Try to obtain the image width and height based on the URL and update the values.', 'affiliates' ); $IX19953 .= '</p>'; $IX19953 .= '</div>'; $IX19953 .= '<div>'; $IX19953 .= '<label>'; $IX19953 .= __( 'Width', 'affiliates' ); $IX19953 .= ' '; $IX19953 .= sprintf( '<input style="display:block; width:5em" type="text" name="width" value="%s" />', esc_attr( $IX59779 ) ); $IX19953 .= '</label>'; $IX19953 .= '<p class="description">'; $IX19953 .= __( 'Banner image width in pixels.', 'affiliates' ); $IX19953 .= '</p>'; $IX19953 .= '</div>'; $IX19953 .= '<div>'; $IX19953 .= '<label>'; $IX19953 .= __( 'Height', 'affiliates' ); $IX19953 .= ' '; $IX19953 .= sprintf( '<input style="display:block; width:5em" type="text" name="height" value="%s" />', esc_attr( $IX85908 ) ); $IX19953 .= '</label>'; $IX19953 .= '<p class="description">'; $IX19953 .= __( 'Banner image height in pixels.', 'affiliates' ); $IX19953 .= '</p>'; $IX19953 .= '</div>'; echo $IX19953; }

	public static function save_post( $post_id = null, $post = null ) { if ( ! ( ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) ) ) { if ( $post->post_type == 'affiliates_banner' ) { if ( $post->post_status != 'auto-draft' ) { if ( isset( $_REQUEST['action'] ) && ( $_REQUEST['action'] == 'inline-save' ) ) { return; } $IX51227 = !empty( $_POST['url'] ) ? trim( $_POST['url'] ) : ''; delete_post_meta( $post_id, 'url' ); if ( !empty( $IX51227 ) ) { add_post_meta( $post_id, 'url', $IX51227 ); } $IX98514 = !empty( $_POST['update_size'] ) ? 'yes' : 'no'; delete_post_meta( $post_id, 'update_size' ); add_post_meta( $post_id, 'update_size', $IX98514 ); $IX76757 = null; $IX35654 = null; if ( $IX98514 == 'yes' ) { if ( !empty( $IX51227 ) ) { if ( $IX89119 = getimagesize( $IX51227 ) ) { if ( isset( $IX89119[0] ) ) { $IX76757 = $IX89119[0]; } if ( isset( $IX89119[1] ) ) { $IX35654 = $IX89119[1]; } } } } if ( $IX76757 === null ) { $IX76757 = !empty( $_POST['width'] ) ? intval( trim( $_POST['width'] ) ) : 0; } delete_post_meta( $post_id, 'width' ); if ( $IX76757 > 0 ) { add_post_meta( $post_id, 'width', $IX76757 ); } if ( $IX35654 === null ) { $IX35654 = !empty( $_POST['height'] ) ? intval( trim( $_POST['height'] ) ) : 0; } delete_post_meta( $post_id, 'height' ); if ( $IX35654 > 0 ) { add_post_meta( $post_id, 'height', $IX35654 ); } } } } }

	public static function post_row_actions( $actions ) { $IX16102 = get_post_type(); if ( $IX16102 == 'affiliates_banner' ) { unset( $actions['view'] ); } return $actions; }

	public static function post_updated_messages( $messages ) { $IX68495 = get_post(); $messages['affiliates_banner'] = array( 0 => '', 1 => __( 'Banner updated.', 'affiliates' ), 2 => __( 'Custom field updated.', 'affiliates' ), 3 => __( 'Custom field deleted.', 'affiliates' ), 4 => __( 'Banner updated.', 'affiliates' ), 5 => isset( $_GET['revision'] ) ? sprintf( __( 'Banner restored to revision from %s', 'affiliates' ), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false, 6 => __( 'Banner published.', 'affiliates' ), 7 => __( 'Banner saved.', 'affiliates' ), 8 => __( 'Banner submitted.', 'affiliates' ), 9 => sprintf( __( 'Banner scheduled for: <strong>%1$s</strong>.', 'affiliates' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $IX68495->post_date ) ) ), 10 => __( 'Banner draft updated.', 'affiliates' ) ); return $messages; }

	public static function affiliates_banner_shortcode( $atts, $content = '' ) { $IX69736 = shortcode_atts( array( 'id' => '*', 'url' => '', 'render' => '' ), $atts ); $IX23054 = ''; $IX15107 = trim( $IX69736['url'] ); $IX64735 = trim( $IX69736['id'] ); $IX91255 = trim( $IX69736['render'] ); $IX24984 = array_map( 'trim', explode( ',', $IX15107 ) ); $IX69337 = array(); if ( trim( $IX64735 ) == '*' ) { $IX54108 = array( 'numberposts' => -1, 'post_type' => 'affiliates_banner', 'post_status' => 'publish', 'suppress_filters' => false ); $IX90264 = get_posts( apply_filters( 'affiliates_banner_shortcode_get_posts', $IX54108 ) ); foreach( $IX90264 as $IX87905 ) { if ( get_post_thumbnail_id( $IX87905->ID ) || get_post_meta( $IX87905->ID, 'url', true ) ) { $IX69337[] = $IX87905->ID; } } } else { $IX69337 = array_map( 'intval', array_map( 'trim', explode( ',', $IX64735 ) ) ); } $IX10202 = array(); $IX76208 = 0; foreach( $IX69337 as $IX12026 ) { if ( isset( $IX24984[$IX76208] ) ) { if ( !empty( $IX24984[$IX76208] ) ) { $IX10202['url'] = $IX24984[$IX76208]; } } $IX15107 = Affiliates_Url_Renderer_WordPress::render_affiliate_url( $IX10202 ); add_filter( 'wp_get_attachment_image_attributes', array( __CLASS__, 'wp_get_attachment_image_attributes' ), 999, 2 ); $IX49475 = get_the_post_thumbnail( $IX12026, 'full', array( 'class' => '' ) ); if ( empty( $IX49475 ) ) { $IX49646 = get_the_title( $IX12026 ); $IX49475 = self::get_url_image( $IX12026, $IX49646 ); } $IX32428 = sprintf( '<a href="%s">%s</a>', esc_attr( $IX15107 ), $IX49475 ); remove_filter( 'wp_get_attachment_image_attributes', array( __CLASS__, 'wp_get_attachment_image_attributes' ) ); $IX23054 .= apply_filters( 'affiliates_banner_before', '', $atts ); $IX23054 .= '<div class="affiliates-banner">'; if ( empty( $IX91255 ) || ( $IX91255 == 'image' ) ) { $IX23054 .= apply_filters( 'affiliates_banner_image_before', '', $IX64735, $IX15107, $atts ); $IX23054 .= apply_filters( 'affiliates_banner_image', '<div class="banner-image">' . $IX49475 . '</div>', $IX64735, $IX15107, $atts ); $IX23054 .= apply_filters( 'affiliates_banner_image_after', '', $IX64735, $IX15107, $atts ); } if ( empty( $IX91255 ) || ( $IX91255 == 'code' ) ) { $IX23054 .= apply_filters( 'affiliates_banner_code_before', '', $IX64735, $IX15107, $atts ); $IX23054 .= apply_filters( 'affiliates_banner_code', '<div class="banner-code">' . '<code>' . htmlentities( $IX32428 ) . '</code>' . '</div>', $IX64735, $IX15107, $atts ); $IX23054 .= apply_filters( 'affiliates_banner_code_after', '', $IX64735, $IX15107, $atts ); } $IX23054 .= '</div>'; $IX23054 .= apply_filters( 'affiliates_banner_after', '', $atts ); $IX76208++; } $IX23054 = apply_filters( 'affiliates_banner', $IX23054, $atts ); return $IX23054; }

	public static function wp_get_attachment_image_attributes( $attr, $attachment ) { unset( $attr['class'] ); return $attr; }

	public static function post_thumbnail_meta_box( $post ) { $IX34081 = get_post_meta( $post->ID, '_thumbnail_id', true ); echo self::_wp_post_thumbnail_html( $IX34081, $post->ID ); }

	public static function _wp_post_thumbnail_html( $thumbnail_id = null, $post = null ) { global $content_width, $_wp_additional_image_sizes; $post = get_post( $post ); $IX25639 = esc_url( get_upload_iframe_src('image', $post->ID ) ); $IX74079 = '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set banner image', 'affiliates' ) . '" href="%s" id="set-post-thumbnail" class="thickbox">%s</a></p>'; $IX54837 = sprintf( $IX74079, $IX25639, esc_html__( 'Set banner image', 'affiliates' ) ); if ( $thumbnail_id && get_post( $thumbnail_id ) ) { $IX43318 = $content_width; $content_width = 266; if ( !isset( $_wp_additional_image_sizes['full'] ) ) { $IX75188 = wp_get_attachment_image( $thumbnail_id, array( $content_width, $content_width ) ); } else { $IX75188 = wp_get_attachment_image( $thumbnail_id, 'full' ); } if ( !empty( $IX75188 ) ) { $IX10382 = wp_create_nonce( 'set_post_thumbnail-' . $post->ID ); $IX54837 = sprintf( $IX74079, $IX25639, $IX75188 ); $IX54837 .= '<p class="hide-if-no-js"><a href="#" id="remove-post-thumbnail" onclick="WPRemoveThumbnail(\'' . $IX10382 . '\');return false;">' . esc_html__( 'Remove banner image', 'affiliates' ) . '</a></p>'; } $content_width = $IX43318; } return apply_filters( 'admin_post_thumbnail_html', $IX54837, $post->ID ); }

	public static function upload_dir( $params ) { global $post, $post_id; if ( empty( $post_id ) ) { if ( !empty( $post ) && isset( $post->ID ) ) { $post_id = $post->ID; } else { $post_id = !empty( $_REQUEST['post_id'] ) ? intval( $_REQUEST['post_id'] ) : null; } } if ( !empty( $post_id ) && ( get_post_type( $post_id ) == 'affiliates_banner' ) ) { if ( apply_filters( 'affiliates_banner_empty_subdir', true ) ) { $params['subdir'] = ''; $params['path'] = $params['basedir'] . '/banners'; $params['url'] = $params['baseurl'] . '/banners'; } else { if ( empty( $params['subdir'] ) ) { $params['path'] = $params['path'] . '/banners'; $params['url'] = $params['url'] . '/banners'; $params['subdir'] = '/banners'; } else { $IX92955 = '/banners' . $params['subdir']; $params['path'] = str_replace( $params['subdir'], $IX92955, $params['path'] ); $params['url'] = str_replace( $params['subdir'], $IX92955, $params['url'] ); $params['subdir'] = str_replace( $params['subdir'], $IX92955, $params['subdir'] ); } } } return $params; }

	/**
	 * Filter to show help.
	 *
	 * @param boolean $show
	 * @param string $screen_id
	 *
	 * @return boolean
	 */
	public static function affiliates_admin_help_show_screen( $show, $screen_id ) { return $show || strpos( $screen_id, 'affiliates_banner' ) !== false; }
}
Affiliates_Banner::init();
