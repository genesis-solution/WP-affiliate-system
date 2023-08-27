<div class="wslu-onboard-section wslu-onboard-module">
    <h2 class="wslu-onboard-section-title"><?php echo esc_html__('Modules', 'wp-social'); ?></h2>
    <?php include(self::get_dir() . 'views/settings-sections/modules.php'); ?>
</div>

<div class="wslu-onboard-section wslu-onboard-widget">
    <?php include(self::get_dir() . 'views/settings-sections/widgets.php'); ?>
</div>

<div class="wslu-onboard-pagination">
    <a class="wslu-onboard-btn wslu-onboard-pagi-btn prev" href="#"><i class="icon xs-onboard-arrow-left"></i><?php echo esc_html__('Back', 'wp-social'); ?></a>
    <a class="wslu-onboard-btn wslu-onboard-pagi-btn next" href="#"><?php echo esc_html__('Next Step', 'wp-social'); ?></a>
</div>