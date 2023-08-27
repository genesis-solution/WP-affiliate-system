<?php

namespace WP_Social\App;

class Providers {

	const ORDER_LIST_PROVIDER_SHARE = 'xs_share_providers_order';
	const ORDER_LIST_PROVIDER_LOGIN = 'xs_login_providers_order';
	const ORDER_LIST_PROVIDER_COUNTER = 'xs_counter_providers_order';

	public static function get_core_providers_share() {

		$share_links = [
			'facebook' => [
				'label'  => 'Facebook',
				'url'    => 'http://www.facebook.com/sharer.php',
				'params' => [
					'u' => '[%url%]',
					't' => '[%title%]',
					'v' => 3,
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Facebook',
				],
			],

			'twitter' => [
				'label'  => 'Twitter',
				'url'    => 'https://twitter.com/intent/tweet',
				'params' => [
					'text'             => '[%title%] [%url%]',
					'original_referer' => '[%url%]',
					'related'          => '[%author%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Twitter',
				],
			],

			'linkedin' => [
				'label'  => 'LinkedIn',
				'url'    => 'https://www.linkedin.com/shareArticle',
				'params' => [
					'url'     => '[%url%]',
					'title'   => '[%title%]',
					'summary' => '[%details%]',
					'source'  => '[%source%]',
					'mini'    => true,
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'LinkedIn',
				],
			],

			'pinterest' => [
				'label'  => 'Pinterest',
				'url'    => 'https://pinterest.com/pin/create/button/',
				'params' => [
					'url'         => '[%url%]',
					'media'       => '[%media%]',
					'description' => '[%details%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Pinterest',
				],
			],

			'facebook-messenger' => [
				'label'  => 'Facebook Messenger',
				'url'    => 'https://www.facebook.com/dialog/send',
				'params' => [
					'link'         => '[%url%]',
					'redirect_uri' => '[%url%]',
					'display'      => 'popup',
					'app_id'       => '[%app_id%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Facebook Messenger',
				],
			],

			'kik' => [
				'label'  => 'Kik',
				'url'    => 'https://www.kik.com/send/article/',
				'params' => [
					'url'   => '[%url%]',
					'text'  => '[%details%]',
					'title' => '[%title%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Kik',
				],
			],

			'skype' => [
				'label'  => 'Skype',
				'url'    => 'https://web.skype.com/share',
				'params' => [
					'url' => '[%url%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Skype',
				],
			],

			'trello' => [
				'label'  => 'Trello',
				'url'    => 'https://trello.com/add-card',
				'params' => [
					'url'  => '[%url%]',
					'name' => '[%title%]',
					'desc' => '[%details%]',
					'mode' => 'popup',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Trello',
				],
			],

			'viber' => [
				'label'  => 'Viber',
				'url'    => 'viber://forward',
				'params' => [
					'text' => '[%title%] [%url%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Viber',
				],
			],

			'whatsapp' => [
				'label'  => 'WhatsApp',
				'url'    => 'whatsapp://send',
				'params' => [
					'text' => '[%title%] [%url%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'WhatsApp',
				],
			],

			'telegram' => [
				'label'  => 'Telegram',
				'url'    => 'https://telegram.me/share/url',
				'params' => [
					'url'  => '[%url%]',
					'text' => '[%title%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Telegram',
				],
			],

			'email' => [
				'label'  => 'Email',
				'url'    => 'mailto:',
				'params' => [
					'body'    => 'Title: [%title%] \n\n URL: [%url%]',
					'subject' => '[%title%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Email',
				],
			],

			'reddit' => [
				'label'  => 'Reddit',
				'url'    => 'http://reddit.com/submit',
				'params' => [
					'url'   => '[%url%]',
					'title' => '[%title%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Reddit',
				],
			],

			'digg' => [
				'label'  => 'Digg',
				'url'    => 'http://digg.com/submit',
				'params' => [
					'url'   => '[%url%]',
					'title' => '[%title%]',
					'phase' => 2,
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'Digg',
				],
			],

			'stumbleupon' => [
				'label'  => 'StumbleUpon',
				'url'    => 'http://www.stumbleupon.com/submit',
				'params' => [
					'url'   => '[%url%]',
					'title' => '[%title%]',
				],
				'data'   => [
					'value' => 0,
					'text'  => 'Share',
					'label' => 'StumbleUpon',
				],
			],
		];

		$providers_order = get_option(self::ORDER_LIST_PROVIDER_SHARE);

		return self::providers_sort($providers_order, $share_links);
	}

	public static function get_core_providers_login() {

		$login_providers = [
			'facebook'  => 'Facebook',
			'google'    => 'Google',
			'linkedin'  => 'LinkedIn',
			'twitter'   => 'Twitter',
			'dribbble'  => 'Dribbble',
			'github'    => 'GitHub',
			'wordpress' => 'WordPress',
			'vkontakte' => 'Vkontakte',
			'reddit'    => 'Reddit',
			'lineapp'	=> 'LineApp'
		];

		$providers_order = get_option(self::ORDER_LIST_PROVIDER_LOGIN);

		return self::providers_sort($providers_order, $login_providers);
	}

