<?php
/**
 * Register and Enqueue Styles and Scripts.
 *
 * @package maudern
 * @since 1.0
 */

/**
 * Enqueue theme scripts and styles.
 */
function maudern_scripts() {

	$google_font_url = Maudern_Fonts::get_google_font_url();
	if ( $google_font_url ) {
		wp_enqueue_style( 'maudern-google-font', $google_font_url, false, Maudern::get_theme_version(), 'all' );
	}

	wp_enqueue_script( 'comment-reply' );

	wp_enqueue_style( 'maudern-style', get_stylesheet_uri(), array(), Maudern::get_theme_version() );

	wp_enqueue_style( 'maudern-main', get_template_directory_uri() . '/assets/css/styles.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-modals', get_template_directory_uri() . '/assets/css/modals.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-dashboard', get_template_directory_uri() . '/assets/css/dashboard.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-account', get_template_directory_uri() . '/assets/css/my-account.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-slick_style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-slick_theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-look-editor-style', get_site_url().'/wp-content/plugins/personal-shopper-assistant/css/look-editor.css', array(), Maudern::get_theme_version(), 'all' );
	wp_enqueue_style( 'maudern-marketplace-style', get_template_directory_uri() . '/assets/css/marketplace.css', array(), Maudern::get_theme_version(), 'all' );

	wp_enqueue_script( 'maudern-font-awesome', 'https://kit.fontawesome.com/25e156ccb2.js', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-wow', 'https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern_html2canvas', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js');
	wp_enqueue_script( 'maudern-slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js');
	wp_enqueue_script( 'maudern-raphael', 'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js');
	wp_enqueue_script( 'maudern-justgage', 'https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js');
	wp_enqueue_script( 'maudern-parallax', 'https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js');


	wp_enqueue_script( 'maudern-swap-green', get_template_directory_uri() . '/assets/js/swap-grid.js', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-modals', get_template_directory_uri() . '/assets/js/parts/modals.js', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-main', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-account', get_template_directory_uri() . '/assets/js/my-account.js', array( 'jquery' ), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-custom-main', get_template_directory_uri() . '/assets/js/main.js', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-google-callback', get_template_directory_uri() . '/assets/js/google-callback.js', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-rules', get_site_url().'/wp-content/plugins/personal-shopper-assistant/js/rules.js', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-look-editor', get_site_url().'/wp-content/plugins/personal-shopper-assistant/js/look-editor.js', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-gmap', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB2rN5aZMNEEKtDicybgfmgSPpOVrSvhZg&callback=initMap&libraries=places', array(), true, Maudern::get_theme_version() );
	wp_enqueue_script( 'maudern-gchart', 'https://www.gstatic.com/charts/loader.js', array(), true, Maudern::get_theme_version() );


	wp_add_inline_style( 'maudern-main', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-slick_style', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-slick_theme', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-modals', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-custom', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-dashboard', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-account', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-animate', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-look-editor-style', Maudern_Customize::get_options_css() );
	wp_add_inline_style( 'maudern-marketplace-style', Maudern_Customize::get_options_css() );
}
add_action( 'wp_enqueue_scripts', 'maudern_scripts', 100 );

/**
 * Enqueue admin scripts and styles.
 */
function maudern_admin_scripts() {

	$google_font_url = Maudern_Fonts::get_google_font_url();
	if ( $google_font_url ) {
		wp_enqueue_style( 'maudern-google-font', $google_font_url, false, Maudern::get_theme_version(), 'all' );
	}

	wp_enqueue_style( 'maudern-admin-main', get_template_directory_uri() . '/assets/css/admin-styles.css', array(), Maudern::get_theme_version(), 'all' );

	wp_enqueue_script( 'maudern-admin-main', get_template_directory_uri() . '/assets/js/admin-scripts.js', array( 'jquery' ), true, Maudern::get_theme_version() );
	wp_localize_script(
		'maudern-admin-main',
		'maudern_admin',
		array(
			'nonce' => wp_create_nonce( 'maudern_notice_dismiss' ),
		)
	);

	wp_add_inline_style( 'maudern-admin-main', Maudern_Customize::get_options_css() );
}
add_action( 'admin_enqueue_scripts', 'maudern_admin_scripts' );
