<?php
/**
 * Plugin Name: Rate limiting UI for WooCommerce
 * Plugin URI: https://github.com/nielslange/rate-limiting-ui-for-woocommerce
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
 *
 * @package Rate_Limiting_UI_for_WooCommerce
 */

/**
 * Add settings link on plugin page
 *
 * @param array $links The original array with customizer links.
 *
 * @return array The updated array with customizer links.
 */
function smntcs_google_webmasadd_plugin_action_links( array $links ) {
	$admin_url     = admin_url( 'admin.php?page=wc-settings&tab=advanced&section=rate_limiting' );
	$settings_link = sprintf( '<a href="%s">' . __( 'Settings', 'rate-limiting-ui-for-woocommerce' ) . '</a>', $admin_url );
	array_unshift( $links, $settings_link );

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'smntcs_google_webmasadd_plugin_action_links' );

/**
 * Add a new settings section tab to the WooCommerce advanced settings tabs array.
 *
 * @param array $sections The original array with the WooCommerce settings tabs.
 * @return array $sections The updated array with our settings tab added.
 */
function add_wc_advanced_settings_tab( $sections ) {
	$sections['rate_limiting'] = __( 'Rate Limiting', 'rate-limiting-ui-for-woocommerce' );

	return $sections;
}
add_filter( 'woocommerce_get_sections_advanced', 'add_wc_advanced_settings_tab', 20 );

// @phpcs:disable
// add_filter(
// 'woocommerce_store_api_rate_limit_options',
// function() {
// return array(
// 'enabled'       => defined( 'STORE_API_RATE_LIMITING_ENABLED' ) ? STORE_API_RATE_LIMITING_ENABLED : true,
// 'proxy_support' => defined( 'STORE_API_RATE_LIMITING_PROXY_SUPPORT' ) ? STORE_API_RATE_LIMITING_PROXY_SUPPORT : false,
// 'limit'         => defined( 'STORE_API_RATE_LIMITING_LIMIT' ) ? STORE_API_RATE_LIMITING_LIMIT : 25,
// 'seconds'       => defined( 'STORE_API_RATE_LIMITING_SECONDS' ) ? STORE_API_RATE_LIMITING_SECONDS : 10,
// );
// }
// );
// @phpcs:enable

/**
 * Add the settings section to the WooCommerce settings tab array on the advanced tab.
 *
 * @param array $settings The settings array to add our section to.
 * @return array $settings The settings array with our section added.
 */
function add_wc_advanced_settings( $settings ) {
	global $current_section;
	if ( 'rate_limiting' == $current_section ) {
		$rate_limiting_settings = array(
			array(
				'name' => __( 'Rate Limiting', 'rate-limiting-ui-for-woocommerce' ),
				'type' => 'title',
				'desc' => '',
				'id'   => 'rate_limiting_settings',
			),
			array(
				'name' => __( 'Enable', 'rate-limiting-ui-for-woocommerce' ),
				'id'   => 'enabled',
				'type' => 'checkbox',
				'desc' => __( 'Enable the Rate Limiting feature', 'rate-limiting-ui-for-woocommerce' ),
			),
			array(
				'name'    => __( 'Seconds', 'rate-limiting-ui-for-woocommerce' ),
				'id'      => 'seconds',
				'type'    => 'number',
				'css'     => 'width:50px;',
				'default' => '10',
				'desc'    => __( 'Time in seconds before rate limits are reset.', 'rate-limiting-ui-for-woocommerce' ),
			),
			array(
				'name'    => __( 'Limit', 'rate-limiting-ui-for-woocommerce' ),
				'id'      => 'limit',
				'type'    => 'number',
				'css'     => 'width:50px;',
				'default' => '25',
				'desc'    => __( 'Amount of max requests allowed for the defined timeframe.', 'rate-limiting-ui-for-woocommerce' ),

			),
			array(
				'name' => __( 'Enable Basic Proxy support', 'rate-limiting-ui-for-woocommerce' ),
				'id'   => 'proxy_support',
				'type' => 'checkbox',
				'desc' => __( 'Enable this only if your store is running behing a reverse proxy, cache system, etc.', 'rate-limiting-ui-for-woocommerce' ),
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
add_filter( 'woocommerce_get_settings_advanced', 'add_wc_advanced_settings' );
