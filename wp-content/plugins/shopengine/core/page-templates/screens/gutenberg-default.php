<?php if (wp_is_block_theme()) : wp_head(); ?>
    <div class="wp-site-blocks">
        <header class="wp-block-template-part">
            <?php block_header_area(); ?>
        </header>
        <main class="gutenova-template-default has-global-padding is-layout-constrained wp-block-group">
            <?php do_action('shopengine/builder/gutenberg/before-content'); ?>

            <?php do_action('shopengine/builder/gutenberg/simple'); ?>

            <?php do_action('shopengine/builder/gutenberg/after-content'); ?>
        </main>

        <footer class="wp-block-template-part">
            <?php block_footer_area(); ?>
            <?php wp_footer(); ?>
        </footer>
    </div>
<?php else : ?>
    <div class="wp-site-blocks">
        <?php get_header(); ?>
        <div class="gutenova-template-default gutenova-static-template-width">
            <?php do_action('shopengine/builder/gutenberg/before-content'); ?>
            <?php do_action('shopengine/builder/gutenberg/simple'); ?>
            <?php do_action('shopengine/builder/gutenberg/after-content'); ?>
        </div>
        <?php get_footer(); ?>
    </div>
<?php endif; ?>