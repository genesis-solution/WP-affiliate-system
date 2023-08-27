<?php

defined('ABSPATH') || exit;

$xsc_data         = array();
$xsc_options      = get_option('xs_counter_options') ? get_option('xs_counter_options') : array('data' => array());
$xsc_transient    = get_transient('xs_counters_data');
$xsc_options_save = get_option('xs_counter_providers_data') ? get_option('xs_counter_providers_data') : [];

if(empty($xsc_transient) || (false === $xsc_transient)) {
	$xsc_transient = [];
}

/**
 * Twitter Followers Count
 * todo - we are not using this function any more, check for other reference and delete it
 *
 */
if(!function_exists('xsc_twitter_count')) :
	function xsc_twitter_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['twitter'])) {
			$result = $xsc_transient['twitter'];
		} elseif(empty($xsc_transient['twitter']) && !empty($xsc_data) && !empty($xsc_options['data']['twitter'])) {
			$result = $xsc_options['data']['twitter'];
		} else {
			$result = '';
			$id = isset($xsc_options_save['social']['twitter']['id']) ? $xsc_options_save['social']['twitter']['id'] : 'xpeedstudio';
			$default_token = 'AAAAAAAAAAAAAAAAAAAAAJBzagAAAAAAXr%2Fxj2UWtV%2BnQNigsUm%2Bjrlkr4o%3DoYt2AFQFvPpPsJ1wtVmJ3MLetbYnmTWLFzDZJWLnXZtRJRZKOQ';
			$token = get_option('xs_counter_twitter_token') ? get_option('xs_counter_twitter_token') : '';
			$token = strlen($token) > 5 ? $token : $default_token;

			$args = [
				'httpversion' => '1.1',
				'blocking'    => true,
				'timeout'     => 10,
				'headers'     => [
					'Authorization'   => "Bearer $token",
					'Accept-Language' => 'en',
				],
			];

			add_filter('https_ssl_verify', '__return_false');
			$api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=$id";
			$response = xsc_remote_get($api_url, true, $args);

			/**
			 * We will show actual count always if user gives the access token
			 * even if it is 0!
			 */
			if(isset($response['followers_count'])) {
				$result = intval($response['followers_count']);
			}


			if(!empty($result)) //To update the stored data
			{
				$xsc_data['twitter'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['twitter'])) //Get the stored data
			{
				$result = $xsc_options['data']['twitter'];
			}
		}

		return (int)$result;

	}
endif;

/**
 * Facebook Fans
 */

if(!function_exists('xsc_facebook_count')) :
	function xsc_facebook_count($cache_time = 43000) {

		//todo - delete it.

		return 0;


		$tran_key = '_xs_social_facebook_count_';

		$trans_value = get_transient($tran_key);

		if(false === $trans_value) {

			global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

			$counter = 0;


			if(!empty($xsc_transient['facebook'])) {
				$counter = $xsc_transient['facebook'];
			} elseif(empty($xsc_transient['facebook']) && !empty($xsc_data) && !empty($xsc_options['data']['facebook'])) {
				$counter = $xsc_options['data']['facebook'];
			} else {

				$counter = '';

				$social_id = isset($xsc_options_save['social']['facebook']['id']) ? $xsc_options_save['social']['facebook']['id'] : 'xpeedstudio';

				$get_request = wp_remote_get("https://www.facebook.com/plugins/likebox.php?href=https://facebook.com/$social_id&show_faces=true&header=false&stream=false&show_border=false&locale=en_US", ['timeout' => 20]);
				$the_request = wp_remote_retrieve_body($get_request);

				$pattern = '/_1drq[^>]+>(.*?)<\/a/s';
				preg_match($pattern, $the_request, $matches);

				if(!empty($matches[1])) {
					$number = strip_tags($matches[1]);

					foreach(str_split($number) as $char) {
						if(is_numeric($char)) {
							$counter .= $char;
						}
					}
				}

				if(!empty($counter)) //To update the stored data
				{
					$xsc_data['facebook'] = $counter;
				}

				if(empty($counter) && !empty($xsc_options['data']['facebook'])) //Get the stored data
				{
					$counter = $xsc_options['data']['facebook'];
				}
			}

			$expiration_time = empty($cache_time) ? 43200 : intval($cache_time);

			set_transient($tran_key, $counter, $expiration_time);
			update_option('_xs_social_facebook_last_cached', time());

			return (int)$counter;
		}

		return (int)$trans_value;

	}
endif;

/**
 * Google+ Followers
 */

if(!function_exists('xsc_google_count')) :
	function xsc_google_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['google'])) {
			$result = $xsc_transient['google'];
		} elseif(empty($xsc_transient['google']) && !empty($xsc_data) && !empty($xsc_options['data']['google'])) {
			$result = $xsc_options['data']['google'];
		} else {
			$id = (isset($xsc_options_save['social']['google']['id']) && strlen($xsc_options_save['social']['google']['id']) > 5) ? $xsc_options_save['social']['google']['id'] : 'google';
			$key = (isset($xsc_options_save['social']['google']['key']) && strlen($xsc_options_save['social']['google']['key']) > 4) ? $xsc_options_save['social']['google']['key'] : 'AIzaSyBAwpfyAadivJ6EimaAOLh-F1gBeuwyVoY';

			try {
				// Get googleplus data.
				$googleplus_data = xsc_remote_get('https://www.googleapis.com/plus/v1/people/' . $id . '?key=' . $key);

				if(isset($googleplus_data['circledByCount'])) {
					$result = (int)$googleplus_data['circledByCount'];
				}
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['google'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['google'])) //Get the stored data
			{
				$result = $xsc_options['data']['google'];
			}
		}

		return $result;

	}
