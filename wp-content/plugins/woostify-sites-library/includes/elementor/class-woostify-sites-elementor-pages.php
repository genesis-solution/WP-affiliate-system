<?php
/**
 * Elementor Importer
 *
 * @package Woostify Sites
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If plugin - 'Elementor' not exist then return.
if ( ! class_exists( '\Elementor\Plugin' ) ) {
	return;
}

use Elementor\Core\Base\Document;
use Elementor\DB;
use Elementor\Core\Settings\Page\Manager as PageSettingsManager;
use Elementor\Core\Settings\Manager as SettingsManager;
use Elementor\Core\Settings\Page\Model;
use Elementor\Editor;
use Elementor\Plugin;
use Elementor\Settings;
use Elementor\Utils;
use Elementor\TemplateLibrary\Source_Local;

/**
 * Elementor template library local source.
 *
 * Elementor template library local source handler class is responsible for
 * handling local Elementor templates saved by the user locally on his site.
 *
 * @since 2.0.0 Added compatibility for Elemetnor v2.5.0
 */
class Woostify_Sites_Elementor_Pages extends Source_Local {

	/**
	 * Update post meta.
	 *
	 * @since 2.0.0
	 * @param  integer $post_id Post ID.
	 * @param  array   $data Elementor Data.
	 * @return array   $data Elementor Imported Data.
	 */
	public function import( $post_id = 0, $data = array(), $contact_form = '' ) {

		if ( ! empty( $post_id ) && ! empty( $data ) ) {

			$data = wp_json_encode( $data, true );
			if ( ! empty( $contact_form ) ) {

				$handle   = fopen( $contact_form, 'r' );
				$row      = fgetcsv( $handle );
				$args     = array();
				while ( $row = fgetcsv( $handle )) {

					$id = $row[1];
					$title = $row[6];
					$args = array(
						'post_author'  => $row[2],
						'post_content' => $row[5],
						'post_title'   => $row[6],
						'post_excerpt' => $row[7],
						'post_status'  => $row[8],
						'post_name'    => $row[12],
						'post_type'    => $row[20],
					);

					$wpcf7 = wp_insert_post( $args );
					$content = explode( "1\n", $row[5]);
					wpcf7_save_contact_form(
						array(
							'id' => $wpcf7,
							'title' => $title,
							'form'  => $content['0'],
						)
					);

					$new_wpcf7 = '[contact-form-7 id=\"' . $wpcf7;
					$old_wpcf7 = '[contact-form-7 id=\"' . $id;
					$data  = str_replace( $old_wpcf7, $new_wpcf7, $data );

				}
				fclose($handle);
			}

			$data = json_decode( $data, true );

			// Import the data.
			$data = $this->process_export_import_content( $data, 'on_import' );
			// Update processed meta.
			update_metadata( 'post', $post_id, '_elementor_data', $data );

			// !important, Clear the cache after images import.
			\Elementor\Plugin::$instance->files_manager->clear_cache();

			return $data;
		}

		return array();
	}
}
