<?php

use WP_Social\App\Settings;
use WP_Social\Lib\Login\Line_App;

defined('ABSPATH') || exit;

/**
 * session stat for current redirect URL after login from social.
 *
 * @since : 1.0
 */
session_start();


if(isset($_GET['XScurrentPage']) and strlen(sanitize_url($_GET['XScurrentPage'])) > 2) {

	$_SESSION['xs_social_login_ref_url'] = sanitize_url($_GET['XScurrentPage']);
	$_SESSION['xs_social']['login_ref_url'] = sanitize_url($_GET['XScurrentPage']);
}

//wordpress default redirect_to param
if(!empty($_GET['redirect_to'])) {

	$_SESSION['xs_social']['redirect_to'] = urldecode(sanitize_url($_GET['redirect_to']));
}


/**
 * Variable Name: $currentURL
 * Variable Details: get Current URL from session data after login by social
 *
 * @since : 1.0
 */
$currentURL = isset($_SESSION['xs_social_login_ref_url']) ? sanitize_url($_SESSION['xs_social_login_ref_url']) : get_site_url();

/**
 * Wp Function: is_user_logged_in();
 * Function Details: check user login. If user is login after redirect current URL by $currentURL
 *
 * @since : 1.0
 */

if(is_user_logged_in()) {
	if(wp_redirect($currentURL)) {
		exit;
	}
}

/**
 * Variable Name : $xs_config
 * Variable Type : Array
 *
 * @since : 1.0
 */
$xs_config = [];

if(!empty($typeSocial)) {
	if($typeSocial == 'lineapp' && !empty($code)){
		create_line_app_user($code, $typeSocial);
	}

	/**
	 * Variable Name : $provider_data
	 * Variable Type : Array
	 * @return : array() $provider_data .  Get array from socail provider data ""
	 *
	 * @since : 1.0
	 */
	$provider_data = Settings::get_login_settings_data();

	/**
	 * Variable Name : $callBackUrl
	 * Variable Type : String
	 * Variable Details : Create dynamic callback URL for all social services.
	 *
	 * @since : 1.0
	 */
	$callBackUrl = get_site_url() . '/wp-json/wslu-social-login/type/' . $typeSocial;

	/**
	 * Variable Name : $serviceType
	 * Variable Type : Array
	 * @return : array().  Get array from custom function page "admin-custom-function.php"
	 *
	 * @since : 1.0
	 */
	$serviceType  = \WP_Social\App\Providers::get_core_providers_login();

	/**
	 * check array key from $serviceType by social type . For Example: facebook
	 *
	 * @since : 1.0
	 */
	if(array_key_exists($typeSocial, $serviceType)) {
		$socialType = $serviceType[$typeSocial];
	}

	/**
	 * API configration for Facebook, Twitter, Linkedin, Dribble, Pinterest, Wordpress, Instagram, GitHub, Vkontakte and Reddit
	 *
	 * @since : 1.0
	 */

	/**
	 * Set callback URL in array "$xs_config" for configration API
	 *
	 * @since : 1.0
	 */
	$xs_config['callback'] = $callBackUrl;

	/**
	 * Create array for API Providers for all service using foreach by variable "$serviceType"
	 *
	 * @since : 1.0
	 */
	foreach($serviceType as $serviceKey => $serviceValue) :
		$idData = 'id';
		if($serviceKey == 'twitter') {
			$idData = 'key';
		}

		$config_para = [
			'enabled' => true,
			'keys'    => [
				$idData  => isset($provider_data[$serviceKey]['id']) ? $provider_data[$serviceKey]['id'] : '',
				'secret' => isset($provider_data[$serviceKey]['secret']) ? $provider_data[$serviceKey]['secret'] : '',
			],
		];
		
		if( $serviceKey == 'linkedin' ) {
			$config_para['scope'] = 'r_liteprofile r_emailaddress'; // optional
		}

		$xs_config['providers'][$serviceValue] = $config_para;

	endforeach;
}


/**
 * Config API
 *
 * @since : 1.0
 */
$code = isset($_GET['code']) ? sanitize_text_field($_GET['code']) : '';

