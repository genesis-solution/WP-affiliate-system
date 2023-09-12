<?php

defined('ABSPATH') || exit;

do_action('shopengine_woocommerce_before_single_product');

if (post_password_required()) {
	shopengine_content_render(get_the_password_form());
	return;
}

function single_content($_this, $prod_tpl_id)
{
	while (have_posts()) : the_post();
		if (\ShopEngine\Core\Builders\Action::is_edit_with_gutenberg($prod_tpl_id)) {
			shopengine_content_render(do_blocks(get_the_content(null, false, $prod_tpl_id)));
		} else {
			\ShopEngine\Core\Page_Templates\Hooks\Base_Content::instance()->load_content_designed_from_builder($_this);
		}
	endwhile;
}

?>

<?php if ($this->get_page_type_option_slug() == 'quick_view') : ?>
	<style>
		#wpadminbar {
			display: none !important;
		}

		html {
			margin: 0 !important;
		}
	</style>
<?php endif; ?>


<?php if(wp_is_block_theme()): ?>
	<?php single_content($this, $this->prod_tpl_id); ?>
<?php else: ?>
	<div class="shopengine-quickview-content-warper">
		<div id="product-<?php the_ID(); ?>" <?php post_class('shopengine-product-page'); ?>>
			<?php single_content($this, $this->prod_tpl_id); ?>
		</div>
	</div>
<?php endif; ?>