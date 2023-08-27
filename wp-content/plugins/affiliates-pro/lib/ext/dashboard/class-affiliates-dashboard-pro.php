<?php
/**
 * class-affiliates-dashboard-pro.php
 *
 * Copyright (c) 2010 - 2019 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-pro
 * @since affiliates-pro 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard extensions.
 */
class Affiliates_Dashboard_Pro extends Affiliates_Dashboard {

	public static function init() {
        Affiliates_Dashboard_Factory::set_dashboard_class( __CLASS__ );
        Affiliates_Dashboard_Section_Factory::set_section_classes(
            array( Affiliates_Dashboard_Overview_Pro::get_key() => Affiliates_Dashboard_Overview_Pro::class,
                Affiliates_Dashboard_Banners::get_key() => Affiliates_Dashboard_Banners::class,
                Affiliates_Dashboard_Traffic::get_key() => Affiliates_Dashboard_Traffic::class,
                Affiliates_Dashboard_Referrals::get_key() => Affiliates_Dashboard_Referrals::class,
                Affiliates_Dashboard_ShopList::get_key() => Affiliates_Dashboard_ShopList::class
                )
        );
    }

	public function __construct( $params = array() )
    {
        parent::__construct( $params );
        add_filter( 'affiliates_dashboard_setup_sections', array( $this, 'setup_sections' ) ); }

	public function setup_sections( $sections ) {
        $IX18344 = $this->get_user_id();
        if ( $IX18344 !== null && affiliates_user_is_affiliate( $IX18344 ) ) {
            $sections[Affiliates_Dashboard_ShopList::get_key()] = array(
                'class' => 'Affiliates_Dashboard_ShopList',
                'parameters' => array( 'user_id' => $IX18344 )
            );
            $sections[Affiliates_Dashboard_Overview_Pro::get_key()] = array(
                'class' => 'Affiliates_Dashboard_Overview_Pro',
                'parameters' => array( 'user_id' => $IX18344 ) );
            $sections[Affiliates_Dashboard_Traffic::get_key()] = array(
                'class' => 'Affiliates_Dashboard_Traffic',
                'parameters' => array( 'user_id' => $IX18344 ) );
            $sections[Affiliates_Dashboard_Referrals::get_key()] = array(
                'class' => 'Affiliates_Dashboard_Referrals',
                'parameters' => array( 'user_id' => $IX18344 )
            );
            $sections[Affiliates_Dashboard_Banners::get_key()] = array(
                'class' => 'Affiliates_Dashboard_Banners',
                'parameters' => array( 'user_id' => $IX18344 )
            );
        }
        return $sections;
    }
}
Affiliates_Dashboard_Pro::init();
