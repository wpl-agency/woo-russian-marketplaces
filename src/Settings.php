<?php
/**
 * Настройки плагина.
 *
 * @package russian-marketplaces-for-woocommerce;
 * @link https://woocommerce.com/document/adding-a-section-to-a-settings-tab/
 * @link https://www.tychesoftwares.com/how-to-add-custom-sections-fields-in-woocommerce-settings/
 * @link https://misha.agency/course/woocommerce-options
 * @link https://www.speakinginbytes.com/2014/07/woocommerce-settings-tab/
 */

namespace WPlovers\WooRussianMarketplaces;

/**
 * Class Settings.
 */
class Settings {
	/**
	 * Название секции.
	 */
	const SECTION_LABEL = 'Russian Marketplaces';

	/**
	 * Идентификатор секции.
	 */
	const SECTION_SLUG = 'russian-marketplaces-for-woocommerce';

	/**
	 * Setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks() {
		add_action( 'admin_menu', [ $this, 'add_submenu' ], 90 );
		add_action( 'admin_menu', [ $this, 'add_submenu2' ], 91 );
		add_filter( 'woocommerce_get_sections_advanced', [ $this, 'add_section_to_advanced_tab' ], 11 );
		add_filter( 'woocommerce_get_settings_advanced', [ $this, 'add_settings_to_advanced_tab' ], 10, 2 );
		add_filter( 'plugin_action_links', [ $this, 'add_settings_link' ], 10, 2 );

		add_action(
			'woocommerce_admin_field_spoiler_start',
			function ( $args ) {
				?>
			<!--spoiler-->
			<div class="wplovers-spoiler wplovers-spoiler--collapsed <?php echo esc_html( $args['class'] ); ?>">
				<div class="wplovers-spoiler__name"><?php echo esc_html( $args['name'] ); ?></div>
				<div class="wplovers-spoiler__data">
				<?php
			}
		);
		add_action(
			'woocommerce_admin_field_spoiler_end',
			function () {
				?>
			</div>
			</div>
			<!--/spoiler-->
				<?php
			}
		);

		add_action(
			'woocommerce_admin_field_html',
			function ( array $args ) {
				?>
				<tr>
					<td colspan="2"><?php echo wp_kses_post( $args['text'] ); ?></td>
				</tr>
				<?php
			}
		);

		add_action(
			'admin_enqueue_scripts',
			function () {
				wp_enqueue_script(
					Utils::get_plugin_slug(),
					Utils::get_plugin_url() . 'assets/js/admin.js',
					[ 'jquery' ],
					filemtime( Utils::get_plugin_path() . 'assets/js/admin.js' )
				);
			}
		);
	}

	/**
	 * Получает ссылку на настройки плагина.
	 *
	 * @return string
	 */
	public static function get_settings_link(): string {
		return add_query_arg(
			[
				'page'    => 'wc-settings',
				'tab'     => 'advanced',
				'section' => Utils::get_plugin_slug(),
			],
			admin_url( 'admin.php' )
		);
	}

	/**
	 * Получает ссылку на платную версию плагина.
	 *
	 * @return string
	 */
	public static function get_gopro_link(): string {
		return 'http://wplovers.pro';
	}

	/**
	 * Add plugin action links
	 *
	 * @param array  $defaults    Default actions.
	 * @param string $plugin_file Plugin file.
	 *
	 * @return array
	 */
	public function add_settings_link( array $defaults, string $plugin_file ): array {
		if ( WPL_WOO_RUSSIAN_MARKETPLACES_BASENAME === $plugin_file ) {
			$settings[] = sprintf(
				'<a href="%s">%s</a>',
				self::get_settings_link(),
				esc_html__( 'Settings', 'russian-marketplaces-for-woocommerce' )
			);

			$gopro[] = sprintf(
				'<a href="%s" style="font-weight: bold; color: #524cff">%s</a>',
				self::get_gopro_link(),
				esc_html__( 'Get full integrations!', 'russian-marketplaces-for-woocommerce' )
			);

			return array_merge( $settings, $defaults, $gopro );
		}

		return $defaults;
	}

	/**
	 * Add submenu.
	 *
	 * @return void
	 */
	public function add_submenu(): void {
		$hook_name = add_submenu_page(
			'woocommerce',
			self::SECTION_LABEL,
			self::SECTION_LABEL,
			'manage_woocommerce',
			self::SECTION_SLUG,
			array( $this, 'my_custom_submenu_page_callback' ),
			12
		);

		add_action(
			"load-{$hook_name}",
			function () {
				wp_safe_redirect(
					add_query_arg(
						[
							'page'    => 'wc-settings',
							'tab'     => 'advanced',
							'section' => self::SECTION_SLUG,
						],
						admin_url( 'admin.php' )
					)
				);
				die;
			}
		);
	}

	/**
	 * Add submenu.
	 *
	 * @return void
	 */
	public function add_submenu2(): void {
		global $submenu;

		$submenu['woocommerce'][8][3] = 'https://kkk.ru';
		// die;
	}

	public function my_custom_submenu_page_callback() {
		echo 1111;
	}

