<?php

namespace ShopEngine\Core\Builders;

use ShopEngine\Core\PageTemplates\Page_Templates;
use ShopEngine\Core\Template_Cpt;
use ShopEngine\Traits\Singleton;
use ShopEngine\Utils\Helper;

defined('ABSPATH') || exit;

class Hooks {

	use Singleton;

	public $action;
	public $actionPost_type = ['product']; // only for woocommerce product
	public $languages = [];
	public $activated_templates = [];

	public function init() {

		$this->action = new Action();
		$cptName      = Template_Cpt::TYPE;

		// check admin init
		add_action('admin_init', [$this, 'add_author_support'], 10);
		add_filter('manage_' . $cptName . '_posts_columns', [$this, 'set_columns']);
		add_action('manage_' . $cptName . '_posts_custom_column', [$this, 'render_column'], 10, 2);

		// add filter for search
		add_action('restrict_manage_posts', [$this, 'add_filter']);
		// query filter
		add_filter('parse_query', [$this, 'query_filter']);

		add_action('elementor/editor/init', [$this, 'elementor_editor_initialized']);

		// override the default notice template.
		add_filter('woocommerce_locate_template', [$this, 'shopengine_notice_template'], 10, 3);
	}

	/**
	 * On shopengine template elementor editor
	 * Check if the shopengine product id exists for single template
	 *
	 * @since 2.5.0
	 */
	public function elementor_editor_initialized()
	{
		global $post;
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This hook can access only admin and already verified from elementor
		if ( !empty( $_GET['action'] ) && sanitize_text_field( wp_unslash( $_GET['action'] ) ) === 'elementor' && get_post_type( $post ) === 'shopengine-template' ) {
			$template_type           = get_post_meta( $post->ID, 'shopengine_template__post_meta__type', true );
			$checkable_template_type = ['single', 'quick_view'];
			// Check if the template is single or quick view template
			if ( in_array( $template_type, $checkable_template_type ) ) {
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended
				if ( empty( $_GET['shopengine_product_id'] ) || !wc_get_product( intval( $_GET['shopengine_product_id'] ) ) ) {
					wp_safe_redirect( Helper::get_admin_list_template_url() );
					exit();
				}
			}
		}
	}

	/**
	 * Public function add_author_support.
	 * check author support
	 *
	 * @since 1.0.0
	 */
	public function add_author_support() {
		$this->languages           = apply_filters('shopengine_multi_language', ['status' => false, 'lang_items' => []]);
		$this->activated_templates = Action::get_activated_templates();

		add_post_type_support(Template_Cpt::TYPE, 'author');
	}


	/**
	 * Public function set_columns.
	 * set column for custom post type
	 *
	 * @since 1.0.0
	 */
	public function set_columns($columns) {

		$date_column   = $columns['date'];
		$author_column = $columns['author'];

		unset($columns['date']);
		unset($columns['author']);

		$columns['type']    = esc_html__('Type', 'shopengine');

		if(true === $this->languages['status']) {
			$columns['lang']    = esc_html__('Language', 'shopengine');
		}
	
		$columns['status']  = esc_html__('Status', 'shopengine');
		$columns['builder'] = esc_html__('Builder', 'shopengine');
		$columns['author']  = esc_html($author_column);
		$columns['date']    = esc_html($date_column);

		return $columns;
	}