if(strlen($socialType) > 0) {

	try {
		$hybridauth = new Hybridauth\Hybridauth($xs_config);

		$adapter    = $hybridauth->authenticate($socialType);

		$isConnected = $adapter->isConnected();

		if($isConnected) :
			$getProfile = $adapter->getUserProfile();

			if(is_object($getProfile) && !empty($getProfile)) {

				/**
				 * Variable Name : $setting_data
				 * Variable Type : Array
				 * @return : array() $setting_data .  Get array from social global setting data "xs_global_setting_data"
				 *
				 * @since : 1.0
				 */
				$setting_data = get_option(\WP_Social\Keys::OK_GLOBAL_SETTINGS);

				/**
				 * Resolve it before resetting the session
				 */
				$final_redirect = resolve_redirect_url($_SESSION, $setting_data);


				/**
				 * Now cleaning the session
				 *
				 */
				xs_login_session_handaler();

				$avatar_obj = \WP_Social\App\Avatar::instance();

				$first_name = $avatar_obj->get_nice_name($getProfile, $socialType);
				$last_name = $avatar_obj->get_last_name($getProfile, $socialType);
				$s_user_key = $avatar_obj->get_username($getProfile, $socialType);
				$display_nm = $avatar_obj->get_display_name($getProfile, $socialType);
				$user_email = $getProfile->email;
				$description = $getProfile->description;

				$user_info  = $avatar_obj->get_linked_user($s_user_key, $socialType);
				
				$user = false;
				if (isset($user_info['username'])) {
					$user = get_user_by('login', $user_info['username']);
				}

				if ( !$user) {

					/**
					 * This is a registration process
					 * this user never? had registered with us
					 *
					 * Lets check if user's social profile email is existed in our system
					 * If it does we just let him log in
					 */
					$user_id = email_exists($user_email);

					if($user_id) {

						$user_nameD = xs_login_get_user_data_email($user_email, 'user_login');

						$avatar_obj->update_linked_user($s_user_key, $socialType, ['id' => $user_id, 'usr' => $user_nameD]);

						xs_user_login($user_nameD, $final_redirect);

						die('Most unlikely error occurred in your case.');
					}

					/**
					 * It turns out this user does not used his email in our system
					 * So lets make him a new username for login
					 *
					 */
					$user_nm = $avatar_obj->get_available_username($getProfile, $socialType);

					/**
					 * Grabbing the default role settings for new user
					 * Though it is working with wp_insert_user still adding this as per Ataur bhai
					 *
					 */
					$default_role = get_option('default_role', '');

					$insertData                  = [];
					$insertData['first_name']    = $first_name;
					$insertData['last_name']     = $last_name;
					$insertData['user_nicename'] = $user_nm;
					$insertData['user_email']    = $user_email;
					$insertData['display_name']  = $display_nm;
					$insertData['description']   = $description;

					/**
					 * User does not exists with prepared username or
					 * email from social site in our system
					 *
					 * Save the image from social site a attachment
					 * lets make a random password
					 * now create a new user
					 *
					 */
					$password                 = wp_generate_password();
					$insertData['user_login'] = $user_nm;
					$insertData['user_pass']  = $password;
					$insertData['role']       = $default_role;

					/**
					 * Make the avatar url
					 * and save the image as attachment
					 */
					$avatar_url = $avatar_obj->get_avatar_url($getProfile, $socialType);
//					if(get_option('wp_social_login_sync_image_too') == 'yes') {
//						$attach     = save_image_from_url_as_attachment($avatar_url);
//					}else{
//						$attach['error'] = true;
//					}
                   // $attach     = save_image_from_url_as_attachment($avatar_url);

					//$checkUser = xs_login_create_user($insertData);
					$checkUser = xs_social_create_user($insertData);

					if($checkUser > 0) {
						/**
						 * User created successful
						 * Update user meta
						 * Notify admin a new user has been created
						 * Notify user? [AR: a customer asked!]
						 *
						 */

                        update_user_meta($checkUser, 'xs_social_register_by', $socialType);
                        update_user_meta($checkUser, 'line_app_profile_image', $avatar_url);

//						if(empty($attach['error'])) {
//
//							update_user_meta($checkUser, 'xs_social_register_by', $socialType);
//							update_user_meta($checkUser, 'line_app_profile_image', $attach['url']);
//							update_user_meta($checkUser, 'line_app_profile_image_id', $attach['attachment_id']);
//						} else {
//							update_user_meta($checkUser, 'line_app_profile_image', '');
//							update_user_meta($checkUser, 'line_app_profile_image_error_log', $socialType . '::' . $attach['error']);
//						}

						$avatar_obj->update_linked_user($s_user_key, $socialType, ['id' => $checkUser, 'usr' => $user_nm]);

						/**
						 * As we have created the user with a random password and they are registering with social credential
						 * so there is no use of change of password
						 */
						update_user_meta($checkUser, 'xs_password_changed', 'yes');

						notify_new_user_to_user($insertData);
						
						$wp_social_login_settings = get_option('xs_global_setting_data');

						if (isset($wp_social_login_settings['email_new_registered_user']['enable']) && $wp_social_login_settings['email_new_registered_user']['enable'] == 1) {
							notify_new_user_to_admin($checkUser, $socialType);
						}

						xs_user_login($user_nm, $final_redirect);

						die('Most most unlikely error occurred in your case. user registration done but login failed!!');
					}

					die('New user creation failed!');

				} else {

					$id = $user->data->ID;
					
					update_user_meta($id, 'xs_social_register_by', $socialType);

					if(get_option('wp_social_login_sync') == 'yes') {


						update_user_meta($id, 'first_name', $first_name);
						update_user_meta($id, 'last_name', $last_name);
						update_user_meta($id, 'display_name', $display_nm);
						update_user_meta($id, 'description', $description);
						

//						if(get_option('wp_social_login_sync_image_too') == 'yes') {
//							$avatar_url = $avatar_obj->get_avatar_url($getProfile, $socialType);
//							$attach     = save_image_from_url_as_attachment($avatar_url);
//
//							if(empty($attach['error'])) {
//								wp_delete_attachment(get_user_meta($id, 'line_app_profile_image_id'));
//								update_user_meta($id, 'line_app_profile_image', $attach['url']);
//								update_user_meta($id, 'line_app_profile_image_id', $attach['attachment_id']);
//							}
//						}
                        $avatar_url = $avatar_obj->get_avatar_url($getProfile, $socialType);
                        //$attach     = save_image_from_url_as_attachment($avatar_url);

//                        if(empty($attach['error'])) {
//                            wp_delete_attachment(get_user_meta($id, 'line_app_profile_image_id'));
//                            update_user_meta($id, 'line_app_profile_image', $attach['url']);
//                            update_user_meta($id, 'line_app_profile_image_id', $attach['attachment_id']);
//                        }
					}

					/**
					 * Proceeding to login
					 *
					 */

					$user_name = $user_info['username'];

					xs_user_login($user_name, $final_redirect);

					die('Most unlikely error occurred in your case.');
				}

			} else {
				die('System Error for Callback!');
			}

		endif;

		$adapter->disconnect();

	} catch(\Exception $e) {
		echo esc_html('Oops, we ran into an issue!' . $e->getMessage());
	}
}


