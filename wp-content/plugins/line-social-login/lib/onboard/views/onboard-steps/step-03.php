<div class="wslu-onboard-main-header">
    <h1 class="wslu-onboard-main-header--title"><strong><?php

echo esc_html__('Take your website to the next level', 'wp-social'); ?></strong></h1>
    <p class="wslu-onboard-main-header--description"><?php echo esc_html__('We have some plugins you can install to get most from Wordpress.', 'wp-social'); ?></p>
    <p class="wslu-onboard-main-header--description"><?php echo esc_html__('These are absolute FREE to use.', 'wp-social'); ?></p>
</div>
<div class="wslu-onboard-plugin-list">
    <div class="attr-row">
        <?php
        $pluginStatus =  \WP_Social\Lib\Onboard\Classes\Plugin_Status::instance();
        $plugins = \WP_Social\Lib\Onboard\Attr::instance()->utils->get_option('settings', []);
        ?>
		<div class="attr-col-lg-8">
			<div class="wslu-onboard-single-plugin">
				<img class="badge--featured" src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/featured.svg">
				<label>
					<img class="wslu-onboard-single-plugin--logo" src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/getgenie-logo.svg" alt="GetGenie">
					<p class="wslu-onboard-single-plugin--description"><span><?php echo esc_html__( 'Get FREE 1500 AI words, SEO Keyword, and Competitor Analysis credits', 'wp-social' )?> </span><?php echo esc_html__('on your personal AI assistant for Content & SEO right inside WordPress!', 'wp-social' ); ?></p>
					<?php $plugin = $pluginStatus->get_status( 'getgenie/getgenie.php' ); ?>
					<a data-plugin_status="<?php echo esc_attr( $plugin['status'] ); ?>" data-activation_url="<?php echo esc_url( $plugin['activation_url'] ); ?>" href="<?php echo esc_url( $plugin['installation_url'] ); ?>" class="wslu-pro-btn wslu-onboard-single-plugin--install_plugin <?php echo $plugin['status'] == 'activated' ? 'activated' : ''; ?>"><?php echo esc_html( $plugin['title'], 'elementskit-lite' ); ?></a>
				</label>
			</div>
		</div>
        <div class="attr-col-lg-4">
            <div class="wslu-onboard-single-plugin">
                <label>
                    <img class="wslu-onboard-single-plugin--logo" src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shopengine-logo.png" alt="ShopEngine">
                    <p class="wslu-onboard-single-plugin--description"><?php echo esc_html__('Completely customize your  WooCommerce WordPress', 'wp-social'); ?></p>
                    <?php $plugin = $pluginStatus->get_status('shopengine/shopengine.php'); ?>
                    <a data-plugin_status="<?php echo esc_attr($plugin['status']); ?>" data-activation_url="<?php echo esc_url($plugin['activation_url']); ?>" href="<?php echo esc_url($plugin['installation_url']); ?>" class="wslu-pro-btn wslu-onboard-single-plugin--install_plugin <?php echo $plugin['status'] == 'activated' ? 'activated' : ''; ?>"><?php echo esc_html($plugin['title'] , 'elementskit-lite'); ?></a>
                </label>
            </div>
        </div>
        <div class="attr-col-lg-4">
            <div class="wslu-onboard-single-plugin">
                <label>
                    <img class="wslu-onboard-single-plugin--logo" src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/elementskit-logo.svg" alt="WpSocial">
                    <p class="wslu-onboard-single-plugin--description"><?php echo esc_html__('All-in-One Addons for Elementor', 'wp-social'); ?></p>
                    <?php $plugin = $pluginStatus->get_status('elementskit-lite/elementskit-lite.php'); ?>
                    <a data-plugin_status="<?php echo esc_attr($plugin['status']); ?>" data-activation_url="<?php echo esc_url($plugin['activation_url']); ?>" href="<?php echo esc_url($plugin['installation_url']); ?>" class="wslu-pro-btn wslu-onboard-single-plugin--install_plugin <?php echo $plugin['status'] == 'activated' ? 'activated' : ''; ?>"><?php echo esc_html($plugin['title'], 'elementskit-lite'); ?></a>
                </label>
            </div>
        </div>
        <div class="attr-col-lg-4">
            <div class="wslu-onboard-single-plugin">
                <label>
                    <img class="wslu-onboard-single-plugin--logo" src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/metform-logo.png" alt="Metform">
                    <p class="wslu-onboard-single-plugin--description"><?php echo esc_html__('Most flexible drag-and-drop form builder', 'wp-social'); ?></p>
                    <?php $plugin = $pluginStatus->get_status('metform/metform.php'); ?>
                    <a data-plugin_status="<?php echo esc_attr($plugin['status']); ?>" data-activation_url="<?php echo esc_url($plugin['activation_url']); ?>" href="<?php echo esc_url($plugin['installation_url']); ?>" class="wslu-pro-btn wslu-onboard-single-plugin--install_plugin <?php echo $plugin['status'] == 'activated' ? 'activated' : ''; ?>"><?php echo esc_html($plugin['title'], 'elementskit-lite'); ?></a>
                </label>
            </div>
        </div>
        <div class="attr-col-lg-4">
            <div class="wslu-onboard-single-plugin">
                <label>
                    <img class="wslu-onboard-single-plugin--logo" src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/ultimate-review-logo.png" alt="UltimateReview">
                    <p class="wslu-onboard-single-plugin--description"><?php echo esc_html__('Integrate various styled review system in your website', 'wp-social'); ?></p>
                    <?php $plugin = $pluginStatus->get_status('wp-ultimate-review/wp-ultimate-review.php'); ?>
                    <a data-plugin_status="<?php echo esc_attr($plugin['status']); ?>" data-activation_url="<?php echo esc_url($plugin['activation_url']); ?>" href="<?php echo esc_url($plugin['installation_url']); ?>" class="wslu-pro-btn wslu-onboard-single-plugin--install_plugin <?php echo $plugin['status'] == 'activated' ? 'activated' : ''; ?>"><?php echo esc_html($plugin['title'], 'elementskit-lite'); ?></a>
                </label>
            </div>
        </div>
        <div class="attr-col-lg-4 hidden">
            <div class="wslu-onboard-single-plugin">
                <label>
                    <img class="wslu-onboard-single-plugin--logo" src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/fundraising-logo.png" alt="Fundraising">
                    <p class="wslu-onboard-single-plugin--description"><?php echo esc_html__('Integrate various styled review system in your website', 'wp-social'); ?></p>
                    <?php $plugin = $pluginStatus->get_status('wp-fundraising-donation/wp-fundraising.php'); ?>
                    <a data-plugin_status="<?php echo esc_attr($plugin['status']); ?>" data-activation_url="<?php echo esc_url($plugin['activation_url']); ?>" href="<?php echo esc_url($plugin['installation_url']); ?>" class="wslu-pro-btn wslu-onboard-single-plugin--install_plugin <?php echo $plugin['status'] == 'activated' ? 'activated' : ''; ?>"><?php echo esc_html($plugin['title'], 'elementskit-lite'); ?></a>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="wslu-onboard-pagination">
    <a class="wslu-onboard-btn wslu-onboard-pagi-btn prev" data-plugin_status="<?php echo esc_attr($plugin['status']); ?>" data-activation_url="<?php echo esc_attr($plugin['activation_url']) ?>" href="#"><i class="icon xs-onboard-arrow-left"></i><?php echo esc_html__('Back', 'wp-social'); ?></a>
    <a class="wslu-onboard-btn wslu-onboard-pagi-btn next" data-plugin_status="<?php echo esc_attr($plugin['status']); ?>" data-activation_url="<?php echo esc_attr($plugin['activation_url']) ?>" href="#"><?php echo esc_html__('Next Step', 'wp-social'); ?></a>
</div>
<div class="wslu-onboard-shapes">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-06.png" alt="" class="shape-06">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-10.png" alt="" class="shape-10">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-11.png" alt="" class="shape-11">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-12.png" alt="" class="shape-12">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-13.png" alt="" class="shape-13">
</div>