	/**
	 * Добавляет новую секцию на страницу расширенных настроек.
	 *
	 * @param array $sections Секции по умолчанию.
	 *
	 * @return array
	 */
	public function add_section_to_advanced_tab( array $sections ): array {
		$sections[ self::SECTION_SLUG ] = self::SECTION_LABEL;

		return $sections;
	}

	/**
	 * Добавляет новые поля на только созданную сецкию.
	 *
	 * @param array  $settings        Секции по умолчанию.
	 * @param string $current_section Текущая секция.
	 *
	 * @return array
	 */
	public function add_settings_to_advanced_tab( array $settings, string $current_section ): array {
		if ( $current_section !== self::SECTION_SLUG ) {
			return $settings;
		}

		$settings_slider = [];

		$settings_slider[] = $this->add_field(
			[
				'type' => 'info',
				'text' => sprintf(
					'<h1>%s</h1>',
					__( 'Russian marketplaces settings', 'russian-marketplaces-for-woocommerce' )
				),
				'id'   => 'info',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name' => __( 'Buttons block design', 'russian-marketplaces-for-woocommerce' ),
				'type' => 'title',
				'desc' => __( 'Settings of the main block with buttons-links to marketplaces', 'russian-marketplaces-for-woocommerce' ),
				'id'   => 'buttons_block_design',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Margin top', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'buttons_block_design_margin_top',
				'default'     => 20,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Margin bottom', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'buttons_block_design_margin_bottom',
				'default'     => 20,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Padding', 'russian-marketplaces-for-woocommerce' ),
				'desc'        => __( 'Sets padding on all sides of the block', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'buttons_block_design_padding',
				'default'     => 25,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Background color', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'color',
				'id'          => 'buttons_block_design_background_color',
				'css'         => 'width:80px',
				'placeholder' => '#ff0000',
				'default'     => '#F6F9FB',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Border width', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'buttons_block_design_border_width',
				'default'     => 0,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Border radius', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'buttons_block_design_border_radius',
				'default'     => 15,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Border color', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'color',
				'id'          => 'buttons_block_design_border_color',
				'css'         => 'width:80px',
				'placeholder' => '#ff0000',
				'default'     => '#F6F9FB',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'    => __( 'Where to place', 'russian-marketplaces-for-woocommerce' ),
				'type'    => 'radio',
				'id'      => 'buttons_block_design_where_to_place',
				'options' => [
					'before' => __( 'Before Add to cart block', 'russian-marketplaces-for-woocommerce' ),
					'after'  => __( 'After Add to cart block', 'russian-marketplaces-for-woocommerce' ),
				],
				'default' => 'after',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'type' => 'sectionend',
				'id'   => 'buttons_block_design',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name' => __( 'Block title', 'russian-marketplaces-for-woocommerce' ),
				'type' => 'title',
				'desc' => __( 'Write your call to buy on marketplaces', 'russian-marketplaces-for-woocommerce' ),
				'id'   => 'block_title',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'    => __( 'Text', 'russian-marketplaces-for-woocommerce' ),
				'type'    => 'text',
				'id'      => 'block_title_text',
				'default' => __( 'Buy this product on marketplaces', 'russian-marketplaces-for-woocommerce' ),
				'css'     => 'width:260px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Margin bottom', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'block_title_margin_bottom',
				'default'     => 20,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Font size', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'block_title_font_size',
				'default'     => 15,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Color', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'color',
				'id'          => 'block_title_color',
				'css'         => 'width:80px',
				'placeholder' => '#ff0000',
				'default'     => '#000000',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'type' => 'sectionend',
				'id'   => 'block_title',
			]
		);

		$marketplaces = Marketplace::get_merketplaces();


		$settings_slider[] = $this->add_field(
			[
				'name' => __( 'Marketplaces', 'russian-marketplaces-for-woocommerce' ),
				'type' => 'title',
				'id'   => 'marketplaces',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Buttons border width', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'button_border_width',
				'default'     => 0,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Buttons border radius', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'button_border_radius',
				'default'     => 5,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'        => __( 'Buttons font size', 'russian-marketplaces-for-woocommerce' ),
				'type'        => 'number',
				'id'          => 'button_font_size',
				'default'     => 14,
				'placeholder' => 'px',
				'css'         => 'width:115px',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'type' => 'sectionend',
				'id'   => 'marketplaces',
			]
		);

		foreach ( $marketplaces as $marketplace_id => $data ) {

			$enabled = self::get_option( 'marketplaces_' . $marketplace_id . '_enabled', 'no' ) === 'yes';

			$settings_slider[] = $this->add_field(
				[
					'type'  => 'spoiler_start',
					'id'    => 'marketplaces_' . $marketplace_id,
					'name'  => $data['name'],
					'class' => $enabled
						? 'wplovers-spoiler--enabled'
						: '',
				]
			);

			$settings_slider[] = $this->add_field(
				[
					'name' => '',
					'type' => 'title',
					'id'   => 'marketplaces_' . $marketplace_id . '_section',
				]
			);

			$settings_slider[] = $this->add_field(
				[
					'name'    => __( 'On/Off', 'russian-marketplaces-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'no',
					'id'      => 'marketplaces_' . $marketplace_id . '_enabled',
				]
			);

			$settings_slider[] = $this->add_field(
				[
					'name'        => __( 'Button background color', 'russian-marketplaces-for-woocommerce' ),
					'type'        => 'color',
					'default'     => $data['css']['background-color'],
					'id'          => 'marketplaces_' . $marketplace_id . '_background_color',
					'css'         => 'width:80px',
					'placeholder' => '#ff0000',
				]
			);

			$settings_slider[] = $this->add_field(
				[
					'name'        => __( 'Button border color', 'russian-marketplaces-for-woocommerce' ),
					'type'        => 'color',
					'id'          => 'marketplaces_' . $marketplace_id . '_border_color',
					'default'     => $data['css']['background-color'],
					'placeholder' => '#ff0000',
					'css'         => 'width:80px',
				]
			);

			$settings_slider[] = $this->add_field(
				[
					'name'        => __( 'Marketplace name color', 'russian-marketplaces-for-woocommerce' ),
					'type'        => 'color',
					'id'          => 'marketplaces_' . $marketplace_id . '_color',
					'default'     => $data['css']['color'],
					'placeholder' => '#ff0000',
					'css'         => 'width:80px',
				]
			);

			$settings_slider[] = $this->add_field(
				[
					'name' => __( 'Go Pro', 'russian-marketplaces-for-woocommerce' ),
					'type' => 'html',
					'id'   => 'marketplaces_' . $marketplace_id . '_gopro',
					'text' => self::get_gopro_content(),
				]
			);

			$settings_slider[] = $this->add_field(
				[
					'type' => 'sectionend',
					'id'   => 'marketplaces_' . $marketplace_id . '_section',
				]
			);

			$settings_slider[] = $this->add_field(
				[
					'type' => 'spoiler_end',
					'id'   => 'marketplaces_' . $marketplace_id,
				]
			);
		}

		$settings_slider[] = $this->add_field(
			[
				'name' => __( 'SEO', 'russian-marketplaces-for-woocommerce' ),
				'type' => 'title',
				'id'   => 'seo',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'    => __( 'Wrap links with noindex', 'russian-marketplaces-for-woocommerce' ),
				'type'    => 'checkbox',
				'default' => 'no',
				'id'      => 'seo_wrap_links_with_noindex',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'    => __( 'Add nofollow attribute to links', 'russian-marketplaces-for-woocommerce' ),
				'type'    => 'checkbox',
				'default' => 'no',
				'id'      => 'seo_add_nofollow_attribute_to_links',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'name'    => __( 'Open links in a new tab', 'russian-marketplaces-for-woocommerce' ),
				'type'    => 'checkbox',
				'default' => 'no',
				'id'      => 'seo_open_links_in_a_new_tab',
			]
		);

		$settings_slider[] = $this->add_field(
			[
				'type' => 'sectionend',
				'id'   => 'seo',
			]
		);

		return $settings_slider;
	}

	/**
	 * Обёртка для добавления поля,
	 * чтобы каждый раз не писать префиксы к полям.
	 *
	 * @param array $args Массив аргументов.
	 *
	 * @return array
	 */
	private function add_field( array $args ): array {
		$args['id'] = Utils::get_plugin_prefix() . '[' . $args['id'] . ']';

		return $args;
	}

	/**
	 * Получить все настройки.
	 * Тоже обертка, чтобы не писать префиксы лишние.
	 *
	 * @return false|mixed|null
	 */
	public static function get_options(): array {
		return (array) get_option( Utils::get_plugin_prefix(), [] );
	}

	/**
	 * Получить настройку по имени.
	 * Тоже обертка, чтобы не писать префиксы лишние.
	 *
	 * @param string $option_name Название опции.
	 * @param mixed  $default     Значение по умолчанию.
	 *
	 * @return false|mixed|null
	 */
	public static function get_option( string $option_name, $default = null ) {
		$options = self::get_options();

		if ( ! isset( $options[ $option_name ] ) ) {
			return $default;
		}

		return $options[ $option_name ];
	}

	/**
	 * Получает содержимое для контролла GoPro.
	 *
	 * @return string
	 */
	private static function get_gopro_content(): string {
		ob_start();
		?>
		<div class="wplovers-gopro">
			<p><b><?php esc_html_e( 'Want to automatically fill in product links?', 'russian-marketplaces-for-woocommerce' ); ?></b> <?php esc_html_e( 'Connect integration with marketplaces and get:', 'russian-marketplaces-for-woocommerce' ); ?></p>
			<ul>
				<li><?php esc_html_e( 'Automatic download and upload products;', 'russian-marketplaces-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Loading orders;', 'russian-marketplaces-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Exchange of balances;', 'russian-marketplaces-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Flexible pricing.', 'russian-marketplaces-for-woocommerce' ); ?></li>
			</ul>
			<p><a href="<?php echo esc_url( self::get_gopro_link() ); ?>"><b><?php esc_html_e( 'Yes, I want to automate everything!', 'russian-marketplaces-for-woocommerce' ); ?></b></a></p>
		</div>
		<?php
		return ob_get_clean();
	}
}