/**
 * Function Name : xs_login_create_user();
 * Function Details : create new user from socail login and check enable wp new create new users.
 *
 * @params : array() $userdata. For user information
 *
 * @return : int() if success then user id else 0
 *
 * @since : 1.0
 */

function xs_login_create_user($userdata) {

	// todo - permission checking removed for registering user : consult with CTO

	$user_id = wp_insert_user($userdata);

	if(!is_wp_error($user_id)) {

		update_user_meta($user_id, 'xs_password_changed', 'no');

		return $user_id;
	}

	return 0;
}


add_action('init', 'xs_login_create_user');

/**
 * Function Name : xs_login_get_user_data();
 * Function Details : Get user information when user already exists into database
 *
 * @params : String() $loginName. User login name
 *
 * @return : String() User information by set filed from database table.
 *
 * @since : 1.0
 */
function xs_login_get_user_data($loginName, $getFiled = 'user_login') {
	$users = get_user_by('login', $loginName);
	if(empty($users)) {
		return '';
	}

	return $users->data->$getFiled;
}


/**
 *
 * @since 1.3.8
 *
 * @param $loginName
 * @param string $field
 *
 * @return string
 */
function xs_login_get_user_field($loginName, $field = 'user_login') {

	$users = get_user_by('login', $loginName);

	if(empty($users)) {
		return '';
	}

	return $users->data->$field;
}


