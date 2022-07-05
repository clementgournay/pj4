<?php
/**
 * Template Name: Page No Sidebar
 *
 * Description: Page No Sidebar
 *
 * @package    GonThemes
 * @author     GonThemes <gonthemes@gmail.com>
 * @copyright  Copyright (C) 2015 Ginthemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://gonthemes.info
 */

$gon_options  = gon_get_global_variables();

get_header();
?>
<div class="main-container default-page">
	<div class="breadcrumb-blog" <?php if(!empty($gon_options['breadcrumb_background']['url'])){ ?>style="background-image: url(<?php echo esc_url($gon_options['breadcrumb_background']['url']); ?>)" <?php } ?>>
		<div class="container">
			<h3><?php echo the_title(); ?></h3>
			<?php gon_breadcrumb(); ?>
		</div>
	</div>
	<div class="page-content">
		<div class="container">
			<div class="row">	
				<div class="col-xs-12">
					<div class="page-content">
						<?php while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<div class="entry-content">
									<?php the_content(); ?>
								</div>
							</article>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>