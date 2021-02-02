<?php 
/*
	Plugin Name: Woo Coming Soon
	Plugin URI: http://androidbubble.com/blog/wordpress/plugins/woo-coming-soon
	Description: Woo Coming Soon is a great plugin to set your products to coming status. 
	Version: 1.2.6
	Author: Fahad Mahmood 
	Author URI: https://www.androidbubbles.com
	Text Domain: woo-coming-soon
	Domain Path: /languages/
	License: GPL2
	
	Woo Coming Soon is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version. Woo Coming Soon is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with Woo Coming Soon. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/ 

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
	global $woo_cs_dir, $woo_cs_url, $woo_cs_data, $woo_cs_options, $woo_cs_android_settings, $woo_cs_premium_link, $woo_cs_pro;
	
	$woo_cs_premium_link = 'https://shop.androidbubbles.com/product/woo-coming-soon';//https://shop.androidbubble.com/products/wordpress-plugin?variant=36439508254875';//

		
	$woo_cs_dir = plugin_dir_path( __FILE__ );
	$woo_cs_url = plugin_dir_url( __FILE__ );

	$woo_cs_pro_file = $woo_cs_dir . '/pro/woo_cs_pro.php';
	$woo_cs_pro =  file_exists($woo_cs_pro_file);

	$woo_cs_data = get_plugin_data(__FILE__);
	$woo_cs_options = get_option('woo_cs_options');
	$woo_cs_options = is_array($woo_cs_options)?$woo_cs_options:array();
	$woo_cs_options['product_page_text'] = array_key_exists('product_page_text', $woo_cs_options)?$woo_cs_options['product_page_text']:__('This product is Coming Soon!', 'woo-coming-soon');
	
	include('inc/functions.php');

	if($woo_cs_pro){
		include_once($woo_cs_pro_file);
	}else{
		add_filter( 'manage_product_posts_columns' , 'woo_cs_custom_columns_title' );
	}
		
	include('io/functions-inner.php');
	$rest_api_url = 'woo-cs-settings/v1';
	if(class_exists('QR_Code_Settings_WOOCS')){
		$woo_cs_android_settings = new QR_Code_Settings_WOOCS($woo_cs_dir, $woo_cs_url, $rest_api_url);
	}else{
		$woo_cs_android_settings = array();
	}


	
	
	if(is_admin()){
		add_action( 'admin_menu', 'woo_cs_admin_menu' );
		add_action( 'admin_enqueue_scripts', 'woo_cs_admin_scripts', 99 );
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'woo_cs_plugin_links' );		
	}	
	