add_action('init', 'xs_login_get_user_data');

/**
 * Function Name : xs_login_get_user_data_email();
 * Function Details : Get user information when email already exists into database
 *
 * @params : String() $email. User login name
 *
 * @return : String() User information by set filed from database table.
 *
 * @since : 1.0
 */
function xs_login_get_user_data_email($email, $getFiled = 'user_login') {
	$users = get_user_by('email', $email);
	if(empty($users)) {
		return '';
	}

	return $users->data->$getFiled;
}


add_action('init', 'xs_login_get_user_data');
/**
 * Function Name : xs_user_login();
 * Function Details : User login function by wp_signon();
 *
 * @params : String() $user_name. User login name
 * @params : String() $password. User password
 *
 * @return : True | False
 *
 * @since : 1.0
 */
function xs_user_login($user_name, $redirect_to = '') {
	if(strlen($user_name) == 0) {
		die('User name is empty!');
	}

	$username = $user_name;
	$user     = get_user_by('login', $username);


	if(!is_wp_error($user)) {
		wp_clear_auth_cookie();
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID);

		$redirect_to = empty($redirect_to) ? user_admin_url() : $redirect_to;
		wp_safe_redirect($redirect_to);
		exit();
	}
}


add_action('init', 'xs_user_login');

/**
 * Get file extension fro a image that is rendering from a php url
 *
 * @since 1.0.0
 *
 * @param $url
 *
 * @return array|string
 */
function get_file_ext_from_url($url) {

	$extension = '';
	$headers   = wp_get_http_headers($url);
	$mime_type = $headers['content-type'];

	foreach(wp_get_mime_types() as $ext => $mime) {
		if($mime == $mime_type) {

			$extension = explode('|', $ext);

			return $extension[0];
		}
	}

	return $extension;
}


/**
 * Save a image php url as a attachment of post
 *
 * @since 1.0.0
 *
 * @param $url
 * @param string $unique_name - name with extension
 * @param int $post_id - default 0
 *
 * @return array
 */
function save_image_from_url_as_attachment($url, $unique_name = '', $post_id = 0) {

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$ext = get_file_ext_from_url($url);
	$tmp = download_url($url);

	$name = empty($unique_name) ? '__tmp_' . time() . '.' . $ext : $unique_name;

	$file_array = array(
		'name'     => $name,
		'tmp_name' => $tmp,
	);


	/**
	 * Check for download errors
	 * if there are error unlink the temp file name
	 */
	if(is_wp_error($tmp)) {
		@unlink($file_array['tmp_name']);

		return [
			'error' => $tmp->get_error_message(),
		];
	}

	/**
	 * now we can actually use media_handle_sideload
	 * we pass it the file array of the file to handle
	 * and the post id of the post to attach it to
	 * $post_id can be set to '0' to not attach it to any particular post
	 */
	$id = media_handle_sideload($file_array, $post_id);

	/**
	 * We don't want to pass something to $id
	 * if there were upload errors.
	 * So this checks for errors
	 */
	if(is_wp_error($id)) {
		@unlink($file_array['tmp_name']);

		return [
			'error' => $id->get_error_message(),
		];
	}

	/**
	 * No we can get the url of the sideloaded file
	 * $value now contains the file url in WordPress
	 * $id is the attachment id
	 */
	$value = wp_get_attachment_url($id);


	return [
		'url'           => $value,
		'attachment_id' => $id,
	];
}


function xs_login_session_handaler() {

	session_unset();

	// do we ever need the below?
	if(isset($_SESSION['xs_social_login_ref_url'])) {
		unset($_SESSION['xs_social_login_ref_url']);
	}
}


/**
 *
 * @since 1.3.7
 *
 * @param $user_info
 *
 * @return int
 */
