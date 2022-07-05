<?php
/**
 * @version    1.0
 * @package    GonThemes
 * @author     GonThemes <gonthemes@gmail.com>
 * @copyright  Copyright (C) 2017 GonThemes. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://gonthemes.info
 */
 
if (post_password_required())
	return;
?>
<?php $gon_options  = gon_get_global_variables(); ?>
<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>
		<?php if (have_comments()) : ?>

			<ol class="commentlist">
				<h3 class="heading-title">
					<?php
						printf(_n('1 comment', '%1$s comments', get_comments_number(), 'cosmeli'),
							number_format_i18n(get_comments_number()));
					?>
				</h3>
				<?php wp_list_comments(array('callback' => 'gon_comment', 'style' => 'ol')); ?>
			</ol><!-- .commentlist -->

			<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
			<div class="pagination">
				<?php paginate_comments_links(); ?>
			</div>
			<?php endif; // check for comment navigation ?>

			<?php
			/* If there are no comments and comments are closed, let's leave a note.
			 * But we only want the note on posts and pages that had comments in the first place.
			 */
			if (! comments_open() && get_comments_number()) : ?>
			<p class="nocomments"><?php esc_html_e('Comments are closed.' , 'cosmeli'); ?></p>
			<?php endif; ?>

		<?php endif; // have_comments() ?>
	<?php
		$comments_args = array(
			// change the title of send button
			// 'label_submit'=>'Send',
			// change the title of the reply section
			// 'title_reply'=>'Write a Reply or Comment',
			// remove "Text or HTML to be displayed after the set of comment fields"
			'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' =>
				  '<p class="comment-form-author">' .
				  '<input id="author" placeholder="' . esc_html__( 'Name*', 'cosmeli' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				  '" size="30" /></p>',

				'email' =>
				  '<p class="comment-form-email">' .
				  '<input id="email" placeholder="' . esc_html__( 'Email*', 'cosmeli' ) . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				  '" size="30" /></p>',

				'url' =>
				  '<p class="comment-form-url">' .
				  '<input id="url" placeholder="' . esc_html__( 'Website', 'cosmeli' ) . '" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				  '" size="30" /></p>'
				)
			),
			// redefine your own textarea (the comment body)
			'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" placeholder="' . esc_html__( 'Comment', 'cosmeli' ) . '" rows="8" cols="37" wrap="hard"></textarea></p>',
		);
		comment_form($comments_args); ?>

</div><!-- #comments .comments-area -->