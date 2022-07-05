<?php
/**
 * The template for displaying image attachments
 *
 * @package maudern
 * @since Maudern 1.0
 */

get_header();

if ( Elementor_Extension::location_not_set( 'single' ) ) {

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content/image' );
		}
	}
}

get_footer();