function xs_social_create_user($user_info) {

	/*
	 * todo - ask Ataur bhai - do we allow insert user without permission with social? it make sense to do so
	 *
	 */
	$getPermissionRegisterWP = get_option('users_can_register', 0);

	if($getPermissionRegisterWP == 0) {

		// return 0;
	}

	$user_id = wp_insert_user($user_info);

	if(is_wp_error($user_id)) {

		return 0;
	}


	return $user_id;
}


/**
 * Checking the parameter and settings to find the correct redirect url
 *
 * @since 1.3.8
 *
 * @param $session
 * @param $setting
 *
 * @return string
 */
function resolve_redirect_url($session, $setting) {

	/**
	 * First priority to wordpress default redirect_to param
	 * Second priority to custom login settings url
	 * Third priority to XScurrentPage param [AR : not sure where it is used though!]
	 * And lastly site home page
	 *
	 */

	if(!empty($session['xs_social']['redirect_to'])) {

		$final_redirect = $session['xs_social']['redirect_to'];

	} elseif(!empty($setting['custom_login_url']['enable']) && !empty($setting['custom_login_url']['data'])) {

		$final_redirect = $setting['custom_login_url']['data'];

	} elseif(!empty($session['xs_social']['login_ref_url'])) {

		$final_redirect = $session['xs_social']['login_ref_url'];

	} else {

		$final_redirect = user_admin_url();
	}

	return $final_redirect;
}


/**
 *
 * @since 1.3.8
 *
 */
function clear_social_session_data() {

	if(!empty($_SESSION['xs_social'])) {

		unset($_SESSION['xs_social']);
	}
}


/**
 *
 * @since 1.3.7
 *
 * @param $user_id
 *
 * @return mixed
 */
function notify_new_user_to_admin($user_id, $social_type) {

	wp_new_user_notification($user_id, null, 'both');

	return true;
}


/**
 *
 * @since 1.3.7
 *
 *
 * @param array $info_array
 *
 * @return bool
 */
function notify_new_user_to_user($info_array = []) {

	/*
	 * todo - complete it after discussion
	 */

	return true;
}