	/**
	 * todo - right now I am just collecting all functions used for providers here, once gathering is done then we can merge some methods into one
	 *
	 */
	public static function xs_login_service_provider_instruction($social) {

		$doc_url = 'https://help.wpmet.com/docs-cat/wp-social/';

		$tmp = [
			'getting_txt' => '',
			'doc_url'     => $doc_url,
			'local_ins'   => '',
		];

		$doc_arr['facebook'] = [
			'getting_txt' => __('To allow your visitors to log in with their Facebook account, first you must create a Facebook App. The following guide will help you through the Facebook App creation process. After you have created your Facebook App, head over to "Settings" and configure the given "App ID" and "App Secret" according to your Facebook App.', 'wp-social'),
			'doc_url'     => 'https://wpmet.com/doc/facebook-social-login-app/',
			'local_ins'   => __('For local development environment you do not need to add the redirect URI.', 'wp-social'),
		];

		$doc_arr['google'] = [
			'getting_txt' => __('To allow your visitors to log in with their Google account, first you must create a Google Project. The following guide will help you through the Google project creation process. After you have created your Google project, head over to "Settings" and configure the given "App ID" and "App Secret" according to your Google App.', 'wp-social'),
			'doc_url'     => 'https://help.wpmet.com/docs/wp-social-google-login-app/',
			'local_ins'   => '',
		];

		$doc_arr['linkedin'] = [
			'getting_txt' => __('To connect your Auth0 app to LinkedIn, you will need to generate a Client ID and Client Secret in a LinkedIn app, copy these keys into your Auth0 settings, and enable the connection', 'wp-social'),
			'doc_url'     => 'https://help.wpmet.com/docs/wp-social-linkedin-login-app/',
			'local_ins'   => '',
		];

		$doc_arr['twitter'] = [
			'getting_txt' => __('To allow your visitors to log in with their Twitter account, first you must create a Twitter App. The following guide will help you through the Twitter App creation process. After you have created your Twitter App, head over to "Settings" and configure the given "Consumer Key" and "Consumer Secret" according to your Twitter App.', 'wp-social'),
			'doc_url'     => 'https://help.wpmet.com/docs/wp-social-twitter-app/',
			'local_ins'   => '',
		];

		$doc_arr['dribbble'] = [
			'getting_txt' => __('To allow your visitors to log in with their Dribbble account, first you must create a Dribbble App. The following guide will help you through the Dribbble App creation process. After you have created your Dribbble App, head over to "Settings" and configure the given "App ID" and "App Secret" according to your Dribbble App.', 'wp-social'),
			'doc_url'     => 'https://help.wpmet.com/docs/wp-social-dribbble-app/',
			'local_ins'   => '',
		];

		$doc_arr['github'] = [
			'getting_txt' => __('To allow your visitors to log in with their GitHub account, first you must create a GitHub App. The following guide will help you through the GitHub App creation process. After you have created your GitHub App, head over to "Settings" and configure the given "App ID" and "App Secret" according to your GitHub App.', 'wp-social'),
			'doc_url'     => 'https://help.wpmet.com/docs/wp-social-github-app/',
			'local_ins'   => '',
		];

		$doc_arr['wordpress'] = [
			'getting_txt' => __('To allow your visitors to log in with their WordPress account, first you must create a WordPress App. The following guide will help you through the WordPress App creation process. After you have created your WordPress App, head over to "Settings" and configure the given "App ID" and "App Secret" according to your WordPress App.', 'wp-social'),
			'doc_url'     => 'https://help.wpmet.com/docs/wp-social-wordpress-app/',
			'local_ins'   => '',
		];

		$doc_arr['reddit'] = [
			'getting_txt' => __('To allow your visitors to log in with their Reddit account, first you must create a Reddit App. The following guide will help you through the Reddit App creation process. After you have created your Reddit App, head over to "Settings" and configure the given "App ID" and "App Secret" according to your Reddit App.', 'wp-social'),
			'doc_url'     => 'https://help.wpmet.com/docs/wp-social-reddit-app/',
			'local_ins'   => '',
		];

		$doc_arr['vkontakte'] = [
			'getting_txt' => __('To allow your visitors to log in with their Vkontakte account, first you must create a Vkontakte App. The following guide will help you through the Vkontakte App creation process. After you have created your Vkontakte App, head over to "Settings" and configure the given "App ID" and "App Secret" according to your Vkontakte App.', 'wp-social'),
			'doc_url'     => 'https://wpmet.com/doc/vkontakte-integration-for-wp-social/',
			'local_ins'   => '',
		];

		$doc_arr['lineapp'] = [
			'getting_txt' => __('To allow your visitors to log in with their LineApp account, first you must create a LineApp. The following guide will help you through the LineApp creation process. After you have created your LineApp, head over to "Settings" and configure the given "App ID" and "App Secret" according to your LineApp.', 'wp-social'),
			'doc_url'     => 'https://wpmet.com/doc/wp-social-line-app-integration/',
			'local_ins'   => '',
		];


		return isset($doc_arr[$social]) ? $doc_arr[$social] : $tmp;
	}


