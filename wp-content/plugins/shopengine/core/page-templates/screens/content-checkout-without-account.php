<?php defined( 'ABSPATH' ) || exit; ?>

<?php echo !wp_is_block_theme() ? '<div class="shopengine">' : ""; ?>
    <?php
    while ( have_posts() ): the_post();
        if(\ShopEngine\Core\Builders\Action::is_edit_with_gutenberg($this->prod_tpl_id)) {
            shopengine_content_render( do_blocks( get_the_content(null, false, $this->prod_tpl_id) ) );
        }else{
            \ShopEngine\Core\Page_Templates\Hooks\Base_Content::instance()->load_content_designed_from_builder();
        }
    endwhile;
    ?>
<?php echo !wp_is_block_theme() ? '</div>' : ""; ?>