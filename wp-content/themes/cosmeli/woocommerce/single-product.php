<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

get_header();
$gon_options  = gon_get_global_variables(); 
$sidebar = 'left';
$sidebar_product = '';
if(isset($gon_options['sidebar_product']) && $gon_options['sidebar_product']!=''){
	$sidebar = $gon_options['sidebar_product'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$sidebar = $_GET['sidebar'];
}
switch($sidebar) {
	case 'left':
		$sidebar_product = 'left';
		break;
	case 'right':
		$sidebar_product = 'right';
		break;
	default:
		$sidebar_product = $sidebar_shop;
		break;
}

?>
<div class="main-container page-shop">
	<div class="breadcrumb-blog" <?php if(!empty($gon_options['breadcrumb_background']['url'])){ ?>style="background-image: url(<?php echo esc_url($gon_options['breadcrumb_background']['url']); ?>)" <?php } ?>>
		<div class="container">
			<h3><?php echo esc_html('Shop', 'cosmeli'); ?></h3>
			<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action('woocommerce_before_main_content');
			?>
		</div>
	</div>
	<div class="page-content">
		<div class="container">
			<div class="row">
				<?php if($sidebar_product=='left') :?>
					<?php get_sidebar('product'); ?>
				<?php endif; ?>
				<div id="product-content" class="col-xs-12 <?php if (is_active_sidebar('sidebar-product')) : ?>col-md-9<?php endif; ?>">
					<div class="product-view">
						<?php while (have_posts()) : the_post(); ?>

							<?php wc_get_template_part('content', 'single-product'); ?>

						<?php endwhile; // end of the loop. ?>

						<?php
							/**
							 * woocommerce_after_main_content hook
							 *
							 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
							 */
							do_action('woocommerce_after_main_content');
						?>

						<?php
							/**
							 * woocommerce_sidebar hook
							 *
							 * @hooked woocommerce_get_sidebar - 10
							 */
							//do_action('woocommerce_sidebar');
						?>
					</div>
				</div>
				<?php if($sidebar_product=='right') :?>
					<?php get_sidebar('product'); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>