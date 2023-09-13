<?php
/**
 * wp-init.php
 *
 * Copyright (c) 2011 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-pro
 * @since affiliates-pro 1.0.1
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

global $affiliates_options, $affiliates_version, $affiliates_pro_version, $affiliates_pro_admin_messages;

if ( !isset( $affiliates_pro_admin_messages ) ) {
	$affiliates_pro_admin_messages = array();
}

if ( !isset( $affiliates_pro_version ) ) {
	$affiliates_pro_version = AFFILIATES_EXT_VERSION;
}

add_action( 'init', 'affiliates_pro_version_check' );
function affiliates_pro_version_check() { global $affiliates_pro_version, $affiliates_pro_admin_messages; $IX79738 = get_option( 'affiliates_pro_plugin_version', null ); $affiliates_pro_version = AFFILIATES_EXT_VERSION; if ( version_compare( $IX79738, $affiliates_pro_version ) < 0 ) { $IX92572 = affiliates_pro_update( $IX79738 ); if ( $IX92572 === true ) { update_option( 'affiliates_pro_plugin_version', $affiliates_pro_version ); } else { if ( $IX92572 === false ) { affiliates_log_error( 'There were errors during update (ext) – this might only be a temporary issue, unless this message comes up permanently.' ); } } } }

function affiliates_pro_admin_notices() { global $affiliates_pro_admin_messages; if ( !empty( $affiliates_pro_admin_messages ) ) { foreach ( $affiliates_pro_admin_messages as $IX86275 ) { echo $IX86275; } } }

add_action( 'admin_notices', 'affiliates_pro_admin_notices' );

function affiliates_pro_activate( $network_wide = false ) { if ( is_multisite() && $network_wide ) { $IX34340 = affiliates_get_blogs(); foreach ( $IX34340 as $IX19772 ) { switch_to_blog( $IX19772 ); affiliates_pro_setup(); restore_current_blog(); } } else { affiliates_pro_setup(); } }

function affiliates_pro_setup() { global $affiliates_db, $wpdb; if ( affiliates_pro_check_dependencies() ) { $IX95115 = null; $IX53006 = null; if ( ! empty( $wpdb->charset ) ) { $IX95115 = $wpdb->charset; } if ( ! empty( $wpdb->collate ) ) { $IX53006 = $wpdb->collate; } $affiliates_db->create_tables( $IX95115, $IX53006 ); affiliates_pro_update(); } }

function affiliates_pro_wpmu_new_blog( $blog_id, $user_id ) { if ( is_multisite() ) { if ( affiliates_is_sitewide_plugin() ) { switch_to_blog( $blog_id ); affiliates_pro_setup(); restore_current_blog(); } } }

function affiliates_pro_delete_blog( $blog_id, $drop = false ) { if ( is_multisite() ) { if ( affiliates_is_sitewide_plugin() ) { switch_to_blog( $blog_id ); affiliates_pro_cleanup( $drop ); restore_current_blog(); } } }

register_activation_hook( AFFILIATES_PRO_FILE, 'affiliates_pro_activate' );
add_action( 'wpmu_new_blog', 'affiliates_pro_wpmu_new_blog', 11, 2 );
add_action( 'delete_blog', 'affiliates_pro_delete_blog', 10, 2 );

function affiliates_pro_update( $previous_version = null ) { global $affiliates_db, $wpdb; $IX60431 = true; if ( defined( 'DOING_AJAX' ) && DOING_AJAX || defined( 'DOING_CRON' ) && DOING_CRON ) { return null; } $IX61086 = null; $IX32456 = null; if ( ! empty( $wpdb->charset ) ) { $IX61086 = $wpdb->charset; } if ( ! empty( $wpdb->collate ) ) { $IX32456 = $wpdb->collate; } if ( !$affiliates_db->update_tables( $previous_version, $IX61086, $IX32456 ) ) { $IX60431 = false; } return $IX60431; }

remove_action( 'deactivate_' . plugin_basename( AFFILIATES_PRO_FILE ), 'affiliates_deactivate' );
register_deactivation_hook( AFFILIATES_PRO_FILE, 'affiliates_pro_deactivate' );

function affiliates_pro_deactivate( $network_wide = false ) { if ( is_multisite() && $network_wide ) { if ( get_option( 'aff_delete_network_data', false ) ) { $IX27390 = affiliates_get_blogs(); foreach ( $IX27390 as $IX52421 ) { switch_to_blog( $IX52421 ); affiliates_pro_cleanup( true ); restore_current_blog(); } } } else { affiliates_pro_cleanup(); } affiliates_deactivate( $network_wide ); }

function affiliates_pro_cleanup( $delete = false ) { global $affiliates_db; $IX49093 = get_option( 'aff_delete_data', false ) || $delete; if ( $IX49093 ) { $affiliates_db->drop_tables(); delete_option( 'affiliates_pro_plugin_version' ); delete_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_KEY ); delete_option( Affiliates_Referral::DEFAULT_REFERRAL_CALCULATION_VALUE ); delete_option( 'affiliates_notifications' ); } }

add_action( 'init', 'affiliates_pro_init' );

function affiliates_pro_init() {
    global $affiliates_pro_admin_messages;
    load_plugin_textdomain( 'affiliates', null, AFFILIATES_PLUGIN_NAME . '/lib/ext/languages' );
    affiliates_pro_check_dependencies();
}

function affiliates_pro_check_dependencies() {
    global $affiliates_pro_admin_messages; $IX79973 = true;
//    $IX90261 = get_option( 'active_plugins', array() );
//    $IX57222 = in_array( 'affiliates/affiliates.php', $IX90261 );
//    if ( is_multisite() ) { $IX22122 = get_site_option( 'active_sitewide_plugins', array() );
//        $IX57222 = $IX57222 || key_exists( 'affiliates/affiliates.php', $IX22122 ); }
//    if ( $IX57222 ) { $affiliates_pro_admin_messages[] =
//        "<div class='error'>" . __( 'The <a href="https://www.itthinx.com/plugins/affiliates" target="_blank">Affiliates</a> plugin must be deactivated or removed.', 'affiliates' ) . "</div>";
//        include_once ABSPATH . 'wp-admin/includes/plugin.php';
//        deactivate_plugins( AFFILIATES_PLUGIN_BASENAME );
//        $IX79973 = false; } if ( function_exists( 'fake_bcadd' ) )
//        {
//            if ( isset( $_GET['page'] ) ) {
//                if ( ( "affiliates-admin-options" == $_GET['page'] ) || ( "affiliates-admin-settings" == $_GET['page'] ) )
//                {
//                    $affiliates_pro_admin_messages[] = "<div class='error'>" . __( 'You are running PHP with <a target="_blank" href="http://www.php.net/manual/en/book.bc.php">BCMath Arbitrary Precision Mathematics</a> disabled. Your <strong>Affiliates</strong> plugin will use substitute functions, but you should seriously consider getting BCMath enabled to avoid loss of precision.', 'affiliates' ) . "</div>"; } } }
    return true;
}

if ( !function_exists( 'bcadd' ) ) {
	include_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/fake_bcmath.php';
}

require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/interfaces.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/abstract/abstract.php';
function affiliates_pro_affiliates_attributes_init() { Affiliates_Attributes::set_keys( array( Affiliates_Attributes::PAYPAL_EMAIL => __( 'PayPal Email', 'affiliates' ), Affiliates_Attributes::REFERRAL_AMOUNT => __( '推薦金額', 'affiliates' ), Affiliates_Attributes::REFERRAL_AMOUNT_METHOD => __( '推薦金額方法', 'affiliates' ), Affiliates_Attributes::REFERRAL_RATE => __( '推薦率', 'affiliates' ), Affiliates_Attributes::COUPONS => __( 'Coupons', 'affiliates' ), Affiliates_Attributes::COOKIE_TIMEOUT_DAYS => __( 'Cookie Expiration', 'affiliates' ) ) ); }
add_action( 'init', 'affiliates_pro_affiliates_attributes_init' );
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/wordpress/wordpress.php';

require_once AFFILIATES_CORE_LIB . '/class-affiliates-utility.php';
require_once AFFILIATES_CORE_LIB . '/class-affiliates-pagination.php';

require_once AFFILIATES_CORE_LIB . '/class-affiliates-date-helper.php';

require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/wordpress/class-affiliates-affiliate-stats-widget.php';
add_action( 'widgets_init', 'affiliates_pro_widgets_init' );

require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/class-affiliates-notifications-extended.php';
if ( is_admin() ) {
	require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/wordpress/class-affiliates-admin-notifications-extended.php';
}

require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/class-affiliates-export.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/class-affiliates-referrals-export.php';

require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/class-affiliates-rate.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/class-affiliates-formula-tokenizer.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/includes/class-affiliates-formula-computer.php';

require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-overview-pro.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-overview-pro-block.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-overview-pro-shortcode.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-referrals.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-referrals-block.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-referrals-shortcode.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-traffic.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-traffic-block.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-traffic-shortcode.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-banners.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-banners-block.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-banners-shortcode.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-shoplist.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-shoplist-block.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-shoplist-shortcode.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-purchased.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-purchased-block.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-purchased-shortcode.php';
require_once dirname( AFFILIATES_PRO_FILE ) . '/lib/ext/dashboard/class-affiliates-dashboard-pro.php';

function affiliates_pro_widgets_init() { register_widget( 'Affiliates_Affiliate_Stats_Widget' ); }

add_filter( 'affiliates_footer', array( 'Affiliates_Ext_Footer', 'render' ) );
class Affiliates_Ext_Footer {
	public static function render( $footer ) { $IX96995 = ucwords( str_replace( '-', ' ', AFFILIATES_PLUGIN_NAME ) ); $footer = sprintf( '<div class="%s-footer">', AFFILIATES_PLUGIN_NAME ) . sprintf( '<div class="%s">', AFFILIATES_PLUGIN_NAME ) . sprintf( 'Powered by <a href="%s">%s</a>', sprintf( 'https://www.itthinx.com/plugins/%s', AFFILIATES_PLUGIN_NAME ), sprintf( '<img style="vertical-align:middle" src="%s://www.itthinx.com/img/%s/%s.png" alt="Icon"/>%s</a>', is_ssl() ? 'https' : 'http', AFFILIATES_PLUGIN_NAME, AFFILIATES_PLUGIN_NAME, $IX96995 ) ) . ' ' . sprintf( '<span style="font-size:0.8em">&#169; Copyright %d <a href="https://www.itthinx.com">itthinx</a>', date( 'Y' ) ) . '</span>' . ' ' . '<span style="font-size:0.7em">' . 'Use of this plugin without a granted license constitutes an act of COPYRIGHT INFRINGEMENT and LICENSE VIOLATION.' . ' ' . 'This plugin contains parts that are provided under the GPLv3 License and strictly independent proprietary parts to which the GPLv3 License does not apply.' . ' ' . 'You MUST be granted a license by the copyright holder for those parts that are not provided under the GPLv3 license.' . ' ' . 'If you have not obtained a license by the copyright holder, you should remove this plugin and use the fully GPLv3-licensed <a href="https://www.itthinx.com/plugins/affiliates/">Affiliates</a> plugin instead.' . '</span>' . '</div>' . '</div>'; return $footer; }
}

add_action( 'admin_init', 'affiliates_pro_admin_init' );

function affiliates_pro_admin_init() { global $affiliates_pro_version; wp_register_style( 'smoothness', AFFILIATES_CORE_URL . '/css/smoothness/jquery-ui.min.css', array(), $affiliates_pro_version ); wp_register_style( 'affiliates_pro_admin', AFFILIATES_PRO_PLUGIN_URL . 'css/affiliates_pro_admin.css', array(), $affiliates_pro_version ); }

add_action( 'affiliates_admin_menu', 'affiliates_pro_affiliates_admin_menu' );
function affiliates_pro_affiliates_admin_menu( $pages ) { foreach ( $pages as $IX76427 ) { add_action( 'admin_print_styles-' . $IX76427, 'affiliates_pro_admin_print_styles' ); add_action( 'admin_print_scripts-' . $IX76427, 'affiliates_pro_admin_print_scripts' ); } }

add_filter( 'affiliates_add_submenu_page_function', 'affiliates_pro_affiliates_add_submenu_page_function' );
function affiliates_pro_affiliates_add_submenu_page_function( $function ) { if ( $function == 'affiliates_admin_affiliates' ) { $IX52969 = new Affiliates_Affiliates_WordPress(); return array( $IX52969, 'view' ); } else { return $function; } }

function affiliates_pro_admin_print_styles() { wp_enqueue_style( 'smoothness' ); wp_enqueue_style( 'affiliates_pro_admin' ); }

function affiliates_pro_admin_print_scripts() { global $affiliates_pro_version; wp_enqueue_script( 'datepicker', AFFILIATES_PRO_PLUGIN_URL . 'js/jquery-ui.min.js', array( 'jquery', 'jquery-ui-core' ), $affiliates_pro_version ); wp_enqueue_script( 'datepickers', AFFILIATES_PRO_PLUGIN_URL . 'js/datepickers.js', array( 'jquery', 'jquery-ui-core', 'datepicker' ), $affiliates_pro_version ); wp_enqueue_script( 'my affiliate pro', AFFILIATES_PRO_PLUGIN_URL . 'js/affiliates-pro.js', array( 'jquery' ), $affiliates_pro_version ); $IX60217 = get_current_screen(); if ( isset( $IX60217->id ) ) { switch( $IX60217->id ) { case 'affiliates_page_affiliates-admin-rates' : Affiliates_UI_Elements::enqueue( 'select' ); if ( class_exists( 'Groups_UIE' ) ) { Groups_UIE::enqueue( 'select' ); } break; } } }

add_action( 'wp_enqueue_scripts', 'affiliates_pro_wp_enqueue_scripts' );
function affiliates_pro_wp_enqueue_scripts() { global $affiliates_pro_version; wp_register_style( 'my affiliate pro', AFFILIATES_PRO_PLUGIN_URL . 'css/affiliates_pro.css', array(), AFFILIATES_EXT_VERSION ); wp_register_style( 'smoothness', AFFILIATES_CORE_URL . 'css/smoothness/jquery-ui.min.css', array(), AFFILIATES_EXT_VERSION ); wp_register_script( 'excanvas', AFFILIATES_PLUGIN_URL . 'js/graph/flot/excanvas.min.js', array( 'jquery' ), AFFILIATES_EXT_VERSION ); wp_register_script( 'flot', AFFILIATES_PLUGIN_URL . 'js/graph/flot/jquery.flot.min.js', array( 'jquery' ), AFFILIATES_EXT_VERSION ); wp_register_script( 'flot-resize', AFFILIATES_PLUGIN_URL . 'js/graph/flot/jquery.flot.resize.min.js', array( 'jquery', 'flot' ), AFFILIATES_EXT_VERSION ); wp_register_script( 'datepicker', AFFILIATES_CORE_URL . 'js/jquery-ui.min.js', array( 'jquery', 'jquery-ui-core' ), AFFILIATES_EXT_VERSION, true ); wp_register_script( 'datepickers', AFFILIATES_CORE_URL . 'js/datepickers.js', array( 'jquery', 'jquery-ui-core', 'datepicker' ), AFFILIATES_EXT_VERSION, true ); }

add_action( 'affiliates_cookie_timeout_days', 'affiliates_get_affiliates_cookie_timeout_days', 10, 2 );
function affiliates_get_affiliates_cookie_timeout_days( $days, $affiliate_id ) { global $affiliates_db; $IX94402 = $affiliates_db->get_tablename( 'affiliates_attributes' );
    $IX71924 = $affiliates_db->get_value( "SELECT attr_value FROM $IX94402 WHERE affiliate_id = %d AND attr_key = %s",
        $affiliate_id, Affiliates_Attributes::COOKIE_TIMEOUT_DAYS );
    if ( $IX71924 !== null ) { $days = intval( $IX71924 ); }
  //  return $days;
    return 100;
}

function affiliates_pro_get_integrations() { ob_start(); $IX86942 = array(); require_once AFFILIATES_CORE_LIB . '/class-affiliates-settings-integrations.php'; $IX25630 = Affiliates_Settings_Integrations::get_integrations(); if ( !empty( $IX25630 ) && is_array( $IX25630 ) ) { foreach( $IX25630 as $IX35424 => $IX86418 ) { if ( is_plugin_active( $IX86418['plugin_file'] ) ) { switch( $IX35424 ) { case 'affiliates-contact-form-7' : $IX86942[$IX35424] = $IX86418; $IX86942[$IX35424]['object'] = 'wpcf7_contact_form'; $IX86942[$IX35424]['taxonomy'] = null; break; case 'affiliates-events-manager' : $IX86942[$IX35424] = $IX86418; $IX86942[$IX35424]['object'] = defined( 'EM_POST_TYPE_EVENT' ) ? EM_POST_TYPE_EVENT : 'event'; $IX86942[$IX35424]['taxonomy'] = defined( 'EM_TAXONOMY_CATEGORY' ) ? EM_TAXONOMY_CATEGORY : 'event-categories'; break; case 'affiliates-formidable' : $IX86942[$IX35424] = $IX86418; $IX86942[$IX35424]['object'] = null; $IX86942[$IX35424]['taxonomy'] = null; break; case 'affiliates-gravityforms' : $IX86942[$IX35424] = $IX86418; $IX86942[$IX35424]['object'] = null; $IX86942[$IX35424]['taxonomy'] = null; break; case 'affiliates-ninja-forms' : $IX86942[$IX35424] = $IX86418; $IX86942[$IX35424]['object'] = null; $IX86942[$IX35424]['taxonomy'] = null; break; case 'affiliates-paypal' : $IX86942[$IX35424] = $IX86418; $IX86942[$IX35424]['object'] = null; $IX86942[$IX35424]['taxonomy'] = null; break; case 'affiliates-ppc' : $IX86942[$IX35424] = $IX86418; $IX86942[$IX35424]['object'] = null; $IX86942[$IX35424]['taxonomy'] = null; break; case 'affiliates-woocommerce' : $IX86942[$IX35424] = $IX86418; $IX86942[$IX35424]['object'] = 'product'; $IX86942[$IX35424]['taxonomy'] = 'product_cat'; break; } } } } ob_end_clean(); return $IX86942; }

function total_product_page_views_shortcode($atts) {
    // Extract the attributes
    $attributes = shortcode_atts(
        array(
            'view_page_full_path' => 'default_value1',
            'is_view' => 'false',
        ),
        $atts
    );

    // Access the attribute values
    $view_page = $attributes['view_page_full_path'];
    $is_view = $attributes['is_view'];

    global $wpdb;

    $products = $wpdb->get_results($wpdb->prepare(
        "SELECT `ID`, `post_title`, `post_name`, `post_content` FROM {$wpdb->posts} WHERE `post_type` = %s AND `post_status` = %s ORDER BY `post_title` ASC;",
        'product', 'publish'
    ));

    $table_name = $wpdb->prefix . 'share_products';
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $project_count = 0;
        foreach ($products as $product) {
            $shared_value_by_post_id = $wpdb->get_row($wpdb->prepare(
                "SELECT `user_id`, `status`, `token` FROM {$table_name} WHERE `post_id` = %s;",
                $product->ID
            ));

            if (!empty($shared_value_by_post_id) && $shared_value_by_post_id->user_id == $user_id) {
                $project_count++;
            }
        }

        ?>
    <style>

        .view-count {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .redirect-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .redirect-button:hover {
            background-color: #45a049;
        }
    </style>
    <div class="container">
        <span class="view-count">
            產品頁觀看總和: <span id="count"><?php echo $project_count; ?></span>
        </span>
        <?php
        if ($is_view == 'true')
        {
        ?>
        <a href="<?php echo $view_page; ?>" class="redirect-button">看法</a>
        <?php
        }
        ?>
    </div>
<?php
    }
    else {
        ?>
        <style>

            .view-count {
                font-size: 24px;
                color: #333;
                margin-bottom: 20px;
            }

            .redirect-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }

            .redirect-button:hover {
                background-color: #45a049;
            }
        </style>
        <div class="container">
            <span class="view-count">
                產品頁觀看總和: <span id="count">0</span>
            </span>
            <?php
            if ($is_view == 'true')
            {
                ?>
                <a href="<?php echo $view_page; ?>" class="redirect-button">看法</a>
                <?php
            }
            ?>
        </div>
            <?php
    }

}
add_shortcode('total_product_page_views', 'total_product_page_views_shortcode');


function total_monthly_fees_paid_for_project_shortcode($atts) {
    // Extract the attributes
    $attributes = shortcode_atts(
        array(
            'view_page_full_path' => 'default_value1',
            'is_view' => 'false',
        ),
        $atts
    );

    // Access the attribute values
    $view_page = $attributes['view_page_full_path'];
    $is_view = $attributes['is_view'];

    global $wpdb;

    $products = $wpdb->get_results($wpdb->prepare(
        "SELECT `ID`, `post_title`, `post_name`, `post_content` FROM {$wpdb->posts} WHERE `post_type` = %s AND `post_status` = %s ORDER BY `post_title` ASC;",
        'product', 'publish'
    ));

    $table_name = $wpdb->prefix . 'share_products';
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $project_count = 0;
        foreach ($products as $product) {
            $shared_value_by_post_id = $wpdb->get_row($wpdb->prepare(
                "SELECT `user_id`, `status`, `token` FROM {$table_name} WHERE `post_id` = %s;",
                $product->ID
            ));

            if (!empty($shared_value_by_post_id) && $shared_value_by_post_id->user_id == $user_id) {
                $project_count++;
            }
        }

        $total_amount = intval($project_count) * 5;
        ?>
        <style>

            .view-count {
                font-size: 24px;
                color: #333;
                margin-bottom: 20px;
            }

            .redirect-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }

            .redirect-button:hover {
                background-color: #45a049;
            }
        </style>
        <div class="container">
            <span class="view-count">
                專案繳交的月費總和: <span id="count">$<?php echo $total_amount; ?></span>
            </span>
            <?php
            if ($is_view == 'true')
            {
                ?>
                <a href="<?php echo $view_page; ?>" class="redirect-button">看法</a>
                <?php
            }
            ?>
        </div>
        <?php
    }
    else {
        ?>

        <style>

            .view-count {
                font-size: 24px;
                color: #333;
                margin-bottom: 20px;
            }

            .redirect-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }

            .redirect-button:hover {
                background-color: #45a049;
            }
        </style>
        <div class="container">
            <span class="view-count">
                專案繳交的月費總和: <span id="count">$0</span>
            </span>
            <?php
            if ($is_view == 'true')
            {
                ?>
                <a href="<?php echo $view_page; ?>" class="redirect-button">看法</a>
                <?php
            }
            ?>
        </div>
            <?php
    }

}
//Total monthly fees paid for the project
add_shortcode('total_monthly_fees_paid_for_project', 'total_monthly_fees_paid_for_project_shortcode');

function total_get_profit_from_project_shortcode($atts) {
    // Extract the attributes
    $attributes = shortcode_atts(
        array(
            'view_page_full_path' => 'default_value1',
            'is_view' => 'false',
        ),
        $atts
    );

    // Access the attribute values
    $view_page = $attributes['view_page_full_path'];
    $is_view = $attributes['is_view'];




    global $wpdb, $affiliates_options, $affiliates_version;

    $per_page = 100000;
    $current_page = 0;

    // filters
    $from_date = null;
    $thru_date = null;


    $orderby = 'period';

    $sort_order = 'DESC';
    $filters = " WHERE 1=%d ";
    $filter_params = array( 1 );
    // We now have the desired dates from the user's point of view, i.e. in her timezone.
    // If supported, adjust the dates for the site's timezone:
    if ( $from_date ) {
        $from_datetime = DateHelper::u2s( $from_date );
    }
    if ( $thru_date ) {
        $thru_datetime = DateHelper::u2s( $thru_date, 24*3600 );
    }
    if ( $from_date && $thru_date ) {
        $filters .= " AND r.datetime >= %s AND r.datetime <= %s ";
        $filter_params[] = $from_datetime;
        $filter_params[] = $thru_datetime;
    } else if ( $from_date ) {
        $filters .= " AND r.datetime >= %s ";
        $filter_params[] = $from_datetime;
    } else if ( $thru_date ) {
        $filters .= " AND r.datetime < %s ";
        $filter_params[] = $thru_datetime;
    }

    $user_id = get_current_user_id();

    $affiliate_id = null;

    $affiliate_user = affiliates_get_user_affiliate($user_id);

    if (!empty($affiliate_user) && count($affiliate_user) > 0) {
        $affiliate_id = $affiliate_user[0];
    }
    $filters .= " AND r.affiliate_id = %d ";
    $filter_params[] = $affiliate_id;

    $status_condition = '';

    $offset = $per_page * $current_page;

    $referrals_table  = _affiliates_get_tablename( 'referrals' );

    $query_base =
        "SELECT SQL_CALC_FOUND_ROWS " .
        "YEAR(datetime) year, " .
        "MONTH(datetime) month, " .
        "SUM(amount) total, " .
        "SUM(IF(status='" . esc_sql( AFFILIATES_REFERRAL_STATUS_ACCEPTED ) . "',amount,0)) total_accepted, " .
        "SUM(IF(status='" . esc_sql( AFFILIATES_REFERRAL_STATUS_CLOSED ) . "',amount,0)) total_closed, " .
        "SUM(IF(status='" . esc_sql( AFFILIATES_REFERRAL_STATUS_PENDING ) . "',amount,0)) total_pending, " .
        "SUM(IF(status='" . esc_sql( AFFILIATES_REFERRAL_STATUS_REJECTED ) . "',amount,0)) total_rejected, " .
        "currency_id " .
        "FROM $referrals_table r " .
        "$filters " .
        "GROUP BY YEAR(datetime), MONTH(datetime), currency_id ";

    $query_suffix = "ORDER BY YEAR(datetime) %s, MONTH(datetime) %s LIMIT %d OFFSET %d";

    $query = $query_base . sprintf( $query_suffix, $sort_order, $sort_order, intval( $per_page ), intval( $offset ) );

    $entries = $wpdb->get_results(
        $wpdb->prepare(
            $query,
            $filter_params
        ),
        OBJECT
    );

    $count = intval( $wpdb->get_var( "SELECT FOUND_ROWS()" ) );

    // Was this a query for a page beyond the last page?
    // If yes, reset and retrieve results for the first page.
    if ( count( $entries ) === 0 && $count > 0 ) {
        $current_page = 0;
        $query = $query_base . sprintf( $query_suffix, $sort_order, $sort_order, intval( $per_page ), 0 ); // OFFSET 0
        $entries = $wpdb->get_results(
            $wpdb->prepare(
                $query,
                $filter_params
            ),
            OBJECT
        );
        $count = intval( $wpdb->get_var( "SELECT FOUND_ROWS()" ) );
    }

    if (is_user_logged_in() && count($entries) > 0) {

        $total_amount = $entries[0]->total;
        $display_amount = sprintf( '%.' . affiliates_get_referral_amount_decimals( 'display' ) . 'f', $entries[0]->total );

        ?>
        <style>

            .view-count {
                font-size: 24px;
                color: #333;
                margin-bottom: 20px;
            }

            .redirect-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }

            .redirect-button:hover {
                background-color: #45a049;
            }
        </style>
        <div class="container">
            <span class="view-count">
                產品頁銷售的分潤總和: <span id="count"><?php echo esc_html( $entries[0]->currency_id ) . ' ' . esc_html( $display_amount ); ?></span>
            </span>
            <?php
            if ($is_view == 'true')
            {
                ?>
                <a href="<?php echo $view_page; ?>" class="redirect-button">看法</a>
                <?php
            }
            ?>
        </div>
        <?php

    }
    else {
        ?>
        <style>

            .view-count {
                font-size: 24px;
                color: #333;
                margin-bottom: 20px;
            }

            .redirect-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }

            .redirect-button:hover {
                background-color: #45a049;
            }
        </style>
        <div class="container">
            <span class="view-count">
                產品頁銷售的分潤總和: <span id="count">0</span>
            </span>
        </div>
<?php
    }

}
//Total monthly fees paid for the project
add_shortcode('total_get_profit_from_project', 'total_get_profit_from_project_shortcode');