endif;


/**
 * Youtube Subscribers
 * todo - No more needed, use this class - lib/provider/counter/youtube-counter.php
 */
if(!function_exists('xsc_youtube_count')) :
	function xsc_youtube_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['youtube'])) {
			$result = $xsc_transient['youtube'];
		} elseif(empty($xsc_transient['youtube']) && !empty($xsc_data) && !empty($xsc_options['data']['youtube'])) {
			$result = $xsc_options['data']['youtube'];
		} else {
			$result = '';
			$id = (isset($xsc_options_save['social']['youtube']['id']) && strlen($xsc_options_save['social']['youtube']['id']) > 5) ? $xsc_options_save['social']['youtube']['id'] : 'UCJp-j8uvirVgez7TDAmfGYA';
			$api = (isset($xsc_options_save['social']['youtube']['key']) && strlen($xsc_options_save['social']['youtube']['key']) > 4) ? $xsc_options_save['social']['youtube']['key'] : 'AIzaSyBAwpfyAadivJ6EimaAOLh-F1gBeuwyVoY';
			try {
				if(!empty($xsc_options_save['social']['youtube']['type']) && $xsc_options_save['social']['youtube']['type'] == 'Channel') {
					$data = @xsc_remote_get("https://www.googleapis.com/youtube/v3/channels?part=statistics&id=$id&key=$api");
				} else {
					$data = @xsc_remote_get("https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=$id&key=$api");
				}
				$result = (int)isset($data['items'][0]['statistics']['subscriberCount']) ? $data['items'][0]['statistics']['subscriberCount'] : 0;

			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['youtube'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['youtube'])) //Get the stored data
			{
				$result = $xsc_options['data']['youtube'];
			}
		}

		return (int)$result;

	}
endif;


/**
 * Vimeo Subscribers
 */
if(!function_exists('xsc_vimeo_count')) :
	function xsc_vimeo_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['vimeo'])) {
			$result = $xsc_transient['vimeo'];
		} elseif(empty($xsc_transient['vimeo']) && !empty($xsc_data) && !empty($xsc_options['data']['vimeo'])) {
			$result = $xsc_options['data']['vimeo'];
		} else {
			$id = isset($xsc_options_save['social']['vimeo']['id']) ? $xsc_options_save['social']['vimeo']['id'] : 'user1837238';
			try {
				//$data 	= xsc_remote_get( "http://vimeo.com/api/v2/channel/$id/info.json" );
				$default_token = '6m4GyfcFCklFySPiz9DDqup1gbL9oqkj';
				$token = get_option('xs_counter_VimeoToken') ? get_option('xs_counter_VimeoToken') : '';
				$token = strlen($token) > 5 ? $token : $default_token;

				$args = [
					'httpversion' => '1.1',
					'blocking'    => true,
					'timeout'     => 10,
					'headers'     => [
						'Authorization' => "bearer $token",
					],
				];
				$api_url = "http://vimeo.com/api/v2/channel/$id/info.json";
				$data = xsc_remote_get($api_url, true, $args);
				print_r($data);
				$result = (int)isset($data['total_subscribers']) ? $data['total_subscribers'] : 0;
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['vimeo'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['vimeo'])) //Get the stored data
			{
				$result = $xsc_options['data']['vimeo'];
			}
		}

		return $result;

	}
endif;


/**
 * Dribbble Followers
 * todo - No more needed, use this class - lib/provider/counter/dribbble-counter.php
 */
if(!function_exists('xsc_dribbble_count')) :
	function xsc_dribbble_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['dribbble'])) {
			$result = $xsc_transient['dribbble'];
		} elseif(empty($xsc_transient['dribbble']) && !empty($xsc_data) && !empty($xsc_options['data']['dribbble'])) {
			$result = $xsc_options['data']['dribbble'];
		} else {
			$result = '';
			$id = isset($xsc_options_save['social']['dribbble']['id']) ? $xsc_options_save['social']['dribbble']['id'] : 'NicolasIbrahim';


			$default_token = 'doesNotWork';
			$token = get_option('xs_counter_dribbble_token') ? get_option('xs_counter_dribbble_token') : '';
			$token = strlen($token) > 5 ? $token : $default_token;

			try {
				$data = @xsc_remote_get("https://api.dribbble.com/v2/user/$id?access_token=$token");
				$result = (int)isset($data['followers_count']) ? $data['followers_count'] : 0;

			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['dribbble'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['dribbble'])) //Get the stored data
			{
				$result = $xsc_options['data']['dribbble'];
			}
		}

		return (int)$result;

	}
endif;


/**
 * Github Followers
 */
if(!function_exists('xsc_github_count')) :
	function xsc_github_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['github'])) {
			$result = $xsc_transient['github'];
		} elseif(empty($xsc_transient['github']) && !empty($xsc_data) && !empty($xsc_options['data']['github'])) {
			$result = $xsc_options['data']['github'];
		} else {
			$id = isset($xsc_options_save['social']['github']['id']) ? $xsc_options_save['social']['github']['id'] : 'VingtCinq';
			try {
				$data = @xsc_remote_get("https://api.github.com/users/$id");
				$result = (int)$data['followers'];
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['github'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['github'])) //Get the stored data
			{
				$result = $xsc_options['data']['github'];
			}
		}

		return $result;

	}
