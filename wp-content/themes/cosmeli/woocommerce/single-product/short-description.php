<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

$post 	= gon_get_global_variables('post');

if (! $post->post_excerpt) return;
?>
<div class="short-description" itemprop="description">
	<?php echo apply_filters('woocommerce_short_description', $post->post_excerpt) ?>
</div>