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
$gon_options['sidebarse_pos'] = isset($gon_options['sidebarse_pos']) ? $gon_options['sidebarse_pos'] : 'left';

get_header();
?>
<div class="main-container default-page">
	<div class="breadcrumb-blog" <?php if(!empty($gon_options['breadcrumb_background']['url'])){ ?>style="background-image: url(<?php echo esc_url($gon_options['breadcrumb_background']['url']); ?>)" <?php } ?>>
		<div class="container">
			<?php gon_breadcrumb(); ?>
		</div>
	</div>
	<div class="page-content">
		<div class="container">
			<div class="row">
				<?php if($gon_options['sidebarse_pos']=='left'  || !isset($gon_options['sidebarse_pos'])) :?>
					<?php get_sidebar('page'); ?>
				<?php endif; ?>
				<div class="col-xs-12 <?php if (is_active_sidebar('sidebar-page')) : ?>col-md-9<?php endif; ?>">
					<?php while (have_posts()) : the_post(); ?>
						<?php get_template_part('content', 'page'); ?>
						<?php comments_template('', true); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
				<?php if($gon_options['sidebarse_pos']=='right') :?>
					<?php get_sidebar('page'); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>