endif;


/**
 * Envato Followers
 */
if(!function_exists('xsc_envato_count')) :
	function xsc_envato_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['envato'])) {
			$result = $xsc_transient['envato'];
		} elseif(empty($xsc_transient['envato']) && !empty($xsc_data) && !empty($xsc_options['data']['envato'])) {
			$result = $xsc_options['data']['envato'];
		} else {
			//https://build.envato.com/api/
			$id = isset($xsc_options_save['social']['envato']['id']) ? $xsc_options_save['social']['envato']['id'] : 'xpeedstudio';
			try {
				//$data 	= @xsc_remote_get("http://marketplace.envato.com/api/edge/user:$id.json");
				$default_token = '6m4GyfcFCklFySPiz9DDqup1gbL9oqkj';
				$token = get_option('xs_counter_EnvatoToken') ? get_option('xs_counter_EnvatoToken') : '';
				$token = strlen($token) > 5 ? $token : $default_token;

				$args = [
					'httpversion' => '1.1',
					'blocking'    => true,
					'timeout'     => 10,
					'headers'     => [
						'Authorization' => "Bearer $token",
					],
				];
				$api_url = "https://api.envato.com/v1/market/user:$id.json";
				$data = xsc_remote_get($api_url, true, $args);
				print_r($data);
				$result = (int)isset($data['user']['followers']) ? $data['user']['followers'] : 0;
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['envato'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['envato'])) //Get the stored data
			{
				$result = $xsc_options['data']['envato'];
			}
		}

		return $result;

	}
endif;


/**
 * SoundCloud Followers
 */
if(!function_exists('xsc_soundcloud_count')) :
	function xsc_soundcloud_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['soundcloud'])) {
			$result = $xsc_transient['soundcloud'];
		} elseif(empty($xsc_transient['soundcloud']) && !empty($xsc_data) && !empty($xsc_options['data']['soundcloud'])) {
			$result = $xsc_options['data']['soundcloud'];
		} else {
			$id = $xsc_options_save['social']['soundcloud']['id'];
			$api = $xsc_options_save['social']['soundcloud']['api'];
			try {
				$data = @xsc_remote_get("http://api.soundcloud.com/users/$id.json?consumer_key=$api");
				$result = (int)$data['followers_count'];
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['soundcloud'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['soundcloud'])) //Get the stored data
			{
				$result = $xsc_options['data']['soundcloud'];
			}
		}

		return $result;

	}
endif;


/**
 * Behance Followers
 */
if(!function_exists('xsc_behance_count')) :
	function xsc_behance_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['behance'])) {
			$result = $xsc_transient['behance'];
		} elseif(empty($xsc_transient['behance']) && !empty($xsc_data) && !empty($xsc_options['data']['behance'])) {
			$result = $xsc_options['data']['behance'];
		} else {
			$id = isset($xsc_options_save['social']['behance']['id']) ? $xsc_options_save['social']['behance']['id'] : 'mostafahazi';
			$api = isset($xsc_options_save['social']['behance']['api']) ? $xsc_options_save['social']['behance']['api'] : 'INekEPLWGFlXlfmWjjOZD79vWNaD1Nxj';
			try {
				$url = sprintf(
					'https://www.behance.net/v2/users/%s?api_key=%s',
					$id,
					$api
				);
				$data = xsc_remote_get($url);
				//print_r($data);
				$result = (int)isset($data['user']['stats']['followers']) ? $data['user']['stats']['followers'] : 0;
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['behance'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['behance'])) //Get the stored data
			{
				$result = $xsc_options['data']['behance'];
			}
		}

		return $result;

	}
endif;


///**
// * Instagram Followers

// Delete as it does not work anymore...
// todo - delete it later
// */
//if(!function_exists('xsc_instagram_count')) :
//
//	function xsc_instagram_count($cache_time) {
//
//
//		$tran_key = '_xs_social_instagram_count_55';
//
//		$trans_value = get_transient($tran_key);
//
//
//		if(false === $trans_value) {
//
//			global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;
//
//			if(!empty($xsc_transient['instagram'])) {
//				$result = $xsc_transient['instagram'];
//			} elseif(empty($xsc_transient['instagram']) && !empty($xsc_data) && !empty($xsc_options['data']['instagram'])) {
//				$result = $xsc_options['data']['instagram'];
//			} else {
//
//
//				$default_token = '2367672995.f53f83f.88eda6a77b1d4a9fb704fedc4ff869eb';
//				$token = get_option('xs_counter_instagram_token') ? get_option('xs_counter_instagram_token') : '';
//				if(strlen($token) > 5) {
//					$token = strlen($token) > 5 ? $token : $default_token;
//					$explodeUs = explode('.', $token);
//					$id = current($explodeUs);
//					$url = sprintf(
//						'https://api.instagram.com/v1/users/%s?access_token=%s',
//						$id,
//						$token
//					);
//					$data = xsc_remote_get($url);
//					$result = (int)isset($data['data']['counts']['followed_by']) ? $data['data']['counts']['followed_by'] : 0;
//				} else {
//
//					$id = isset($xsc_options_save['social']['instagram']['id']) ? $xsc_options_save['social']['instagram']['id'] : '2367672995';
//
//					$url = 'http://instagram.com/' . $id . '#';
//
//					$get_request = wp_remote_get($url, ['timeout' => 20]);
//					$the_request = wp_remote_retrieve_body($get_request);
//
//					$pattern = "/followed_by\":[ ]*{\"count\":(.*?)}/";
//
//					if(is_string($the_request) && preg_match($pattern, $the_request, $matches)) {
//
//						$result = intval($matches[1]);
//					}
//				}
//
//				if(!empty($result)) //To update the stored data
//				{
//					$xsc_data['instagram'] = $result;
//				}
//
//				if(empty($result) && !empty($xsc_options['data']['instagram'])) //Get the stored data
//				{
//					$result = $xsc_options['data']['instagram'];
//				}
//
//			}
//
//			$expiration_time = empty($cache_time) ? 43200 : intval($cache_time);
//
//			set_transient($tran_key, $result, $expiration_time);
//			update_option('_xs_social_instagram_last_cached', time());
//
//			return $result;
//		}
//
//		return $trans_value;
//
//	}
//endif;
//

