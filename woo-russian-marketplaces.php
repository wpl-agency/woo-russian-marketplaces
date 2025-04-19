<?php
/**
 * Plugin Name: Russian marketplaces for WooCommerce
 * Plugin URI:https://www.kobzarev.com/
 * Description: Добавьте ссылки на свои товары в Российских маркетплейсах.
 * Author: mihdan
 * Author URI: https://www.kobzarev.com/
 * Version: 0.1.3.1
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: russian-marketplaces-for-woocommerce
 * Requires Plugins: woocommerce
 *
 * @package russian-marketplaces-for-woocommerce
 */

namespace WPlovers\WooRussianMarketplaces;

define( 'WPL_WOO_RUSSIAN_MARKETPLACES_NAME', 'Russian marketplaces for WooCommerce' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_SLUG', 'russian-marketplaces-for-woocommerce' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_PREFIX', 'russian_marketplaces_for_woocommerce' );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_URL', plugin_dir_url( __FILE__ ) );
define( 'WPL_WOO_RUSSIAN_MARKETPLACES_PATH', plugin_dir_path( __FILE__ ) );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

new Main();
