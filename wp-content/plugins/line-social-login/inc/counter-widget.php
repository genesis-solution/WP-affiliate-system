<?php

namespace WP_Social\Inc;

use WP_Social\App\Providers;

defined('ABSPATH') || exit;


/**
 * Class Name : Counter_Widget;
 * Class Details : Create Widget for XS Social Login Plugin
 *
 * @params : void
 * @return : void
 *
 * @since : 1.0
 */
class Counter_Widget extends \WP_Widget {

	public $styleArr = [];
	public $providers = [];
	private $hover_effect = [];

	public function __construct() {

		$widget_ops = array(
		        'classname' => 'xs_counter-widget',
                'description' => __('Wp Social Login System for Facebook, Twitter, Linkedin, Dribble, Pinterest, Post, Comments counter.', 'wp-social')
        );

		parent::__construct('Counter_Widget', __('WSLU Social Counter', 'wp-social'), $widget_ops, []);

		$this->styleArr = \WP_Social\Inc\Admin_Settings::counter_styles();
	}

	public static function register() {

		register_widget('WP_Social\Inc\Counter_Widget');
	}


	/**
	 *
	 * @param $args
	 * @param $instance
	 */
	public function widget($args, $instance) {

		extract($args);

		$title 		= isset($instance['title']) ? $instance['title'] : '';
		$layout 	= isset($instance['layout']) ? $instance['layout'] : '';
		$hover 	    = isset($instance['hover_effect']) ? $instance['hover_effect'] : '';
		$providers 	= isset($instance['providers']) ? $instance['providers'] : '';
		$cusClass   = isset($instance['customclass']) ? $instance['customclass'] : '';
		$box_only 	= isset($instance['box_only']) ? $instance['box_only'] : false;


		$counter = New \WP_Social\Inc\Counter(false);

		$config = [];
		$config['class'] = $cusClass;
		$config['style'] = $layout;
		$config['hover'] = $hover;
		$providers = (is_array($providers) && !empty($providers) && !empty($providers[0])) ? $providers : 'all';

		echo wp_kses(($before_widget . $before_title . $title . $after_title), \WP_Social\Helper\Helper::get_kses_array());

		echo wp_kses(($counter->get_counter_data($providers, $config)), \WP_Social\Helper\Helper::get_kses_array());

		echo wp_kses(($after_widget), \WP_Social\Helper\Helper::get_kses_array());
	}


	/**
	 *
	 * @param $instance
	 */
	public function form($instance) {

		$defaults = array('title' => __('Follow us', 'wp-social'), 'layout' => 'block', 'columns' => 'xs-3-column', 'box_only' => false, 'providers' => '', 'customclass' => '');
		$instance = wp_parse_args((array)$instance, $defaults);
		$select_provider = is_array($instance['providers']) && !empty($instance['providers']) && !empty($instance['providers'][0]) ? $instance['providers'] : [];

		$core_providers = Providers::get_core_providers_count();

		?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Counter Title :', 'wp-social') ?> </label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   value="<?php echo esc_attr($instance['title']); ?>" class="widefat" type="text"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('providers')); ?>"><?php esc_html_e('Providers :', 'wp-social') ?></label>
            <select class="widefat"
                    id="<?php echo esc_attr($this->get_field_id('providers')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('providers')); ?>[]" multiple>
                <option value="" <?php echo empty($select_provider) ? 'selected' : '' ?>>All</option>
				<?php
				foreach($core_providers as $k => $v):
					?>
                    <option value="<?php echo esc_attr($k); ?>" <?php echo esc_attr((in_array($k, $select_provider)) ? 'selected' : ''); ?>>
                        <?php echo esc_html($v['label']) ?>
                    </option> <?php
                endforeach; ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('layout')); ?>"><?php esc_html_e('Style :', 'wp-social') ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('layout')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('layout')); ?>">
				<?php
				foreach($this->styleArr as $k => $v):
					?>
                    <option value="<?php echo esc_attr((!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ? 'wslu-pro-only' : $k); ?>" <?php echo esc_attr(($instance['layout'] == $k) ? 'selected' : ''); ?>>
						<?php
						echo esc_html($v['name']);
						esc_html_e((!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ? '(Pro Only)' : '', 'wp-social');
						?>
                    </option>
				<?php endforeach; ?>
            </select>
        </p>

		<?php

		if(did_action('wslu_social_pro/plugin_loaded')):

			if( method_exists( \WP_Social_Pro\Inc\Admin_Settings::class, 'counter_hover_effects' ) ){

				$this->hover_effect = \WP_Social_Pro\Inc\Admin_Settings::counter_hover_effects();

			}else{

				$this->hover_effect = \WP_Social_Pro\Inc\Admin_Settings::$counter_hover_effects;
				
			}
			?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('hover_effect')); ?>"><?php esc_html_e('Hover effect :', 'wp-social') ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('hover_effect')); ?>"
                        name="<?php echo esc_attr($this->get_field_name('hover_effect')); ?>">
					<?php
					foreach($this->hover_effect as $k => $v):
						?>
                        <option value="<?php echo esc_attr($k); ?>" <?php echo esc_attr((isset($instance['hover_effect']) && $instance['hover_effect'] == $k) ? 'selected' : ''); ?>> <?php esc_html_e($v['name'], 'wp-social'); ?> </option>
					<?php endforeach; ?>
                </select>
            </p>

		<?php

		endif; ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('customclass')); ?>"><?php esc_html_e('Custom Class :', 'wp-social') ?> </label>
            <input id="<?php echo esc_attr($this->get_field_id('customclass')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('customclass')); ?>"
                   value="<?php echo esc_attr($instance['customclass']); ?>" class="widefat" type="text"/>
        </p>
		<?php
	}

	public function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['providers'] 	= $new_instance['providers'] ;
		$instance['layout'] 	= $new_instance['layout'] ;
		$instance['hover_effect'] 	= isset($new_instance['hover_effect']) ? $new_instance['hover_effect'] : '' ;
		$instance['title'] 		= $new_instance['title'] ;
		$instance['box_only'] 	= isset($new_instance['box_only']) ? $new_instance['box_only'] : false ;
		$instance['customclass'] 	= $new_instance['customclass'] ;

		return $instance;
	}
}