/**
 * Foursquare Followers
 */
if(!function_exists('xsc_foursquare_count')) :
	function xsc_foursquare_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['foursquare'])) {
			$result = $xsc_transient['foursquare'];
		} elseif(empty($xsc_transient['foursquare']) && !empty($xsc_data) && !empty($xsc_options['data']['foursquare'])) {
			$result = $xsc_options['data']['foursquare'];
		} else {
			$api = get_option('foursquare_access_token');
			$date = date("Ymd");
			try {
				$data = @xsc_remote_get("https://api.foursquare.com/v2/users/self?oauth_token=$api&v=$date");
				$result = (int)$data['response']['user']['friends']['count'];
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['foursquare'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['foursquare'])) //Get the stored data
			{
				$result = $xsc_options['data']['foursquare'];
			}
		}

		return $result;

	}
endif;


/**
 * Mailchimp Subscribers
 */
if(!function_exists('xsc_mailchimp_count')) :
	function xsc_mailchimp_count($cache_time) {

		$tran_key = '_xs_social_mailchimp_count_';

		$trans_value = get_transient($tran_key);

		if(false === $trans_value) {

			global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

			if(!empty($xsc_transient['mailchimp'])) {
				$result = $xsc_transient['mailchimp'];
			} elseif(empty($xsc_transient['mailchimp']) && !empty($xsc_data) && !empty($xsc_options['data']['mailchimp'])) {
				$result = $xsc_options['data']['mailchimp'];
			} else {

				$result = 0;
				$id = isset($xsc_options_save['social']['mailchimp']['id']) ? $xsc_options_save['social']['mailchimp']['id'] : ''; //35bfe5a4f5
				$apikey = isset($xsc_options_save['social']['mailchimp']['api']) ? $xsc_options_save['social']['mailchimp']['api'] : '7025ab20d2b50082e656df4e8e98f02f-us8';

				$server = explode('-', $apikey);
				$hosting = end($server);

				$url = sprintf('https://%s.api.mailchimp.com/3.0/lists/%s', $hosting, $id);
				$response = wp_remote_get($url, [
					'timeout' => 10,
					'headers' => [
						'Authorization' => 'apikey ' . $apikey,
						'Content-Type'  => 'application/vnd.api+json',
					],
				]);
				$response = wp_remote_retrieve_body($response);
				$response = json_decode($response, true);

				/*
				//https://developer.mailchimp.com/documentation/mailchimp/guides/how-to-use-oauth2/
				$url = sprintf('https://%s.api.mailchimp.com/3.0/', $hosting);
				$response = wp_remote_get( $url, array(
					'timeout' => 10,
					'headers' => array(
						'Authorization' => 'apikey ' . $apikey,
						'Content-Type' => 'application/vnd.api+json',
					)
				));
				$response = wp_remote_retrieve_body( $response );
				$response = json_decode( $response, true );

				print_r($response);
				*/

				if(isset($response['lists'][0]['stats'])) {
					$result = isset($response['lists'][0]['stats']['member_count']) ? $response['lists'][0]['stats']['member_count'] : 0;
				} else {
					$result = isset($response['stats']['member_count']) ? $response['stats']['member_count'] : 0;
				}

				if(!empty($result)) //To update the stored data
				{
					$xsc_data['mailchimp'] = $result;
				}

				if(empty($result) && !empty($xsc_options['data']['mailchimp'])) //Get the stored data
				{
					$result = $xsc_options['data']['mailchimp'];
				}
			}

			$expiration_time = empty($cache_time) ? 43200 : intval($cache_time);

			set_transient($tran_key, $result, $expiration_time);
			update_option('_xs_social_mailchimp_last_cached', time());

			return $result;
		}

		return $trans_value;

	}
endif;


/**
 * MailPoet Subscribers
 */
