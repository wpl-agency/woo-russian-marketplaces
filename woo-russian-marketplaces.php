<?php
/**
 * Plugin Name: Russian marketplaces for WooCommerce
 * Plugin URI:https://www.kobzarev.com/
 * Description: Добавьте ссылки на свои товары в Российских маркетплейсах.
 * Author: mihdan
 * Author URI: https://www.kobzarev.com/
 * Version: 0.1.3
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: woo-russian-marketplaces
 * Requires Plugins: woocommerce
 *
 * @package woo-russian-marketplaces
 */

namespace WPlovers\WooRussianMarketplaces;

define( 'WPL_WOO_RUSSIAN_MARKETPLACES_NAME', 'Russian marketplaces for WooCommerce' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_SLUG', 'woo-russian-marketplaces' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_PREFIX', 'woo_russian_marketplaces' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_URL', plugin_dir_url( __FILE__ ) );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_PATH', plugin_dir_path( __FILE__ ) );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

new Main();
