<?php
/**
 * Template Name: Full Width
 *
* Description: Full Width template
 *
 * @package    GonThemes
 * @author     GonThemes <gonthemes@gmail.com>
 * @copyright  Copyright (C) 2017 GonThemes. All Rights Reserved.
 */
$gon_options  = gon_get_global_variables();

get_header();
?>
<div class="main-container full-width">

	<div class="page-content">

		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part('content', 'page'); ?>
		<?php endwhile; // end of the loop. ?>

	</div>
</div>
<?php get_footer(); ?>