<?php
/**
 * Plugin Name:  Woostify Sites Library
 * Description:  Import site demos built with Woostify theme
 * Version:      1.4.5
 * Author:       Woostify
 * Author URI:   https://woostify.com
 * License:      GPLv2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  woostify-sites-library
 *
 * The following code is a derivative work from Merlin WP by the
 * Rich Tabor from ThemeBeans.com & the team at ProteusThemes.com and
 * Envato WordPress Theme Setup Wizard by David Baker.
 *
 * @package Woostify Sites
 */

/**
 * Set constants.
 */
if ( ! defined( 'WOOSTIFY_SITES_NAME' ) ) {
	define( 'WOOSTIFY_SITES_NAME', __( 'Woostify Sites', 'woostify-sites-library' ) );
}

if ( ! defined( 'WOOSTIFY_SITES_VER' ) ) {
	define( 'WOOSTIFY_SITES_VER', '1.4.5' );
}

if ( ! defined( 'WOOSTIFY_SITES_FILE' ) ) {
	define( 'WOOSTIFY_SITES_FILE', __FILE__ );
}

if ( ! defined( 'WOOSTIFY_SITES_BASE' ) ) {
	define( 'WOOSTIFY_SITES_BASE', plugin_basename( WOOSTIFY_SITES_FILE ) );
}

if ( ! defined( 'WOOSTIFY_SITES_DIR' ) ) {
	define( 'WOOSTIFY_SITES_DIR', plugin_dir_path( WOOSTIFY_SITES_FILE ) );
}

if ( ! defined( 'WOOSTIFY_SITES_URI' ) ) {
	define( 'WOOSTIFY_SITES_URI', plugins_url( '/', WOOSTIFY_SITES_FILE ) );
}

require_once WOOSTIFY_SITES_DIR . 'class-woostify-sites.php';
require_once WOOSTIFY_SITES_DIR . 'vendor/autoload.php';

/**
 * Set directory locations, text strings, and settings.
 */
$wizard      = new Woostify_Sites(
	$config  = array(
		'woostify_sites_url'   => 'woostify-sites', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => false, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => '', // Link for the big button on the ready step.
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Woostify Sites Library', 'woostify-sites-library' ),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'woostify-sites-library' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'woostify-sites-library' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'woostify-sites-library' ),

		'btn-skip'                 => esc_html__( 'Skip', 'woostify-sites-library' ),
		'btn-next'                 => esc_html__( 'Next', 'woostify-sites-library' ),
		'btn-start'                => esc_html__( 'Start', 'woostify-sites-library' ),
		'btn-no'                   => esc_html__( 'Cancel', 'woostify-sites-library' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'woostify-sites-library' ),
		'btn-child-install'        => esc_html__( 'Install', 'woostify-sites-library' ),
		'btn-content-install'      => esc_html__( 'Install', 'woostify-sites-library' ),
		'btn-import'               => esc_html__( 'Start Import', 'woostify-sites-library' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'woostify-sites-library' ),
		'btn-license-skip'         => esc_html__( 'Later', 'woostify-sites-library' ),

		/* translators: Theme Name */
		'license-header%s'         => esc_html__( 'Activate %s', 'woostify-sites-library' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'woostify-sites-library' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'woostify-sites-library' ),
		'license-label'            => esc_html__( 'License key', 'woostify-sites-library' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'woostify-sites-library' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'woostify-sites-library' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'woostify-sites-library' ),

		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Welcome to %s', 'woostify-sites-library' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'woostify-sites-library' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'woostify-sites-library' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'woostify-sites-library' ),

		'child-header'             => esc_html__( 'Install Child Theme', 'woostify-sites-library' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'woostify-sites-library' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'woostify-sites-library' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'woostify-sites-library' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'woostify-sites-library' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'woostify-sites-library' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'woostify-sites-library' ),

		'plugins-header'           => esc_html__( 'Install Plugins', 'woostify-sites-library' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'woostify-sites-library' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'woostify-sites-library' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'woostify-sites-library' ),
		'plugins-action-link'      => esc_html__( 'Advanced', 'woostify-sites-library' ),

		'import-header'            => esc_html__( 'Import Starter Site', 'woostify-sites-library' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'woostify-sites-library' ),
		'import-action-link'       => esc_html__( 'Advanced', 'woostify-sites-library' ),

		'ready-header'             => esc_html__( 'All done. Have fun!', 'woostify-sites-library' ),

		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by Woostify.', 'woostify-sites-library' ),
		'ready-action-link'        => esc_html__( 'Extras', 'woostify-sites-library' ),
		'ready-big-button'         => esc_html__( 'View your website', 'woostify-sites-library' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://woostify.com/', esc_html__( 'Explore Woostify', 'woostify-sites-library' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://woostify.com/contact/', esc_html__( 'Get Theme Support', 'woostify-sites-library' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'woostify-sites-library' ) ),
	)
);

require_once WOOSTIFY_SITES_DIR . 'demos/demos.php';
// require_once WOOSTIFY_SITES_DIR . 'includes/class-woostify-sites-elementor.php';

/**
 * Initialize the tracker
 *
 * @return void
 */
function appsero_init_tracker_woostify_sites_library() {

	if ( ! class_exists( 'Appsero\Client' ) ) {
		require_once __DIR__ . '/appsero/client/src/Client.php';
	}

	$client = new Appsero\Client( '424aa9f8-2435-4fa7-a61c-fad11ff04249', 'Woostify Sites Library', __FILE__ );

	// Active insights
	$client->insights()->hide_notice()->init();

}

appsero_init_tracker_woostify_sites_library();
