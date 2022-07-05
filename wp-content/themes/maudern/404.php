<?php
/**
 * The template for displaying the 404 template.
 *
 * @package maudern
 * @since Maudern 1.0
 */

get_header();

if ( Elementor_Extension::location_not_set( 'single' ) ) {
	?>

	<header class="entry-header not-found flex flex-column-md-down flex-row-md-up items-center justify-center main-header">

		<div class="entry-header-inner relative flex-1 full-width">
			<h1 class="archive-title heading-size-1-lg-down heading-size-title-lg-up half-width-lg-up text-center-md-down text-left-md-up no-margin-top margin-b-md-up">
				<?php echo esc_html_x( 'Page Not Found', '404 Page Template', 'maudern' ); ?>
			</h1>

			<div class="archive-subtitle half-width-lg-up text-center-md-down text-left-md-up margin-b-md-down margin-b-md margin-b-lg margin-b-xlg-up heading-size-5-lg-down heading-size-4-lg-up">
				<?php echo esc_html_x( 'The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.', '404 Page Template', 'maudern' ); ?>
			</div>

			<div class="search-form-wrapper half-width-lg-up text-left">
				<?php get_search_form(); ?>
			</div>

		</div>

	</header>

	<?php
}

get_footer();
