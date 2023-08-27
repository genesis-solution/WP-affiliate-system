<?php

namespace WP_Social\Inc;

use WP_Social\App\Providers;
use WP_Social\App\Settings;
use WP_Social\App\Share_Settings;
use WP_Social\Lib\Provider\Share_Factory;

defined('ABSPATH') || exit;

/**
 * Class Name : Share;
 * Class Details : this class for showing login button in login and register page for wp, woocommerce, buddyPress and others
 *
 * @params : void
 * @return : void
 *
 * @since : 1.0
 */
class Share {

	private $app_key = ['c5752d2f90b7c95dd6fcf1ffc82a8fbb68d8c9e8', '1934f519a63e142e0d3c893e59cc37fe0172e98a'];
	private $api_url = 'https://api.sharedcount.com/v1.0/?url=%s&apikey=%s';

	public function __construct($load = true) {

		if($load) {
			//add_filter( 'plugin_row_meta', array( $this, 'xs_plugin_row_meta' ), 10, 2 );

			add_shortcode('xs_social_share', [$this, 'social_share_shortcode']);

			add_action('the_content', [$this, 'share_the_body_content']);
			//add_action('wp_body_open', [ $this, 'share_the_body_content_body' ] );

			add_action('wp_footer', [$this, 'share_the_body_content_body']);
		}
	}

	/*
	 body and content
	*/
	public function share_the_body_content($content = '') {

		if(Share_Settings::instance()->is_share_content_enabled()) {

			$position = Share_Settings::instance()->get_share_content_position();

			/*
				check indiviaual social share style positon
			*/
			Global $post;
			$page_position = get_post_custom( $post->ID );
			if( isset($page_position['social_share_style'][0]) ){
				$inner_position = $page_position['social_share_style'][0];
				if( $inner_position !== 'global'){
					$position = $inner_position;
				}
			}


			$get_content = $this->get_share_data('all', ['class' => $position]);

			if($position == 'after_content') {

				return $content . $get_content;
			}

			if($position == 'before_content') {

				return $get_content . $content;
			}

			if($position == 'both_content'){
				return $get_content . $content . $get_content;
			}
		}

		return $content;
	}