	/**
	 * Public function render_column.
	 * Render column for custom post type
	 *
	 * @param $column
	 * @param $post_id
	 * @since 1.0.0
	 *
	 */
	public function render_column($column, $post_id) {

		$data                 = get_post_meta($post_id, Action::PK__SHOPENGINE_TEMPLATE, true);
		$template_type        = isset($data['form_type']) ? $data['form_type'] : '';
		$template_config_data = Page_Templates::instance()->getTemplate($template_type);
		$template_class       = $template_config_data['class'] ?? null;
		$category_id          = !empty($data['category_id']) ? $data['category_id'] : 0;
		$template_language    = get_post_meta($post_id, 'language_code', true);

		switch($column) {
			case 'type':
				echo esc_html(empty($template_config_data['title']) ?  '' : $template_config_data['title']);
				if(class_exists(\ShopEngine_Pro::class)) {
					$cat_name = get_the_category_by_ID($category_id);
					if(isset($cat_name) && !is_wp_error($cat_name)) {
						echo '<br>' . esc_html__('Category', 'shopengine') .' : '. esc_html($cat_name);
					}
				}
				break;

			case 'lang':
				if(!empty($this->languages['lang_items'][$template_language]['country_flag_url'])) {
					?>
						<img src="<?php echo esc_url($this->languages['lang_items'][$template_language]['country_flag_url'])?>">
					<?php
				}
				break;

			case 'builder':
				$builder = Helper::get_template_builder_type($post_id);;
				echo esc_html(empty($builder) ? 'elementor' : $builder);
				break;

			case 'status':

				$status       = esc_html__('Inactive', 'shopengine');
				$status_class = 'shopengine-deactive';

				if(class_exists($template_class)) {
					$template_data = Action::get_template_data($post_id, $this->activated_templates);
					if('en' === $template_language) {
						if(is_array($template_data) && $template_data['status']) {
							$status       = esc_html__('Active', 'shopengine');
							$status_class = 'shopengine-active';
						}
					} elseif($this->languages['status'] && is_array($template_data) && $template_data['status']) {
						$status       = esc_html__('Active', 'shopengine');
						$status_class = 'shopengine-active';
					}
				}

				echo wp_kses('<span class="shopengine_default type-'.$template_type . ' ' . $status_class.'"> ' . $status . ' </span>', Helper::get_kses_array());
				break;
		}
	}

	/**
	 * Public function add_filter.
	 * Added search filter for type of template
	 *
	 * @since 1.0.0
	 */
	public function add_filter() {

		global $typenow;

		if($typenow == Template_Cpt::TYPE) {

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This hook can access only admin And not possible to verify nonce here
			$selected = isset($_GET['type']) ? sanitize_key($_GET['type']) : ''; ?>

            <select name="type" id="type">

                <option value="all" <?php selected('all', $selected); ?>><?php esc_html_e('Template Type ', 'shopengine'); ?></option> <?php

				foreach(Templates::get_template_types() as $key => $value) { ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php selected($key, $selected); ?>><?php esc_html_e($value['title'], 'shopengine'); ?></option>
				<?php } ?>

            </select>
			<?php
		}
	}

	/**
	 * Public function query_filter.
	 * Search query filter added in search query
	 *
	 * @param $query
	 * @since 1.0.0
	 */
	public function query_filter($query) {

		global $pagenow;
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This hook can access only admin And not possible to verify nonce here
		$current_page = isset($_GET['post_type']) ? sanitize_key($_GET['post_type']) : '';

		if(
			is_admin()
			&& Template_Cpt::TYPE == $current_page
			&& 'edit.php' == $pagenow
			&& !empty($_GET['type']) // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This hook can access only admin And not possible to verify nonce here
			&& $_GET['type'] != 'all' // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This hook can access only admin And not possible to verify nonce here
		) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This hook can access only admin And not possible to verify nonce here
			$type                              = sanitize_key($_GET['type']); 
			$query->query_vars['meta_key']     = Action::get_meta_key_for_type();
			$query->query_vars['meta_value']   = $type;
			$query->query_vars['meta_compare'] = '=';
		}
	}

	/**
	 * Change the default notice template.
	 *
	 * @param $template
	 * @param $template_name
	 * @param $template_path
	 * @since 4.2.0
	 */
	public function shopengine_notice_template($template, $template_name, $template_path) {
		if ($template_name === 'notices/notice.php') {
			$template = \Shopengine::plugin_dir() . 'woocommerce/notices/notice.php';
		}
		return $template;
	}
	
}
