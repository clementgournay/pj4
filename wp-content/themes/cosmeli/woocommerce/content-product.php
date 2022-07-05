<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post;

$gon_options  = gon_get_global_variables();
$gon_showcountdown 	= gon_get_global_variables('gon_showcountdown');
$gon_productrows 	= gon_get_global_variables('gon_productrows');
$gon_productsfound 	= gon_get_global_variables('gon_productsfound');
$gon_columns 	= gon_get_global_variables('gon_columns');
$gon_options['product_columns'] = isset($gon_options['product_columns']) ? $gon_options['product_columns'] : 3;

//product columns
if($gon_options['product_columns']){
	$gon_columns = esc_html($gon_options['product_columns']);
} else {
	$gon_columns = 3;
}

//hide countdown on category page, show on all others
if(!isset($gon_showcountdown)) {
	$gon_showcountdown = true;
}

// Store loop count we're currently on
if (empty($woocommerce_loop['loop']))
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns']))
	$woocommerce_loop['columns'] = apply_filters('loop_shop_columns', $gon_columns);

// Ensure visibility
if (! $product || ! $product->is_visible())
	return;

// Extra post classes
$classes = array();
if (0 == ($woocommerce_loop['loop']) % $woocommerce_loop['columns'] || 0 == $woocommerce_loop['columns']) {
	$classes[] = 'first';
}
if (0 == ($woocommerce_loop['loop'] + 1) % $woocommerce_loop['columns']) {
	$classes[] = 'last';
}

$count   = $product->get_rating_count();

if ($woocommerce_loop['columns']==3 || $woocommerce_loop['columns']==4 || $woocommerce_loop['columns']==2) {
	$colwidth = 12/$woocommerce_loop['columns'];
} else {
	$colwidth = 4;
}

$class_img = '';
if(isset($gon_options['second_image'])){
	if($gon_options['second_image'] == true){
		$class_img = 'twoimg';
	} else {
		$class_img = 'oneimg';
	}
}

$classes[] = ' item-col col-xs-6 col-sm-'.$colwidth ;?>

<?php if ((0 == ($woocommerce_loop['loop'] - 1) % 2) && ($woocommerce_loop['columns'] == 2)) {
	if($gon_productrows!=1){
		echo '<div class="group">';
	}
} ?>

