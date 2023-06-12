<?php
/**
 * Plugin Name: Rate limiting UI for WooCommerce
 * Plugin URI: https://github.com/nielslange/rate-limiting-ui-for-woocommerce-blocks
 * Description: Allows merchants to configure the rate limiting settings for WooCommerce.
 * Version: 1.0
 * Author: Paulo Arromba, Niels Lange
 *
 * Requires at least: 6.1.1
 * Requires PHP: 7.4
 * WC requires at least: 7.2
 * WC tested up to: 7.2
 *
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: rate-limiting-ui-for-woocommerce
 */

/**
 * Add a new settings section tab to the WooCommerce advanced settings tabs array.
 */
function add_wc_advanced_settings_tab($sections){
    $sections['rate_limiting'] = __('Rate Limiting', 'rate-limiting-ui-for-woocommerce');
    
    return $sections;
}
add_filter('woocommerce_get_sections_advanced', 'add_wc_advanced_settings_tab', 20);

// add_filter( 'woocommerce_store_api_rate_limit_options', function() {
// 	return [
// 		'enabled' => defined('STORE_API_RATE_LIMITING_ENABLED') ? STORE_API_RATE_LIMITING_ENABLED : true, // enables/disables Rate Limiting
// 		'proxy_support' => defined('STORE_API_RATE_LIMITING_PROXY_SUPPORT') ? STORE_API_RATE_LIMITING_PROXY_SUPPORT : false, //enables/disables Proxy support. Default:false
// 		'limit' => defined('STORE_API_RATE_LIMITING_LIMIT') ? STORE_API_RATE_LIMITING_LIMIT : 25, // limit of request per timeframe. Default: 25
// 		'seconds' => defined('STORE_API_RATE_LIMITING_SECONDS') ? STORE_API_RATE_LIMITING_SECONDS : 10, // timeframe in seconds. Default: 10
// 	];
// } );

/**
 * Add the settings section to the WooCommerce settings tab array on the advanced tab.
 * 
 * @param array $settings The settings array to add our section to.
 * @return array $settings The settings array with our section added.
 */
function add_wc_advanced_settings($settings){
    global $current_section;
    if ('rate_limiting' == $current_section) {
        $rate_limiting_settings = array(
            array(
                'name' => __('Rate Limiting', 'rate-limiting-ui-for-woocommerce'),
                'type' => 'title',
                'desc' => '',
                'id'   => 'rate_limiting_settings'
            ),
            array(
                'name'     => __('Enable', 'rate-limiting-ui-for-woocommerce'),
                'id'       => 'enabled',
                'type'     => 'checkbox',
                'desc'     => __('Here is some help text', 'rate-limiting-ui-for-woocommerce'),
            ),
            array(
                'name'     => __('Proxy support', 'rate-limiting-ui-for-woocommerce'),
                'id'       => 'proxy_support',
                'type'     => 'checkbox',
                'desc'     => __('Here is some help text', 'rate-limiting-ui-for-woocommerce'),
            ),
            array(
                'name'     => __('Limit', 'rate-limiting-ui-for-woocommerce'),
                'id'       => 'limit',
                'type'     => 'text',
                'css'      => 'width:100px;',
                'default'  => '25',
                'desc'     => __('Here is some help text', 'rate-limiting-ui-for-woocommerce'),
                
            ),
            array(
                'name'     => __('Seconds', 'rate-limiting-ui-for-woocommerce'),
                'id'       => 'seconds',
                'type'     => 'text',
                'css'      => 'width:100px;',
                'default'  => '10',
                'desc'     => __('Here is some help text', 'rate-limiting-ui-for-woocommerce'),
            ),
            array(
                'type' => 'sectionend',
                'id'   => 'rate_limiting_settings',
            ),
        );
        return $rate_limiting_settings;
    }
    return $settings;
}
add_filter('woocommerce_get_settings_advanced', 'add_wc_advanced_settings');