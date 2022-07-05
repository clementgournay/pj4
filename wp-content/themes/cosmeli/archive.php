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

<div class="main-container page-category">
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
					<header class="archive-header">
						<h1 class="archive-title">
							<?php
							if (is_day()) :
								printf(esc_html__('Daily Archives: %s', 'cosmeli'), '<span>' . get_the_date() . '</span>');
							elseif (is_month()) :
								printf(esc_html__('Monthly Archives: %s', 'cosmeli'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'cosmeli')) . '</span>');
							elseif (is_year()) :
								printf(esc_html__('Yearly Archives: %s', 'cosmeli'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'cosmeli')) . '</span>');
							else :
								esc_html_e('Archives', 'cosmeli');
							endif;
							?>	
						</h1>
					</header>
					<?php if (have_posts()) : ?>

						<?php
						/* Start the Loop */
						while (have_posts()) : the_post();

							/* Include the post format-specific template for the content. If you want to
							 * this in a child theme then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part('content', get_post_format());

						endwhile;
						?>
						
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