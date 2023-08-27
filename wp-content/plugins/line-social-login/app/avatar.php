<?php

namespace WP_Social\App;

use WP_Social\Traits\Singleton;

class Avatar {

	use Singleton;


	public function init() {

		add_filter('get_avatar', [$this, 'xs_social_get_avatar'], 10, 5);
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $type
	 *
	 * @return string
	 */
	private function get_user_cache_key($type) {

		return '_wps__user_cache__' . $type;
	}


	public function xs_social_get_avatar($avatar, $id_or_email, $size = 96, $default = '', $alt = '') {

		if(is_numeric($id_or_email)) {

			$pic_url = get_user_meta($id_or_email, 'xs_social_profile_image', true);

			if(!empty($pic_url)) {

				return '<img alt="' . $alt . '" src="' . $pic_url . '" class="avatar avatar-' . $size . ' photo" height="' . $size . '" width="' . $size . '" />';
			}
		}

		return $avatar;
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $profile
	 * @param $type
	 *
	 * @return string
	 */
	public function get_nice_name($profile, $type) {

		switch($type) {

			case 'Twitter':
			case 'twitter': #fall through
			case 'Facebook':
			case 'facebook': #fall through
			case 'LinkedIn':
			case 'linkedIn':
			case 'Google':
			case 'google':

				$ret = $profile->firstName;
				break;

			case 'GitHub':
			case 'gitHub':

				$ret = empty($profile->firstName) ? ($this->get_display_name($profile, $type)) : $profile->firstName;
				break;

			default:

				$ret = empty($profile->firstName) ? 'Nice name' : $profile->firstName;
		}

		return $ret;
	}


	public function get_first_name($profile, $type) {

		switch($type) {

			case 'Twitter':
			case 'twitter': #fall through
			case 'Facebook':
			case 'facebook': #fall through
			case 'LinkedIn':
			case 'linkedIn': #fall through
			case 'Google':
			case 'google': #fall through
			case 'GitHub':
			case 'gitHub':

				$ret = empty($profile->firstName) ? '' : $profile->firstName;
				break;

			default:

				$ret = empty($profile->firstName) ? '' : $profile->firstName;
		}

		return $ret;
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $profile
	 * @param $type
	 *
	 * @return string
	 */
	public function get_last_name($profile, $type) {

		switch($type) {

			case 'Twitter':
			case 'twitter': #fall through
			case 'Facebook':
			case 'facebook': #fall through
			case 'LinkedIn':
			case 'linkedIn': #fall through
			case 'Google':
			case 'google': #fall through
			case 'GitHub':
			case 'gitHub':

				$ret = empty($profile->lastName) ? '' : $profile->lastName;
				break;

			default:

				$ret = empty($profile->lastName) ? '' : $profile->lastName;
		}

		return $ret;
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $profile
	 * @param $type
	 *
	 * @return string
	 */
	public function get_display_name($profile, $type) {

		switch($type) {

			case 'Twitter':
			case 'twitter': #fall through
			case 'Facebook':
			case 'facebook': #fall through
			case 'LinkedIn':
			case 'linkedIn': #fall through
			case 'Google':
			case 'google': #fall through
			case 'GitHub':
			case 'gitHub':

				$ret = $profile->displayName;
				break;

			default:

				$ret = empty($profile->displayName) ? $this->get_nice_name($profile, $type) : $profile->displayName;
		}

		return $ret;
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $profile
	 * @param $type
	 *
	 * @return string
	 */
	protected function get_email($profile, $type) {

		if(!empty($profile->email) || !empty($profile->emailVerified)) {

			return $profile->email;
		}

		if(!empty($profile->emailVerified)) {

			return $profile->emailVerified;
		}


		return $profile->identifier . '_not_exist@' . $type . '.com';
	}


	public function get_user_id_by_social_key($user_name) {

		get_user_meta();
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $profile
	 * @param $type
	 *
	 * @return string
	 */
	public function get_username($profile, $type) {

		switch($type) {

			case 'Twitter':
			case 'twitter':

				$ret = 'twt' . $profile->identifier;
				break;

			case 'Facebook':
			case 'facebook':

				$ret = 'fb' . $profile->identifier;
				break;

			case 'LinkedIn':
			case 'linkedIn':

				$ret = 'Ln' . $profile->identifier;
				break;

			case 'Google':
			case 'google':

				$ret = 'G' . $profile->identifier;
				break;

			case 'GitHub':
			case 'gitHub':

				$ret = 'Gt' . $profile->identifier;
				break;

			default:

				$ret = empty($profile->identifier) ? strtolower($type) . '_' . $profile->email : strtolower($type) . '_' . $profile->identifier;
		}

		return $ret;
	}


	public function make_wp_username($profile, $type) {


	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $user_key
	 * @param $type
	 *
	 * @return array
	 */
	public function get_linked_user($user_key, $type) {

		$cache = get_option($this->get_user_cache_key($type));

		return empty($cache[$user_key]) ? [] : $cache[$user_key];
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $user_key
	 * @param $type
	 * @param array $info
	 *
	 * @return mixed
	 */
	public function update_linked_user($user_key, $type, $info = []) {

		$option_key = $this->get_user_cache_key($type);

		$cache = get_option($option_key);

		$cache[$user_key]['id']       = $info['id'];
		$cache[$user_key]['username'] = $info['usr'];;

		return update_option($option_key, $cache);
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $profile
	 * @param $type
	 *
	 * @return string
	 */
	public function get_available_username($profile, $type) {

		$usr = $this->get_sanitized_username($profile, $type);

		$user_id = username_exists($usr);

		if($user_id == false) {
			return $usr;
		}

		$counter = 1;
		$usr     = $usr . $counter;

		while(username_exists($usr) !== false) {
			$counter++;
			$usr = $usr . $counter;
		}

		return $usr;
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $profile
	 * @param $type
	 *
	 * @return string
	 */
	protected function get_sanitized_username($profile, $type) {

		$user_nm = $this->get_first_name($profile, $type) . $this->get_last_name($profile, $type);

		if(empty($user_nm)) {

			//this is a fallback checking
			//if for any reason user first name and last name is not comming we will make the id as out username
			return $this->get_username($profile, $type);
		}

		$username = strtolower($user_nm);
		$username = preg_replace('/\s+/', '', $username);

		$sanitized = sanitize_user($username);

		if(empty($sanitized)) {

			return $this->get_username($profile, $type);
		}

		if(!validate_username($sanitized)) {

			return $this->get_username($profile, $type);
		}

		return $sanitized;
	}


	/**
	 *
	 * @since 1.3.8
	 *
	 * @param $profile
	 * @param $type
	 *
	 * @return mixed
	 */
	public function get_avatar_url($profile, $type) {

		switch($type) {

			case 'Twitter':
			case 'twitter': #fall through
			case 'Facebook':
			case 'facebook': #fall through
			case 'LinkedIn':
			case 'linkedIn': #fall through
			case 'Google':
			case 'google': #fall through
			case 'GitHub':
			case 'gitHub':

				$ret = $profile->photoURL;
				break;

			default:

				$ret = $profile->photoURL; // todo - later we will put the mystry man url from wordpress
		}

		return $ret;
	}


	/**
	 * Only for testing purpose
	 *
	 * @since 1.3.8
	 *
	 * @param $type
	 * @param array $info
	 *
	 * @return mixed
	 */
	public function clear_it($type, $info = []) {

		$option_key = $this->get_user_cache_key($type);
		$cache      = [];

		return update_option($option_key, $cache);
	}

}
