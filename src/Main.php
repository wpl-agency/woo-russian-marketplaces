<?php
/**
 * Основной файл плагина.
 *
 * @package wplovers-woo-russian-marketplaces
 */

namespace WPlovers\WooRussianMarketplaces;

/**
 * Class Main.
 */
class Main {
	/**
	 * Конструктор класса.
	 */
	public function __construct() {
		( new Settings() )->setup_hooks();
		( new Metabox() )->setup_hooks();
		( new Widget() )->setup_hooks();
		( new Assets() )->setup_hooks();
	}
}