if(!function_exists('xsc_mailpoet_count')) :
	function xsc_mailpoet_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['mailpoet'])) {
			$result = $xsc_transient['mailpoet'];
		} elseif(empty($xsc_transient['mailpoet']) && !empty($xsc_data) && !empty($xsc_options['data']['mailpoet'])) {
			$result = $xsc_options['data']['mailpoet'];
		} else {

			$list = $xsc_options_save['social']['mailpoet']['list'];

			if(!empty($list)) {
				if($list == 'all') {
					$result = do_shortcode('[mailpoet_subscribers_count]');
				} else {
					$result = do_shortcode('[mailpoet_subscribers_count segments="' . $list . '"]');
				}
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['mailpoet'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['mailpoet'])) //Get the stored data
			{
				$result = $xsc_options['data']['mailpoet'];
			}
		}

		return $result;

	}
endif;


/**
 * myMail Subscribers
 */
if(!function_exists('xsc_mymail_count')) :
	function xsc_mymail_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['mymail'])) {
			$result = $xsc_transient['mymail'];
		} elseif(empty($xsc_transient['mymail']) && !empty($xsc_data) && !empty($xsc_options['data']['mymail'])) {
			$result = $xsc_options['data']['mymail'];
		} else {

			$list = $xsc_options_save['social']['mymail']['list'];

			if(!empty($list)) {
				if($list == 'all') {
					$counts = mailster('subscribers')->get_count_by_status();
					$result = $counts[1];
				} else {
					$result = mailster('lists')->get_member_count($list, 1);
				}
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['mymail'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['mymail'])) //Get the stored data
			{
				$result = $xsc_options['data']['mymail'];
			}
		}

		return $result;

	}
endif;


/**
 * LinkedIn Followers
 */
if(!function_exists('xsc_linkedin_count')) :
	function xsc_linkedin_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['linkedin'])) {
			$result = $xsc_transient['linkedin'];
		} elseif(empty($xsc_transient['linkedin']) && !empty($xsc_data) && !empty($xsc_options['data']['linkedin'])) {
			$result = $xsc_options['data']['linkedin'];
		} else {
			$default_token = 'AQRX2qAD_yEPBj6jdTLqcn6rgPCgZCKcF8gRPppRcW94N7zZus35iZ4LylyRcuMfm7HnphraWkSTyDF6sxFPSZk5x2GnQnHYDV3Ueu1-qVp5J_3Nw5ZIC1A_OOkn1pfj1q_ZihHq4_6HOfkS7oVO9ZTjUogsfc1U6DEKgGQVi1JT-5NLfKm3E2XoZal33g';
			$token = get_option('xs_counter_linkedin_token') ? get_option('xs_counter_linkedin_token') : '';
			//$token = strlen($token) > 5 ? $token : $default_token;

			$type = isset($xsc_options_save['social']['linkedin']['type']) ? $xsc_options_save['social']['linkedin']['type'] : 'Profile';
			$result = 0;
			if(!empty($xsc_options_save['social']['linkedin']['type']) && !empty($token)) {

				$args = [
					'headers' => [
						'Authorization'             => sprintf('Bearer %s', $token),
						'Content-Type'              => 'application/json',
						'x-li-format'               => 'json',
						'X-Restli-Protocol-Version' => '2.0.0',
					],
				];

				if($type == 'Profile') {
					$id = isset($xsc_options_save['social']['linkedin']['id']) ? $xsc_options_save['social']['linkedin']['id'] : '';

					//$data   = xsc_remote_get('https://api.linkedin.com/v2/me', true, $args);
					$fields = 'id,numConnections';

					//$data   = xsc_remote_get('https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams),numConnections)', true, $args);
					$data = xsc_remote_get('https://api.linkedin.com/v2/me?projection=(num-connections)', true, $args);

					try {
						$result = (int)isset($data['numConnections']) ? $data['numConnections'] : 0;
					} catch(Exception $e) {
						$result = 0;
					}

				} elseif($type == 'Company') {
					$companyId = isset($xsc_options_save['social']['linkedin']['id']) ? $xsc_options_save['social']['linkedin']['id'] : '';
					$page_id = sprintf('https://api.linkedin.com/v1/companies/%s/num-followers?format=json', $companyId);
					//$page_id = sprintf('https://api.linkedin.com/v2/organizations?q=vanityI&vanityName=%s', $companyId );
					try {
						$data = xsc_remote_get($page_id, true, $args);
						//print_r($data);
						if(!is_array($data)) {
							$result = $data;
						}
					} catch(Exception $e) {
						$result = 0;
					}
				}

				if(!empty($result)) { //To update the stored data
					$xsc_data['linkedin'] = $result;
				}

				if(empty($result) && !empty($xsc_options['data']['linkedin'])) { //Get the stored data
					$result = $xsc_options['data']['linkedin'];
				}
			}
		}

		return $result;
	}
endif;


/**
 * Vk Members
 */
