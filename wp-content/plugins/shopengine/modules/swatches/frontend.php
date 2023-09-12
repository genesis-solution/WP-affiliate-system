<?php

namespace ShopEngine\Modules\Swatches;

use ShopEngine;
use ShopEngine\Traits\Singleton;
use ShopEngine\Core\Register\Module_List;

defined('ABSPATH') || exit;

class Frontend
{
	use Singleton;

	public function init() {

		$sett = Module_List::instance()->get_settings('swatches');

		// Todo: Need to remove the old codes of swatches
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_filter('woocommerce_dropdown_variation_attribute_options_html', [$this, 'get_swatch_html'], 100, 2);
		add_filter('shopengine_filter_html_swatch_hook', [$this, 'swatch_html'], 5, 4);

		if(isset($sett['show_color_swatch_on_loop']['value']) && $sett['show_color_swatch_on_loop']['value'] === 'yes'){
			add_action('woocommerce_after_shop_loop_item', [$this, 'show_archive_product_loop_swatch'], 15);
		}
		

		add_action('wp_ajax_shopengine_swatch_image_on_loop_products', [$this, 'swatch_image_on_loop_products']);
		add_action("wp_ajax_nopriv_shopengine_swatch_image_on_loop_products", [$this, "swatch_image_on_loop_products"]);
	}

	public function enqueue_scripts() {
		wp_enqueue_style('shopengine-css-front', Swatches::asset_source('css', 'frontend.css'), [], ShopEngine::version());
		wp_enqueue_script('shopengine-js-front', Swatches::asset_source('js', 'frontend.js'), ['jquery'], ShopEngine::version(), true);

		wp_localize_script('shopengine-js-front', 'frontendApiSettings', [
			'nonce'    => esc_js(wp_create_nonce('shopengine_swatch_image_on_loop_products')),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		]);
	}

	public function show_archive_product_loop_swatch(){
		global $product;

		if($product->get_type() === 'variable'){
			
			$attributes = $product->get_attributes();

			if(!empty($attributes)){
				$output_div = '<div class="shopengine_loop_swatches_wrap" data-product-id="'. esc_attr($product->get_id()) .'">';
				echo wp_kses($output_div, \ShopEngine\Utils\Helper::get_kses_array());
				foreach($attributes as $attr_key => $attribute){

					$current_attr_key = Helper::get_tax_attribute($attr_key);
					if(isset($current_attr_key->attribute_type) && $current_attr_key->attribute_type === 'shopengine_color'){

						$selected_attr = $product->get_variation_default_attribute( $attr_key );
						$output_div = '<div class="shopengine_swatches shopengine-loop-swatches" data-attribute_name="attribute_'. esc_attr($attr_key) .'">';
						echo wp_kses($output_div, \ShopEngine\Utils\Helper::get_kses_array());

						if(!empty($attribute->get_terms())){
							foreach($attribute->get_terms() as $attr_option){

								$name = apply_filters('woocommerce_variation_option_name', $attr_option->name);
								$current_selected = $selected_attr === $attr_option->slug ? 'selected' : '';

								$color = get_term_meta($attr_option->term_id, 'shopengine_color', true);
								list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");

								echo sprintf(
									'<span class="swatch swatch_color_loop swatch_color swatch-%s %s" style="background-color:%s;color:%s;" data-value="%s">%s</span>',
									esc_attr($attr_option->slug),
									esc_attr($current_selected),
									esc_attr($color),
									esc_attr("rgba($r,$g,$b,0.5)"),
									esc_attr($attr_option->slug),
									esc_html($name),
								);

							}
						}

						echo wp_kses('</div>', \ShopEngine\Utils\Helper::get_kses_array());
					}
					
				}

				echo wp_kses('</div>', \ShopEngine\Utils\Helper::get_kses_array());
			}
		}
	}

