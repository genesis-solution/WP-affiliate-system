<?php
if(wp_is_block_theme()){
    wp_head();
    block_header_area();
}else{
    get_header();
}

?>

<div class="gutenova-template-default gutenova-template-full-width">
    <?php do_action('shopengine/builder/gutenberg/before-content'); ?>

    <?php do_action('shopengine/builder/gutenberg/simple'); ?>

    <?php do_action('shopengine/builder/gutenberg/after-content'); ?>
</div>
<?php 

if(wp_is_block_theme()){
    wp_footer();
    block_footer_area();
 }else{
     get_footer();
 }
