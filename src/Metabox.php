<?php
/**
 * Вкладка настроек товара в метабоксе WooCommerce.
 *
 * @package wplovers-woo-russian-marketplaces
 * @link https://woocommerce.com/document/editing-product-data-tabs/
 * @link https://misha.agency/course/nastrojki-tovara-woocommerce
 */

namespace WPlovers\WooRussianMarketplaces;

/**
 * Class Metabox.
 */
class Metabox {
	/**
	 * Идентификатор наовой вкладки.
	 */
	const TAB_ID = 'wplovers_product_options_marketplaces';

	/**
	 * Название новой вкладки.
	 */
	const TAB_NAME = 'Marketplaces';

	/**
	 * Приоритет новой вкладки.
	 * Вкладка "Get more options"
	 * имеет приоритет 1000.
	 */
	const TAB_PRIORITY = 1001;

	/**
	 * Инициализация хуков.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {
		add_filter( 'woocommerce_product_data_tabs', [ $this, 'add_tab' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'populate_tab' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_tab' ] );
	}

	/**
	 * Добавляет новую вкладку в метабок настройки товара.
	 *
	 * @param array $tabs Дефолтные табы.
	 *
	 * @return array
	 */
	public function add_tab( array $tabs ): array {
		$tabs[ self::TAB_ID ] = array(
			'label'    => self::TAB_NAME,
			'target'   => self::TAB_ID,
			'priority' => self::TAB_PRIORITY,
		);
		return $tabs;
	}

	/**
	 * Заполняет новый таб данными.
	 *
	 * @return void
	 */
	public function populate_tab(): void {
		global $post;

		$marketplaces = Marketplace::get_merketplaces();
		$values       = get_post_meta( $post->ID, Utils::get_plugin_prefix(), true );
		$note         = true;

		// Если включен хоть один маркетплейс - не нужно показывать заметку
		// "про вашего мальчика".
		foreach ( $marketplaces as $marketplace_id => $data ) {
			if ( Settings::get_option( 'marketplaces_' . $marketplace_id . '_enabled', 'no' ) === 'yes' ) {
				$note = false;
				break;
			}
		}
		?>
		<div id="<?php echo esc_attr( self::TAB_ID ); ?>" class="panel woocommerce_options_panel hidden">
			<h3 style="padding-left: 10px;"><?php echo esc_html( self::TAB_NAME ); ?></h3>
			<?php if ( $note ) : ?>
				<p>
					<?php
					echo wp_kses_post(
						sprintf( __( 'All marketplaces are disabled. Enable at least one in <a href="%s">Settings</a>.', 'wplovers-woo-russian-marketplaces' ), Settings::get_settings_link() )
					);
					?>
				</p>
			<?php else : ?>
				<p><?php esc_html_e( 'Insert links for this product on marketplaces into the fields', 'wplovers-woo-russian-marketplaces' ); ?></p>
			<?php endif; ?>
			<?php
			foreach ( $marketplaces as $marketplace_id => $data ) {
				if ( Settings::get_option( 'marketplaces_' . $marketplace_id . '_enabled', 'no' ) === 'yes' ) {
					woocommerce_wp_text_input(
						[
							'id'          => Utils::get_plugin_prefix() . '_' . $marketplace_id,
							'name'        => Utils::get_plugin_prefix() . '[' . $marketplace_id . ']',
							'label'       => $data['name'],
							'placeholder' => $data['placeholder'],
							'data_type'   => 'url',
							'value'       => $values[ $marketplace_id ] ?? '',
						]
					);
				}
			}
			?>
			<div class="wplovers-gopro">
				<p><b><?php esc_html_e( 'Want to automatically fill in product links?', 'wplovers-woo-russian-marketplaces' ); ?></b> <?php esc_html_e( 'Connect integration with marketplaces and get:', 'wplovers-woo-russian-marketplaces' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'Automatic download and upload products;', 'wplovers-woo-russian-marketplaces' ); ?></li>
					<li><?php esc_html_e( 'Loading orders;', 'wplovers-woo-russian-marketplaces' ); ?></li>
					<li><?php esc_html_e( 'Exchange of balances;', 'wplovers-woo-russian-marketplaces' ); ?></li>
					<li><?php esc_html_e( 'Flexible pricing.', 'wplovers-woo-russian-marketplaces' ); ?></li>
				</ul>
				<p><a href="<?php echo esc_url( Settings::get_gopro_link() ); ?>"><b><?php esc_html_e( 'Yes, I want to automate everything!', 'wplovers-woo-russian-marketplaces' ); ?></b></a></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Сохраняет кастомный таб.
	 *
	 * @param int $post_id Идентификатор товара.
	 *
	 * @return void
	 */
	public function save_tab( int $post_id ): void {
		if (
			! (
				isset( $_POST['woocommerce_meta_nonce'], $_POST[ Utils::get_plugin_prefix() ] ) ||
				wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' )
			)
		) {
			return;
		}

		$data = wp_unslash( (array) $_POST[ Utils::get_plugin_prefix() ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$data = array_map( 'sanitize_url', $data );

		update_post_meta( $post_id, Utils::get_plugin_prefix(), $data );
	}
}
