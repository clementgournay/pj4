<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

// Find the category + category parent, if applicable 
$term = get_queried_object(); 
$parent_id = empty( $term->term_id ) ? 0 : $term->term_id; 

// NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( http://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work
$args = array(
	'child_of'		=> $parent_id,
	'menu_order'	=> 'ASC',
	'hide_empty'	=> 0,
	'hierarchical'	=> 1,
	'taxonomy'		=> 'product_cat',
	'pad_counts'	=> 1
);
$product_subcategories = get_categories( $args  );

get_header(); ?>
<?php
$gon_options  		= gon_get_global_variables();
$gon_showcountdown 	= gon_get_global_variables('gon_showcountdown');
$gon_productrows 	= gon_get_global_variables('gon_productrows'); 

$gon_showcountdown = false;
$gon_productrows = 1;

$sidebar = 'left';
$sidebar_shop = '';
if(isset($gon_options['sidebar_shop']) && $gon_options['sidebar_shop']!=''){
	$sidebar = $gon_options['sidebar_shop'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$sidebar = $_GET['sidebar'];
}
switch($sidebar) {
	case 'left':
		$sidebar_shop = 'left';
		break;
	case 'right':
		$sidebar_shop = 'right';
		break;
	default:
		$sidebar_shop = $sidebar_shop;
		break;
}

$categorystyle = 'gridview';
if(isset($gon_options['layout_product']) && $gon_options['layout_product']!=''){
	$layout_product = $gon_options['layout_product'];
}
if(isset($_GET['style']) && $_GET['style']!=''){
	$categorystyle = $_GET['style'];
}
switch($categorystyle) {
	case 'gridview':
		$layout_product = 'gridview';
		break;
	case 'listview':
		$layout_product = 'listview';
		break;
	default:
		$layout_product = $layout_product;
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
			<div class="shop-content">
				<div class="row">
					<?php if($sidebar_shop=='left') :?>
						<?php get_sidebar('category'); ?>
					<?php endif; ?>
					
					<div id="archive-product" class="col-xs-12 <?php if (is_active_sidebar('sidebar-category')) : ?>col-md-9<?php endif; ?>">
						<div class="archive-border">
							<?php if(is_shop() && !empty($gon_options['cat_banner_img']['url'])){ 
								$img_url = $gon_options['cat_banner_img']['url'];
								$img_crop = aq_resize($img_url, 870, 350, true);
								if($img_crop) {
									$img = '<img src="' . esc_url($img_crop) . '" alt="banner">';
								} else {
									$img = '<img src="' . esc_url($img_url) . '" alt="banner">';
								}
							?>
								<div class="category-image-desc">
									<?php echo ent2ncr($img); ?>
									<div class="info">
										<h3>
										<?php if(!empty($gon_options['cat_banner_title'])){ 
												echo esc_html($gon_options['cat_banner_title']);
										} ?>
										</h3>
										<p>
										<?php if(!empty($gon_options['cat_banner_description'])){ 
											echo esc_html($gon_options['cat_banner_description']);
										} ?>
										</p>
									</div>
								</div>
							<?php } else { ?>
								<?php do_action('woocommerce_archive_description'); ?>
							<?php } ?>
							
							<?php if (have_posts()) : ?>
								
								<?php
									/**
									* remove message from 'woocommerce_before_shop_loop' and show here
									*/
									do_action('woocommerce_show_message');
								?>
								<?php if((is_shop() && '' !== get_option('woocommerce_shop_page_display')) || (is_product_category() && '' !== get_option('woocommerce_category_archive_display'))) : ?>
								<div class="all-subcategories">
									<?php woocommerce_product_subcategories(); ?>
									<div class="clearfix"></div>
								</div>							
								<?php endif; ?>
								<?php if((is_shop() && 'subcategories' !== get_option('woocommerce_shop_page_display')) || (is_product_category() && 'subcategories' !== get_option('woocommerce_category_archive_display')) || (empty($product_subcategories) && 'subcategories' == get_option('woocommerce_category_archive_display')) ||  is_product_tag()): ?>
								<div class="toolbar">
									<div class="view-mode">
										<a href="#" class="grid active" title="<?php echo esc_attr__('Grid', 'cosmeli'); ?>"><i class="icon-grid icons"></i></a>
										<a href="#" class="list" title="<?php echo esc_attr__('List', 'cosmeli'); ?>"><i class="icon-list icons"></i></a>
									</div>
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 * 
										 */
										do_action('woocommerce_before_shop_loop');
										do_action('woocommerce_after_shop_loop');
									?>
									<div class="clearfix"></div>
								</div>
								<?php endif; ?>
								
								<?php woocommerce_product_loop_start(); ?>

									<?php while (have_posts()) : the_post(); ?>

										<?php wc_get_template_part('content', 'product'); ?>

									<?php endwhile; // end of the loop. ?>

								<?php woocommerce_product_loop_end(); ?>
								
								<?php if((is_shop() && 'subcategories' !== get_option('woocommerce_shop_page_display')) || (is_product_category() && 'subcategories' !== get_option('woocommerce_category_archive_display')) || (empty($product_subcategories) && 'subcategories' == get_option('woocommerce_category_archive_display')) ||  is_product_tag()): ?>
								<div class="toolbar tb-bottom">
									<div class="view-mode">
										<a href="#" class="grid active" title="<?php echo esc_attr__('Grid', 'cosmeli'); ?>"><i class="icon-grid icons"></i></a>
										<a href="#" class="list" title="<?php echo esc_attr__('List', 'cosmeli'); ?>"><i class="icon-list icons"></i></a>
									</div>
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 * 
										 */
										do_action('woocommerce_before_shop_loop');
										do_action('woocommerce_after_shop_loop');
									?>
									<div class="clearfix"></div>
								</div>
								<?php endif; ?>
							<?php elseif (! woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

								<?php wc_get_template('loop/no-products-found.php'); ?>

							<?php endif; ?>

						<?php
							/**
							 * woocommerce_after_main_content hook
							 *
							 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
							 */
							do_action('woocommerce_after_main_content');
						?>
						</div>
					</div>
					
					<?php if($sidebar_shop=='right') :?>
						<?php get_sidebar('category'); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	(function($) {
		"use strict";
		jQuery(document).ready(function(){
			jQuery('.view-mode').each(function(){
			<?php if($layout_product=='gridview') { ?>
				/* Grid View */
				jQuery('#archive-product .view-mode').find('.grid').addClass('active');
				jQuery('#archive-product .view-mode').find('.list').removeClass('active');
				
				jQuery('#archive-product .shop-products').removeClass('list-view');
				jQuery('#archive-product .shop-products').addClass('grid-view');
				
				jQuery('#archive-product .list-col4').removeClass('col-xs-12 col-sm-4');
				jQuery('#archive-product .list-col8').removeClass('col-xs-12 col-sm-8');
			<?php } ?>
			<?php if($layout_product=='listview') { ?>
				/* List View */
				jQuery('#archive-product .view-mode').find('.list').addClass('active');
				jQuery('#archive-product .view-mode').find('.grid').removeClass('active');
				
				jQuery('#archive-product .shop-products').addClass('list-view');
				jQuery('#archive-product .shop-products').removeClass('grid-view');
				
				jQuery('#archive-product .list-col4').addClass('col-xs-12 col-sm-4');
				jQuery('#archive-product .list-col8').addClass('col-xs-12 col-sm-8');
			<?php } ?>
			});
		});
	})(jQuery);
</script>
<?php get_footer(); ?>