if(!function_exists('xsc_vkontakte_count')) :
	function xsc_vkontakte_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		$counter = 0;

		if(!empty($xsc_transient['vkontakte'])) {
			$counter = $xsc_transient['vkontakte'];
		} elseif(empty($xsc_transient['vkontakte']) && !empty($xsc_data) && !empty($xsc_options['data']['vkontakte'])) {
			$counter = $xsc_options['data']['vkontakte'];
		} else {

			$id = isset($xsc_options_save['social']['vkontakte']['id']) ? $xsc_options_save['social']['vkontakte']['id'] : 'id72867608';

			$get_request = wp_remote_get("https://m.vk.com/$id", ['timeout' => 20]);
			$the_request = wp_remote_retrieve_body($get_request);

			$pattern = '/pm_counter[^>]+>(.*?)<\/em/s';
			preg_match($pattern, $the_request, $matches);

			if(!empty($matches[1])) {
				$number = strip_tags($matches[1]);
				$counter = '';

				foreach(str_split($number) as $char) {
					if(is_numeric($char)) {
						$counter .= $char;
					}
				}
			}

			if(!empty($counter)) //To update the stored data
			{
				$xsc_data['vkontakte'] = $counter;
			}

			if(empty($counter) && !empty($xsc_options['data']['vkontakte'])) //Get the stored data
			{
				$counter = $xsc_options['data']['vkontakte'];
			}
		}

		return $counter;

	}
endif;


/**
 * Tumblr Followers
 */
if(!function_exists('xsc_tumblr_count')) :
	function xsc_tumblr_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['tumblr'])) {
			$result = $xsc_transient['tumblr'];
		} elseif(empty($xsc_transient['tumblr']) && !empty($xsc_data) && !empty($xsc_options['data']['tumblr'])) {
			$result = $xsc_options['data']['tumblr'];
		} else {
			$base_hostname = str_replace([
				                             'http://',
				                             'https://',
			                             ], '', $xsc_options_save['social']['tumblr']['hostname']);

			try {
				$consumer_key = get_option('tumblr_api_key');
				$consumer_secret = get_option('tumblr_api_secret');
				$oauth_token = get_option('tumblr_oauth_token');
				$oauth_token_secret = get_option('tumblr_token_secret');
				$tumblr_api_URI = 'http://api.tumblr.com/v2/blog/' . $base_hostname . '/followers';

				$tum_oauth = new TumblrOAuthTie($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
				$tumblr_api = $tum_oauth->post($tumblr_api_URI, '');

				if($tumblr_api->meta->status == 200 && !empty($tumblr_api->response->total_users)) {
					$result = (int)$tumblr_api->response->total_users;
				}

			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['tumblr'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['tumblr'])) //Get the stored data
			{
				$result = $xsc_options['data']['tumblr'];
			}
		}

		return $result;

	}
endif;


/**
 * 500px Followers
 */
if(!function_exists('xsc_500px_count')) :
	function xsc_500px_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		$result = 0;

		if(!empty($xsc_transient['500px'])) {
			$result = $xsc_transient['500px'];
		} elseif(empty($xsc_transient['500px']) && !empty($xsc_data) && !empty($xsc_options['data']['500px'])) {
			$result = $xsc_options['data']['500px'];
		} else {

			$social_id = $xsc_options_save['social']['500px']['username'];
			$get_request = wp_remote_get("https://500px.com/$social_id", ['timeout' => 20]);
			$the_request = wp_remote_retrieve_body($get_request);

			$pattern = '/followers[^>]+>(.*?)<\/li/s';
			preg_match($pattern, $the_request, $matches);

			if(!empty($matches[1])) {

				$number = strip_tags($matches[1]);
				$result = '';

				foreach(str_split($number) as $char) {
					if(is_numeric($char)) {
						$result .= $char;
					}
				}
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['500px'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['500px'])) //Get the stored data
			{
				$result = $xsc_options['data']['500px'];
			}
		}

		return $result;

	}
endif;


/**
 * Pinterest Followers
 */
if(!function_exists('xsc_pinterest_count')) :
	function xsc_pinterest_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['pinterest'])) {
			$result = $xsc_transient['pinterest'];
		} elseif(empty($xsc_transient['pinterest']) && !empty($xsc_data) && !empty($xsc_options['data']['pinterest'])) {
			$result = $xsc_options['data']['pinterest'];
		} else {
			$result = '';
			$username = isset($xsc_options_save['social']['pinterest']['username']) ? $xsc_options_save['social']['pinterest']['username'] : '101outfitcom';
			try {
				$html = xsc_remote_get("https://www.pinterest.com/$username/", false);

				$prev = libxml_use_internal_errors(true);
				$doc = new DOMDocument();
				@$doc->loadHTML($html);
				libxml_use_internal_errors($prev);

				$metas = $doc->getElementsByTagName('meta');
				for($i = 0; $i < $metas->length; $i++) {
					$meta = $metas->item($i);
					if($meta->getAttribute('name') == 'pinterestapp:followers') {
						$result = $meta->getAttribute('content');
						break;
					}
				}
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['pinterest'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['pinterest'])) //Get the stored data
			{
				$result = $xsc_options['data']['pinterest'];
			}
		}

		return $result;
	}
endif;


/**
 * Flickr Followers
 */
if(!function_exists('xsc_flickr_count')) :
	function xsc_flickr_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['flickr'])) {
			$result = $xsc_transient['flickr'];
		} elseif(empty($xsc_transient['flickr']) && !empty($xsc_data) && !empty($xsc_options['data']['flickr'])) {
			$result = $xsc_options['data']['flickr'];
		} else {
			$id = $xsc_options_save['social']['flickr']['id'];
			$api = $xsc_options_save['social']['flickr']['api'];
			try {
				$data = @xsc_remote_get("https://api.flickr.com/services/rest/?method=flickr.groups.getInfo&api_key=$api&group_id=$id&format=json&nojsoncallback=1");
				$result = (int)$data['group']['members']['_content'];
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['flickr'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['flickr'])) //Get the stored data
			{
				$result = $xsc_options['data']['flickr'];
			}
		}

		return $result;

	}
