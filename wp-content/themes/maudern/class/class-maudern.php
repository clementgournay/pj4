<?php
/**
 * Maudern Class
 * Globals and helper functions
 *
 * @package maudern
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Maudern' ) ) {
	/**
	 * Main theme class.
	 */
	class Maudern {

		/**
		 * Convert string to slug.
		 *
		 * @param [string] $str String to be converted.
		 *
		 * @return [string] Processed string.
		 */
		public static function convert_string_to_slug( $str ) {
			$str = strtolower( trim( $str ) );
			$str = preg_replace( '/[^a-z0-9-]/', '_', $str );
			$str = preg_replace( '/-+/', '_', $str );

			return $str;
		}

		/**
		 * Get theme's name.
		 *
		 * @return [string] Theme's name.
		 */
		public static function get_theme_name() {
			$theme = wp_get_theme();
			if ( $theme->parent() ) :
				$theme_name = $theme->parent()->get( 'Name' );
			else :
				$theme_name = $theme->get( 'Name' );
			endif;

			return $theme_name;
		}

		/**
		 * Get theme's slug.
		 *
		 * @return [string] Theme's slug.
		 */
		public static function get_theme_slug() {
			$theme = wp_get_theme();

			return self::convert_string_to_slug( $theme->get( 'Name' ) );
		}

		/**
		 * Get theme's author.
		 *
		 * @return [string] Theme's author.
		 */
		public static function get_theme_author() {
			$theme = wp_get_theme();

			return $theme->get( 'Author' );
		}

		/**
		 * Get theme's description.
		 *
		 * @return [string] Theme's description.
		 */
		public static function get_theme_description() {
			$theme = wp_get_theme();

			return $theme->get( 'Description' );
		}

		/**
		 * Get theme's version.
		 *
		 * @return [string] Theme's version.
		 */
		public static function get_theme_version() {
			$theme = wp_get_theme();

			return $theme->get( 'Version' );
		}

		/**
		 * Returns Theme Website URL.
		 *
		 * @return string the URL.
		 */
		public static function get_theme_link() {

			return esc_url( 'https://maudern.thunder-stores.com/' );
		}

		/**
		 * Returns Theme Author Website URL.
		 *
		 * @return string the URL.
		 */
		public static function get_theme_author_link() {

			return esc_url( 'https://thunder-stores.com/' );
		}

		/**
		 * Get page ID.
		 *
		 * @return [string] Page ID.
		 */
		public static function get_page_id() {
			$page_id = '';
			if ( is_single() || is_page() ) {
				$page_id = get_the_ID();
			} elseif ( is_home() ) {
				$page_id = get_option( 'page_for_posts' );
			} elseif ( maudern_is_wc_active() && is_shop() ) {
				$page_id = wc_get_page_id( 'shop' );
			}

			return $page_id;
		}

		/**
		 * Returns page ID or posts page
		 *
		 * @param string $prefix The ID prefix.
		 * @return [int] [ID of the page].
		 */
		public static function generate_unique_id( $prefix ) {
			static $id_counter = 0;
			if ( function_exists( 'wp_unique_id' ) ) {
				return wp_unique_id( $prefix );
			}
			return $prefix . (string) ++$id_counter;
		}

		/**
		 * Returns an array of all WooCommerge page ID's
		 *
		 * @return [array] [the ID's].
		 */
		public static function get_woo_page_ids() {
			if ( maudern_is_wc_active() ) {
				$woo_page_ids = array(
					wc_get_page_id( 'shop' ),
					wc_get_page_id( 'cart' ),
					wc_get_page_id( 'checkout' ),
					wc_get_page_id( 'myaccount' ),

				);
			} else {
				$woo_page_ids = array();
			}

			return $woo_page_ids;
		}

		/**
		 * Returns true if the active page is Blog page
		 *
		 * @return [bool].
		 */
		public static function is_blog() {

			return ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' === get_post_type();
		}

		/**
		 * Returns Google Fonts URL.
		 *
		 * @return string the URL.
		 */
		public static function get_google_fonts_url() {

			return esc_url( 'https://fonts.google.com' );
		}

		/**
		 * Returns Safe Fonts URL.
		 *
		 * @return string the URL.
		 */
		public static function get_safe_fonts_url() {

			return esc_url( 'https://www.w3schools.com/cssref/css_websafe_fonts.asp' );
		}

		/**
		 * Get Ajax URL.
		 *
		 * @return [string] Ajax URL.
		 */
		public static function get_ajax_url() {

			$ajax_url = admin_url( 'admin-ajax.php' );

			if ( class_exists( 'SitePress' ) ) {
				$my_current_lang = apply_filters( 'wpml_current_language', null );
				if ( $my_current_lang ) {
					$ajax_url = add_query_arg( 'wpml_lang', $my_current_lang, $ajax_url );
				}
			}

			return $ajax_url;
		}

		/**
		 * Get Attachment URL.
		 *
		 * @param int $attachment_id Attachment ID.
		 * @return [string] attachment URL.
		 */
		public static function get_attachment_url( $attachment_id ) {
			if ( empty( $attachment_id ) ) {
				return;
			}

			$image = wp_get_attachment_image_src( $attachment_id, 'full', false );

			return ( ! empty( $image ) && isset( $image[0] ) ) ? $image[0] : '';
		}

		/**
		 * Get allowed HTML tags for footer, logo section.
		 *
		 * @return [array] allowed HTML tags.
		 */
		public static function get_allowed_html_tags() {
			return array(
				'a'      => array(
					'href'           => array(),
					'title'          => array(),
					'class'          => array(),
					'rel'            => array(),
					'target'         => array(),
					'id'             => array(),
					'referrerpolicy' => array(),
					'crossorigin'    => array(),
					'data-*'         => array(),
					'style'          => array(),
				),
				'br'     => array(),
				'em'     => array(),
				'i'      => array(),
				'strong' => array(),
				'div'    => array(
					'id'     => array(),
					'class'  => array(),
					'data-*' => array(),
					'style'  => array(),
				),
				'span'   => array(
					'id'    => array(),
					'class' => array(),
					'style' => array(),
				),
				'img'    => array(
					'id'             => array(),
					'alt'            => array(),
					'class'          => array(),
					'src'            => array(),
					'title'          => array(),
					'width'          => array(),
					'height'         => array(),
					'srcset'         => array(),
					'sizes'          => array(),
					'style'          => array(),
					'referrerpolicy' => array(),
					'crossorigin'    => array(),
				),
			);
		}
	}
}
