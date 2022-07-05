<?php
/**
 * Displays the post header
 *
 * @package maudern
 * @since Maudern 1.0
 */

$disallowed_post_types = apply_filters( 'maudern_disallowed_post_types_for_featured_image', array( 'page', 'product' ) );

$header_classes      = ( is_singular() ) ? 'main-header' : '';
$header_classes     .= ( 'post' === get_post_type( get_the_ID() ) ) ? ' singular-header flex-column-md-down flex-row-md-up' : ' flex-column';
$header_width_class  = ( ! in_array( get_post_type( get_the_ID() ), $disallowed_post_types, true ) || is_search() ) ? 'half-width-lg-up padding-t-sm-up padding-b-sm-up' : '';
$header_width_class .= ( ! in_array( get_post_type( get_the_ID() ), $disallowed_post_types, true ) && is_singular() && has_post_thumbnail() ) ? ' padding-l-md-up padding-l-xlg-up' : '';
$title_class         = in_array( get_post_type( get_the_ID() ), $disallowed_post_types, true ) ? 'half-width-md-up text-center-md-down text-left-md-up' : '';

$text_alignment_class = '';
if ( ! in_array( get_post_type( get_the_ID() ), $disallowed_post_types, true ) || is_search() ) {
	$text_alignment_class = has_post_thumbnail() ? 'text-left' : 'text-center-md-up';
}
?>

<header class="entry-header flex items-center justify-center <?php echo esc_attr( $header_classes ); ?>">

	<?php get_template_part( 'template-parts/content/featured-image' ); ?>

	<div class="entry-header-inner relative flex-1 full-width <?php echo esc_attr( $header_width_class ); ?> <?php echo esc_attr( $text_alignment_class ); ?>">

		<?php

		// Default to displaying the post meta.
		if ( is_single() ) {
			maudern_the_post_meta( get_the_ID(), 'single-top' );
		} elseif ( is_page() ) {
			maudern_the_post_meta( get_the_ID(), 'page-top' );
		} else {
			maudern_the_post_meta( get_the_ID(), 'archive-top' );
		}

		if ( is_singular() ) {
			the_title( '<h1 class="entry-title heading-size-1-lg-down heading-size-title-lg-up margin-b-md-up ' . $title_class . '">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title heading-size-2-lg-down heading-size-1-lg-up"><a href="' . esc_url( get_permalink() ) . '" class="text-color">', '</a></h2>' );
		}

		if ( maudern_is_wc_active() && is_account_page() ) {
			do_action( 'maudern_account_navigation' );
		}

		if ( is_single() ) {
			maudern_the_post_meta( get_the_ID(), 'single-bottom' );
		}

		if ( ! is_singular() ) {
			?>

			<div class="excerpt margin-t-md-down margin-t-md-up">
				<?php the_excerpt(); ?>
			</div>

			<?php
		}
		?>

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->
