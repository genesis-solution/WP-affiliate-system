<?php

namespace ShopEngine\Core\Builders;

use ShopEngine\Core\PageTemplates\Page_Templates;

class Templates {

	const BODY_CLASS = 'shopengine-template';

	public static function get_template_types(): array {

		return Page_Templates::instance()->getTemplates();
	}

	public static function get_registered_template_data($template_id) {

		$type = self::get_template_type_by_id($template_id);

		return Page_Templates::instance()->getTemplate($type);
	}

	public static function get_template_type_by_id($pid): string {

		$pm = get_post_meta($pid, Action::get_meta_key_for_type(), true);

		return empty($pm) ? 'shop' : $pm;
	}

	public static function get_registered_template_id($template_type) {

		if(!empty($_GET['change_template']) && !empty($_GET['shopengine_template_id']) && !empty($_GET['preview_nonce'])) {
			
			$nonce_status = apply_filters(
				'shopengine/demo/bypass_nonce', 
				(wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['preview_nonce'])), 'template_preview_' . sanitize_text_field(wp_unslash($_GET['shopengine_template_id']))))
			);

			if($nonce_status === false ) {
				return ;
			}

			return (int)$_GET['shopengine_template_id'];
		}

		$activated_templates = Action::get_activated_templates();

		if(empty($activated_templates)) {
			return;
		}

		$language_code = apply_filters('shopengine_language_code', 'en');

		if(isset($activated_templates[$template_type]['lang'][$language_code])) {
			$templates = $activated_templates[$template_type]['lang'][$language_code];

			$category_id = apply_filters('shopengine_template_category_id', 0);

			if(0 === $category_id) {
				$key = Action::get_template_key($templates);
			} else {
				$key = Action::get_template_key($templates, 'category_id', $category_id);
				if(is_bool($key)) {
					$key = Action::get_template_key($templates);
				}
			}
			
			if(is_integer($key)) {
				$template_data = $templates[$key];

				if($template_data['status']) {
					return $template_data['template_id'];
				}
			}
		}
		return;
	}

    public static function has_simple_product($in_status = ['publish', 'draft'])
    {
        global $wpdb;

        $result = $wpdb->get_row("SELECT * FROM  $wpdb->posts WHERE post_type = 'product' AND post_status IN('publish', 'draft')");

        return ! empty($result);
    }

    public static function create_wc_simple_product() {

		$product = new \WC_Product_Simple();

		$product->set_name( 'Shopengine preview product [do not delete it]' );
		$product->set_description( 'This is a shopengine demo preview product' );
		$product->set_short_description( 'This is a shopengine demo preview product' );
		$product->set_status( 'draft' );

		$product->set_regular_price( 100 );
		$product->set_sale_price( 79 );
		$product->set_price( 79 );

		$product->set_sku( 'shopengine-demo-preview-01' );

		$product->set_manage_stock( false );
		$product->set_stock_status( 'instock' );

		$product->set_weight( 11 );
		$product->set_length( 12 );
		$product->set_width( 10 );
		$product->set_height( 9 );

		//$product->set_image_id( 'image_id' );
		//$product->set_gallery_image_ids( [] );

		return $product->save();
	}
}
