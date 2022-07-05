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
 
$num_comments =(int)get_comments_number();
$write_comments = '';
if(comments_open()) {
	if($num_comments == 0) {
		$comments = esc_html__('0 Comment', 'cosmeli');
	} elseif($num_comments > 1) {
		$comments = $num_comments . esc_html__(' Comments', 'cosmeli');
	} else {
		$comments = esc_html__('1 Comment', 'cosmeli');
	}
	$write_comments = '<a href="' . esc_url(get_comments_link()) .'"><i class="icon-bubble icons"></i> '. $comments.'</a>';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="postinfo-wrapper">
		<?php if (has_post_thumbnail()) { ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		</div>
		<?php } ?>
		<div class="post-info">
			<header class="entry-header">
				<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h3>
			</header>
			<div class="entry-meta-small">
				<div class="entry-date"><?php echo '<span class="day">'.get_the_date().'</span>' ;?></div>
				<?php echo ent2ncr($write_comments); ?>
			</div>
			<div class="entry-summary">
				<div class="description"><?php echo wp_trim_words( get_the_content(), 18, '...' ); ?></div>
			</div>
		</div>
	</div>
</article>