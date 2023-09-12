<?php

namespace ShopEngine\Core\Onboard;

use ShopEngine\Core\Register\Model;

class Onboard
{
    const ACCOUNT_URL     = 'https://account.wpmet.com';
    const ENVIRONMENT_ID  = 3;
    const CONTACT_LIST_ID = 3;
    const STATUS          = 'shopengine_onboard_status';
    /**
     * @param $data
     */
    public function submit($data)
    {
        if (!empty($data['data'])) {
            $data = $data['data'];

            if (!empty($data['widgets'])) {
                Model::source('settings')->set_option('widgets', $data['widgets']);
            }

            if (!empty($data['modules'])) {
                Model::source('settings')->set_option('modules', $data['modules']);
            }

            if (isset($data['user_onboard_data']['isDataSharable']) && $data['user_onboard_data']['isDataSharable'] == true) {
                Plugin_Data_Sender::instance()->send('diagnostic-data');
            }

            if (!empty($data['user_onboard_data']['email']) && !empty(is_email($data['user_onboard_data']['email']))) {
                $args = [
                    'email'           => $data['user_onboard_data']['email'],
                    'environment_id'  => Onboard::ENVIRONMENT_ID,
                    'contact_list_id' => Onboard::CONTACT_LIST_ID
                ];
                Plugin_Data_Sender::instance()->sendAutomizyData('email-subscribe', $args);
            }
            update_option(Onboard::STATUS, true);
        }

        return [
            'status'  => 'success',
            'message' => esc_html__('settings saved successfully.', 'shopengine')
        ];
    }
}