	public function swatch_image_on_loop_products(){

		$nonce  = isset($_POST['nonce']) ? sanitize_key($_POST['nonce']) : '';

		$selectedData = isset($_POST['selectedData']) ? map_deep( wp_unslash( $_POST['selectedData'] ) , 'sanitize_text_field' ) : '';
		$product_id = isset($_POST['productId']) ? sanitize_text_field( wp_unslash($_POST['productId']) ) : '';

		if(!wp_verify_nonce($nonce, 'shopengine_swatch_image_on_loop_products')) {
			wp_send_json_error(esc_html__('Request denied', 'shopengine'));
		} 

		$product = wc_get_product($product_id);
		$variations = $product->get_available_variations();		

		if(!empty($variations)){
			foreach($variations as $variation){
				$attributes = $variation['attributes'];
				$variation_match_found = false;

				foreach( $attributes as $attr_key => $value ){
					
					$current_attr_key = Helper::get_tax_attribute(ltrim($attr_key, 'attribute_'));
					
					if(isset($current_attr_key->attribute_type) && $current_attr_key->attribute_type === 'shopengine_color'){

						$attribute_match_found = false;

						// Variation has given value
						if(!empty($value)){
							foreach($selectedData as $selectedDataItem){
								if($selectedDataItem[0] === $attr_key && $selectedDataItem[1] === $value){
									$attribute_match_found = true;
								}
							}

							if(!$attribute_match_found){
								$variation_match_found = false;
								break;
							}
							$variation_match_found = true;
						}
						
					}
				}

				if($variation_match_found){
					wp_send_json_success( array(
						'variation_img_html' => Helper::get_product_thumbnail_by_image_id( $variation['image_id'], $product ),
					) );
					wp_die();
				}
				
			}
		}

		wp_send_json_error(esc_html__('No image found', 'shopengine'));
		wp_die();
	}

	public function get_swatch_html($html, $args) {
		$swatch_types = Swatches::instance()->get_available_types();
		$attr = Helper::get_tax_attribute($args['attribute']);

		// Return if this is normal attribute
		if(empty($attr)) {
			return $html;
		}

		if(!array_key_exists($attr->attribute_type, $swatch_types)) {
			return $html;
		}

		$options   = $args['options'];
		$product   = $args['product'];
		$attribute = $args['attribute'];
		$class     = "variation-selector variation-select-{$attr->attribute_type}";
		$swatches  = '';

		$args['tooltip'] = $this->is_tooltip_enabled();

		if(empty($options) && !empty($product) && !empty($attribute)) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[$attribute];
		}

		if(array_key_exists($attr->attribute_type, $swatch_types)) {
			if(!empty($options) && $product && taxonomy_exists($attribute)) {
				$terms = wc_get_product_terms($product->get_id(), $attribute, ['fields' => 'all']);

				foreach($terms as $term) {
					if(in_array($term->slug, $options)) {
						$swatches .= apply_filters('shopengine_filter_html_swatch_hook', '', $term, $attr->attribute_type, $args);
					}
				}
			}

			if(!empty($swatches)) {
				$class    .= ' hidden';
				$swatches = '<div class="shopengine_swatches" data-attribute_name="attribute_' . esc_attr($attribute) . '">' . $swatches . '</div>';
				$html     = '<div class="' . esc_attr($class) . '">' . $html . '</div>' . $swatches;
			}
		}

		return $html;
	}


	public function swatch_html($html, $term, $type, $args) {

		$selected = sanitize_title($args['selected']) == $term->slug ? 'selected' : '';
		$name     = esc_html(apply_filters('woocommerce_variation_option_name', $term->name));
		$tooltip  = '';

		if(!empty($args['tooltip'])) {
			$tooltip = '<span class="shopengine_swatch__tooltip">' . ($term->description ? $term->description : $name) . '</span>';
		}

		switch($type) {
			case Swatches::PA_COLOR:
				$color = get_term_meta($term->term_id, $type, true);


				list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
				$html = sprintf(
					'<span class="swatch swatch_color swatch-%s %s" style="background-color:%s;color:%s;" data-value="%s">%s%s</span>',
					esc_attr($term->slug),
					$selected,
					esc_attr($color),
					"rgba($r,$g,$b,0.5)",
					esc_attr($term->slug),
					$name,
					$tooltip
				);
				break;

			case Swatches::PA_IMAGE:
				$image = get_term_meta($term->term_id, $type, true);
				$image = $image ? wp_get_attachment_image_src($image) : '';
				$image = $image ? $image[0] : Helper::get_dummy();
				$html  = sprintf(
					'<span class="swatch swatch_image swatch-%s %s" data-value="%s"><img src="%s" alt="%s">%s%s</span>',
					esc_attr($term->slug),
					$selected,
					esc_attr($term->slug),
					esc_url($image),
					esc_attr($name),
					$name,
					$tooltip
				);
				break;

			case Swatches::PA_LABEL:
				$label = get_term_meta($term->term_id, $type, true);
				$label = $label ? $label : $name;
				$html  = sprintf(
					'<span class="swatch swatch_label swatch-%s %s" data-value="%s">%s%s</span>',
					esc_attr($term->slug),
					$selected,
					esc_attr($term->slug),
					esc_html($label),
					$tooltip
				);
				break;
		}

		return $html;
	}


	public function is_tooltip_enabled() {

		return true;
	}
}