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
<div class="main-container page-category page-wrapper">
	<div class="breadcrumb-blog" <?php if(!empty($gon_options['breadcrumb_background']['url'])){ ?>style="background-image: url(<?php echo esc_url($gon_options['breadcrumb_background']['url']); ?>)" <?php } ?>>
		<div class="container">
			<h3>
				<?php 
				$category = get_the_category();
				if (isset($category[0])) {
					$category_id = get_cat_ID($category[0]->cat_name);
					echo get_category_parents($category_id, false, " ");
				}?>
			</h3>
			<?php gon_breadcrumb(); ?>
		</div>
	</div>
	<div class="page-content">
		<div class="container">
			<div class="row">

				<?php if($blogsidebar=='left') : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
				
				<div class="col-xs-12 col-md-<?php echo (is_active_sidebar('sidebar-1')) ? $blogcolclass : 12 ; ?>">
					<div class="page-content blog-page single <?php echo esc_attr($blogclass); if($blogsidebar=='left') {echo ' left-sidebar'; } if($blogsidebar=='right') {echo ' right-sidebar'; } ?>">
						<?php while (have_posts()) : the_post(); ?>

							<?php get_template_part('content', get_post_format()); ?>

							<?php comments_template('', true); ?>
							<nav class="nav-single">
								<span class="nav-wrapper">
									<span class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'cosmeli') . '</span> %title'); ?></span>
									<span class="nav-next"><?php next_post_link('%link', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'cosmeli') . '</span>'); ?></span>
								</span>
							</nav>
							
						<?php endwhile; // end of the loop. ?>
					</div>
				</div>
				
				<?php if($blogsidebar=='right') : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>