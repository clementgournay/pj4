<?php
/**
 * Single Product Image
 *
 * @author 		YIThemes
 * @package 	YITH_Magnifier/Templates
 * @version     1.1.2
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

global $product;

$post 			= gon_get_global_variables('post');
$woocommerce 	= gon_get_global_variables('woocommerce');
$is_IE 			= gon_get_global_variables('is_IE');

$enable_slider = get_option('yith_wcmg_enableslider') == 'yes' ? true : false;
?>
    <div class="images<?php if($is_IE): ?> ie<?php endif ?>">
		
        <?php
        if (has_post_thumbnail()) {

            $image       		= get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'));
            $image_title 		= esc_attr(get_the_title(get_post_thumbnail_id()));
            $image_link  		= wp_get_attachment_url(get_post_thumbnail_id());
            list($magnifier_url, $magnifier_width, $magnifier_height) = wp_get_attachment_image_src(get_post_thumbnail_id(), "shop_magnifier");

            $placeholder = function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src() : woocommerce_placeholder_img_src();

            echo apply_filters('woocommerce_single_product_image_html', sprintf('<a href="%s" itemprop="image" class="yith_magnifier_zoom woocommerce-main-image" title="%s">%s</a>', $magnifier_url, $image_title, $image), $post->ID);

        } else {
            echo apply_filters('woocommerce_single_product_image_html', sprintf('<a href="%s" itemprop="image" class="yith_magnifier_zoom woocommerce-main-image"><img src="%s" alt="Placeholder" /></a>', $placeholder, $placeholder), $post->ID);
        }
        ?>
		<div class="zoom_in_marker"><i class="fa fa-expand"></i></div>
    </div>
	
	<?php do_action('woocommerce_product_thumbnails'); ?>
<?php if($enable_slider) : ?>
<script type="text/javascript">
    var yith_magnifier_options = {
        enableSlider: <?php echo $enable_slider ? 'true' : 'false' ?>,

        <?php if($enable_slider): ?>
        sliderOptions: {
            responsive: <?php echo get_option('yith_wcmg_slider_responsive') == 'yes' ? 'true' : 'false' ?>,
            circular: <?php echo get_option('yith_wcmg_slider_circular') == 'yes' ? 'true' : 'false' ?>,
            infinite: <?php echo get_option('yith_wcmg_slider_infinite') == 'yes' ? 'true' : 'false' ?>,
            direction: 'left',
            debug: false,
            auto: false,
            align: 'left',
            prev	: {
                button	: "#slider-prev",
                key		: "left"
            },
            next	: {
                button	: "#slider-next",
                key		: "right"
            },
            scroll : {
                items     : 1,
                pauseOnHover: true
            },
            items   : {
                visible: <?php echo apply_filters('woocommerce_product_thumbnails_columns', get_option('yith_wcmg_slider_items', 3)) ?>
            }
        },

        <?php endif ?>

        showTitle: false,
        zoomWidth: '<?php echo get_option('yith_wcmg_zoom_width') ?>',
        zoomHeight: '<?php echo get_option('yith_wcmg_zoom_height') ?>',
        position: '<?php echo get_option('yith_wcmg_zoom_position') ?>',
        lensOpacity: <?php echo get_option('yith_wcmg_lens_opacity') ?>,
        softFocus: <?php echo get_option('yith_wcmg_softfocus') == 'yes' ? 'true' : 'false' ?>,
        adjustY: 0,
        disableRightClick: false,
        phoneBehavior: '<?php echo get_option('yith_wcmg_zoom_mobile_position') ?>',
        loadingLabel: '<?php echo stripslashes(get_option('yith_wcmg_loading_label')) ?>'
    };
	
	//change height
	jQuery(window).bind('load resize', function(){
		var imgHeight = jQuery('.thumbnails_carousel img').height();
		jQuery('.thumbnails_carousel').css('max-height', imgHeight);
		jQuery('.caroufredsel_wrapper').css('max-height', imgHeight);
		jQuery('.thumbnails_carousel_list').css('max-height', imgHeight);
	});
</script>
<?php endif; ?>