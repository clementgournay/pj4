<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @package maudern
 * @since Maudern 1.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header flex flex-column-md-down flex-row-md-up items-center justify-center alignwide main-header">
		<div class="entry-header-inner relative flex-1 full-width half-width-lg padding-t-sm-up padding-b-sm-up text-center-md-up">
			<?php

			maudern_the_post_meta( get_the_ID(), 'image' );
			the_title( '<h1 class="entry-title heading-size-1-lg-down heading-size-title-lg-up margin-b-md-up">', '</h1>' );

			?>
		</div><!-- .entry-header-inner -->
	</header><!-- .entry-header -->

	<div class="entry-content">

		<figure class="entry-attachment wp-block-image">
			<?php
			/**
			 * Filters the default image attachment size.
			 *
			 * @since Maudern 1.0
			 *
			 * @param string $image_size Image size. Default 'large'.
			 */
			$image_size = apply_filters( 'maudern_attachment_size', 'full' );

			echo wp_get_attachment_image( get_the_ID(), $image_size );
			?>

			<figcaption class="wp-caption-text"><?php the_excerpt(); ?></figcaption>

		</figure><!-- .entry-attachment -->

		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php
	/**
	 *  Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 * */
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>

</article><!-- .post -->
