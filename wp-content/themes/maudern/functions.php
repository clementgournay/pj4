<?php
/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage maudern
 * @since 1.0.0
 */

// Main Class.
require get_template_directory() . '/class/class-maudern.php';

// Handle Customizer Settings.
require get_template_directory() . '/class/class-maudern-customize.php';

// Elementor Compatibility.
require get_template_directory() . '/class/class-elementor-extension.php';

if ( is_admin() ) {
	// Plugin Install.
	include get_template_directory() . '/class/admin/class-maudern-plugin-install.php';
	// Block Patterns.
	include get_template_directory() . '/functions/function-block-patterns.php';
}
/**
* Starter Content.
* Only load if wp version is 4.7.3 or above because of this issue;
* https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
*/
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	include get_template_directory() . '/class/admin/class-maudern-starter-content.php';
}

// Include Theme Setup Functions.
require get_template_directory() . '/functions/function-theme-setup.php';

// Include Theme Enqueue Functions.
require get_template_directory() . '/functions/function-enqueue.php';

// Include WooCommerce Functions.
if ( maudern_is_wc_active() ) {
	require get_template_directory() . '/functions/function-woocommerce-setup.php';
}

// Include Theme Fonts Class.
require get_template_directory() . '/class/class-maudern-fonts.php';

// Include Theme's Template Tags.
require get_template_directory() . '/includes/template-tags.php';

