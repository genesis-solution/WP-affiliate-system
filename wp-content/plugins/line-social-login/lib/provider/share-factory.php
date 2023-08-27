<?php

namespace WP_Social\Lib\Provider;

use WP_Social\Lib\Provider\Share\Digg_Sharer;
use WP_Social\Lib\Provider\Share\Email_Sharer;
use WP_Social\Lib\Provider\Share\Facebook_Messenger_Sharer;
use WP_Social\Lib\Provider\Share\Facebook_Sharer;
use WP_Social\Lib\Provider\Share\Kik_Sharer;
use WP_Social\Lib\Provider\Share\Linkedin_Sharer;
use WP_Social\Lib\Provider\Share\No_Provider_Share;
use WP_Social\Lib\Provider\Share\Pinterest_Sharer;
use WP_Social\Lib\Provider\Share\Reddit_Sharer;
use WP_Social\Lib\Provider\Share\Skype_Sharer;
use WP_Social\Lib\Provider\Share\Stumbleupon_Sharer;
use WP_Social\Lib\Provider\Share\Telegram_Sharer;
use WP_Social\Lib\Provider\Share\Trello_Sharer;
use WP_Social\Lib\Provider\Share\Twitter_Sharer;
use WP_Social\Lib\Provider\Share\Viber_Sharer;
use WP_Social\Lib\Provider\Share\Whatsapp_Sharer;

defined('ABSPATH') || exit;

class Share_Factory {

	private $provider_type;
	private $post_id;

	public $factory;


	public function __construct($post_id) {

		$this->post_id = intval($post_id);
	}


	public function make($type) {

		$this->provider_type = $type;

		switch($type) {

			case 'facebook' :
				$this->factory = new Facebook_Sharer($this->post_id, $type);
				break;

			case 'twitter' :
				$this->factory = new Twitter_Sharer($this->post_id, $type);
				break;

			case 'pinterest' :
				$this->factory = new Pinterest_Sharer($this->post_id, $type);
				break;

			case 'linkedin' :
				$this->factory = new Linkedin_Sharer($this->post_id, $type);
				break;

			case 'facebook-messenger' :
				$this->factory = new Facebook_Messenger_Sharer($this->post_id, $type);
				break;

			case 'kik' :
				$this->factory = new Kik_Sharer($this->post_id, $type);
				break;

			case 'skype' :
				$this->factory = new Skype_Sharer($this->post_id, $type);
				break;

			case 'trello' :
				$this->factory = new Trello_Sharer($this->post_id, $type);
				break;

			case 'viber' :
				$this->factory = new Viber_Sharer($this->post_id, $type);
				break;

			case 'whatsapp' :
				$this->factory = new Whatsapp_Sharer($this->post_id, $type);
				break;

			case 'telegram' :
				$this->factory = new Telegram_Sharer($this->post_id, $type);
				break;

			case 'email' :
				$this->factory = new Email_Sharer($this->post_id, $type);
				break;

			case 'reddit' :
				$this->factory = new Reddit_Sharer($this->post_id, $type);
				break;

			case 'digg' :
				$this->factory = new Digg_Sharer($this->post_id, $type);
				break;

			case 'stumbleupon' :
				$this->factory = new Stumbleupon_Sharer($this->post_id, $type);
				break;

			default:
				$this->factory = new No_Provider_Share();

		}

		return $this->factory;
	}

}