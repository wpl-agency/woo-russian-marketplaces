<?php
/**
 * Plugin Name: Russian marketplaces for WooCommerce
 * Description: Добавьте ссылки на свои товары в Российских маркетплейсах.
 * Author: WPlovers
 * Author URI: https://wplovers.pro/
 * Version: 0.1.2
 *
 * @package wplovers-woo-russian-marketplaces
 */

namespace WPlovers\WooRussianMarketplaces;

define( 'WPL_WOO_RUSSIAN_MARKETPLACES_NAME', 'Russian marketplaces for WooCommerce' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_SLUG', 'wplovers-woo-russian-marketplaces' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_PREFIX', 'wplovers_woo_russian_marketplaces' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_URL', plugin_dir_url( __FILE__ ) );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_PATH', plugin_dir_path( __FILE__ ) );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

new Main();
