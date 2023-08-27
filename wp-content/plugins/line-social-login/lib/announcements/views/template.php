<style>
    .wpmet-ann {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        margin-bottom: 15px;
    }
    .wpmet-ann-thumb {
        width: 75px;
        padding-right: 7px;
        box-sizing: border-box;
        align-self: flex-start;
        padding-top: 5px;
    }
    .wpmet-ann-thumb img {
        width: 100%;
        display: block;
        min-height: 34px;
    }
    .wpmet-ann-desc {
        width: calc(100% - 75px);
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
    }
    .wpmet-ann-desc a {
        font-weight: 500;
        color: #0073aa;
        text-decoration: none;
        padding-bottom: 5px;
        line-height: 20px;
        display: inline-block;
        font-size: 14px;
    }
    .wpmet-ann:last-child {
        margin-bottom: 0;
    }
    .wpmet-ann-desc span {
    display: block;
    }
    .wpmet-bullet-wall {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: black;
        display: inline-block;
        margin: 0 5px;
    }
    .wpmet-dashboard-widget-block {
        width: 100%;
    }
    .wpmet-dashboard-widget-block .wpmet-title-bar {
        display: table;
        width: 100%;
        -webkit-box-shadow: 0 5px 8px rgba(0, 0, 0, 0.05);
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.05);
        margin: 0 -12px 8px;
        padding: 0 12px 12px;
    }
    .wpmet-dashboard-widget-block .wpmet-footer-bar {
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }
    .wpmet-dashboard-widget-block .wpmet-footer-bar a {
        padding: 0 5px;
    }
    .wpmet-dashboard-widget-block a {
        text-decoration: none;
        font-size: 14px;
        color: #007cba;
        font-weight: 600;
    }
    .wpmet-ann .wpmet-banner {
        width: 100%;
        height: 50px;
    }
    .wpmet-dashboard-widget-block .dashicons {
        vertical-align: middle;
        font-size: 17px;
    }
</style>

<div class="wpmet-dashboard-widget-block">
    <div class="wpmet-title-bar">
        <?php
        foreach ($this->plugin_link as $k => $link) {
            echo wp_kses('<a href="' . $link[1] . '">' . $link[0] . '</a>', \WP_Social\Helper\Helper::get_kses_array());
            if (isset($this->plugin_link[$k + 1])) {
                echo wp_kses('<div class="wpmet-bullet-wall"></div>', \WP_Social\Helper\Helper::get_kses_array());
            }
        }
        ?>
    </div>
</div>

<?php 
foreach ($this->announcements as $announcements) {
    if($announcements['type'] === 'news' || $announcements['type'] === '') :
        ?>
        <div class="wpmet-ann">
            <?php if(isset($announcements['announcements_image']) && $announcements['announcements_image'] != ''): ?>
                <div class="wpmet-ann-thumb">
                    <img src="<?php echo esc_url($announcements['announcements_image']); ?>" />
                </div>
            <?php endif; ?>

            <div  class="wpmet-ann-desc">

                <a  href="<?php echo esc_url($announcements['announcements_link']) ?>">
                    <?php echo esc_html($announcements['title']); ?>    
                </a>

                <?php if(isset($announcements['description']) && $announcements['description'] != ''): ?>
                    <span><?php echo esc_html($announcements['description']); ?>  </span>
                <?php endif; ?>
                
            </div>
        </div>
    <?php
    elseif($announcements['type'] === 'banner') :
    ?>
        <div class="wpmet-ann">
            <img class="wpmet-banner" src="<?php echo esc_url(isset($announcements['announcements_image']) && $announcements['announcements_image'] != '' ? $announcements['announcements_image'] : '#'); ?>" />
        </div>
        <?php
    endif;
}
?>

<div class="wpmet-dashboard-widget-block">
    <div class="wpmet-footer-bar">
        <a href="https://help.wpmet.com/" target="_blank">
            <?php echo esc_html__('Need Help?', 'wp-social'); ?> 
            <span aria-hidden="true" class="dashicons dashicons-external"></span>
        </a>
        <a href="https://wpmet.com/blog/" target="_blank">
        <?php echo esc_html__('Blog', 'wp-social') ;?> 
            <span aria-hidden="true" class="dashicons dashicons-external"></span>
        </a>
        <a href="https://wpmet.com/fb-group" target="_blank" style="color: #27ae60;">
            <?php echo esc_html__('Facebook Community', 'wp-social'); ?> 
            <span aria-hidden="true" class="dashicons dashicons-external"></span>
        </a>
    </div>
</div>