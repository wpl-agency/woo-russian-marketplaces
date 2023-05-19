<?php
/**
 * Класс маркетплейса Wildberries.
 *
 * @package wplovers-woo-russian-marketplaces
 */

namespace WPlovers\WooRussianMarketplaces\Marketplaces;

use WPlovers\WooRussianMarketplaces\Marketplace;

/**
 * Class Wildberries.
 */
class Wildberries extends Marketplace {
	/**
	 * Получает идентификатор маркетплейса.
	 *
	 * @return string
	 */
	public function get_id(): string {
		return 'wildberries';
	}

	/**
	 * Получает название маркетплейса.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return __( 'Wildberries', 'wplovers-woo-russian-marketplaces' );
	}

	/**
	 * Получает плейсхолдер для поля со ссылкой.
	 *
	 * @return string
	 */
	public function get_url_placeholder(): string {
		return 'https://www.wildberries.ru/catalog/25947331/detail.aspx';
	}
}
