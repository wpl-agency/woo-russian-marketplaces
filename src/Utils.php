<?php
/**
 * Полезные утилиты для плагина.
 *
 * @package wplovers-woo-russian-marketplaces
 */

namespace WPlovers\WooRussianMarketplaces;

class Utils {
	public static function get_plugin_prefix(): string {
		return WPL_WOO_RUSSIAN_MARKETPLACES_PREFIX;
	}

	public static function get_plugin_slug(): string {
		return WPL_WOO_RUSSIAN_MARKETPLACES_SLUG;
	}

	public static function get_plugin_name(): string {
		return WPL_WOO_RUSSIAN_MARKETPLACES_NAME;
	}

	public static function get_plugin_url(): string {
		return WPL_WOO_RUSSIAN_MARKETPLACES_URL;
	}

	public static function get_plugin_path(): string {
		return WPL_WOO_RUSSIAN_MARKETPLACES_PATH;
	}
}