function create_line_app_user($code, $socialType) {

	$lineapp = new Line_App();
	$user = $lineapp->get_user_info($code);

	if (empty($user->email)) {
		die('Please allow line app email permission');
	}

    $profile_picture = $user->picture;

	$final_redirect = get_site_url() . '/wp-admin';

	$old_user = get_user_by('email', $user->email);

	if ($old_user == false) {
		$default_role                   = get_option('default_role', '');
		$nicename                       = $user->name . time();
		$password                       = wp_generate_password();

		$insertData                     = [
			'first_name'    => $user->name,
			'user_nicename' => $nicename,
			'user_email'    => $user->email,
			'display_name'  => $user->name,
			'user_login'    => $user->email,
			'user_pass'     => $password,
			'role'          => $default_role
		];

        $insertAffiliateData['name'] = $user->name;
        $insertAffiliateData['email'] = $user->email;
        $insertAffiliateData['from_date'] = date("Y-m-d");
        $insertAffiliateData['status'] = "active";

       // $attach     = save_image_from_url_as_attachment($user->picture);

		$user_id    = xs_social_create_user($insertData);

		if ($user_id > 0) {
            // Create new affiliate user
            global $wpdb;
            $affiliates_table = _affiliates_get_tablename( 'affiliates' );
            $affiliates_users_table = _affiliates_get_tablename( 'affiliates_users' );
            $affiliate = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM $affiliates_users_table LEFT JOIN $affiliates_table ON $affiliates_users_table.affiliate_id = $affiliates_table.affiliate_id WHERE $affiliates_users_table.user_id = %d",
                    intval( $user_id )
                )
            );
            if (!empty($affiliate) && is_object($affiliate) ) {
                $fees_id['affiliate_id'] = $affiliate->affiliate_id;
                $result=$wpdb->update( $affiliates_table, $insertAffiliateData ,$fees_id);
            }
            else {
                $inset_affiliate = $wpdb->insert($affiliates_table, $insertAffiliateData);
                $new_affiliate_id = (int) $wpdb->insert_id;
                
                $insertAffiliateUserData['affiliate_id'] = $new_affiliate_id;
                $insertAffiliateUserData['user_id'] = $user_id;
                $wpdb->insert($affiliates_users_table, $insertAffiliateUserData);
            }

            $old_social_image_data = get_user_meta($user_id, 'line_app_profile_image', true);
            if ($old_social_image_data != null) {
                update_user_meta($user_id, 'line_app_profile_image', $profile_picture);
            } else {
                add_user_meta($user_id, 'line_app_profile_image', $profile_picture, true);
            }
            
//			if (empty($attach['error'])) {
//				update_user_meta($user_id, 'xs_social_register_by', $socialType);
//				update_user_meta($user_id, 'line_app_profile_image', $attach['url']);
//				update_user_meta($user_id, 'line_app_profile_image_id', $attach['attachment_id']);
//			} else {
//				update_user_meta($user_id, 'line_app_profile_image', '');
//				update_user_meta($user_id, 'line_app_profile_image_error_log', $socialType . '::' . $attach['error']);
//			}
			$wp_social_login_settings = get_option('xs_global_setting_data');

			if (isset($wp_social_login_settings['email_new_registered_user']['enable']) && $wp_social_login_settings['email_new_registered_user']['enable'] == 1) {
				notify_new_user_to_admin($user_id, $socialType);
			}

			xs_user_login($user->email, $final_redirect);

			die('Most most unlikely error occurred in your case. user registration done but login failed!!');
		}
	} else {

		$id = $old_user->data->ID;

        global $wpdb;
        $affiliates_table = _affiliates_get_tablename( 'affiliates' );
        $affiliates_users_table = _affiliates_get_tablename( 'affiliates_users' );
        $affiliate = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $affiliates_users_table LEFT JOIN $affiliates_table ON $affiliates_users_table.affiliate_id = $affiliates_table.affiliate_id WHERE $affiliates_users_table.user_id = %d",
                intval( $id )
            )
        );

        $insertAffiliateData['name'] = $user->name;
        $insertAffiliateData['email'] = $user->email;
        $insertAffiliateData['from_date'] = date("Y-m-d");
        $insertAffiliateData['status'] = "active";

        if (!empty($affiliate) && is_object($affiliate) ) {
            $fees_id['affiliate_id'] = $affiliate->affiliate_id;
            $result=$wpdb->update( $affiliates_table, $insertAffiliateData ,$fees_id);
        }
        else {
            $inset_affiliate = $wpdb->insert($affiliates_table, $insertAffiliateData);
            $new_affiliate_id = (int) $wpdb->insert_id;

            $insertAffiliateUserData['affiliate_id'] = $new_affiliate_id;
            $insertAffiliateUserData['user_id'] = $id;
            $wpdb->insert($affiliates_users_table, $insertAffiliateUserData);
        }

		update_user_meta($id, 'xs_social_register_by', $socialType);

        $old_social_image_data = get_user_meta($id, 'line_app_profile_image', true);
        if ($old_social_image_data != null) {
            update_user_meta($id, 'line_app_profile_image', $profile_picture);
        } else {
            add_user_meta($id, 'line_app_profile_image', $profile_picture, true);
        }

		if (get_option('wp_social_login_sync') == 'yes') {

			update_user_meta($id, 'first_name', $user->name);
			update_user_meta($id, 'display_name', $user->name);


//			if(get_option('wp_social_login_sync_image_too') == 'yes') {
//				$attach     = save_image_from_url_as_attachment($user->picture);
//
//				if (empty($attach['error'])) {
//					wp_delete_attachment(get_user_meta($id, 'line_app_profile_image_id'));
//					update_user_meta($id, 'line_app_profile_image', $attach['url']);
//					update_user_meta($id, 'line_app_profile_image_id', $attach['attachment_id']);
//				}
//			}
//            $attach     = save_image_from_url_as_attachment($user->picture);

//            if (empty($attach['error'])) {
//                wp_delete_attachment(get_user_meta($id, 'line_app_profile_image_id'));
//                update_user_meta($id, 'line_app_profile_image', $attach['url']);
//                update_user_meta($id, 'line_app_profile_image_id', $attach['attachment_id']);
//            }
		}

		/**
		 * Proceeding to login
		 *
		 */

		xs_user_login($old_user->data->user_login, $final_redirect);

		die('Most unlikely error occurred in your case.');
	}
}