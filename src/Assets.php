<?php
/**
 * Подключает ассеты.
 *
 * @package wplovers-woo-russian-marketplaces
 */

namespace WPlovers\WooRussianMarketplaces;

/**
 * Class Widget.
 */
class Assets {
	/**
	 * Инициализация хуков.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	/**
	 * Добавляет ассеты в админке.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts(): void {
		wp_enqueue_style(
			Utils::get_plugin_slug(),
			Utils::get_plugin_url() . '/assets/css/admin.css',
			[],
			filemtime( Utils::get_plugin_path() . '/assets/css/admin.css', )
		);
	}
}
