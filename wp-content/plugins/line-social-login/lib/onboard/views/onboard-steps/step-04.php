<div class="wslu-onboard-main-header">
    <h1 class="wslu-onboard-main-header--title">
        <strong>
            <?php echo esc_html__('Learn How You Can Integrate All Social Media Features in Website without Coding', 'wp-social'); ?>
        </strong>
    </h1>
</div>

<div class="wslu-onboard-tutorial">
    <div class="wslu-onboard-tutorial--btn">
        <a class="wslu-onboard-tutorial--link" data-video_id="UhfYiDOjtYo" target="_blank" href="https://wpmet.com/knowledgebase/wp-social/"><i class="icon xs-onboard-play"></i></a>
    </div>
    
    <div class="ekti-admin-video-tutorial-popup">
            <div class="ekti-admin-video-tutorial-iframe"></div>
    </div>
</div>


<div class="wslu-onboard-tut-term">
    <label class="wslu-onboard-tut-term--label">
        <?php $term = WP_Social\Lib\Onboard\Attr::instance()->utils->get_option('settings', []);
        ?>
        <input <?php if(empty($term['tut_term']) || $term['tut_term'] !== 'user_agreed') : ?>checked="checked"<?php endif; ?> class="wslu-onboard-tut-term--input" name="settings[tut_term]" type="checkbox" value="user_agreed">
        <?php echo esc_html__('Share non-sensitive diagnostic data and details about plugin usage.', 'wp-social'); ?>
    </label>

    <p class="wslu-onboard-tut-term--helptext"><?php echo esc_html__("We gather non-sensitive diagnostic data as well as information about plugin use. Your site's URL, WordPress and PHP versions, plugins and themes, as well as your email address, will be used to give you a discount coupon. This information enables us to ensure that this plugin remains consistent with the most common plugins and themes at all times. We pledge not to give you any spam, for sure.", 'wp-social'); ?></p>
    <p class="wslu-onboard-tut-term--help"><?php echo esc_html__('What types of information do we gather?', 'wp-social'); ?></p>
</div>
<div class="wslu-onboard-pagination">
    <a class="wslu-onboard-btn wslu-onboard-pagi-btn prev" href="#"><i class="icon xs-onboard-arrow-left"></i><?php echo esc_html__('Back', 'wp-social'); ?></a>
    <a class="wslu-onboard-btn wslu-onboard-pagi-btn next" href="#"><?php echo esc_html__('Next Step', 'wp-social'); ?></a>
</div>
<div class="wslu-onboard-shapes">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-07.png" alt="" class="shape-07">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-14.png" alt="" class="shape-14">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-15.png" alt="" class="shape-15">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-16.png" alt="" class="shape-16">
    <img src="<?php echo esc_url(self::get_url()); ?>assets/images/onboard/shape-17.png" alt="" class="shape-17">
</div>