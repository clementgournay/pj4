<?php
/**
 * The template file for displaying the comments and comment form.
 *
 * @package maudern
 * @since Maudern 1.0
 */

/*
* If the current post is protected by a password and
* the visitor has not yet entered the password we will
* return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}

?>

<div class="offcanvas offcanvas-right offcanvas-comments">
	<div class="offcanvas-inner">
		<div class="offcanvas-close"></div>

		<div class="comments-loader"></div>

		<?php

		if ( $comments ) {
			?>

			<div class="comments" id="comments">

				<?php
				wp_list_comments(
					array(
						'avatar_size' => 45,
						'style'       => 'div',
					)
				);

				$comment_pagination = paginate_comments_links(
					array(
						'echo'      => false,
						'mid_size'  => 1,
						'next_text' => false,
						'prev_text' => false,
					)
				);

				if ( $comment_pagination ) {
					?>

					<nav class="comments-pagination pagination" aria-label="<?php esc_attr_e( 'Comments', 'maudern' ); ?>">
						<div class="nav-links">
							<?php echo wp_kses_post( $comment_pagination ); ?>
						</div>
					</nav>

					<?php
				}
				?>

			</div><!-- comments -->

			<?php
		}

		if ( comments_open() || pings_open() ) {

			comment_form(
				array(
					'class_form'         => '',
					'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
					'title_reply_after'  => '</h2>',
				)
			);

		} elseif ( is_single() ) {

			?>

			<div id="respond" class="comment-respond no-comments">

				<p class="comments-closed"><?php esc_html_e( 'Comments are closed.', 'maudern' ); ?></p>

			</div><!-- #respond -->

			<?php
		}
		?>
	</div>
</div>
