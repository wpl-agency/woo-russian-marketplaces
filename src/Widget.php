<?php
/**
 * Вывод виджета во фронтенде.
 *
 * @package russian-marketplaces-for-woocommerce
 */

namespace WPlovers\WooRussianMarketplaces;

/**
 * Class Widget.
 */
class Widget {
	/**
	 * Инициализация хуков.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {
		if ( Settings::get_option( 'buttons_block_design_where_to_place' ) === 'after' ) {
			add_action( 'woocommerce_after_add_to_cart_form', [ $this, 'add_block' ] );
		} else {
			add_action( 'woocommerce_before_add_to_cart_form', [ $this, 'add_block' ] );
		}

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 11 );
	}

	public function enqueue_scripts(): void {
		$urls         = get_post_meta( get_the_ID(), Utils::get_plugin_prefix(), true );
		$marketplaces = Marketplace::get_merketplaces();
		$settings     = Settings::get_options();
		ob_start();
		?>
		.russian-marketplaces-for-woocommerce {
			background-color: <?php echo esc_html( $settings['buttons_block_design_background_color'] ); ?>;
			padding: <?php echo esc_html( $settings['buttons_block_design_padding'] ); ?>px;
			border-radius: <?php echo esc_html( $settings['buttons_block_design_border_radius'] ); ?>px;
			margin-top: <?php echo esc_html( $settings['buttons_block_design_margin_top'] ); ?>px;
			margin-bottom: <?php echo esc_html( $settings['buttons_block_design_margin_bottom'] ); ?>px;
			border-width: <?php echo esc_html( $settings['buttons_block_design_border_width'] ); ?>px;
			border-style: solid;
			border-color: <?php echo esc_html( $settings['buttons_block_design_border_color'] ); ?>;
		}
		.russian-marketplaces-for-woocommerce .russian-marketplaces-for-woocommerce__header {
			font-weight: 700;
			margin-bottom: <?php echo esc_html( $settings['block_title_margin_bottom'] ); ?>px;
			font-size: <?php echo esc_html( $settings['block_title_font_size'] ); ?>px;
			color: <?php echo esc_html( $settings['block_title_color'] ); ?>;
		}
		.russian-marketplaces-for-woocommerce .russian-marketplaces-for-woocommerce__list {
			display: flex;
			flex-direction: row;
			flex-wrap: wrap;
			gap: 15px;
			align-items: center;
			justify-content: flex-start;
		}
		.russian-marketplaces-for-woocommerce .russian-marketplaces-for-woocommerce__link {
			text-decoration: none;
			text-transform: uppercase;
			padding: 8px 22px;
			-webkit-transition: all 300ms ease;
			transition: all 300ms ease;
			border-style: solid;
			border-width: <?php echo esc_html( $settings['button_border_width'] ); ?>px;
			font-size: <?php echo esc_html( $settings['button_font_size'] ); ?>px;
			border-radius: <?php echo esc_html( $settings['button_border_radius'] ); ?>px;
		}
		.russian-marketplaces-for-woocommerce .russian-marketplaces-for-woocommerce__link:hover {
			opacity: 0.8;
		}
		<?php foreach ( $urls as $marketplace => $url ) : ?>
			<?php
			if ( empty( $url ) ) {
				continue;
			}
			?>
			.russian-marketplaces-for-woocommerce .russian-marketplaces-for-woocommerce__link--<?php echo esc_html( $marketplace ); ?> {
				background-color: <?php echo esc_html( $settings[ 'marketplaces_' . $marketplace . '_background_color' ] ); ?>;
				border-color: <?php echo esc_html( $settings[ 'marketplaces_' . $marketplace . '_border_color' ] ); ?>;
				color: <?php echo esc_html( $settings[ 'marketplaces_' . $marketplace . '_color' ] ); ?>;
			}
		<?php endforeach; ?>
		<?php
		wp_add_inline_style( 'photoswipe', ob_get_clean() );
	}

	/**
	 * Выводит блок во фронтенде.
	 *
	 * @return void
	 */
	public function add_block(): void {
		global $post;

		$urls = get_post_meta( $post->ID, Utils::get_plugin_prefix(), true );

		if ( ! is_array( $urls ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				wc_print_notice(
					sprintf(
					/* translators: plugin name, settings link */
						__( 'Плагин "%1$s" активирован, но не настроен! <a href="%2$s">Настроить плагин.</a>', 'russian-marketplaces-for-woocommerce' ),
						Utils::get_plugin_name(),
						Settings::get_settings_link()
					),
					'notice'
				);
			}

			return;
		}
		$marketplaces = Marketplace::get_merketplaces();
		$settings     = Settings::get_options();
		?>
		<?php if ( $urls ) : ?>
			<?php
			$target = $settings['seo_open_links_in_a_new_tab'] === 'yes'
				? '_blank'
				: '_self';

			$rel = $settings['seo_add_nofollow_attribute_to_links'] === 'yes'
				? 'nofollow noreferrer'
				: 'external';
			?>
			<div class="<?php echo esc_attr( Utils::get_plugin_slug() ); ?>">
				<h3 class="<?php echo esc_attr( Utils::get_plugin_slug() ); ?>__header">
					<?php echo esc_html( $settings['block_title_text'] ); ?>
				</h3>
				<div class="<?php echo esc_attr( Utils::get_plugin_slug() ); ?>__list">
					<?php if ( $settings['seo_wrap_links_with_noindex'] === 'yes' ) : ?>
						<!--noindex-->
					<?php endif; ?>
					<?php foreach ( $urls as $marketplace => $url ) : ?>
						<?php
						if ( empty( $url ) ) {
							continue;
						}
						?>
						<a
							href="<?php echo esc_url( $url ); ?>"
							target="<?php echo esc_attr( $target ); ?>"
							rel="<?php echo esc_attr( $rel ); ?>"
							class="<?php echo esc_attr( Utils::get_plugin_slug() ); ?>__link <?php echo esc_attr( Utils::get_plugin_slug() ); ?>__link--<?php echo esc_attr( $marketplace ); ?>"
						>
							<?php echo esc_html( $marketplaces[ $marketplace ]['name'] ); ?>
						</a>
					<?php endforeach; ?>
					<?php if ( $settings['seo_wrap_links_with_noindex'] === 'yes' ) : ?>
						<!--/noindex-->
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php
	}
}
