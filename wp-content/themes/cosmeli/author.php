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

$gon_options  = gon_get_global_variables();

get_header();
?>
<?php 
$bloglayout = 'blog-sidebar';
if(isset($gon_options['layout']) && $gon_options['layout']!=''){
	$bloglayout = $gon_options['layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$bloglayout = $_GET['layout'];
}
$blogsidebar = 'right';
if(isset($gon_options['sidebarblog_pos']) && $gon_options['sidebarblog_pos']!=''){
	$blogsidebar = $gon_options['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$blogsidebar = $_GET['sidebar'];
}
switch($bloglayout) {
	case 'nosidebar':
		$blogclass = 'blog-nosidebar';
		$blogcolclass = 12;
		$blogsidebar = 'none';
		break;
	case 'fullwidth':
		$blogclass = 'blog-fullwidth';
		$blogcolclass = 12;
		$blogsidebar = 'none';
		break;
	default:
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
}
?>

<div class="main-container">
	<div class="blog_header"><?php esc_html_e('Blog', 'cosmeli'); ?></div>
	
	<div class="container">
		<?php gon_breadcrumb(); ?>
		
		<div class="row">
			<?php if($blogsidebar=='left') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			
			<div class="col-xs-12 <?php echo 'col-md-'.esc_attr($blogcolclass); ?>">
				<div class="page-content blog-page <?php echo esc_attr($blogclass); if($blogsidebar=='left') {echo ' left-sidebar'; } if($blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if (have_posts()) : ?>

						<?php
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							 *
							 * We reset this later so we can run the loop
							 * properly with a call to rewind_posts().
							 */
							the_post();
						?>

						<header class="archive-header">
							<h1 class="archive-title"><?php printf(esc_html__('Author Archives: %s', 'cosmeli'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta("ID"))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>'); ?></h1>
						</header><!-- .archive-header -->

						<?php
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();
						?>

						<?php
						// If a user has filled out their description, show a bio on their entries.
						if (get_the_author_meta('description')) : ?>
						<div class="author-info archives">
							<div class="author-avatar">
								<?php
								/**
								 * Filter the author bio avatar size.
								 *
								 * @since GonThemes 1.0
								 *
								 * @param int $size The height and width of the avatar in pixels.
								 */
								$author_bio_avatar_size = apply_filters('gon_author_bio_avatar_size', 68);
								echo get_avatar(get_the_author_meta('user_email'), $author_bio_avatar_size);
								?>
							</div><!-- .author-avatar -->
							<div class="author-description">
								<h2><?php printf(esc_html__('About %s', 'cosmeli'), get_the_author()); ?></h2>
								<p><?php the_author_meta('description'); ?></p>
							</div><!-- .author-description	-->
						</div><!-- .author-info -->
						<?php endif; ?>

						<?php /* Start the Loop */ ?>
						<?php while (have_posts()) : the_post(); ?>
							<?php get_template_part('content', get_post_format()); ?>
						<?php endwhile; ?>
						
						<div class="pagination">
							<?php gon_pagination(); ?>
						</div>

					<?php else : ?>
						<?php get_template_part('content', 'none'); ?>
					<?php endif; ?>
				</div>
			</div>
			
			<?php if($blogsidebar=='right') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</div>
		
	</div>
</div>
<?php get_footer(); ?>