endif;


/**
 * Steam Followers
 */
if(!function_exists('xsc_steam_count')) :
	function xsc_steam_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['steam'])) {
			$result = $xsc_transient['steam'];
		} elseif(empty($xsc_transient['steam']) && !empty($xsc_data) && !empty($xsc_options['data']['steam'])) {
			$result = $xsc_options['data']['steam'];
		} else {
			$id = $xsc_options_save['social']['steam']['group'];
			try {
				$data = @xsc_remote_get("http://steamcommunity.com/groups/$id/memberslistxml?xml=1", false);
				$data = @new SimpleXmlElement($data);
				$result = (int)$data->groupDetails->memberCount;
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['steam'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['steam'])) //Get the stored data
			{
				$result = $xsc_options['data']['steam'];
			}
		}

		return $result;
	}
endif;


/**
 * Rss Subscribers
 */
if(!function_exists('xsc_rss_count')) :
	function xsc_rss_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['rss'])) {
			$result = $xsc_transient['rss'];
		} elseif(empty($xsc_transient['rss']) && !empty($xsc_data) && !empty($xsc_options['data']['rss'])) {
			$result = $xsc_options['data']['rss'];
		} else {
			if(($xsc_options_save['social']['rss']['type'] == 'feedpress.it') && !empty($xsc_options_save['social']['rss']['feedpress'])) {
				try {
					$feedpress_url = esc_url($xsc_options_save['social']['rss']['feedpress']);
					$feedpress_url = str_replace('feedpress.it', 'feed.press', $feedpress_url);
					//$feedpress_url 	= str_replace( 'http', 'https', $feedpress_url);

					$data = @xsc_remote_get($feedpress_url);
					$result = (int)$data['subscribers'];
				} catch(Exception $e) {
					$result = 0;
				}
			} elseif(($xsc_options_save['social']['rss']['type'] == 'Manual') && !empty($xsc_options_save['social']['rss']['manual'])) {
				$result = $xsc_options_save['social']['rss']['manual'];
			} else {
				$result = 0;
			}
			if(!empty($result)) //To update the stored data
			{
				$xsc_data['rss'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['rss'])) //Get the stored data
			{
				$result = $xsc_options['data']['rss'];
			}
		}

		return $result;

	}
endif;


/*
* Spotify Followers
*/
if(!function_exists('xsc_spotify_count')) :
	function xsc_spotify_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['spotify'])) {
			$result = $xsc_transient['spotify'];
		} elseif(empty($xsc_transient['spotify']) && !empty($xsc_data) && !empty($xsc_options['data']['spotify'])) {
			$result = $xsc_options['data']['spotify'];
		} else {
			$id = $url = $xsc_options_save['social']['spotify']['id'];
			$id = rtrim($id, "/");
			$id = urlencode(str_replace([
				                            'https://play.spotify.com/',
				                            'https://player.spotify.com/',
				                            'artist/',
				                            'user/',
			                            ], '', $id));

			try {
				if(!empty($url) && strpos($url, 'artist') !== false) {
					$data = @xsc_remote_get("https://api.spotify.com/v1/artists/$id");
				} else {
					$data = @xsc_remote_get("https://api.spotify.com/v1/users/$id");
				}
				$result = (int)$data['followers']['total'];

			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['spotify'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['spotify'])) //Get the stored data
			{
				$result = $xsc_options['data']['spotify'];
			}
		}

		return $result;

	}
endif;


/**
 * Goodreads Followers
 */
if(!function_exists('xsc_goodreads_count')) :
	function xsc_goodreads_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['goodreads'])) {
			$result = $xsc_transient['goodreads'];
		} elseif(empty($xsc_transient['goodreads']) && !empty($xsc_data) && !empty($xsc_options['data']['goodreads'])) {
			$result = $xsc_options['data']['goodreads'];
		} else {
			$id = $url = $xsc_options_save['social']['goodreads']['id'];
			$key = $xsc_options_save['social']['goodreads']['key'];

			$id = rtrim($id, "/");
			$id = @parse_url($id);
			$id = $id['path'];
			$id = str_replace(['/user/show/', '/author/show/'], '', $id);
			if(strpos($id, '-') !== false) {
				$id = explode('-', $id);
			} else {
				$id = explode('.', $id);
			}
			$id = $id[0];
			try {
				if(!empty($url) && strpos($url, 'author') !== false) {
					$data = @xsc_remote_get("https://www.goodreads.com/author/show/$id.xml?key=$key", false);
					$data = @new SimpleXmlElement($data);
					$result = (int)$data->author->author_followers_count;
				} else {
					$data = @xsc_remote_get("https://www.goodreads.com/user/show/$id.xml?key=$key", false);
					$data = @new SimpleXmlElement($data);
					$result = (int)$data->user->friends_count;
				}

			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['goodreads'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['goodreads'])) //Get the stored data
			{
				$result = $xsc_options['data']['goodreads'];
			}
		}

		return $result;

	}
endif;


/**
 * Twitch Followers
 */
