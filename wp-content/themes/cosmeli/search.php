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
$gon_options['blog_style1_number'] = isset($gon_options['blog_style1_number']) ? $gon_options['blog_style1_number'] : 4;
$gon_options['blog_style2_number'] = isset($gon_options['blog_style2_number']) ? $gon_options['blog_style2_number'] : 6;
$gon_options['blog_style3_number'] = isset($gon_options['blog_style3_number']) ? $gon_options['blog_style3_number'] : 6;

get_header();
?>
<?php 
$blog_style = 'style1';
if(isset($gon_options['blog_style']) && $gon_options['blog_style']!=''){
	$blog_style = $gon_options['blog_style'];
}
if(isset($_GET['style']) && $_GET['style']!=''){
	$blog_style = $_GET['style'];
}

$blogsidebar = 'right';
if(isset($gon_options['sidebarblog_pos']) && $gon_options['sidebarblog_pos']!=''){
	$blogsidebar = $gon_options['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$blogsidebar = $_GET['sidebar'];
}
switch($blogsidebar) {
	case 'right':
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
		break;
	case 'left':
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
		break;
	case 'none':
		$blogclass = 'blog-nosidebar';
		$blogcolclass = 12;
		break;
	default:
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
}
?>
<div class="main-container page-wrapper">
	<div class="breadcrumb-title">
		<div class="container">
			<?php gon_breadcrumb(); ?>
		</div>
	</div>
	<div class="container">
		
		<div class="row">
			<?php if($blogsidebar=='left') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			
			<div class="col-xs-12 <?php echo 'col-md-'.esc_attr($blogcolclass); ?>">
			
				<div class="page-content blog-page <?php echo esc_attr($blogclass); if($blogsidebar=='left') {echo ' left-sidebar'; } if($blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if (have_posts()) : ?>
						
						<header class="archive-header">
							<h1 class="archive-title"><?php printf(esc_html__('Search Results for: %s', 'cosmeli'), '<span>' . get_search_query() . '</span>'); ?></h1>
						</header><!-- .archive-header -->

						<?php /* Start the Loop */ ?>
						<?php while (have_posts()) : the_post(); 
							get_template_part('content', get_post_format());
						endwhile; ?>

						<div class="pagination">
							<?php gon_pagination(); ?>
						</div>

					<?php else : ?>

						<article id="post-0" class="post no-results not-found">
							<header class="entry-header">
								<h1 class="entry-title"><?php esc_html_e('Nothing Found', 'cosmeli'); ?></h1>
							</header>

							<div class="entry-content">
								<p><?php esc_html_e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'cosmeli'); ?></p>
								<?php get_search_form(); ?>
							</div><!-- .entry-content -->
						</article><!-- #post-0 -->

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