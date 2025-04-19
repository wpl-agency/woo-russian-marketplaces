<?php
/**
 * Абстрактный класс маркетплейса.
 *
 * @package woo-russian-marketplaces
 */

namespace WPlovers\WooRussianMarketplaces;

/**
 * Class Marketplace
 */
abstract class Marketplace {
	/**
	 * Получает идентификатор маркетплейса.
	 *
	 * @return string
	 */
	abstract public function get_id(): string;

	/**
	 * Получает название маркетплейса.
	 *
	 * @return string
	 */
	abstract public function get_name(): string;

	/**
	 * Получает плейсхолдер для поля со ссылкой.
	 *
	 * @return string
	 */
	abstract public function get_url_placeholder(): string;



	/**
	 * Возвращает массив русских маркетплейсов.
	 * TODO: сделать абстрактный класс и по классу на каждый маркетлпейс.
	 *
	 * @return array
	 */
	public static function get_merketplaces(): array {
		return apply_filters(
			'wplovers/woo_russian_marketplaces/marketplaces',
			[
				'wildberries'    => [
					'name'        => __( 'Wildberries', 'woo-russian-marketplaces' ),
					'css'         => [
						'background-color' => '#CB11AB',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.wildberries.ru/&hellip;',
				],
				'ozon'           => [
					'name'        => __( 'Ozon', 'woo-russian-marketplaces' ),
					'css'         => [
						'background-color' => '#005BFF',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.ozon.ru/&hellip;',
				],
				'yandex_market'  => [
					'name'        => __( 'Yandex Market', 'woo-russian-marketplaces' ),
					'css'         => [
						'background-color' => '#FFCC00',
						'color'            => '#000000',
					],
					'placeholder' => 'https://market.yandex.ru/&hellip;',
				],
				'avito'          => [
					'name'        => __( 'Avito', 'woo-russian-marketplaces' ),
					'css'         => [
						'background-color' => '#00AAFF',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.avito.ru/&hellip;',
				],
				'lamoda'         => [
					'name'        => __( 'Lamoda', 'woo-russian-marketplaces' ),
					'css'         => [
						'background-color' => '#000000',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.lamoda.ru/&hellip;',
				],
				'sbermegamarket' => [
					'name'        => __( 'SberMegaMarket', 'woo-russian-marketplaces' ),
					'css'         => [
						'background-color' => '#9B38DC',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://sbermegamarket.ru/&hellip;',
				],
				'livemaster'     => [
					'name'        => __( 'Ярмарка мастеров', 'woo-russian-marketplaces' ),
					'css'         => [
						'background-color' => '#EA7913',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.livemaster.ru/&hellip;',
				],
				'aliexpress'     => [
					'name'        => __( 'Aliexpress', 'woo-russian-marketplaces' ),
					'css'         => [
						'background-color' => '#CC290A',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://aliexpress.ru/&hellip;',
				],
			]
		);
	}
}
