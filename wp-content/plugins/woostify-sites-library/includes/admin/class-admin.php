<?php
/**
 * Woostify for Import Export Contact Form 7.
 *
 * @see https://woostify.com/
 *
 * @package Woostify
 */

namespace Woostify\Admin;

/**
 * Woostify Import export contact form 7
 */
class Admin {

	/**
	 * Instance of Admin
	 *
	 * @since  1.0.0
	 * @var (Object) Admin
	 */
	private static $instance = null;

	/**
	 * Instance of Admin.
	 *
	 * @since  1.0.0
	 *
	 * @return object Class object.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Register hook action.
	 */
	public function hooks() {
		add_action( 'wp_ajax_woostify_admin_list_page_demo', array( $this, 'list_page_demo' ), 10, 0 );
		add_action( 'wp_ajax_nopriv_woostify_admin_list_page_demo', array( $this, 'list_page_demo' ) );
	}

	public function list_page_demo() {
		// check_ajax_referer( 'woostify_admin_template_nonce', 'security' );
		$id = $_GET['id'];
		$all_demo = woostify_sites_local_import_files();
		$demo = $all_demo[$id];
		$check_pro = get_option( 'woostify_pro_license_key_status', 'invalid' );
		// ( 'valid' != $check_pro && 'pro' == $demo_type )
		?>
		<div class="demo-template-infomation demo-template-<?php echo esc_attr( $id ); ?>">
			<div class="demo-main-wrapper">
				<div class="demo-head">
					<h2 class="demo-title"><?php echo esc_html( $demo['import_file_name'] ); ?></h2>
				</div>
				<div class="demo-main-content">
					<div class="main-content-wrapper">
						<div class="woostify-info-left">
							<div class="left-wrapper">
								<div class="preview-iframe">
									<img src="<?php echo esc_url( $demo['import_preview_image_url'] ); ?>" alt="<?php echo esc_attr( $demo['import_file_name'] ); ?>">
								</div>
							</div>
						</div>
						<div class="woostify-info-right">
							<div class="right-wrapper">
								<div class="list-template-demo">
									<?php foreach ( $demo['page'] as  $page ): ?>
										<div class="page-item template-item" page-id="<?php echo esc_attr( $page['id'] ); ?>">
											<div class="item-template-wrapper">
												<div class="template-image">
													<img src="<?php echo esc_url( $page['preview'] ) ?>" alt="<?php echo esc_attr( $page['title'] ); ?>">
												</div>
												<div class="item-template-info">
													<div class="info-wrapper">
														<div class="template-name">
															<span class="demo-name">
																<?php echo esc_html( $page['title'] ) ?>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="demo-action-footer">
					<div class="footer-wrapper">
						<div class="footer-left">
							<div class="footer-left-wrapper">
								<a href="<?php echo esc_url( $demo['preview_url'] ); ?>" class="btn-preview-site">
									<?php echo sprintf( __( 'Preview "%s" Site', 'woostify-sites-library' ), $demo['import_file_name']); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		// wp_send_json_success( $demo);
		die();
	}

}
/**
 * Kicking this off by calling 'get_instance()' method
 */
\Woostify\Admin\Admin::get_instance();
