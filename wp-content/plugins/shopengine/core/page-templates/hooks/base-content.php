<?php 
namespace ShopEngine\Core\Page_Templates\Hooks;

defined('ABSPATH') || exit;


class Base_Content{
    public $prod_tpl_id;
    public $prod_tpl_slug;

    use \ShopEngine\Traits\Singleton;

    public function set_tpl_data($id, $slug) {

        if(!empty($_GET['change_template']) && !empty($_GET['shopengine_template_id']) && !empty($_GET['preview_nonce'])){
            $shopengine_template_id = sanitize_text_field(wp_unslash($_GET['shopengine_template_id']));
            if(false !== wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['preview_nonce'])), 'template_preview_' . $shopengine_template_id)){
                $id = $this->get_revision_or_main_post($shopengine_template_id);
            }
        }

		$this->prod_tpl_id = $id;
		$this->prod_tpl_slug = $slug;
	}

    public function get_revision_or_main_post($main_post_id){
        $main_post = get_post($main_post_id);
        $latest_revision = wp_get_post_revisions( $main_post->ID );
        $latest_revision = array_shift( $latest_revision );

        if(!empty($latest_revision) && strtotime($latest_revision->post_modified) > strtotime($main_post->post_modified)){
            return $latest_revision->ID;
        }

        return $main_post->ID;
	}

    public function content_filter() {
         if(did_action('elementor/loaded')) {
             remove_filter('the_content', [
                 \ShopEngine\Core\Page_Templates\Hooks\Base_Content::instance(),
                 'content_filter'
             ]);

             return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($this->prod_tpl_id);
       }
	}

	public function load_content_designed_from_builder($base = null) {

        //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- It's a fronted user part, not possible to verify nonce here
        if((isset($_GET['elementor-preview']) && $_GET['elementor-preview'] == $this->prod_tpl_id) || is_preview()){ } else {
            add_filter('the_content', [$this, 'content_filter']);
        }

        do_action('shopengine/templates/elementor/content/before', $this->prod_tpl_slug);
        do_action('shopengine/templates/elementor/content/before_' . $this->prod_tpl_slug);

        if ($base instanceof Base) {
            $base->before_hooks();
            the_content();
            $base->after_hooks();
        } else {
            the_content();
        }

        do_action('shopengine/templates/elementor/content/after_' . $this->prod_tpl_slug);
        do_action('shopengine/templates/elementor/content/after', $this->prod_tpl_slug);
	}
}