<div <?php post_class($classes); ?>>
	<div class="product-wrapper">
		<div class="list-col4">
			<div class="product-image">
				<a class="<?php echo esc_attr($class_img); ?>" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>" >
					<?php 
					echo $product->get_image('shop_catalog', array('class'=>'primary_image'));
					if(isset($gon_options['second_image'])){
						if($gon_options['second_image'] == true){
							$attachment_ids = $product->get_gallery_attachment_ids();
							if (!empty($attachment_ids)) {
								echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
							}
						}
					}
					?>
				</a>
				<?php if ($product->is_featured()) : ?>
					<?php echo apply_filters('woocommerce_featured_flash', '<div class="theme-label theme-label-hot">' . esc_html__('Hot', 'cosmeli') . '</div>', $post, $product); ?>
				<?php endif; ?>
				
				<?php if ($product->is_on_sale() && $product->is_featured() ) : ?>
					<?php echo apply_filters('woocommerce_sale_flash', '<div class="theme-label theme-label-sale">' . esc_html__('Sale', 'cosmeli') . '</div>', $post, $product); ?>
				<?php elseif ($product->is_on_sale()) : ?>
					<?php echo apply_filters('woocommerce_sale_flash', '<div class="theme-label theme-label-sale">' . esc_html__('Sale', 'cosmeli') . '</div>', $post, $product); ?>
				<?php endif; ?>
				
				<?php if(class_exists('YITH_WCWL') || class_exists('YITH_Woocompare') || isset($gon_options['quick_view'])) { ?>
				<div class="actions">
					<div class="add-to-links">
						<div class="add-to-cart">
							<?php echo do_shortcode('[add_to_cart id="'.$product->get_id().'" show_price="false"]') ?>
						</div>
						<?php if(class_exists('YITH_Woocompare')) {
							echo do_shortcode('[yith_compare_button]');
						} ?>
						<?php if (class_exists('YITH_WCWL')) {
							echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
						} ?>
						<?php if(isset($gon_options['quick_view'])) { ?>
						<div class="quick-wrapper">
							<a class="quickview quick-view" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'cosmeli');?></a>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="list-col8">
			<div class="gridview">
				<div class="text-block">
					<?php
					$countdown = false;
					$sale_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
					/* simple product */
					if($sale_end){
						$countdown = true;
						$sale_end = date('Y/m/d', (int)$sale_end);
						?>
						<div class="box-timer">
							<div class="countbox hastime" data-time="<?php echo esc_attr($sale_end); ?>"></div>
						</div>
					<?php } ?>
					<?php /* variable product */
					if($product->get_children()){
						$vsale_end = array();
						
						foreach($product->get_children() as $pvariable){
							$vsale_end[] = (int)get_post_meta( $pvariable, '_sale_price_dates_to', true );
							
							if( get_post_meta( $pvariable, '_sale_price_dates_to', true ) ){
								$countdown = true;
							}
						}
						if($countdown){
							/* get the latest time */
							$vsale_end_date = max($vsale_end);
							$vsale_end_date = date('Y/m/d', $vsale_end_date);
							?>
							<div class="box-timer">
								<div class="countbox hastime" data-time="<?php echo esc_attr($vsale_end_date); ?>"></div>
							</div>
							<?php
						}
					}
					?>
					<h3 class="product-name">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<div class="price-rating">
						<div class="price-box"><?php echo $product->get_price_html(); ?></div>
						<div class="ratings"><?php echo wc_get_rating_html( $product->get_average_rating() ); ?></div>
					</div>
				</div>
			</div>
			<div class="listview">
				<div class="text-block">
					<h3 class="product-name">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<div class="ratings"><?php echo wc_get_rating_html( $product->get_average_rating() ); ?> <span class="total-rate">( <?php echo $product->get_review_count(). esc_html__(" reviews", "cosmeli"); ?> )</span></div>
					<div class="price-box"><?php echo $product->get_price_html(); ?></div>
					<div class="product-desc"><?php the_excerpt(); ?></div>
					<?php
					$countdown = false;
					$sale_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
					/* simple product */
					if($sale_end){
						$countdown = true;
						$sale_end = date('Y/m/d', (int)$sale_end);
						?>
						<div class="box-timer">
							<div class="countbox hastime" data-time="<?php echo esc_attr($sale_end); ?>"></div>
						</div>
					<?php } ?>
					<?php /* variable product */
					if($product->get_children()){
						$vsale_end = array();
						
						foreach($product->get_children() as $pvariable){
							$vsale_end[] = (int)get_post_meta( $pvariable, '_sale_price_dates_to', true );
							
							if( get_post_meta( $pvariable, '_sale_price_dates_to', true ) ){
								$countdown = true;
							}
						}
						if($countdown){
							/* get the latest time */
							$vsale_end_date = max($vsale_end);
							$vsale_end_date = date('Y/m/d', $vsale_end_date);
							?>
							<div class="box-timer">
								<div class="countbox hastime" data-time="<?php echo esc_attr($vsale_end_date); ?>"></div>
							</div>
							<?php
						}
					}
					?>
					<div class="add-to-cart">
						<?php echo do_shortcode('[add_to_cart id="'.$product->get_id().'" show_price="false"]') ?>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php //do_action('woocommerce_after_shop_loop_item'); ?>
	</div>
</div>
<?php if (((0 == $woocommerce_loop['loop'] % 2 || $gon_productsfound == $woocommerce_loop['loop']) && $woocommerce_loop['columns'] == 2) ) { /* for odd case: $gon_productsfound == $woocommerce_loop['loop'] */
	if($gon_productrows!=1){
		echo '</div>';
	}
} ?>