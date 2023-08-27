<?php

namespace WP_Social\App;

use WP_Social\Lib\Provider\Share_Factory;
use WP_Social\Traits\Singleton;

defined('ABSPATH') || exit;

class Share_Settings {

	use Singleton;

	const OK_GLOBAL             = 'xs_share_global_setting_data';
	const OK_STYLES             = 'xs_style_setting_data_share';
	const OK_PROVIDER           = 'xs_share_providers_data';
	const OK_PROVIDER_ENABLED   = 'xs_providers_enabled_share';


	private $global;
	private $providers;
	private $enabled;
	private $styles;
	private $def_share_style = 'style-1';

	public function __construct() {

		$this->global    = get_option(self::OK_GLOBAL, []);
		$this->enabled   = get_option(self::OK_PROVIDER_ENABLED, []);
		$this->providers = get_option(self::OK_PROVIDER, []);
		$this->styles    = get_option(self::OK_STYLES, []);
	}


	public function get_enabled_providers() {

		if(empty($this->enabled)) {

			return [];
		}

		$ret = [];

		foreach($this->enabled as $key => $item) {

			if(!empty($item['enable'])) {

				$ret[$key] = $item;
			}
		}

		return $ret;
	}


	public function update_enabled_providers($val) {

		$this->enabled = $val;

		update_option(self::OK_PROVIDER_ENABLED, $val, true);

		return $this;
	}


	public function get_provider_settings() {

		return $this->providers;
	}


	public function update_provider_settings($val) {

		$this->providers = $val;

		update_option(self::OK_PROVIDER, $val, true);

		return $this;
	}


	public function get_horizontal_styles() {

		return \WP_Social\Inc\Admin_Settings::$horizontal_style;
	}


	public function get_hover_styles() {

		$hover_styles = [
			'none-none' => [
				'name'  => 'None',
				'class' => 'wslu-none',
			],
		];

		return apply_filters('wp_social_pro/share/primary-content/hover-styles', $hover_styles);
	}


	public function get_selected_style() {

		$set = $this->get_style_settings();

		return empty($set['login_button_style']['main']) ? $this->def_share_style : $set['login_button_style']['main'];
	}


	public function get_selected_style_keys() {

		$set = $this->get_style_settings();

		$hover_key = 'none-none';
		$vh_key = 'horizontal';
		$def_key = 'style-1'.':'.$hover_key.':'.$vh_key;

		return empty($set['main_content']['style']) ? $def_key : $set['main_content']['style'];
	}


	public function prepare_widget_class($styles) {

		$hover_styles   = $this->get_hover_styles();
		$style_key      = $this->get_selected_style_keys();
		$bArr = explode(':', $style_key);

		$style_cls = $bArr[0];
		$hover_key = $bArr[1];
		$vh_key = $bArr[2];
		$display_cls = 'wslu-main_content';

		$vh_styles = $this->get_horizontal_styles();
		$font_cls = $this->get_theme_font_class();


		return $styles[$style_cls]['class'] . ' ' .
			$hover_styles[$hover_key]['class'] . ' ' .
			$vh_styles[$vh_key]['class'] . ' ' .
			$font_cls . ' ' .
			$display_cls;
	}


	public function get_share_count($post, $enabled_providers) {

		$share_counting = [];

		if(is_object($post) && !empty($post->ID)) {

			$url = get_permalink($post);

			$factory = new Share_Factory($post->ID);

			foreach($enabled_providers as $key => $conf) {

				$obj = $factory->make($key);

				$share_counting[$key]['count'] = $obj->set_uri_hash(Settings::get_hash($url))->get_url_share_count();
			}
		}

		return $share_counting;
	}


	public function get_theme_font_class() {

		return $this->is_theme_font_enabled() ? 'wslu-theme-font-yes' : 'wslu-theme-font-no';
	}


	public function get_old_count($key) {

		return apply_filters('wp_social_pro/provider/share/old_count', 0, $key);
	}


	public function get_extra_data_class($selected_share_style, $all_style) {

		return empty($all_style[$selected_share_style]['content']) ? 'wslu-no-extra-data' : 'wslu-extra-data';
	}


	public function get_style_settings() {

		return $this->styles;
	}


	public function update_style_settings($val) {

		$this->styles = $val;

		update_option(self::OK_STYLES, $val, true);

		return $this;
	}


	public function get_global_settings() {

		return $this->global;
	}


	public function update_global_settings($val) {

		$this->global = $val;

		update_option(self::OK_GLOBAL, $val, true);

		return $this;
	}


	public function is_theme_font_enabled() {

		return !empty($this->global['show_font_from_theme']);
	}


	public function is_share_content_enabled() {

		return empty($this->styles['login_content']) ? false : ($this->styles['login_content'] != 'no_content');
	}


	public function get_share_content_position() {

		return empty($this->styles['login_content']) ? 'after_content' : ($this->styles['login_content']);
	}
}
