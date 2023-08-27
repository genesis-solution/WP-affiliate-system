<?php

namespace WP_Social\App;


class Share {

	public function get_share_primary_content($wanted_providers, $config = []) {

		global $post;

		$postId = isset($post->ID) ? $post->ID : 0;

		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'full');
		$custom_logo_id = get_theme_mod('custom_logo');
		$image = wp_get_attachment_image_src($custom_logo_id, 'full');
		$customLogo = isset($image[0]) ? $image[0] : '';
		$media = isset($thumbnail_src[0]) ? $thumbnail_src[0] : $customLogo;
		$app_id = '';
		$details = '';
		$author = 'xpeedstudio';
		$title = get_the_title($postId);
		$source = get_bloginfo();

		$current_url = (isset($_SERVER['HTTPS']) && sanitize_text_field($_SERVER['HTTPS']) === 'on' ? 'https' : 'http') . '://' . sanitize_text_field($_SERVER['HTTP_HOST']) . sanitize_url($_SERVER['REQUEST_URI']);

		$config['conf_type'] = empty($config['conf_type']) ? 'content_body' : $config['conf_type'];

		$themeFontClass = Share_Settings::instance()->is_theme_font_enabled() ? 'wslu-theme-font-yes' : 'wslu-theme-font-no';
		$customClass = empty($config['class']) ? '' : $config['class'];

		$styles         = \WP_Social\Inc\Admin_Settings::share_styles();
		$saved_settings = \WP_Social\App\Share_Settings::instance()->get_style_settings();
		$share_settings = \WP_Social\App\Settings::instance()->get_providers_settings_share();
		$hover_styles   = \WP_Social\App\Share_Settings::instance()->get_hover_styles();
		$share_style_key        = \WP_Social\App\Share_Settings::instance()->get_selected_style_keys();
		$selected_share_style   = \WP_Social\App\Share_Settings::instance()->get_selected_style();

		$widget_style = \WP_Social\App\Share_Settings::instance()->prepare_widget_class($styles);
		$extra_data_cls = \WP_Social\App\Share_Settings::instance()->get_extra_data_class($selected_share_style, $styles);

		$show_count_markup = false;
		$total_share_count = 0;
		$share_counting = \WP_Social\App\Share_Settings::instance()->get_share_count($post, $wanted_providers);
		$core_provider = Providers::get_core_providers_share();


		ob_start();
		require(WSLU_LOGIN_PLUGIN . '/template/share/primary_content.php');
		$counter = ob_get_contents();
		ob_end_clean();

		return $counter;
	}
}
