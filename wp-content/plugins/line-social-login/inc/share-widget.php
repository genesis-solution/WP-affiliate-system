<?php

namespace WP_Social\Inc;

defined('ABSPATH') || exit;


/**
* Class Name : xs_social_widget;
* Class Details : Create Widget for XS Social Login Plugin
* 
* @params : void
* @return : void
*
* @since : 1.0
*/
class Share_Widget extends \WP_Widget {

    public $styleArr;


	public function __construct() {

		$this->styleArr = Admin_Settings::share_styles();
		
		parent::__construct(

			'Share_Widget',

			__('WSLU Social Share', 'wp-social'), 
		 
			array( 'description' => __( 'Wp Social Share System for Facebook, Twitter, Linkedin, Pinterest & 13+ providers.', 'wp-social' ), ) 
		);
	}
	
	public static function register(){
		register_widget( 'WP_Social\Inc\Share_Widget' );
	}


	public function widget( $args, $instance ) {

	    extract( $args );
		
		$title 		= isset($instance['title']) ? $instance['title'] : '';
		$layout     = isset($instance['layout']) ? $instance['layout'] : '';
		$cusClass   = isset($instance['customclass']) ? $instance['customclass'] : '';
		$hover 	    = isset($instance['hover_effect']) ? $instance['hover_effect'] : '';
		$isHor	    = isset($instance['vertical_effect']) ? $instance['vertical_effect'] : '';
		$showCount  = isset($instance['show_count']) && $instance['show_count'] == 'Yes' ? true : false;

		$share = New \WP_Social\Inc\Share(false);
		
		$config = [];
		$config['class'] = $cusClass;
		$config['style'] = $layout;
		$config['hover'] = $hover;
		$config['hv_effect'] = $isHor;
		$config['show_count'] = $showCount;
		$config['conf_type'] = 'widget';


		#AR do not know from where these variables are initiated!
        #Guessing from arguments
		echo wp_kses(($before_widget . $before_title . $title . $after_title), \WP_Social\Helper\Helper::get_kses_array());

		echo  $share->get_share_data( 'all' , $config); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --  It's already has been escaped from the /template/share/share-html.php

		echo wp_kses(($after_widget), \WP_Social\Helper\Helper::get_kses_array());
	}


	public function form( $instance ) {

		$defaults = array( 'title' => __( 'SOCIAL SHARE' , 'wp-social' )  , 'layout' => 'floating' , 'box_only' => false, 'providers' => '', 'customclass' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );
		$vertical_effect = \WP_Social\Inc\Admin_Settings::$horizontal_style;

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title')); ?>"><?php esc_html_e( 'Share Title:', 'wp-social' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'vertical_effect' )); ?>"><?php esc_html_e( 'Layout:' , 'wp-social' ) ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'vertical_effect' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'vertical_effect' )); ?>" >
				<?php
				foreach($vertical_effect as $k => $v):
					?>
                    <option value="<?php echo esc_attr($k);?>" <?php echo esc_attr((isset($instance['vertical_effect']) && $instance['vertical_effect'] == $k ) ? 'selected' : ''); ?>> <?php esc_html_e($k, 'wp-social'); ?> </option>
				<?php endforeach;?>
            </select>
        </p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>"><?php esc_html_e( 'Style :' , 'wp-social' ) ?></label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'layout' )); ?>" >
				<?php
				 foreach($this->styleArr as $k => $v): ?>
					<option
					value="<?php echo esc_attr((!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ? 'wslu-pro-only' : $k);?>"
					<?php echo esc_attr(($instance['layout'] == $k ) ? 'selected' : ''); ?>
					>
					<?php
						echo esc_html($v['name']);
						esc_html_e((!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ? ' (Pro Only) ' : ' ', 'wp-social');
					?>
					</option>
				<?php endforeach;?>
			</select>
		</p>


		<?php

		if(did_action('wslu_social_pro/plugin_loaded')):

			if( method_exists( \WP_Social_Pro\Inc\Admin_Settings::class, 'share_hover_effects' ) ){
			
				$this->hover_effect = \WP_Social_Pro\Inc\Admin_Settings::share_hover_effects();
				
			}else{

				$this->hover_effect = \WP_Social_Pro\Inc\Admin_Settings::$share_hover_effects;

			}

			?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'hover_effect' )); ?>"><?php esc_html_e( 'Hover effect :' , 'wp-social' ) ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'hover_effect' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hover_effect' )); ?>" >
					<?php
					foreach($this->hover_effect as $k => $v):
						?>
                        <option value="<?php echo esc_attr($k);?>" <?php echo esc_attr((isset($instance['hover_effect']) && $instance['hover_effect'] == $k ) ? 'selected' : ''); ?>> <?php esc_html_e($v['name'], 'wp-social'); ?> </option>
					<?php endforeach;?>
                </select>
            </p>

			<?php

		endif;
		?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_count' )); ?>"><?php esc_html_e( 'Show total count :' , 'wp-social' ) ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'show_count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_count' )); ?>" >

                <option value="No" <?php echo esc_attr((isset($instance['show_count']) && $instance['show_count'] == 'No' ) ? 'selected' : ''); ?>> <?php esc_html_e('No', 'wp-social'); ?> </option>
                <option value="Yes" <?php echo esc_attr((isset($instance['show_count']) && $instance['show_count'] == 'Yes' ) ? 'selected' : ''); ?>> <?php esc_html_e('Yes', 'wp-social'); ?> </option>

            </select>
        </p>


        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'customclass' )); ?>"><?php esc_html_e( 'Custom Class :' , 'wp-social' ) ?> </label>
			<input id="<?php echo esc_attr($this->get_field_id( 'customclass' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'customclass' )); ?>" value="<?php echo esc_attr($instance['customclass']); ?>" class="widefat" type="text" />
		</p>
	<?php 
	}
		 
	public function update( $new_instance, $old_instance ) {

	    $instance = $old_instance;
		$instance['layout'] 	= $new_instance['layout'] ;
		$instance['title'] 		= $new_instance['title'] ;
		$instance['box_only'] 	= isset($new_instance['box_only']) ? $new_instance['box_only'] : '' ;
		$instance['customclass'] 	= $new_instance['customclass'] ;
		$instance['hover_effect'] 	= $new_instance['hover_effect'] ;
		$instance['vertical_effect'] = $new_instance['vertical_effect'] ;
		$instance['show_count'] = $new_instance['show_count'] ;

		return $instance;
	}
} 

