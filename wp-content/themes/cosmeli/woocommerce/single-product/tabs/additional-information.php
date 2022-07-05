<?php
/**
 * Additional Information tab
 * 
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.0.0
 */

if (! defined('ABSPATH')) {
	// Exit if accessed directly
	exit;
}

global $product;

$heading = apply_filters('woocommerce_product_additional_information_heading', esc_html__('Additional Information', 'cosmeli'));
?>

<?php /* if ($heading): ?>
	<h2><?php echo $heading; ?></h2>
<?php endif; */ ?>

<?php wc_display_product_attributes($product); ?>