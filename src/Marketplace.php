<?php
/**
 * Абстрактный класс маркетплейса.
 *
 * @package russian-marketplaces-for-woocommerce
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
					'name'        => __( 'Wildberries', 'russian-marketplaces-for-woocommerce' ),
					'css'         => [
						'background-color' => '#CB11AB',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.wildberries.ru/&hellip;',
				],
				'ozon'           => [
					'name'        => __( 'Ozon', 'russian-marketplaces-for-woocommerce' ),
					'css'         => [
						'background-color' => '#005BFF',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.ozon.ru/&hellip;',
				],
				'yandex_market'  => [
					'name'        => __( 'Yandex Market', 'russian-marketplaces-for-woocommerce' ),
					'css'         => [
						'background-color' => '#FFCC00',
						'color'            => '#000000',
					],
					'placeholder' => 'https://market.yandex.ru/&hellip;',
				],
				'avito'          => [
					'name'        => __( 'Avito', 'russian-marketplaces-for-woocommerce' ),
					'css'         => [
						'background-color' => '#00AAFF',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.avito.ru/&hellip;',
				],
				'lamoda'         => [
					'name'        => __( 'Lamoda', 'russian-marketplaces-for-woocommerce' ),
					'css'         => [
						'background-color' => '#000000',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.lamoda.ru/&hellip;',
				],
				'sbermegamarket' => [
					'name'        => __( 'SberMegaMarket', 'russian-marketplaces-for-woocommerce' ),
					'css'         => [
						'background-color' => '#9B38DC',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://sbermegamarket.ru/&hellip;',
				],
				'livemaster'     => [
					'name'        => __( 'Ярмарка мастеров', 'russian-marketplaces-for-woocommerce' ),
					'css'         => [
						'background-color' => '#EA7913',
						'color'            => '#FFFFFF',
					],
					'placeholder' => 'https://www.livemaster.ru/&hellip;',
				],
				'aliexpress'     => [
					'name'        => __( 'Aliexpress', 'russian-marketplaces-for-woocommerce' ),
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
