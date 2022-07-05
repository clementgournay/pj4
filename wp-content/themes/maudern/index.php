<?php
/**
 * The main template file
 *
 * @package maudern
 * @since Maudern 1.0
 */

get_header();

if ( Elementor_Extension::location_not_set( 'archive' ) ) {

	$archive_title    = '';
	$archive_subtitle = '';

	if ( is_search() ) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . esc_html__( 'Search:', 'maudern' ) . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ( $wp_query->found_posts ) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results. */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'maudern'
				),
				number_format_i18n( $wp_query->found_posts )
			);
		} else {
			$archive_subtitle = esc_html__( 'We could not find any results for your search. You can give it another try through the search form below.', 'maudern' );
		}
	} elseif ( is_archive() && ! have_posts() ) {
		$archive_title = esc_html__( 'Nothing Found', 'maudern' );
	} elseif ( ! is_home() ) {
		apply_filters( 'get_the_archive_title_prefix', '' );
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	} elseif ( is_home() ) {
		$archive_title = empty( get_the_title( get_option( 'page_for_posts' ) ) ) ? esc_html__( 'Tous les articles', 'maudern' ) : esc_html( get_the_title( get_option( 'page_for_posts' ) ) );
		if ( is_front_page() ) {
			$archive_title = esc_html__( 'Tous les articles', 'maudern' );
		}
	}
	?>

	<header class="entry-header flex flex-column-md-down flex-row-md-up items-center justify-center main-header">

		<div class="entry-header-inner relative flex-1 full-width">

			<?php if ( $archive_title ) { ?>
				<h1 class="archive-title heading-size-1-lg-down heading-size-title-lg-up half-width-lg-up text-center-md-down text-left-md-up"><?php echo wp_kses_post( $archive_title ); ?></h1>
			<?php } ?>

			<?php if ( $archive_subtitle ) { ?>
				<div class="archive-subtitle half-width-lg-up text-center-md-down text-left-md-up heading-size-5-lg-down heading-size-4-lg-up"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
			<?php } ?>

			<?php

			if ( ! is_search() ) {

				$categories = wp_list_categories(
					array(
						'hide_empty'       => 1,
						'child_of'         => 0,
						'include'          => '',
						'hierarchical'     => 1,
						'title_li'         => '',
						'show_option_none' => '',
						'number'           => null,
						'echo'             => 0,
						'depth'            => 1,
						'taxonomy'         => 'category',
					)
				);

				if ( $categories ) {
					echo '<ul class="categories-list block text-center-md-down no-padding-left no-list-style"><li class="cat-item cat-item-0"><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html__( 'Tous les articles', 'maudern' ) . '</a></li>' . wp_kses_post( $categories ) . '</ul>';
				}
			}

			if ( ! have_posts() && is_search() ) {
				echo '<div class="search-form-wrapper half-width-lg-up text-left">';
				get_search_form();
				echo '</div>';
			}

			?>

	</div>

</header><!-- .archive-header -->

	<?php
	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		}
	}

	maudern_archive_pagination();

}

get_footer();