	/**
	 * This will give the html for fixed share
	 *
	 * @author UnKnown
	 *
	 */
	public function share_the_body_content_body() {

		$style = get_option('xs_style_setting_data_share', '');
		$content_position = isset($style['login_button_content']) ? $style['login_button_content'] : '';

		if(in_array($content_position, ['left_content', 'right_content', 'top_content', 'bottom_content'])) {

			// set default type fixed_display for body
			echo $this->get_share_data('all', ['class' => $content_position, 'type' => 'fixed_display']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --  It's already has been escaped from the /template/share/share-html.php
		}
	}


	public function social_share_action($post_url = '', $id_post = 0) {


		$option_key = 'xs_share_providers_data';
		$xsc_options = get_option($option_key) ? get_option($option_key) : [];
		$share_provider = isset($xsc_options['social']) ? $xsc_options['social'] : '';

		if(empty($post_url) || $id_post == 0) {
			return '';
		}
		$cache = 12;

		$api_key_set = 'c5752d2f90b7c95dd6fcf1ffc82a8fbb68d8c9e8';

		$get_transient = get_transient('xs_share_data__' . $id_post);
		$get_transient_time = get_transient('timeout_xs_share_data__' . $id_post);

		$prev_data = get_post_meta($id_post, 'xs_share_data__', true) ? get_post_meta($id_post, 'xs_share_data__', true) : [];


		if($get_transient_time > time()) {
			return '';
		}

		$url = sprintf($this->api_url, $post_url, $api_key_set);

		$get_request = wp_remote_get($url, []);
		$request = wp_remote_retrieve_body($get_request);
		$api_call = @json_decode($request, true);

		$return = [];
		$xsc_transient = [];

		if(is_array($share_provider) && sizeof($share_provider) > 0) :
			foreach($share_provider as $k => $v) :
				if(isset($v['enable'])) {
					$before_data = isset($prev_data[$k]) ? $prev_data[$k] : 0;
					if(!empty($get_transient[$k])) {
						$result = $get_transient[$k];
					} else {
						if($k == 'facebook') {
							$result = isset($api_call['Facebook']['share_count']) ? $api_call['Facebook']['share_count'] : $before_data;
						} else {
							if($k == 'pinterest') {
								$result = isset($api_call['Pinterest']) ? $api_call['Pinterest'] : $before_data;
							} else {
								if($k == 'linkedin') {
									$result = isset($api_call['LinkedIn']) ? $api_call['LinkedIn'] : $before_data;
								} else {
									if($k == 'stumbleUpon') {
										$result = isset($api_call['StumbleUpon']) ? $api_call['StumbleUpon'] : $before_data;
									} else {
										$result = 0;
									}
								}
							}
						}
					}
					$return[$k] = $result;
					$xsc_transient[$k] = $result;
				}
			endforeach;
		endif;

		update_post_meta($id_post, 'xs_share_data__', $return);

		set_transient('xs_share_data__' . $id_post, $xsc_transient, $cache * 60 * 60);
	}


	/**
	 * Return Content for shortCode
	 *
	 * @author UnKnown
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function social_share_shortcode($atts, $content = null) {

		$atts = shortcode_atts(
			array(
				'provider' => 'all',
				'class'    => '',
				'style'    => '',
				'hover'    => '',
				'layout'   => 'horizontal',
				'count'    => 'No',
				'box_only' => '',
			),
			$atts,
			'xs_social_share'
		);

		if(empty(trim($atts['provider'])) || $atts['provider'] == 'all') {
			$provider = 'all';
		} else {
			$provider = explode(',', strtolower($atts['provider']));
		}

		$config = [];
		$config['class'] = trim($atts['class']);
		$config['style'] = trim($atts['style']);
		$config['hover'] = trim($atts['hover']);
		$config['hv_effect'] = trim($atts['layout']);
		$config['show_count'] = ucfirst(strtolower(trim($atts['count'])));
		$config['show_count'] = in_array($config['show_count'], ['Yes', 'No']) ? $config['show_count'] : 'No';
		$config['conf_type'] = 'shortCode';

		return $this->get_share_data($provider, $config);
	}


	/**
	 *
	 * @param string $provider
	 * @param array $config
	 *
	 * @return string
	 */
	public function get_share_data($provider = 'all', $config = []) {

		global $post;

		$postId = isset($post->ID) ? $post->ID : 0;


		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'full');
		$custom_logo_id = get_theme_mod('custom_logo');
		$image = wp_get_attachment_image_src($custom_logo_id, 'full');
		$customLogo = isset($image[0]) ? $image[0] : '';
		$media = isset($thumbnail_src[0]) ? $thumbnail_src[0] : $customLogo;
		$app_id = '2577123062406162';
		$details = '';
		$author = 'xpeedstudio';
		$title = get_the_title($postId);
		$source = get_bloginfo();


		$config['conf_type'] = empty($config['conf_type']) ? 'content_body' : $config['conf_type'];


		$core_provider  = Providers::get_core_providers_share();
		$provider       = ($provider == 'all') ? array_keys($core_provider) : $provider;


		$themeFontClass = Share_Settings::instance()->is_theme_font_enabled() ? 'wslu-theme-font-yes' : 'wslu-theme-font-no';
		$customClass    = empty($config['class']) ? '' : $config['class'];

		$saved_style_settings = Settings::instance()->get_share_style_settings();
		//$saved_global_settings = Settings::instance()->get_share_main_settings();
		//$saved_provider_settings = Settings::instance()->get_share_provider_settings();


		$styles = \WP_Social\Inc\Admin_Settings::share_styles();
		$hvStyles = \WP_Social\Inc\Admin_Settings::$horizontal_style;

		$hoverStyles = [
			'none-none' => [
				'name'  => 'None',
				'class' => 'wslu-none',
			],
		];

		if(did_action('wslu_social_pro/plugin_loaded') && class_exists('\WP_Social_Pro\Inc\Admin_Settings')) {

			if( method_exists( \WP_Social_Pro\Inc\Admin_Settings::class, 'share_hover_effects' ) ){

				$hoverStyles = \WP_Social_Pro\Inc\Admin_Settings::share_hover_effects();

			}else{

				$hoverStyles = \WP_Social_Pro\Inc\Admin_Settings::$share_hover_effects;
				
			}

		}

		//defaults values
		$showCountMarkup = false;
		$shareStyleKey = 'style-1';
		$shareHoverKey = 'none-none';
		$vhEffectKey = 'horizontal';
		$fixedWidget_style = 'main_content';
		$displayCls = 'wslu-fixed_display';


		if($config['conf_type'] == 'widget') {

			#content for widget.....
			#from widget we always hiding total markup
			#always main style........................

			if(isset($config['show_count']) && $config['show_count'] === 'yes') {
				$showCountMarkup = true;
			}else {
				$showCountMarkup = false;
			}
			$fixed_display = 'main_content';
			$displayCls = 'wslu-main_content';

			$shareStyleKey = empty($config['style']) ? $shareStyleKey : $config['style']; //after resetting the plugin style-1 will be assigned
			$shareHoverKey = empty($config['hover']) ? $shareHoverKey : $config['hover'];
			$vhEffectKey = empty($config['hv_effect']) ? $vhEffectKey : $config['hv_effect'];

			$mainStyleCls = isset($styles[$shareStyleKey]['class']) ? 'wslu-' . $shareStyleKey . ' ' . $styles[$shareStyleKey]['class'] : '';
			$hoverEffect = empty($hoverStyles[$shareHoverKey]) ? $hoverStyles['none-none']['class'] : $hoverStyles[$shareHoverKey]['class'];
			$vhClass = $hvStyles[$vhEffectKey]['class'];

			$widget_style = $mainStyleCls . ' ' . $hoverEffect . ' ' . $vhClass . ' ' . $themeFontClass . ' ' . $displayCls;

		} elseif($config['conf_type'] == 'shortCode') {

			$fixed_display = 'main_content';
			$displayCls = 'wslu-main_content';

			#here always be the main display settings......
			$shareStyleKeys = empty($saved_style_settings['main_content']['style']) ?
				$shareStyleKey . ':' . $shareHoverKey . ':' . $vhEffectKey : $saved_style_settings['main_content']['style'];

			$bArr = explode(':', $shareStyleKeys);

			#Overridden by short-code attribute
			$shareStyleKey = empty($config['style']) ? $bArr[0] : $config['style'];
			$shareHoverKey = empty($config['hover']) ? $bArr[1] : $config['hover'];
			$vhEffectKey = empty($config['hv_effect']) ? $bArr[2] : $config['hv_effect'];

			$mainStyleCls = isset($styles[$shareStyleKey]['class']) ? 'wslu-' . $shareStyleKey . ' ' . $styles[$shareStyleKey]['class'] : '';
			$hoverEffect = empty($hoverStyles[$shareHoverKey]) ? $hoverStyles['none-none']['class'] : $hoverStyles[$shareHoverKey]['class'];
			$vhClass = empty($hvStyles[$vhEffectKey]) ? $hvStyles['horizontal']['class'] : $hvStyles[$vhEffectKey]['class'];

			$widget_style = $mainStyleCls . ' ' . $hoverEffect . ' ' . $vhClass . ' ' . $themeFontClass . ' ' . $displayCls;

			$showCountMarkup = $config['show_count'] == 'Yes';

		} else {

			//for appending/prepending to main content

			$fixed_display = isset($config['type']) ? $config['type'] : 'main_content';

			if($fixed_display == 'fixed_display') {

				$shareStyleKey = 'style-1';    //defaults values
				$shareHoverKey = 'none-none';
				$vhEffectKey = 'vertical';
				$displayCls = 'wslu-fixed_display';

				$shareStyleKeys = empty($saved_style_settings['fixed_display']['style']) ?
					$shareStyleKey . ':' . $shareHoverKey . ':' . $vhEffectKey : $saved_style_settings['fixed_display']['style'];

				$bArr = explode(':', $shareStyleKeys);

				$shareStyleKey = $bArr[0];
				$shareHoverKey = $bArr[1];
				$vhEffectKey = $bArr[2];

				$mainStyleCls = isset($styles[$shareStyleKey]['class']) ? 'wslu-' . $shareStyleKey . ' ' . $styles[$shareStyleKey]['class'] : '';
				$hoverEffect = empty($hoverStyles[$shareHoverKey]) ? $hoverStyles['none-none']['class'] : $hoverStyles[$shareHoverKey]['class'];
				$vhClass = $hvStyles[$vhEffectKey]['class'];

				$widget_style = $mainStyleCls . ' ' . $hoverEffect . ' ' . $vhClass . ' ' . $themeFontClass . ' ' . $displayCls;


				$showFixedDisplaySC = empty($config['fixed_share_count']) ?
					(empty($saved_style_settings['fixed_display']['show_social_count_share']) ? '0' :
						$saved_style_settings['fixed_display']['show_social_count_share']) :
					$config['fixed_share_count'];

				$showCountMarkup = $showFixedDisplaySC == '1';

			} else {

				$shareStyleKeys = empty($saved_style_settings['main_content']['style']) ?
					$shareStyleKey . ':' . $shareHoverKey . ':' . $vhEffectKey :
					$saved_style_settings['main_content']['style'];

				$bArr = explode(':', $shareStyleKeys);

				$shareStyleKey = $bArr[0];
				$shareHoverKey = $bArr[1];
				$vhEffectKey = $bArr[2];
				$displayCls = 'wslu-main_content';

				$mainStyleCls = isset($styles[$shareStyleKey]['class']) ? 'wslu-' . $shareStyleKey . ' ' . $styles[$shareStyleKey]['class'] : '';
				$hoverEffect = empty($hoverStyles[$shareHoverKey]) ? $hoverStyles['none-none']['class'] : $hoverStyles[$shareHoverKey]['class'];
				$vhClass = $hvStyles[$vhEffectKey]['class'];

				$widget_style = $mainStyleCls . ' ' . $hoverEffect . ' ' . $vhClass . ' ' . $themeFontClass . ' ' . $displayCls;

				$showMainDisplaySC = empty($config['main_share_count']) ?
					(empty($saved_style_settings['main_content']['show_social_count_share']) ? '0' :
						$saved_style_settings['main_content']['show_social_count_share']) :
					$config['main_share_count'];

				$showCountMarkup = $showMainDisplaySC == '1';
			}
		}


		$enabled_providers = Settings::instance()->get_enabled_providers_share();
		$share_counting = [];

		$currentUrl = (isset($_SERVER['HTTPS']) && sanitize_text_field($_SERVER['HTTPS']) === 'on' ? 'https' : 'http') . '://' . sanitize_text_field($_SERVER['HTTP_HOST']) . sanitize_url($_SERVER['REQUEST_URI']);

		$share_counting = Share_Settings::instance()->get_share_count($post, $enabled_providers);


		$totalSCount = 0;

		if($showCountMarkup) {

			foreach($enabled_providers as $key => $arr) {
				if(!empty($arr['enable'])) {
					$totalSCount += $share_counting[$key]['count'];
				}
			}
		}


		if(!empty($post->post_excerpt)) {

			$details = $post->post_excerpt;
		}


		ob_start();
		require(WSLU_LOGIN_PLUGIN . '/template/share/share-html.php');
		$counter = ob_get_contents();
		ob_end_clean();

		return $counter;
	}


