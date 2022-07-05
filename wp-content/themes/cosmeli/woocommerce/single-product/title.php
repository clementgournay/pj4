<?php
/**
 * Single Product title
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php $gon_options  = gon_get_global_variables(); ?>

<h1 itemprop="name" class="product_title entry-title">
<?php the_title(); ?>
</h1>
