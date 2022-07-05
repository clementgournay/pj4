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

	<?php get_template_part( 'template-parts/content/entry-header' ); ?>

	<?php if ( is_singular() ) { ?>

		<div class="entry-content">

			<?php the_content( esc_html__( 'Continue reading', 'maudern' ) ); ?>

		</div><!-- .entry-content -->

	<?php } ?>

	<?php

	if ( is_single() ) {

		?>

		<div class="entry-footer">
			<?php
			wp_link_pages(
				array(
					'before'      => '<div class="pagination"><nav class="post-nav-links nav-links">',
					'after'       => '</nav></div>',
					'link_before' => '',
					'link_after'  => '',
				)
			);
			?>

		</div>

		<?php
	}

	/**
	*  Output comments wrapper if it's a post, or if comments are open,
	* or if there's a comment number – and check for password.
	* */
	if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
		comments_template();
	}
	?>

</article><!-- .post -->

<?php

if ( is_single() ) {
	get_template_part( 'template-parts/content/navigation' );
}