	/**
	 * This function should be replace with Providers::get_core_providers_share() methods for all places
	 *
	 */
	public function social_share_link() {

		$link = [];
		$link['facebook'] = ['label' => 'Facebook', 'url' => 'http://www.facebook.com/sharer.php', 'params' => ['u' => '[%url%]', 't' => '[%title%]', 'v' => 3]];
		$link['twitter'] = ['label' => 'Twitter', 'url' => 'https://twitter.com/intent/tweet', 'params' => ['text' => '[%title%] [%url%]', 'original_referer' => '[%url%]', 'related' => '[%author%]']];
		$link['linkedin'] = ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/shareArticle', 'params' => ['url' => '[%url%]', 'title' => '[%title%]', 'summary' => '[%details%]', 'source' => '[%source%]', 'mini' => true]];
		$link['pinterest'] = ['label' => 'Pinterest', 'url' => 'https://pinterest.com/pin/create/button/', 'params' => ['url' => '[%url%]', 'media' => '[%media%]', 'description' => '[%details%]']];
		$link['facebook-messenger'] = ['label' => 'Facebook Messenger', 'url' => 'https://www.facebook.com/dialog/send', 'params' => ['link' => '[%url%]', 'redirect_uri' => '[%url%]', 'display' => 'popup', 'app_id' => '[%app_id%]']];
		$link['kik'] = ['label' => 'Kik', 'url' => 'https://www.kik.com/send/article/', 'params' => ['url' => '[%url%]', 'text' => '[%details%]', 'title' => '[%title%]']];
		$link['skype'] = ['label' => 'Skype', 'url' => 'https://web.skype.com/share', 'params' => ['url' => '[%url%]']];
		$link['trello'] = ['label' => 'Trello', 'url' => 'https://trello.com/add-card', 'params' => ['url' => '[%url%]', 'name' => '[%title%]', 'desc' => '[%details%]', 'mode' => 'popup']];
		$link['viber'] = ['label' => 'Viber', 'url' => 'viber://forward', 'params' => ['text' => '[%title%] [%url%]']];
		$link['whatsapp'] = ['label' => 'WhatsApp', 'url' => 'whatsapp://send', 'params' => ['text' => '[%title%] [%url%]']];
		$link['telegram'] = ['label' => 'Telegram', 'url' => 'https://telegram.me/share/url', 'params' => ['url' => '[%url%]', 'text' => '[%title%]']];
		$link['email'] = ['label' => 'Email', 'url' => 'mailto:', 'params' => ['body' => 'Title: [%title%] \n\n URL: [%url%]', 'subject' => '[%title%]']];
		$link['reddit'] = ['label' => 'Reddit', 'url' => 'http://reddit.com/submit', 'params' => ['url' => '[%url%]', 'title' => '[%title%]']];
		$link['digg'] = ['label' => 'Digg', 'url' => 'http://digg.com/submit', 'params' => ['url' => '[%url%]', 'title' => '[%title%]', 'phase' => 2]];
		$link['stumbleupon'] = ['label' => 'StumbleUpon', 'url' => 'http://www.stumbleupon.com/submit', 'params' => ['url' => '[%url%]', 'title' => '[%title%]']];

		return $link;
	}


	public function xs_plugin_row_meta($links, $file) {
		if(strpos($file, 'wp-social.php') !== false) {
			$new_links = array(
				'demo'    => '<a href="#" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span>Live Demo</a>',
				'doc'     => '<a href="#" target="_blank"><span class="dashicons dashicons-media-document"></span>User Guideline</a>',
				'support' => '<a href="https://help.wpmet.com/" target="_blank"><span class="dashicons dashicons-admin-users"></span>Support</a>',
				'pro'     => '<a href="#" target="_blank"><span class="dashicons dashicons-cart"></span>Premium version</a>',
			);
			$links = array_merge($links, $new_links);
		}

		return $links;
	}
}
