<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>

<li>
	<div class="image-block">
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_image(); ?>
		</a>
	</div>
	<div class="text-block">
		<h3 class="product-title"><a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo $product->get_title(); ?></a></h3>
		<?php if ( ! empty( $show_rating ) ) : ?>
			<?php echo $product->get_rating_html(); ?>
		<?php endif; ?>
		<?php echo $product->get_price_html(); ?>
		<div class="add-to-cart">
			<?php echo do_shortcode('[add_to_cart id="'.$product->get_id().'" show_price="false"]') ?>
		</div>
	</div>
</li>
