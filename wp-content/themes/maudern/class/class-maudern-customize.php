<?php
/**
 * Customizer settings for this theme.
 *
 * @package WordPress
 * @subpackage maudern
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Maudern_Customize' ) ) {
	/**
	 * Customizer Settings.
	 */
	class Maudern_Customize {

		/**
		 * Cache each request to prevent duplicate queries.
		 *
		 * @var array
		 */
		protected static $cached = array();

		/**
		 * Maudern_Customize constructor
		 */
		private function __construct() {}

		/**
		 * Default values for theme options
		 *
		 * @return array The options array
		 */
		private static function theme_defaults() {
			return array(
				'body_font_family'        => 'Helvetica',
				'font_size'               => 16,
				'body_color_1'            => '#ffffff',
				'body_color_2'            => '#19110b',
				'body_color_3'            => '#7eada4',
				'body_color_4'            => '#7eada4',
				'body_color_5'            => '#aa5d5d',
				'body_color_6'            => '#7eada4',
				'logo_height'             => 75,
				'footer_background_color' => '#f6f5f3',
				'footer_text_color'       => '#19110b',
				'footer_text_note'        => '© Designed with <a href="' . Maudern::get_theme_link() . '">Maudern</a> by <a href="' . Maudern::get_theme_author_link() . '">Thunder Stores</a>.',
				'footer_image'            => '',
				'shop_categories_list'    => true,
				'mobile_categories_list'  => true,
			);
		}

		/**
		 * Writes the options inline styles
		 *
		 * @return string
		 */
		public static function get_options_css() {
			$options = '
				:root {
					--global--font-primary: 	 		 ' . Maudern_Fonts::get_font( self::get_option( 'body_font_family' ) ) . ';
					--global--font-size-base: 	 		 ' . self::get_option( 'font_size' ) . 'px;

					--global--body-color-1: 		 	 ' . self::get_option( 'body_color_1' ) . ';
					--global--body-color-1-light: 	 	 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_1' ) ) . ', .15);
					--global--body-color-1-medium: 	 	 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_1' ) ) . ', .5);
					--global--body-color-1-dark: 	 	 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_1' ) ) . ', .9);
					--global--body-color-1-xdark: 	 	 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_1' ) ) . ', .95);
					--global--body-color-2: 		     ' . self::get_option( 'body_color_2' ) . ';
					--global--body-color-2-rgb: 		 ' . self::convert_hex_to_rgb( self::get_option( 'body_color_2' ) ) . ';
					--global--body-color-2-xlight: 		 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_2' ) ) . ', .05);
					--global--body-color-2-light: 		 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_2' ) ) . ', .15);
					--global--body-color-2-medium: 		 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_2' ) ) . ', .5);
					--global--body-color-2-dark: 		 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_2' ) ) . ', .75);
					--global--body-color-3: 			 ' . self::get_option( 'body_color_3' ) . ';
					--global--body-color-3-medium: 	 	 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_3' ) ) . ', .5);
					--global--body-color-3-dark: 		 rgba(' . self::convert_hex_to_rgb( self::get_option( 'body_color_3' ) ) . ', .75);
					--global--body-color-3-rgb: 		 ' . self::convert_hex_to_rgb( self::get_option( 'body_color_3' ) ) . ';
					--global--body-color-4: 			 ' . self::get_option( 'body_color_4' ) . ';
					--global--body-color-5: 			 ' . self::get_option( 'body_color_5' ) . ';
					--global--body-color-6: 			 ' . self::get_option( 'body_color_6' ) . ';
					--global--footer-background--color:  ' . self::get_option( 'footer_background_color' ) . ';
					--global--footer-text--color: 		 ' . self::get_option( 'footer_text_color' ) . ';
					--global--footer-text-dark--color:   rgba(' . self::convert_hex_to_rgb( self::get_option( 'footer_text_color' ) ) . ', .75);
					--global--footer-text-medium--color: rgba(' . self::convert_hex_to_rgb( self::get_option( 'footer_text_color' ) ) . ', .5);
					--global--footer-text-light--color:  rgba(' . self::convert_hex_to_rgb( self::get_option( 'footer_text_color' ) ) . ', .15);
					--global--footer-text-xlight--color: rgba(' . self::convert_hex_to_rgb( self::get_option( 'footer_text_color' ) ) . ', .05);

					--global--logo-height:				 ' . self::get_option( 'logo_height' ) . 'px;
				}

				select, select:hover, select:focus,
				.wc-block-components-select .components-custom-select-control__button,
				.wc-block-components-select .components-custom-select-control__button:hover,
				.wc-block-components-select .components-custom-select-control__button:focus {
					background-image: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'rgb(' . self::convert_hex_to_rgb( self::get_option( 'body_color_2' ) ) . ')\'><path d=\'M 2.65625 6.25 L 1.34375 7.75 L 11.34375 16.75 L 12 17.34375 L 12.65625 16.75 L 22.65625 7.75 L 21.34375 6.25 L 12 14.65625 Z \'></path></svg>");
				}

				.star-rating::before,
				.star-rating span::before,
				.wc-block-review-list-item__rating__stars::before,
				.wc-block-review-list-item__rating__stars span::before,
				.woocommerce p.stars a::before,
				.wc-block-grid__product-rating__stars:before,
				.wc-block-grid__product-rating__stars span::before {
					background-image: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'rgb(' . self::convert_hex_to_rgb( self::get_option( 'body_color_2' ) ) . ')\'><path d=\'M23.04,9h-8.27L12,1L9.23,9L0.96,9.021l6.559,5.043L5.177,22L12,17.321L18.823,22l-2.342-7.935L23.04,9z\'></path></svg>");
				}

				#site-footer select, #site-footer select:hover, #site-footer select:focus,
				#site-footer .wc-block-components-select .components-custom-select-control__button,
				#site-footer .wc-block-components-select .components-custom-select-control__button:hover,
				#site-footer .wc-block-components-select .components-custom-select-control__button:focus,
			    #site-footer .is-single .wc-block-components-dropdown-selector__input:first-child {
					background-image: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'' . self::get_option( 'font_size' ) . '\' height=\'' . self::get_option( 'font_size' ) . '\' viewBox=\'0 0 24 24\' fill=\'rgb(' . self::convert_hex_to_rgb( self::get_option( 'footer_text_color' ) ) . ')\'><path d=\'M 2.65625 6.25 L 1.34375 7.75 L 11.34375 16.75 L 12 17.34375 L 12.65625 16.75 L 22.65625 7.75 L 21.34375 6.25 L 12 14.65625 Z \'></path></svg>");
				}

				#site-footer .star-rating::before,
				#site-footer .star-rating span::before,
				#site-footer p.stars a::before {
					background-image: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'rgb(' . self::convert_hex_to_rgb( self::get_option( 'footer_text_color' ) ) . ')\'><path d=\'M23.04,9h-8.27L12,1L9.23,9L0.96,9.021l6.559,5.043L5.177,22L12,17.321L18.823,22l-2.342-7.935L23.04,9z\'></path></svg>");
				}
				';

			return self::compress_styles( $options );
		}

		/**
		 * Writes the experimental-theme.json with the customizer options
		 *
		 * @return void
		 */
		public static function get_options_json() {
			$json_array = array(
				'global' => array(
					'presets' => array(
						'color' => array(
							array(
								'slug'  => 'background',
								'value' => self::get_option( 'body_color_1' ),
							),
							array(
								'slug'  => 'font',
								'value' => self::get_option( 'body_color_2' ),
							),
							array(
								'slug'  => 'accent',
								'value' => self::get_option( 'body_color_3' ),
							),
						),
						'font'  => array(
							array(
								'slug'  => 'family',
								'value' => Maudern_Fonts::get_font( self::get_option( 'body_font_family' ) ),
							),
							array(
								'slug'  => 'base_size',
								'value' => self::get_option( 'font_size' ),
							),
						),
					),
				),
			);
		}

		/**
		 * Compress custom styles.
		 *
		 * @param string $minify String to be minified.
		 */
		public static function compress_styles( $minify ) {
			$minify = preg_replace( '/\/\*((?!\*\/).)*\*\//', '', $minify ); // negative look ahead.
			$minify = preg_replace( '/\s{2,}/', ' ', $minify );
			$minify = preg_replace( '/\s*([:;{}])\s*/', '$1', $minify );
			$minify = preg_replace( '/;}/', '}', $minify );

			return $minify;
		}

		/**
		 * Create Color Control.
		 *
		 * @param object $wp_customize WP Customize.
		 * @param string $option_name The option name.
		 * @param string $sanitize_function The options's sanitize function.
		 * @param string $default_value The option's default value.
		 * @param string $label The option's label.
		 * @param string $description The option's description.
		 * @param string $section The option's section.
		 * @param int    $priority The option's priority.
		 */
		public static function add_color_control( $wp_customize, $option_name, $sanitize_function, $default_value, $label, $description, $section, $priority ) {
			$wp_customize->add_setting(
				$option_name,
				array(
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => $sanitize_function,
					'default'           => $default_value,
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$option_name,
					array(
						'label'       => $label,
						'description' => $description,
						'section'     => $section,
						'priority'    => $priority,
					)
				)
			);
		}

		/**
		 * Register customizer options.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public static function register( $wp_customize ) {

			/**
			* Site Title & Description.
			* */
			$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title a',
					'render_callback' => 'maudern_customize_partial_blogname',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => 'maudern_customize_partial_blogdescription',
				)
			);

			self::register_header_controls( $wp_customize );
			self::register_fonts_controls( $wp_customize );
			self::register_colors_controls( $wp_customize );
			self::register_footer_controls( $wp_customize );
			self::register_woocommerce_controls( $wp_customize );
		}

		/**
		 * Header Section controls.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @return void
		 */
		public static function register_header_controls( $wp_customize ) {

			// Logo Height.
			$wp_customize->add_setting(
				'logo_height',
				array(
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
					'default'           => 75,
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'logo_height',
					array(
						'type'        => 'number',
						'label'       => esc_html_x( 'Logo Height', 'Theme customizer options', 'maudern' ),
						'description' => esc_html( '(0px - 300px)' ),
						'section'     => 'title_tagline',
						'priority'    => 9,
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 300,
							'step' => 1,
						),
					)
				)
			);
		}

		/**
		 * Footer Section controls.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @return void
		 */
		public static function register_footer_controls( $wp_customize ) {

			// Footer Section.
			$wp_customize->add_section(
				'footer',
				array(
					'title'    => esc_html_x( 'Footer', 'Theme customizer options', 'maudern' ),
					'priority' => 22,
				)
			);

			// Footer Text Note.
			$wp_customize->add_setting(
				'footer_text_note',
				array(
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'Maudern_Customize::sanitize_html_text',
					'default'           => '© Designed with <a href="' . Maudern::get_theme_link() . '">Maudern</a> by <a href="' . Maudern::get_theme_author_link() . '">Thunder Stores</a>.',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'footer_text_note',
					array(
						'type'        => 'textarea',
						'label'       => esc_html_x( 'Footer Text Note', 'Theme customizer options', 'maudern' ),
						'description' => esc_html_x( 'Allowed HTML tags: a, br, div, em, i, img, span, strong', 'Theme customizer options', 'maudern' ),
						'section'     => 'footer',
						'priority'    => 10,
					)
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'footer_text_note',
				array(
					'selector'        => 'footer .footer-text-note',
					'render_callback' => 'maudern_customize_partial_footer_text',
				)
			);

			// Credit Card Icon.
			$wp_customize->add_setting(
				'footer_image',
				array(
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'Maudern_Customize::sanitize_image',
					'default'           => '',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Cropped_Image_Control(
					$wp_customize,
					'footer_image',
					array(
						'type'     => 'image',
						'label'    => esc_html_x( 'Credit Card Icon', 'Theme customizer options', 'maudern' ),
						'section'  => 'footer',
						'priority' => 10,
					)
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'footer_image',
				array(
					'selector'        => 'footer .footer-image',
					'render_callback' => 'maudern_customize_partial_footer_image',
				)
			);

			// Footer Background Color.
			self::add_color_control(
				$wp_customize,
				'footer_background_color',
				'sanitize_hex_color',
				'#f6f5f3',
				esc_html_x( 'Footer Background Color', 'Theme customizer options', 'maudern' ),
				'',
				'footer',
				10
			);

			// Footer Text Color.
			self::add_color_control(
				$wp_customize,
				'footer_text_color',
				'sanitize_hex_color',
				'#19110b',
				esc_html_x( 'Footer Text Color', 'Theme customizer options', 'maudern' ),
				'',
				'footer',
				10
			);
		}

		/**
		 * Fonts Section controls.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @return void
		 */
		public static function register_fonts_controls( $wp_customize ) {

			// Fonts Section.
			$wp_customize->add_section(
				'fonts',
				array(
					'title'    => esc_attr_x( 'Fonts', 'Theme customizer options', 'maudern' ),
					'priority' => 20,
				)
			);

			// Main Font.
			$wp_customize->add_setting(
				'body_font_family',
				array(
					'default'           => 'Helvetica',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'type'              => 'theme_mod',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'body_font_family',
					array(
						'type'        => 'text',
						'label'       => esc_html_x( 'Base Font Family', 'Theme customizer options', 'maudern' ),
						'description' => Maudern_Fonts::get_suggested_fonts_list() . wp_kses_post( 'Maudern supports all fonts on <a href="' . Maudern::get_google_fonts_url() . '" target="_blank">Google Fonts</a> and all <a href="' . Maudern::get_safe_fonts_url() . '" target="_blank">web safe fonts</a>.' ),
						'section'     => 'fonts',
						'input_attrs' => array(
							'placeholder'    => esc_html_x( 'Enter the font name', 'Theme customizer options', 'maudern' ),
							'class'          => 'maudern-font-suggestions',
							'list'           => 'maudern-suggested-fonts',
							'autocapitalize' => 'off',
							'autocomplete'   => 'off',
							'autocorrect'    => 'off',
							'spellcheck'     => 'false',
						),
					)
				)
			);

			// Base Font Size.
			$wp_customize->add_setting(
				'font_size',
				array(
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
					'default'           => 16,
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'font_size',
					array(
						'type'        => 'number',
						'label'       => esc_html_x( 'Base Font Size', 'Theme customizer options', 'maudern' ),
						'description' => esc_html_x( 'The Base Font Size refers to the size applied to the paragraph text. All other elements, such as headings, links, buttons, etc will adjusted automatically to keep the hierarchy of font sizes based on this one size. Easy-peasy!', 'Theme customizer options', 'maudern' ),
						'section'     => 'fonts',
						'priority'    => 10,
						'input_attrs' => array(
							'min'  => 12,
							'max'  => 24,
							'step' => 1,
						),
					)
				)
			);
		}

		/**
		 * Colors Section controls.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @return void
		 */
		public static function register_colors_controls( $wp_customize ) {

			// Colors Section.
			$wp_customize->add_section(
				'colors',
				array(
					'title'    => esc_html_x( 'Colors', 'Theme customizer options', 'maudern' ),
					'priority' => 21,
				)
			);

			// Background Color.
			self::add_color_control(
				$wp_customize,
				'body_color_1',
				'sanitize_hex_color',
				'#ffffff',
				esc_html_x( 'Color 1', 'Theme customizer options', 'maudern' ),
				esc_html_x( 'Used as background color and contrast texts.', 'Theme customizer options', 'maudern' ),
				'colors',
				11
			);

			// Text Color.
			self::add_color_control(
				$wp_customize,
				'body_color_2',
				'sanitize_hex_color',
				'#19110b',
				esc_html_x( 'Color 2', 'Theme customizer options', 'maudern' ),
				esc_html_x( 'Used as global text color.', 'Theme customizer options', 'maudern' ),
				'colors',
				11
			);

			// Accent Color.
			self::add_color_control(
				$wp_customize,
				'body_color_3',
				'sanitize_hex_color',
				'#7eada4',
				esc_html_x( 'Color 3', 'Theme customizer options', 'maudern' ),
				'',
				'colors',
				11
			);

			// Success Color.
			self::add_color_control(
				$wp_customize,
				'body_color_4',
				'sanitize_hex_color',
				'#7eada4',
				esc_html_x( 'Color 4', 'Theme customizer options', 'maudern' ),
				esc_html_x( 'Used for success notifications.', 'Theme customizer options', 'maudern' ),
				'colors',
				11
			);

			// Error Color.
			self::add_color_control(
				$wp_customize,
				'body_color_5',
				'sanitize_hex_color',
				'#aa5d5d',
				esc_html_x( 'Color 5', 'Theme customizer options', 'maudern' ),
				esc_html_x( 'Used for error notifications.', 'Theme customizer options', 'maudern' ),
				'colors',
				11
			);

			// Info Color.
			self::add_color_control(
				$wp_customize,
				'body_color_6',
				'sanitize_hex_color',
				'#7eada4',
				esc_html_x( 'Color 6', 'Theme customizer options', 'maudern' ),
				esc_html_x( 'Used for info notifications.', 'Theme customizer options', 'maudern' ),
				'colors',
				11
			);
		}

		/**
		 * WooCommerce controls.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @return void
		 */
		public static function register_woocommerce_controls( $wp_customize ) {

			// Show categories list in product archives.
			$wp_customize->add_setting(
				'shop_categories_list',
				array(
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'Maudern_Customize::sanitize_checkbox',
					'default'           => true,
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'shop_categories_list',
					array(
						'type'     => 'checkbox',
						'label'    => esc_html_x( 'Show categories list in product archives', 'Theme customizer options', 'maudern' ),
						'section'  => 'woocommerce_product_catalog',
						'priority' => 10,
					)
				)
			);

			// Show categories list in mobile menu.
			$wp_customize->add_setting(
				'mobile_categories_list',
				array(
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'Maudern_Customize::sanitize_checkbox',
					'default'           => true,
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'mobile_categories_list',
					array(
						'type'     => 'checkbox',
						'label'    => esc_html_x( 'Show categories list in mobile menu', 'Theme customizer options', 'maudern' ),
						'section'  => 'woocommerce_product_catalog',
						'priority' => 10,
					)
				)
			);
		}

		/**
		 * Sanitizes select controls.
		 *
		 * @param string $input [the input].
		 * @param string $setting [the settings].
		 *
		 * @return string
		 */
		public static function sanitize_select( $input, $setting ) {
			$input   = sanitize_key( $input );
			$choices = isset( $setting->manager->get_control( $setting->id )->choices ) ? $setting->manager->get_control( $setting->id )->choices : '';

			return ( $choices && array_key_exists( $input, $choices ) ) ? $input : $setting->default;
		}

		/**
		 * Sanitize boolean for checkbox.
		 *
		 * @param bool $checked Whether or not a box is checked.
		 * @return bool
		 */
		public static function sanitize_checkbox( $checked ) {
			return ( ( isset( $checked ) && true === $checked ) ? true : false );
		}

		/**
		 * Sanitizes html text controls
		 *
		 * @param string $input [the input].
		 *
		 * @return boolean
		 */
		public static function sanitize_html_text( $input ) {
			$allowedtags                          = wp_kses_allowed_html();
			$allowedtags['a']['data-*']           = true;
			$allowedtags['a']['target']           = true;
			$allowedtags['a']['rel']              = true;
			$allowedtags['a']['href']             = true;
			$allowedtags['a']['class']            = true;
			$allowedtags['a']['title']            = true;
			$allowedtags['br']                    = true;
			$allowedtags['em']                    = true;
			$allowedtags['i']                     = true;
			$allowedtags['strong']                = true;
			$allowedtags['div']['class']          = true;
			$allowedtags['div']['data']           = true;
			$allowedtags['div']['style']          = true;
			$allowedtags['span']['class']         = true;
			$allowedtags['span']['style']         = true;
			$allowedtags['img']['alt']            = true;
			$allowedtags['img']['class']          = true;
			$allowedtags['img']['src']            = true;
			$allowedtags['img']['title']          = true;
			$allowedtags['img']['width']          = true;
			$allowedtags['img']['height']         = true;
			$allowedtags['img']['referrerpolicy'] = true;
			$allowedtags['img']['crossorigin']    = true;

			return wp_kses( $input, $allowedtags );
		}

		/**
		 * Sanitizes image upload.
		 *
		 * @param string $input potentially dangerous data.
		 */
		public static function sanitize_image( $input ) {
			$mimes    = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
				'bmp'          => 'image/bmp',
				'tiff|tif'     => 'image/tiff',
				'ico'          => 'image/x-icon',
				'svg'          => 'image/svg+xml',
			);
			$filetype = wp_check_filetype( $input, $mimes );

			if ( isset( $filetype['ext'] ) ) {
				return is_int( $input ) ? $input : attachment_url_to_postid( $input );
			}

			return '';
		}

		/**
		 * Converts a hex string to rgb equivalent string.
		 *
		 * @param string $hex The color hex.
		 * @return string
		 */
		private static function convert_hex_to_base64( $hex ) {
			$base64_color = str_replace( '#', '', $hex );

			return $base64_color;
		}

		/**
		 * Converts a hex string to rgb equivalent string.
		 *
		 * @param string $hex The color hex.
		 * @return string
		 */
		private static function convert_hex_to_rgb( $hex ) {
			$hex = str_replace( '#', '', $hex );

			if ( 3 === strlen( $hex ) ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}
			$rgb = array( $r, $g, $b );

			return implode( ',', $rgb );
		}

		/**
		 * Return the theme option from cache; if it isn't cached fetch it and cache it.
		 *
		 * @param  string $option_name [name of the option].
		 * @param  string $default     [default value of option].
		 *
		 * @return string
		 */
		public static function get_option( $option_name, $default = '' ) {
			/* Return cached if possible */
			if ( array_key_exists( $option_name, self::$cached ) && empty( $default ) ) {
				return self::$cached[ $option_name ];
			}
			/* If no default is given, fetch from theme defaults variable */
			if ( empty( $default ) ) {
				$default = array_key_exists( $option_name, self::theme_defaults() ) ? self::theme_defaults()[ $option_name ] : '';
			}

			$opt = get_theme_mod( $option_name, $default );

			/* Cache the result */
			self::$cached[ $option_name ] = $opt;

			/* Process the variable */
			if ( self::process_option( $option_name, $opt ) !== $opt ) {
				self::$cached[ $option_name ] = self::process_option( $option_name, $opt );
			}

			return self::$cached[ $option_name ];
		}

		/**
		 * Switch case for options that need post processing.
		 *
		 * @param  [string] $key   [name of option].
		 * @param  [string] $value [value].
		 *
		 * @return [string]        [processed value]
		 */
		private static function process_option( $key, $value ) {
			$opacity_dark = .75;

			switch ( $key ) {
				case 'heading_gray_dark':
					return 'rgba(' . self::hex2rgb( self::get_option( 'body_color_2' ) ) . ',' . $opacity_dark . ')';
				default:
					return $value;
			}

			return $value;
		}
	}

	// Setup the Theme Customizer settings and controls.
	add_action( 'customize_register', array( 'Maudern_Customize', 'register' ) );

}

