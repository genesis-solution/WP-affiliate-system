<?php defined('ABSPATH') || exit;


switch($currentStyle) {

	/* ---------------------------------
	   Style No : 1, 5, 6, 7, 8, 10, 11,
	-----------------------------------*/
	case 'style-1':
	case 'style-5':
	case 'style-6':
	case 'style-7':
	case 'style-8':
	case 'style-10':
	case 'style-11':
	case 'style-12':
	case 'style-13':

		?>

        <a rel="nofollow" class="xs-login__item <?php echo esc_attr($args['clrClass']) ?>" href="javascript:void(0)" onclick="javascript:location.href='<?php echo esc_url($args['url']) ?>'">
            <span class="xs-login__item--icon"> <?php echo wp_kses(($args['icon']), \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
            <span class="xs-login__item--label"> <?php echo wp_kses($args['label'], \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
        </a>


		<?php break;

	/* -------------------
	  Style No : 2
   --------------------*/
	case 'style-2': ?>
        <a rel="nofollow" class="xs-login__item <?php echo esc_attr($args['clrClass']) ?>" href="javascript:void(0)" onclick="javascript:location.href='<?php echo esc_url($args['url']) ?>'">
            <span class="xs-login__item--icon"> <?php echo wp_kses(($args['icon']), \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
        </a>
		<?php break;


	/* -------------------
	  Style No : 3
   --------------------*/
	case 'style-3': ?>
        <a rel="nofollow" class="xs-login__item <?php echo esc_attr($args['clrClass']) ?>" href="javascript:void(0)" onclick="javascript:location.href='<?php echo esc_url($args['url']) ?>'">
            <span class="xs-login__item--label"> <?php echo wp_kses($args['label'], \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
        </a>
		<?php break;


	/* -------------------
	   Style No : 4
	--------------------*/
	case 'style-4': ?>
        <a rel="nofollow" class="xs-login__item <?php echo esc_attr($args['clrClass']) ?>" href="javascript:void(0)" onclick="javascript:location.href='<?php echo esc_url($args['url']) ?>'">
            <span class="xs-login__item--icon"> <?php echo wp_kses ($args['icon'], \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
            <span class="xs-login__item--label"> <?php echo wp_kses($args['label'], \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
            <span class="xs-login__item--icon-overlay"> <?php echo wp_kses($args['icon'], \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
        </a>
		<?php break;

	/* -------------------
	  Style No : 9
   --------------------*/
	case 'style-9': ?>
        <a rel="nofollow" class="xs-login__item <?php echo esc_attr($args['clrClass']) ?>" href="javascript:void(0)" onclick="javascript:location.href='<?php echo esc_url($args['url']) ?>'">
            <div class="xs-login__item--content">
                <span class="xs-login__item--icon"> <?php echo wp_kses(($args['icon']), \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
                <span class="xs-login__item--label"> <?php echo wp_kses($args['label'], \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
            </div>
            <span class="xs-login__item--icon-overlay"> <i class="met-social met-social-arrow-right"></i> </span>
        </a>
		<?php break;


	/* -------------------
	   Style No : default
	--------------------*/
	default: ?>
        <a rel="nofollow" class="xs-login__item <?php echo esc_attr($args['clrClass']) ?>" href="javascript:void(0)" onclick="javascript:location.href='<?php echo esc_url($args['url']) ?>'">
            <span class="xs-login__item--icon"> <?php echo wp_kses(($args['icon']), \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
            <span class="xs-login__item--label"> <?php echo wp_kses($args['label'], \WP_Social\Helper\Helper::get_kses_array()) ?> </span>
        </a>
	<?php
}
