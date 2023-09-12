<?php
/**
 * login.php
 *
 * Copyright (c) 2010 - 2018 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates
 * @since affiliates 4.0.0
 *
 * This is a template file. You can customize it by copying it
 * into the appropriate subfolder of your theme:
 *
 *   mytheme/affiliates/dashboard/login.php
 *
 * It is highly recommended to use a child theme for such customizations.
 * Child themes are suitable to keep things up-to-date when the parent
 * theme is updated, while any customizations in the child theme are kept.
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var Affiliates_Dashboard_Login $section Section object available for use in the template.
 */
?>
<?php if ( !is_user_logged_in() ) : ?>
	<h2><?php esc_html_e( '登錄', 'affiliates' ); ?></h2>
	<div class="dashboard-section dashboard-section-login" style="text-align: center">
<!--        Please log in to access the affiliate area.-->
        <style>
            #form-container {
                width: 400px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f2f2f2;
            }

            /* Style the form container border */
            #form-container::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                border: 1px solid #ccc;
                border-radius: 4px;
                z-index: -1;
            }

            /* Style the form labels */
            label {
                width: 320px;
                margin: auto;
                display: block;
                margin-bottom: 10px;
                font-weight: bold;
                color: #333;
                text-align: left;
            }

            /* Style the form inputs */
            #form-container input[type="text"],
            #form-container input[type="email"],
            #form-container textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            /* Style the form submit button */
            #form-container input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            /* Hover effect for the submit button */
            #form-container input[type="submit"]:hover {
                background-color: #45a049;
            }
        </style>
		<?php echo wp_login_form( array( 'echo' => false, 'redirect' => get_permalink() ) ); ?>
	</div>
<?php endif; ?>
<style type="text/css">
	.dashboard-section-login .login-username label,
	.dashboard-section-login .login-password label {
		display: block;
	}
	.dashboard-section-login .login-username input,
	.dashboard-section-login .login-password input {
		max-width: 100%;
		width: 320px;
	}
</style>
