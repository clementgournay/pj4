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

<?php if (is_active_sidebar('sidebar-1')) : ?>
	<div id="secondary" class="col-xs-12 col-md-3 sidebar-blog">
		<?php dynamic_sidebar('sidebar-1'); ?>
	</div><!-- #secondary -->
<?php endif; ?>