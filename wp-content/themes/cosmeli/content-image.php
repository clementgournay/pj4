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
?>
<?php 
$gon_options  = gon_get_global_variables(); 
$gon_options['enable_blog_date'] = isset($gon_options['enable_blog_date']) ? $gon_options['enable_blog_date'] : true;
$gon_options['enable_single_social'] = isset($gon_options['enable_single_social']) ? $gon_options['enable_single_social'] : true;
$gon_options['enable_single_author'] = isset($gon_options['enable_single_author']) ? $gon_options['enable_single_author'] : false;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="postinfo-wrapper">
		<?php if (has_post_thumbnail()) { ?>
		<div class="post-thumbnail">
			<?php 
			if (is_single()) {
				the_post_thumbnail();
			} else { 
				if (has_post_thumbnail()) { ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			<?php }
			}
			?>
		</div>
		<?php } ?>
		<div class="post-info">
			<header class="entry-header">
				<?php if (is_single()) : ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php else : ?>
					<h3 class="entry-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3>
				<?php endif; ?>
			</header>
			<div class="entry-meta">
				<div class="entry-date"><?php echo '<span class="day">'.get_the_date('d', $post->ID).'</span> <span class="month">'.get_the_date('F', $post->ID).'</span> <span class="year">'.get_the_date('Y', $post->ID).'</span>' ;?> </div>
				<?php gon_entry_meta(); ?>
			</div>
			<?php if (is_single()) : ?>
				<div class="entry-content">
					<?php the_content(esc_html__('Read more', 'cosmeli')); ?>
					<?php wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'cosmeli'), 'after' => '</div>', 'pagelink' => '<span>%</span>')); ?>
					<?php  if($gon_options['enable_single_social'] == true) {?>
						<?php if(function_exists('theme_blog_sharing')) { ?>
							<div class="social-list">
								<div class="social-sharing"><h3><?php echo esc_html__('Share: ','cosmeli'); ?></h3><?php theme_blog_sharing(); ?></div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			<?php else : ?>
				<div class="entry-summary">
					<div class="description"><?php the_excerpt(); ?></div>
					<div class="read-more">
						<a href="<?php the_permalink(); ?>" class="more-link" rel="bookmark"><?php echo esc_html__('Read more', 'cosmeli'); ?></a>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if (is_single()) : ?>
				<?php  if($gon_options['enable_single_author'] == true) {?>
				<div class="author-info">
					<div class="author-avatar">
						<?php
						$author_bio_avatar_size = apply_filters('gon_author_bio_avatar_size', 100);
						echo get_avatar(get_the_author_meta('user_email'), $author_bio_avatar_size);
						?>
					</div>
					<div class="author-description">
						<h2>
							<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author"><?php printf('%s',get_the_author()); ?></a>
						</h2>
						<p><?php the_author_meta('description'); ?></p>
					</div>
				</div>
				<?php } ?>
			<?php endif; ?>
		</div>
	</div>
</article>