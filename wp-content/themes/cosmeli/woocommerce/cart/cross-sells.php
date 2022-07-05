<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.4.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
$gon_options  		= gon_get_global_variables();
$woocommerce 			= gon_get_global_variables('woocommerce');

$crosssells = WC()->cart->get_cross_sells();

if (sizeof($crosssells) == 0) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => -1,
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query($args);

$woocommerce_loop['columns'] = apply_filters('woocommerce_cross_sells_columns', $columns);

if ($products->have_posts()) : ?>

	<div class="cross-sells">
		<?php if(isset($gon_options['crosssells_title'])) { ?>
		<h2 class="heading-title"><span><?php echo esc_html($gon_options['crosssells_title']); ?></span></h2>
		<?php } ?>
		<!--<p><?php esc_html_e('Base on your selection, you may be interested in the 
following items:', 'cosmeli');?></p>-->
		<div class="cross-carousel">
			<?php woocommerce_product_loop_start(); ?>

				<?php while ($products->have_posts()) : $products->the_post(); ?>

					<?php wc_get_template_part('content', 'product'); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
		</div>
	</div>

<?php endif;

wp_reset_query();