/**
* PARTIAL REFRESH FUNCTIONS
* */
if ( ! function_exists( 'maudern_customize_partial_blogname' ) ) {
	/**
	 * Render the site title for the selective refresh partial.
	 */
	function maudern_customize_partial_blogname() {
		bloginfo( 'name' );
	}
}

if ( ! function_exists( 'maudern_customize_partial_blogdescription' ) ) {
	/**
	 * Render the site description for the selective refresh partial.
	 */
	function maudern_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}

if ( ! function_exists( 'maudern_customize_partial_footer_image' ) ) {
	/**
	 * Render the footer image for the selective refresh partial.
	 */
	function maudern_customize_partial_footer_image() {
		$footer_image = Maudern::get_attachment_url( Maudern_Customize::get_option( 'footer_image' ) );
		if ( ! empty( $footer_image ) && wp_http_validate_url( $footer_image ) ) {
			echo '<img src="' . esc_url( $footer_image ) . '" alt="' . esc_attr__( 'Footer Image', 'maudern' ) . '" />';
		}
	}
}

if ( ! function_exists( 'maudern_customize_partial_footer_text' ) ) {
	/**
	 * Render the footer text for the selective refresh partial.
	 */
	function maudern_customize_partial_footer_text() {
		echo do_shortcode(
			wp_kses( Maudern_Customize::get_option( 'footer_text_note' ), Maudern::get_allowed_html_tags() )
		);
	}
}
