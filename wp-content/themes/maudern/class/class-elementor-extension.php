<?php
/**
 * Elementor Extension Class.
 *
 * @package WordPress
 * @subpackage maudern
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elementor_Extension {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @static
	 *
	 * @var Elementor_Extension The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @static
	 *
	 * @return Elementor_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'elementor/theme/register_locations', array( $this, 'register_locations' ) );

	}

	/**
	 * Register elementor locations
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, register the locations.
	 *
	 * Fired by `elementor/theme/register_locations` action hook.
	 *
	 * @param object $elementor_theme_manager Theme manager.
	 * @since 1.0.0
	 */
	public function register_locations( $elementor_theme_manager ) {

		if ( $this->is_compatible() ) {
			$elementor_theme_manager->register_all_core_location();
		}

	}

	/**
	 * Checks if Elementor location is set.
	 *
	 * @static
	 *
	 * @param string $location Elementor location.
	 * @return bool
	 */
	public static function location_not_set( $location = '' ) {

		return ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( $location );
	}

	/**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin's minimum requirement.
	 * Checks if the installed PHP version meets the plugin's minimum requirement.
	 *
	 * @since 1.0.0
	 */
	public function is_compatible() {

		// Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			return false;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			return false;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			return false;
		}

		return true;

	}
}

Elementor_Extension::instance();