	public static function get_core_providers_count() {

		$counter_providers = [
			'facebook' => [
				'label' => 'Facebook',
				'data'  => ['text' => __('Fans', 'wp-social'), 'url' => 'http://www.facebook.com/%s'],
				'form'  => [
					'id' => ['type' => 'normal', 'label' => 'Page ID/Name', 'input' => 'text'],
				],
			],

			'twitter' => [
				'label' => 'Twitter',
				'data'  => ['text' => __('Followers', 'wp-social'), 'url' => 'http://twitter.com/%s'],
				'form'  => [
					'id'  => ['type' => 'normal', 'label' => 'Username', 'input' => 'text'],
					'api' => [
						'type'  => 'access',
						'label' => __('Access Token Key', 'wp-social'),
						'input' => 'text',
						'filed' => ['app_id' => 'Consumer key', 'app_secret' => 'Consumer secret'],
					],
				],
			],

			'pinterest' => [
				'label' => 'Pinterest',
				'data'  => ['text' => __('Followers', 'wp-social'), 'url' => 'http://www.pinterest.com/%s'],
				'form'  => [
					'username' => [
						'type'  => 'normal',
						'label' => 'Username',
						'input' => 'text',
					],
				],
			],

			'dribbble' => [
				'label' => 'Dribbble',
				'data'  => ['text' => __('Followers', 'wp-social'), 'url' => 'http://dribbble.com/%s'],
				'form'  => [
					'api' => [
						'type'  => 'access',
						'label' => __('Access Token Key', 'wp-social'),
						'input' => 'text',
						'filed' => ['app_id' => 'Client ID', 'app_secret' => 'Client Secret'],
					],
				],
			],

			'instagram' => [
				'label' => 'Instagram',
				'data'  => ['text' => __('Followers', 'wp-social'), 'url' => 'http://instagram.com/%s'],
				'form'  => [
					'id' => [
						'type'  => 'normal',
						'label' => 'Username',
						'input' => 'text',
					],
				],
			],

			'youtube' => [
				'label' => 'YouTube',
				'data'  => ['text' => __('Subscribers', 'wp-social'), 'url' => 'http://youtube.com/%s/%s'],
				'form'  => [
					'type' => [
						'type'  => 'normal',
						'label' => 'Account Type',
						'input' => 'select',
						'data'  => ['Channel' => 'Channel', 'User' => 'User'],
					],
					'id'   => ['type' => 'normal', 'label' => 'Username or Channel ID', 'input' => 'text'],
					'key'  => ['type' => 'normal', 'label' => 'YouTube API Key', 'input' => 'text'],
				],
			],

			'mailchimp' => [
				'label' => 'Mailchimp',
				'data'  => ['text' => __('Subscribers', 'wp-social')],
				'form'  => [
					'id'  => ['type' => 'normal', 'label' => 'List ID (Optional)', 'input' => 'text'],
					'api' => ['type' => 'normal', 'label' => 'API Key', 'input' => 'text'],
				],
			],

			'comments' => [
				'label' => 'Comments',
				'data'  => ['text' => __('Count', 'wp-social')],
			],

			'posts' => [
				'label' => 'Posts',
				'data'  => ['text' => __('Count', 'wp-social')],
			],

			// 'vimeo'      => [ 'label' => 'Vimeo', 'data' => ['text' => __( 'Subscribers',	'wp-social' ), 'url' => 'https://vimeo.com/channels/%s']  ],
			// 'vkontakte'  => [ 'label' => 'Vkontakte', 'data' => ['text' => __( 'Members', 'wp-social' ), 'url' => 'http://vk.com/%s']  ],
			// 'linkedin'   => [ 
			// 	'label' => 'LinkedIn', 
			// 	'data' => ['text' => __( 'Followers', 'wp-social' ), 'url' => 'https://www.linkedin.com/%s/%s'],  
			// 	'form' => [
			// 		'type' => [
			// 			'type'  => 'normal',
			// 			'label' => 'Account Type',
			// 			'input' => 'select',
			// 			'data'  => ['Company' => 'Company', 'Profile' => 'Profile'],
			// 		],
			// 		'id'   => ['type' => 'normal', 'label' => 'Your ID', 'input' => 'text'],
			// 		'api'  => [
			// 			'type'  => 'access',
			// 			'label' => 'Access Token Key(optional)',
			// 			'input' => 'text',
			// 			'filed' => ['app_id' => 'API Key', 'app_secret' => 'Secret Key'],
			// 		],
			// 	],  
			// ],
		];

		$providers_order = get_option(self::ORDER_LIST_PROVIDER_COUNTER);

		return self::providers_sort($providers_order, $counter_providers);
	}

	public static function providers_sort($providers_order, $main_providers) {

		if(empty($providers_order)) {
			return $main_providers;
		}

		$providers_final_order = [];

		foreach($providers_order as $provider) {
			$providers_final_order[$provider] = $main_providers[$provider];

			unset($main_providers[$provider]);
		}

		if(!empty($main_providers)) {

			foreach($main_providers as $key => $val) {

				$providers_final_order[$key] = $val;
			}
		}

		return $providers_final_order;
	}
}
