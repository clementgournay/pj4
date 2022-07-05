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
 
get_header();
?>
<div class="main-container 404-page">
	<div class="page-404">
		<div class="container">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="search-form">
					<h2><?php esc_html_e('404', 'cosmeli'); ?></h2>
					<h3><?php esc_html_e('PAGE NOT FOUND', 'cosmeli'); ?></h3>
					<label><?php esc_html_e('You can go back to', 'cosmeli');?> <a href="<?php echo esc_url(home_url('/')); ?>"> <?php esc_html_e('Homepage ', 'cosmeli');?></a><?php esc_html_e('or search what you are looking for', 'cosmeli');?></label>
					<?php get_search_form(); ?>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
</div>
<?php get_footer(); ?>