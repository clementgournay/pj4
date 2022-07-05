<?php
/**
 * Displays the featured image
 *
 * @package maudern
 * @since Maudern 1.0
 */

$thumbnail_size = ( 'post' === get_post_type( get_the_ID() ) ) ? 'large' : 'full';

if ( has_post_thumbnail() && ! post_password_required() ) {

	?>

	<div class="entry-header-featured-image flex-1 margin-b-sm-down">

		<figure class="featured-media">

			<?php if ( ! is_singular() ) { ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-color">
				<?php } ?>

				<?php the_post_thumbnail( $thumbnail_size ); ?>

				<?php if ( ! is_singular() ) { ?>
				</a>
			<?php } ?>

		</figure><!-- .featured-media -->

	</div>

	<?php
}
