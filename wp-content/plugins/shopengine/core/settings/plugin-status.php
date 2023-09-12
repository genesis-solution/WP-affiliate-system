<?php

namespace ShopEngine\Core\Settings;

defined('ABSPATH') || exit;

class Plugin_Status
{
    /**
     * @var mixed
     */
    private static $instance;
    /**
     * @var array
     */
    private $installedPlugins = [];
    /**
     * @var array
     */
    private $activatedPlugins = [];

    public function __construct()
    {
        $this->collect_installed_plugins();
        $this->collect_activated_plugins();
    }

    private function collect_installed_plugins()
    {
        foreach (get_plugins() as $key => $plugin) {
            array_push($this->installedPlugins, $key);
        }
    }

    private function collect_activated_plugins()
    {
        foreach (apply_filters('active_plugins', get_option('active_plugins')) as $plugin) {
            array_push($this->activatedPlugins, $plugin);
        }
    }

    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @return mixed
     */
    public function get_installed_plugins()
    {
        return $this->installedPlugins;
    }

    /**
     * @return mixed
     */
    public function get_activated_plugins()
    {
        return $this->activatedPlugins;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get_status($name)
    {
        $data = [
            "url"              => "",
            "activation_url"   => "",
            "installation_url" => "",
            "title"            => "",
            "status"           => ""
        ];

        if ($this->check_installed_plugin($name)) {
            if ($this->check_activated_plugin($name)) {
                $data['title']  = __('Activated', 'shopengine');
                $data['status'] = "activated";
            } else {
                $data['title']          = __('Activate Now', 'shopengine');
                $data['status']         = 'installed';
                $data['activation_url'] = $this->activation_url($name);
            }
        } else {
            $data['title']            = __('Install Now', 'shopengine');
            $data['status']           = 'not_installed';
            $data['installation_url'] = $this->installation_url($name);
            $data['activation_url']   = $this->activation_url($name);
        }

        return $data;
    }

    /**
     * @param $name
     */
    public function check_installed_plugin($name)
    {
        return in_array($name, $this->installedPlugins);
    }

    /**
     * @param $name
     */
    public function check_activated_plugin($name)
    {
        return in_array($name, $this->activatedPlugins);
    }

    /**
     * @param $pluginName
     */
    public function activation_url($pluginName)
    {

        $url = wp_nonce_url(add_query_arg(
            [
                'action'        => 'activate',
                'plugin'        => $pluginName,
                'plugin_status' => 'all',
                'paged'         => '1&s'
            ],
            admin_url('plugins.php')
        ), 'activate-plugin_' . $pluginName);

		return str_replace('&amp;', '&', $url);
    }

    /**
     * @param $pluginName
     */
    public function installation_url($pluginName)
    {
        $action     = 'install-plugin';
        $pluginSlug = $this->get_plugin_slug($pluginName);

        $url = wp_nonce_url(
            add_query_arg(
                [
                    'action' => $action,
                    'plugin' => $pluginSlug
                ],
                admin_url('update.php')
            ),
            $action . '_' . $pluginSlug
        );

		return str_replace('&amp;', '&', $url);
    }

    /**
     * @param $name
     */
    public function get_plugin_slug($name)
    {
        $split = explode('/', $name);

        return isset($split[0]) ? $split[0] : null;
    }

    /**
     * @param $pluginName
     */
    public function activated_url($pluginName)
    {
        return add_query_arg(
            [
                'page' => $this->get_plugin_slug($pluginName)
            ],
            admin_url('admin.php'));
    }
}