if(!function_exists('xsc_twitch_count')) :
	function xsc_twitch_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['twitch'])) {
			$result = $xsc_transient['twitch'];
		} elseif(empty($xsc_transient['twitch']) && !empty($xsc_data) && !empty($xsc_options['data']['twitch'])) {
			$result = $xsc_options['data']['twitch'];
		} else {
			$id = $xsc_options_save['social']['twitch']['id'];
			$api = get_option('twitch_access_token');

			try {
				$data = @xsc_remote_get("https://api.twitch.tv/kraken/channels/$id?oauth_token=$api");

				$result = (int)$data['followers'];
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['twitch'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['twitch'])) //Get the stored data
			{
				$result = $xsc_options['data']['twitch'];
			}
		}

		return $result;

	}
endif;


/**
 * Mixcloud Followers
 */
if(!function_exists('xsc_mixcloud_count')) :
	function xsc_mixcloud_count($cache_time = 3600) {

		global $xsc_data, $xsc_options, $xsc_transient, $xsc_options_save;

		if(!empty($xsc_transient['mixcloud'])) {
			$result = $xsc_transient['mixcloud'];
		} elseif(empty($xsc_transient['mixcloud']) && !empty($xsc_data) && !empty($xsc_options['data']['mixcloud'])) {
			$result = $xsc_options['data']['mixcloud'];
		} else {
			$id = $xsc_options_save['social']['mixcloud']['id'];
			try {
				$data = @xsc_remote_get("http://api.mixcloud.com/$id/");
				$result = (int)$data['follower_count'];
			} catch(Exception $e) {
				$result = 0;
			}

			if(!empty($result)) //To update the stored data
			{
				$xsc_data['mixcloud'] = $result;
			}

			if(empty($result) && !empty($xsc_options['data']['mixcloud'])) //Get the stored data
			{
				$result = $xsc_options['data']['mixcloud'];
			}
		}

		return $result;

	}
endif;


/**
 * Posts Number
 */
if(!function_exists('xsc_posts_count')) :
	function xsc_posts_count($cache_time = 3600) {
		$count_posts = wp_count_posts();

		return $result = $count_posts->publish;
	}
endif;


/**
 * Comments number
 */
if(!function_exists('xsc_comments_count')) :
	function xsc_comments_count($cache_time = 3600) {
		$comments_count = wp_count_comments();

		return $result = $comments_count->approved;
	}
endif;


/**
 * Members number
 */
if(!function_exists('xsc_members_count')) :
	function xsc_members_count($cache_time = 3600) {
		$members_count = count_users();

		return $result = $members_count['total_users'];
	}
endif;


/**
 * Groups number
 */
if(!function_exists('xsc_groups_count')) :
	function xsc_groups_count($cache_time = 3600) {
		return $result = groups_get_total_group_count();
	}
endif;


/**
 * bbPress Counters
 */
if(!function_exists('xsc_bbpress_count')) :
	function xsc_bbpress_count($count) {
		$arg = [
			'count_users'           => false,
			'count_forums'          => false,
			'count_topics'          => false,
			'count_private_topics'  => false,
			'count_spammed_topics'  => false,
			'count_trashed_topics'  => false,
			'count_replies'         => false,
			'count_private_replies' => false,
			'count_spammed_replies' => false,
			'count_trashed_replies' => false,
			'count_tags'            => false,
			'count_empty_tags'      => false,
		];

		$arg['count_' . $count] = true;

		$counters = bbp_get_statistics($arg);
		if($count == 'forums') {
			$result = $counters['forum_count'];
		} elseif($count == 'topics') {
			$result = $counters['topic_count'];
		} elseif($count == 'replies') {
			$result = $counters['reply_count'];
		}

		return $result;

	}
endif;


if(!function_exists('xsc_remote_get')) :
	function xsc_remote_get($url, $json = true, $args = ['timeout' => 18, 'sslverify' => false]) {
		$get_request = preg_replace('/\s+/', '', $url);
		$get_request = wp_remote_get($url, $args);
		$request = wp_remote_retrieve_body($get_request);

		if($json) {
			$request = @json_decode($request, true);
		}

		return $request;
	}
endif;


if(!function_exists('xs_format_num')) :
	function xs_format_num($number) {

		if(!is_numeric($number)) {
			return $number;
		}

		global $wp_locale;

		$sep = [];
		$sep[] = (isset($wp_locale)) ? $wp_locale->number_format['decimal_point'] : '.';
		$sep[] = (isset($wp_locale)) ? $wp_locale->number_format['thousands_sep'] : ',';

		$number = str_replace($sep, '', $number);

		$precision = 1;

		if($number < 100) {
			// 0 - 900
			$n_format = number_format($number, $precision);
			$suffix = '';
		} else {
			if($number < 900000) {
				// 0.9k-850k
				$n_format = number_format($number / 1000, $precision);
				$suffix = 'K';
			} else {
				if($number < 900000000) {
					// 0.9m-850m
					$n_format = number_format($number / 1000000, $precision);
					$suffix = 'M';
				} else {
					if($number < 900000000000) {
						// 0.9b-850b
						$n_format = number_format($number / 1000000000, $precision);
						$suffix = 'B';
					} else {
						// 0.9t+
						$n_format = number_format($number / 1000000000000, $precision);
						$suffix = 'T';
					}
				}
			}
		}

		// Remove unecessary zeroes after decimal
		$dotzero = '.' . str_repeat('0', $precision);
		$n_format = str_replace($dotzero, '', $n_format);

		return $n_format . $suffix;
	}
endif;
