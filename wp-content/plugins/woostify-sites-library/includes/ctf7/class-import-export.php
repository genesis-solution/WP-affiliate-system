<?php
/**
 * Woostify for Import Export Contact Form 7.
 *
 * @see https://woostify.com/
 *
 * @package Woostify
 */

namespace Woostify\CTF7;

/**
 * Woostify Import export contact form 7
 */
class Import_Export {

	/**
	 * Instance of Import_Export
	 *
	 * @since  1.0.0
	 * @var (Object) Import_Export
	 */
	private static $instance = null;

	/**
	 * Instance of Import_Export.
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
		add_filter( 'bulk_actions-toplevel_page_wpcf7', array( $this, 'export_bulk_actions' ) );
		add_filter( 'handle_bulk_actions-toplevel_page_wpcf7', array( $this, 'bulk_action' ), 10, 3 );
		add_filter( 'handle_bulk_actions-edit-wpcf7_contact_form', array( $this, 'bulk_action' ), 10, 3 );
		add_action( 'load-toplevel_page_wpcf7', array( $this, 'bulk_actions' ), 10, 3 );
		add_action( 'admin_notices', array( $this, 'bulk_action_notices' ) );

		add_filter( 'bulk_actions-edit-post', array( $this, 'export_bulk_actions' ) );
		add_filter( 'handle_bulk_actions-edit-post', array( $this, 'bulk_action' ), 10, 3 );
		add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );
	}

	/**
	 * Add Bulk Actions.
	 *
	 * @param (string) $redirect_to | The redirect URL.
	 *
	 * @param (string) $doaction | The action being taken.
	 *
	 * @param (array)  $post_ids | The items to take the action on. Accepts an array of IDs of posts, comments, terms, links, plugins, attachments, or users.
	 */
	public function bulk_action( $redirect_to, $doaction, $post_ids ) {
		$redirect_to = remove_query_arg( array( 'wpcf7_woostify_export' ), $redirect_to );

		if ( $doaction !== 'wpcf7_woostify_export' ) { // phpcs:ignore
			return $redirect_to;
		}
		$data = array();
		$i = 0;
		foreach ( $post_ids as $post_id ) {
			$curent_post = get_post( $post_id );

			if ( empty( $curent_post ) ) {
				continue;
			}
			$data[] = array(
				$i,
				$curent_post->ID,
				$curent_post->post_author,
				$curent_post->post_date,
				$curent_post->post_date_gmt,
				$curent_post->post_content,
				$curent_post->post_title,
				$curent_post->post_excerpt,
				$curent_post->post_status,
				$curent_post->comment_status,
				$curent_post->ping_status,
				$curent_post->post_password,
				$curent_post->post_name,
				$curent_post->to_ping,
				$curent_post->pinged,
				$curent_post->post_modified,
				$curent_post->post_modified_gmt,
				$curent_post->post_content_filtered,
				$curent_post->post_parent,
				$curent_post->menu_order,
				$curent_post->post_type,
				$curent_post->post_mime_type,
			);
			$i++;
		}
		$redirect_to = add_query_arg( 'wpcf7_woostify_export', count( $post_ids ), $redirect_to );

		return $redirect_to;
	}

	/**
	 * Add Bulk Actions.
	 */
	public function bulk_actions() {
		global $plugin_page;

		$action = wpcf7_current_action();
		$export = 0;

		if ( 'wpcf7_woostify_export' == $action ) { //phpcs:ignore
			if ( ! empty( $_POST['post_ID'] ) ) {
				check_admin_referer( 'wpcf7-export-contact-form_' . $_POST['post_ID'] );
			} elseif ( ! is_array( $_REQUEST['post'] ) ) {
				check_admin_referer( 'wpcf7-export-contact-form_' . $_REQUEST['post'] );
			} else {
				check_admin_referer( 'bulk-posts' );
			}

			$posts = empty( $_POST['post_ID'] ) ? (array) $_REQUEST['post'] : (array) $_POST['post_ID'];
			$data  = array();
			$i = 0;

			foreach ( $posts as $post_id ) {
				$post        = \WPCF7_ContactForm::get_instance( $post_id );
				$curent_post = get_post( $post_id );

				if ( empty( $post ) ) {
					continue;
				}
				$data[] = array(
					$i,
					$curent_post->ID,
					$curent_post->post_author,
					$curent_post->post_date,
					$curent_post->post_date_gmt,
					$curent_post->post_content,
					$curent_post->post_title,
					$curent_post->post_excerpt,
					$curent_post->post_status,
					$curent_post->comment_status,
					$curent_post->ping_status,
					$curent_post->post_password,
					$curent_post->post_name,
					$curent_post->to_ping,
					$curent_post->pinged,
					$curent_post->post_modified,
					$curent_post->post_modified_gmt,
					$curent_post->post_content_filtered,
					$curent_post->post_parent,
					$curent_post->menu_order,
					$curent_post->post_type,
					$curent_post->post_mime_type,
				);
				$i++;
				$export++;
			}

			$query = array();
			if ( $export > 0 ) {
				$query['message'] = 'export';
			}

			$this->download_send_headers( $data, 'wpcf7.csv' );

			$redirect_to = add_query_arg( $query, menu_page_url( 'wpcf7', false ) );

			wp_safe_redirect( $redirect_to );
			exit();

		}
	}

	/**
	 * Add bulk actions to pages.
	 *
	 * @param (array) $bulk_array | bulk actions array.
	 */
	public function export_bulk_actions( $bulk_array ) {
		$bulk_array['wpcf7_woostify_export'] = __( 'Export', 'woostify-sites-library' );
		return $bulk_array;
	}

	/**
	 * Add bulk actions notices to pages.
	 */
	public function bulk_action_notices() {
		if ( ! empty( $_REQUEST['wpcf7_woostify_export'] ) ) { //phpcs:ignore
			?>
			<div id="message" class="updated notice is-dismissible">
				<span>
					<?php echo sprintf( esc_html__( 'Price of %s products has been changed.', 'woostify-sites-library' ), intval( $_REQUEST['wpcf7_woostify_export'] ) ); //phpcs:ignore ?>
				</span>
			</div>
			<?php
		}
	}

	/**
	 * Create CSV.
	 *
	 * @param (array)  $array | data file csv.
	 *
	 * @param (string) $filename | file name csv.
	 */
	public function download_send_headers( $array, $filename ) {
		$fh = @fopen( 'php://output', 'w' ); //phpcs:ignore
		fprintf( $fh, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-type: text/csv' );
		header( "Content-Disposition: attachment; filename={$filename}" );
		header( 'Expires: 0' );
		header( 'Pragma: public' );
		foreach ( $array as $data_row ) {
			fputcsv( $fh, $data_row );
		}
		fclose( $fh ); //phpcs:ignore

		ob_end_flush();
		exit();
	}

}
/**
 * Kicking this off by calling 'get_instance()' method
 */
\Woostify\CTF7\Import_Export::get_instance();
