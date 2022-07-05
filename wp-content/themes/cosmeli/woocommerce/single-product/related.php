<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.9.0
 */

if(! defined('ABSPATH')) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
$gon_options  = gon_get_global_variables();

$related = wc_get_related_products($product->get_id());

if(sizeof($related) == 0) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array($product->get_id())
));

$products = new WP_Query($args);

$woocommerce_loop['columns'] = 1;

if($products->have_posts()) :
?>
<div class="widget related_products_widget">
	<?php if(isset($gon_options['related_title'])) { ?>
		<h2 class="heading-title"><span><?php echo esc_html($gon_options['related_title']); ?></span></h2>
	<?php } ?>
	<div class="related products">

		<?php woocommerce_product_loop_start(); ?>

			<?php while($products->have_posts()) : $products->the_post(); ?>

				<?php wc_get_template_part('content', 'product'); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>
</div>
<?php endif;

wp_reset_postdata();
