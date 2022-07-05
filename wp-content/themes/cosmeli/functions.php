<?php
/**
 * @version    1.0
 * @package    GonThemes
 * @author     GonThemes <gonthemes@gmail.com>
 * @copyright  Copyright (C) 2017 GonThemes. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://gonthemes.info
 */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
define( 'THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'THEME_URI', trailingslashit( get_template_directory_uri() ) );
//Require plugins
require_once get_template_directory () . '/class-tgm-plugin-activation.php';

function gon_register_required_plugins() {

    $plugins = array(
		array(
            'name'               => esc_html__('GonThemes Helper', 'cosmeli'),
            'slug'               => 'gonthemes-helper',
            'source'             => get_template_directory() . '/plugins/gonthemes-helper.zip',
            'required'           => true,
            'external_url'       => '',
        ),
		array(
            'name'               => esc_html__('Mega Main Menu', 'cosmeli'),
            'slug'               => 'mega_main_menu',
			'source'             => get_template_directory() . '/plugins/mega_main_menu.zip',
            'required'           => true,
            'external_url'       => '',
        ),
		array(
            'name'               => esc_html__('Revolution Slider', 'cosmeli'),
            'slug'               => 'revslider',
			'source'             => get_template_directory() . '/plugins/revslider.zip',
            'required'           => true,
            'external_url'       => '',
        ),
		array(
            'name'               => esc_html__('Visual Composer', 'cosmeli'),
            'slug'               => 'js_composer',
            'source'             => get_template_directory() . '/plugins/js_composer.zip',
            'required'           => true,
            'external_url'       => '',
        ),
		array(
            'name'               => esc_html__('Redux Framework', 'cosmeli'),
            'slug'               => 'redux-framework',
            'required'           => true,
			'external_url'       => '',
        ),
		
        // Plugins from the WordPress Plugin Repository.
		array(
            'name'      => esc_html__('Shortcodes Ultimate', 'cosmeli'),
            'slug'      => 'shortcodes-ultimate',
            'required'  => true,
			'external_url'       => '',
        ),
        array(
            'name'      => esc_html__('Contact Form 7', 'cosmeli'),
            'slug'      => 'contact-form-7',
            'required'  => true,
			'external_url'       => '',
        ),
		array(
            'name'      => esc_html__('MailPoet Newsletters', 'cosmeli'),
            'slug'      => 'wysija-newsletters',
            'required'  => true,
			'external_url'       => '',
        ),
		array(
            'name'      	=> esc_html__('WooCommerce', 'cosmeli'),
            'slug'      	=> 'woocommerce',
            'required'  	=> true,
			'external_url'  => '',
        ),
		array(
            'name'      	=> esc_html__('YITH WooCommerce Compare', 'cosmeli'),
            'slug'      	=> 'yith-woocommerce-compare',
            'required'  	=> true,
			'external_url'  => '',
        ),
		array(
            'name'      	=> esc_html__('YITH WooCommerce Wishlist', 'cosmeli'),
            'slug'     	 	=> 'yith-woocommerce-wishlist',
            'required'  	=> true,
			'external_url'  => '',
        ),
		array(
            'name'      	=> esc_html__('YITH WooCommerce Zoom Magnifier', 'cosmeli'),
            'slug'      	=> 'yith-woocommerce-zoom-magnifier',
            'required'  	=> true,
			'external_url'  => '',
        ),
		array(
            'name'               => esc_html__('One Click Demo Import', 'cosmeli'),
            'slug'               => 'one-click-demo-import',
            'required'           => true,
			'external_url'       => '',
        ),
		array(
            'name'               => esc_html__('CMB2', 'kokomi'),
            'slug'               => 'cmb2',
            'required'           => true,
			'external_url'       => '',
        ),
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'cosmeli' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'cosmeli' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'cosmeli' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'cosmeli' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'cosmeli' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'cosmeli' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'cosmeli' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'cosmeli' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'cosmeli' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'cosmeli' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'cosmeli' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'cosmeli' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'cosmeli' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'cosmeli' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'cosmeli' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'cosmeli' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'cosmeli' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'gon_register_required_plugins' ); 

//Init the Redux Framework
if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) && file_exists( get_template_directory().'/theme-config.php' ) ) {
    require_once( get_template_directory().'/theme-config.php' );
}

//Add Woocommerce support
add_theme_support( 'woocommerce' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

//remove total cart CrossSells
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals');

//Override woocommerce widgets
function gon_override_woocommerce_widgets() {
	//Show mini cart on all pages
	if ( class_exists( 'WC_Widget_Cart' ) ) {
		unregister_widget( 'WC_Widget_Cart' ); 
		include_once( get_template_directory() . '/woocommerce/class-wc-widget-cart.php' );
		register_widget( 'Custom_WC_Widget_Cart' );
	};
	if ( class_exists( 'WC_Widget_Recent_Reviews' ) ) {
		unregister_widget( 'WC_Widget_Recent_Reviews' ); 
		include_once( get_template_directory() . '/woocommerce/class-wc-widget-recent-reviews.php' );
		register_widget( 'Custom_WC_Widget_Recent_Reviews' );
	};
	if ( class_exists( 'WC_Widget_Price_Filter' ) ) {
		unregister_widget( 'WC_Widget_Price_Filter' ); 
		include_once( get_template_directory() . '/woocommerce/class-wc-widget-price-filter.php' );
		register_widget( 'Custom_Widget_Price_Filter' );
	};
	if ( class_exists( 'WC_Widget_Top_Rated_Products' ) ) {
		unregister_widget( 'WC_Widget_Top_Rated_Products' ); 
		include_once( get_template_directory() . '/woocommerce/class-wc-widget-top-rated-products.php' );
		register_widget( 'Custom_Widget_Top_Rated_Products' );
	};
}
add_action( 'widgets_init', 'gon_override_woocommerce_widgets', 15 );


// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
function gon_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	
	<span class="mcart-number"><?php echo WC()->cart->cart_contents_count; ?></span>
	
	<?php
	$fragments['span.mcart-number'] = ob_get_clean();
	
	return $fragments;
} 
add_filter( 'woocommerce_add_to_cart_fragments', 'gon_woocommerce_header_add_to_cart_fragment' );

//Change price html
function gon_woo_price_html( $price,$product ){
	if ( $product->is_type( 'variable' ) ) {
		return '<div class="price-box price-variable">'. $price .'</div>';
	}
	else {
		return '<div class="price-box">'. $price .'</div>';
	} 
}
add_filter( 'woocommerce_get_price_html', 'gon_woo_price_html', 100, 2 );

// Add image to category description
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
function gon_woocommerce_category_image() {
	if ( is_product_category() ){
		global $wp_query;
		
		$cat = $wp_query->get_queried_object();
		$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		
		$img_url = wp_get_attachment_url( $thumbnail_id );
		$img_crop = aq_resize($img_url, 870, 350, true);
		if($img_crop) {
			$image = '<img src="' . esc_url($img_crop) . '" alt="banner">';
		} else {
			$image = '<img src="' . esc_url($img_url) . '" alt="banner">';
		}
		
		if ( $image ) {
			echo '<div class="category-image-desc">';
			echo ent2ncr($image);		
			echo '<div class="info">';
			echo '<h3>'.esc_html($cat->name).'</h3>';
			echo '<p>'.esc_html($cat->description).'</p>';
			echo '</div>';
			echo '</div>';
		}
	}
}
add_action( 'woocommerce_archive_description', 'gon_woocommerce_category_image', 2 );

// Change products per page
function gon_woo_change_per_page() {
	global $gon_options;
	
	return $gon_options['product_per_page'];
}
add_filter( 'loop_shop_per_page', 'gon_woo_change_per_page', 20 );

//Change number of related products on product page. Set your own value for 'posts_per_page'
function gon_woo_related_products_limit( $args ) {
	global $product, $gon_options;
	$args['posts_per_page'] = $gon_options['related_amount'];

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'gon_woo_related_products_limit' );

//move message to top
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
add_action( 'woocommerce_show_message', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 5 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

//Single product organize
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_show_related_products', 'woocommerce_output_related_products', 20 );

//Display social sharing on product page
function gon_woocommerce_social_share(){
	global $gon_options;
?>
	<div class="share_buttons">
		<?php if ($gon_options['share_code']!='') {
			echo wp_kses($gon_options['share_code'], array(
				'div' => array(
					'class' => array()
				),
				'span' => array(
					'class' => array(),
					'displayText' => array()
				),
			));
		} ?>
	</div>
<?php
}
add_action( 'woocommerce_share', 'gon_woocommerce_social_share', 35 );
 
//Show countdown on product page
function gon_product_countdown(){
	global $product;
	?>
	<?php
	$countdown = false;
	$sale_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
	/* simple product */
	if($sale_end){
		$countdown = true;
		$sale_end = date('Y/m/d', (int)$sale_end);
		?>
		<div class="timer-view"><div class="countbox hastime" data-time="<?php echo esc_attr($sale_end); ?>"></div></div>
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
			<div class="timer-view"><div class="countbox hastime" data-time="<?php echo esc_attr($vsale_end_date); ?>"></div></div>
			<?php
		}
	}
	?>
<?php
}
add_action( 'woocommerce_single_product_summary', 'gon_product_countdown', 35 ); 

function gon_action_list () {
	?>
	<div class="actions">
		<div class="add-to-links">
			<?php if(class_exists('YITH_Woocompare')) {
				echo do_shortcode('[yith_compare_button]');
			} ?>
			<?php if (class_exists('YITH_WCWL')) {
				echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
			} ?>
		</div>
		
	</div>
<?php
}	
add_action( 'woocommerce_after_single_variation', 'gon_action_list', 20 ); 
 
//Change search form
function gon_search_form( $form ) {
	if(get_search_query()!=''){
		$search_str = get_search_query();
	} else {
		$search_str = esc_html__( 'Search Blog...', 'cosmeli' );
	}
	
	$form = '<form method="get" id="blogsearchform" class="searchform" action="' . esc_url(home_url( '/' ) ). '" >
	<div class="form-input">
		<input class="input_text" type="text" data-name="'.esc_attr($search_str).'" value="'.esc_attr($search_str).'" name="s" id="search_input" />
		<button class="button" type="submit" id="blogsearchsubmit"><i class="icon-magnifier icons"></i></button>
		<input type="hidden" name="post_type" value="post" />
		</div>
	</form>';
	return $form;
}
add_filter( 'get_search_form', 'gon_search_form' ); 
 
//Change woocommerce search form
function gon_woo_search_form( $form ) {
	$args = array(
		'type' => 'post',
        'hide_empty' => false,
        'taxonomy' => 'product_cat',
	);
	if(get_search_query()!=''){
		$search_str = get_search_query();
	} else {
		$search_str = esc_html__( 'Search keyword ...', 'cosmeli' );
	}
	
	$form = '<form method="get" id="searchform" action="'.esc_url( home_url( '/'  ) ).'">';
		$form .= '<div>';
			$form  .=	'<div class="product_cat">';
			$form  .=	'<select name="product_cat">';
			$form  .=	'<option value="">'.esc_html__( 'All Categories', 'cosmeli' ).'</option>';
			$product_categories = get_categories( $args );
			foreach( $product_categories as $cat ) {
				$form  .= '<option value="'. esc_attr($cat->slug) .'">' . esc_html($cat->name) . '</option>';
			}
			$form  .=	'</select>';
			$form  .=	'</div>';
			$form .= '<input type="text" data-name="'.esc_attr($search_str).'" value="'.esc_attr($search_str).'" name="s" id="ws" placeholder="" />';
			$form .= '<button class="btn btn-primary" type="submit" id="wsearchsubmit"><i class="icon-magnifier icons"></i></button>';
			$form .= '<input type="hidden" name="post_type" value="product" />';
		$form .= '</div>';
	$form .= '</form>';
	return $form;
}
add_filter( 'get_product_search_form', 'gon_woo_search_form' ); 
 
//Add breadcrumbs
function gon_breadcrumb() {
	$showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter = '<span class="separator"> <i class="icon-arrow-right icons"></i> </span>'; // delimiter between crumbs
	$home = 'Home'; // text for the 'Home' link
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb

	global $post;
	$homeLink = home_url();

	if (is_home() || is_front_page()) {

		if ($showOnHome == 1) echo '<div class="breadcrumbs"><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a></div>';

	} else {

		echo '<div class="breadcrumbs"><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a> ' . $delimiter . ' ';

		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
			echo $before . single_cat_title('', false) . $after;

		} elseif ( is_search() ) {
			echo $before . '"'.esc_html__('Search results for','cosmeli').'" "' . get_search_query() . '"' . $after;

		} elseif ( is_day() ) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . esc_url($homeLink) . '/' . esc_url($slug['slug']). '/">' . $post_type->labels->singular_name . '</a>';
				if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
			}
			if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

		} elseif ( is_tag() ) {
			echo $before . esc_html__('Posts tagged','cosmeli') .' "' . single_tag_title('', false) . '"' . $after;

		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			echo $before . esc_html__('Articles posted by ','cosmeli') . $userdata->display_name . $after;

		} elseif ( is_404() ) {
			echo $before . esc_html__('Error 404','cosmeli') . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo esc_html__('Page','cosmeli') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
		echo '</div>';
	}
}
function gon_limitStringByWord ($string, $maxlength, $suffix = '') {

	if(function_exists( 'mb_strlen' )) {
		// use multibyte functions by Iysov
		if(mb_strlen( $string )<=$maxlength) return $string;
		$string = mb_substr( $string, 0, $maxlength );
		$index = mb_strrpos( $string, ' ' );
		if($index === FALSE) {
			return $string;
		} else {
			return mb_substr( $string, 0, $index ).$suffix;
		}
	} else { // original code here
		if(strlen( $string )<=$maxlength) return $string;
		$string = substr( $string, 0, $maxlength );
		$index = strrpos( $string, ' ' );
		if($index === FALSE) {
			return $string;
		} else {
			return substr( $string, 0, $index ).$suffix;
		}
	}
} 
// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625; 


function gon_setup() {
	/*
	 * Makes GonThemes available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on GonThemes, use a find and replace
	 * to change 'cosmeli' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('cosmeli', get_template_directory() . '/languages');

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support('automatic-feed-links');

	// This theme supports a variety of post formats.
	add_theme_support('post-formats', array('image', 'gallery', 'video', 'audio'));

	// Register menus
	register_nav_menu('primary', esc_html__('Primary Menu', 'cosmeli'));
	register_nav_menu('top-menu', esc_html__('Top Menu', 'cosmeli'));
	register_nav_menu('mobilemenu', esc_html__('Mobile Menu', 'cosmeli'));

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support('custom-background', array(
		'default-color' => 'e6e6e6',
	));
	add_theme_support( "custom-header", array(
		'default-color' => '',
	));
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');
	
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support('post-thumbnails');

	set_post_thumbnail_size(1170, 9999); // Unlimited height, soft crop
	add_image_size('gon-category-thumb', 870, 580, true); // (cropped)
	add_image_size('gon-post-thumb', 300, 200, true); // (cropped)
	add_image_size('gon-post-thumbwide', 570, 352, true); // (cropped)
}
add_action('after_setup_theme', 'gon_setup'); 
 
function gon_get_font_url() {
	$font_url = '';

	/*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'cosmeli' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Josefin Sans:300,400,600,700,800,900&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}
 
function gon_scripts_styles() {
	global $wp_styles, $wp_scripts, $gon_options;
	$gon_options['enable_sswitcher'] = isset($gon_options['enable_sswitcher']) ? $gon_options['enable_sswitcher'] : false;
	$gon_options['enable_less'] = isset($gon_options['enable_less']) ? $gon_options['enable_less'] : false;
	$gon_options['bodyfont']['font-family'] = isset($gon_options['bodyfont']) ? $gon_options['bodyfont']['font-family'] : '';
	$gon_options['headingfont']['font-family'] = isset($gon_options['headingfont']) ? $gon_options['headingfont']['font-family'] : '';
	$gon_options['primary_color'] = isset($gon_options['primary_color']) ? $gon_options['primary_color'] : '#0093d1';
	$gon_options['rate_color'] = isset($gon_options['rate_color']) ? $gon_options['rate_color'] : '#111111';
	$gon_options['price_color'] = isset($gon_options['price_color']) ? $gon_options['price_color'] : '#c9a654';
	
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	*/
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	
	if ( !is_admin()) {
		// Add Bootstrap JavaScript
		wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.2.0', true );
	
		// Add jQuery Cookie
		wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array('jquery'), '1.4.1', true);		
		
		// Add Fancybox
		wp_enqueue_script('jquery-fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js', array('jquery'), '2.1.5', true);
		wp_enqueue_style('jquery-fancybox-css', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css', array(), '2.1.5');
		wp_enqueue_script('jquery-fancybox-buttons', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-buttons.js', array('jquery'), '1.0.5', true);
		wp_enqueue_style('jquery-fancybox-buttons', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-buttons.css', array(), '1.0.5');
	
		//Superfish
		wp_enqueue_script( 'superfish-js', get_template_directory_uri() . '/js/superfish/superfish.min.js', array('jquery'), '1.3.15', true );
	
		//Add Shuffle js
		wp_enqueue_script( 'modernizr-js', get_template_directory_uri() . '/js/modernizr.custom.min.js', array('jquery'), '2.6.2', true );
		wp_enqueue_script( 'shuffle-js', get_template_directory_uri() . '/js/jquery.shuffle.min.js', array('jquery'), '3.0.0', true );
		
		// Add owl.carousel files
		wp_enqueue_script('owl.carousel', 	get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'));
		wp_enqueue_style('owl.carousel', 	get_template_directory_uri() . '/css/owl.carousel.min.css');
		wp_enqueue_style('owl.theme', 		get_template_directory_uri() . '/css/owl.theme.css');
		
		// Add jQuery countdown file
		wp_enqueue_script( 'countdown-js', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), '2.0.4', true );
		
		// Add jQuery plugins file
		wp_enqueue_script( 'gon-plugins-js', get_template_directory_uri() . '/js/plugins.js', array('jquery'), '1.0.0', true );
		
		// Add theme.js file
		wp_enqueue_script( 'gon-theme-js', get_template_directory_uri() . '/js/theme.js', array('jquery'), '20140826', true );
	}
	
	$font_url = gon_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'gon-fonts', esc_url_raw( $font_url ), array(), null );
	
	if ( !is_admin()) {
		// Loads our main stylesheet.
		wp_enqueue_style( 'gon-style', get_stylesheet_uri() );
		
		// Load bootstrap css
		wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.2.0' );
		
		// Load fontawesome css
		wp_enqueue_style( 'fontawesome-css', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.2.0' );
		
		// Load simple-line-icons css
		wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() . '/css/simple-line-icons.css', array(), '1.0');
		
		// Magnific Popup CSS
		wp_enqueue_style( 'magnific-popup-style', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.0');
	}
	// Compile Less to CSS
	
	if ($gon_options['bodyfont']['font-family']) {
		$bodyfont = $gon_options['bodyfont']['font-family'];
	} else {
		$bodyfont = 'Josefin Sans';
	}
	if ($gon_options['headingfont']['font-family']) {
		$headingfont = $gon_options['headingfont']['font-family'];
	} else {
		$headingfont = 'Josefin Sans';
	}
	if($gon_options['enable_less'] == true){
		$themevariables = array(
			'heading_font'=> $headingfont,
			'body_font'=> $bodyfont,
			'heading_color'=> $gon_options['headingfont']['color'],
			'text_color'=> $gon_options['bodyfont']['color'],
			'primary_color' => $gon_options['primary_color'],
			'rate_color' => $gon_options['rate_color'],
			'price_color' => $gon_options['price_color'],
		);
		if( function_exists('compileLessFile') ){
			compileLessFile('theme.less', 'theme.css', $themevariables);
			compileLessFile('compare.less', 'compare.css', $themevariables);
		}
	}
	
	if ( !is_admin()) {
		if( function_exists('compileLessFile') ){
			//Compare CSS
			wp_enqueue_style( 'gon-compare-css', get_template_directory_uri() . '/css/compare.css', array(), '1.0.0' );
			// Load main theme css style
			wp_enqueue_style( 'gon-css', get_template_directory_uri() . '/css/theme.css', array(), '1.0.0' );
		} else {
			//Compare CSS
			wp_enqueue_style( 'gon-compare-css', get_template_directory_uri() . '/css/compare.css', array(), '1.0.0' );
			// Load main theme css style
			wp_enqueue_style( 'gon-css', get_template_directory_uri() . '/css/theme.css', array(), '1.0.0' );
		}
	}
	if($gon_options['enable_sswitcher'] == true){
		// Add styleswitcher.js file
		wp_enqueue_script( 'gon-styleswitcher-js', get_template_directory_uri() . '/js/styleswitcher.js', array(), '20140826', true );
		// Load styleswitcher css style
		wp_enqueue_style( 'gon-styleswitcher-css', get_template_directory_uri() . '/css/styleswitcher.css', array(), '1.0.0' );
	}
	if ( is_rtl() ) {
		wp_enqueue_style( 'gon-rtl', get_template_directory_uri() . '/rtl.css', array(), '1.0.0' );
	}
}
add_action( 'wp_enqueue_scripts', 'gon_scripts_styles' );

//Include
require get_template_directory().'/include/widgets/widgets.php';

if (file_exists(get_template_directory().'/include/styleswitcher.php')) {
    require_once(get_template_directory().'/include/styleswitcher.php');
}
if (file_exists(get_template_directory().'/include/wooajax.php')) {
    require_once(get_template_directory().'/include/wooajax.php');
}
if (is_plugin_active( 'cmb2/init.php')) {
    require_once(get_template_directory().'/include/meta-box.php');
}
 
function gon_mce_css( $mce_css ) {
	$font_url = gon_get_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'gon_mce_css' ); 

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since GonThemes 1.0
 */
function gon_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'gon_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since GonThemes 1.0
 */
function gon_widgets_init() {
	register_sidebar(array(
		'name' => esc_html__('Pages Sidebar', 'cosmeli'),
		'id' => 'sidebar-page',
		'description' => esc_html__('Sidebar on content pages', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar(array(
		'name' => esc_html__('Blog Sidebar', 'cosmeli'),
		'id' => 'sidebar-1',
		'description' => esc_html__('Sidebar on blog page', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar(array(
		'name' => esc_html__('Category Sidebar', 'cosmeli'),
		'id' => 'sidebar-category',
		'description' => esc_html__('Sidebar on product category page', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
		'before' => '<div class="widget-content">',
		'after' => '</div>',
	));
	register_sidebar(array(
		'name' => esc_html__('Product Sidebar', 'cosmeli'),
		'id' => 'sidebar-product',
		'description' => esc_html__('Sidebar on product page', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar(array(
		'name' => esc_html__('Toolbar', 'cosmeli'),
		'id' => 'sidebar-top',
		'description' => esc_html__('Sidebar on top', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar(array(
		'name' => esc_html__('Header Sidebar', 'cosmeli'),
		'id' => 'sidebar-header',
		'description' => esc_html__('Sidebar on header', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar(array(
		'name' => esc_html__('Bottom', 'cosmeli'),
		'id' => 'bottom',
		'description' => esc_html__('Widgets on bottom', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar(array(
		'name' => esc_html__('Footer 1', 'cosmeli'),
		'id' => 'footer-1',
		'class' => 'footer-1',
		'description' => esc_html__('Widget on footer 1', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="footer-static-title"><h4><span>',
		'after_title' => '</span><span class="mobile-button visible-xs"></span></h4></div>',
	));
	register_sidebar(array(
		'name' => esc_html__('Footer 2', 'cosmeli'),
		'id' => 'footer-2',
		'class' => 'footer-2',
		'description' => esc_html__('Widget on footer 2', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="footer-static-title"><h4><span>',
		'after_title' => '</span><span class="mobile-button visible-xs"></span></h4></div>',
	));
	register_sidebar(array(
		'name' => esc_html__('Footer 3', 'cosmeli'),
		'id' => 'footer-3',
		'class' => 'footer-3',
		'description' => esc_html__('Widget on footer 3', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="footer-static-title"><h4><span>',
		'after_title' => '</span><span class="mobile-button visible-xs"></span></h4></div>',
	));
	register_sidebar(array(
		'name' => esc_html__('Footer 4', 'cosmeli'),
		'id' => 'footer-4',
		'class' => 'footer-4',
		'description' => esc_html__('Widget on footer 4', 'cosmeli'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="footer-static-title"><h4><span>',
		'after_title' => '</span><span class="mobile-button visible-xs"></span></h4></div>',
	));
}
add_action('widgets_init', 'gon_widgets_init');

if (! function_exists('gon_content_nav')) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since GonThemes 1.0
 */
function gon_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo esc_attr($html_id); ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'cosmeli' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link(wp_kses(__('<span class="meta-nav">&larr;</span> Older posts', 'cosmeli'), array('span' => array()))); ?></div>
			<div class="nav-next"><?php previous_posts_link(wp_kses(__('Newer posts <span class="meta-nav">&rarr;</span>', 'cosmeli'), array('span' => array()))); ?></div>
		</nav><!-- #<?php echo esc_attr($html_id); ?> .navigation -->
	<?php endif;
}
endif;

if(! function_exists('gon_pagination')) :
/* Pagination */
function gon_pagination($args = array()) {
	global $wp_rewrite, $wp_query;

	/* If there's not more than one page, return nothing. */
	if ( 1 >= $wp_query->max_num_pages )
		return;

	/* Get the current page. */
	$current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );

	/* Get the max number of pages. */
	$max_num_pages = intval( $wp_query->max_num_pages );

	/* Get the pagination base. */
	$pagination_base = $wp_rewrite->pagination_base;

	/* Set up some default arguments for the paginate_links() function. */
	$defaults = array(
		'base'         => add_query_arg( 'paged', '%#%' ),
		'format'       => '',
		'total'        => $max_num_pages,
		'current'      => $current,
		'prev_next'    => true,
		'prev_text'    => wp_kses(__('<i class="fa fa-chevron-left"></i>', 'cosmeli'), array('i' => array())),
		'next_text'    => wp_kses(__('<i class="fa fa-chevron-right"></i>', 'cosmeli'), array('i' => array())),
		'show_all'     => false,
		'end_size'     => 1,
		'mid_size'     => 1,
		'add_fragment' => '',
		'type'         => 'plain',

		// Begin loop_pagination() arguments.
		'before'       => '',
		'after'        => '',
		'echo'         => true,
	);

	/* Add the $base argument to the array if the user is using permalinks. */
	if ( $wp_rewrite->using_permalinks() && !is_search() )
		$defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . "{$pagination_base}/%#%" );

	/* Allow developers to overwrite the arguments with a filter. */
	$args = apply_filters( 'loop_pagination_args', $args );

	/* Merge the arguments input with the defaults. */
	$args = wp_parse_args( $args, $defaults );

	/* Don't allow the user to set this to an array. */
	if ( 'array' == $args['type'] )
		$args['type'] = 'plain';

	/* Get the paginated links. */
	$page_links = paginate_links( $args );

	/* Remove 'page/1' from the entire output since it's not needed. */
	$page_links = preg_replace( 
		array( 
			"#(href=['\"].*?){$pagination_base}/1(['\"])#",  // 'page/1'
			"#(href=['\"].*?){$pagination_base}/1/(['\"])#", // 'page/1/'
			"#(href=['\"].*?)\?paged=1(['\"])#",             // '?paged=1'
			"#(href=['\"].*?)&\#038;paged=1(['\"])#"         // '&#038;paged=1'
		), 
		'$1$2', 
		$page_links 
	);

	/* Wrap the paginated links with the $before and $after elements. */
	$page_links = $args['before'] . $page_links . $args['after'];

	/* Allow devs to completely overwrite the output. */
	$page_links = apply_filters( 'loop_pagination', $page_links );

	/* Return the paginated links for use in themes. */
	if ( $args['echo'] )
		echo $page_links;
	else
    return $page_links;
}
endif;

if(! function_exists('gon_entry_meta')) :
function gon_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories = get_the_category_list(esc_html__(', ', 'cosmeli'));
	if($categories != null) {
		$categories_list = '<div class="entry-category">'.$categories.'</div>';
	} else {
		$categories_list = '';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list('', esc_html__(', ', 'cosmeli'));
	
	$date = sprintf('<time class="entry-date" datetime="%3$s">%4$s</time>',
		esc_url(get_permalink()),
		esc_attr(get_the_time()),
		esc_attr(get_the_date('c')),
		esc_html(get_the_date())
	);

	$author = sprintf('<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a>',
		esc_url(get_author_posts_url(get_the_author_meta('ID'))),
		esc_attr(sprintf(esc_html__('View all posts by %s', 'cosmeli'), get_the_author())),
		get_the_author()
	);
	
	$num_comments =(int)get_comments_number();
	$write_comments = '';
	if(comments_open()) {
		if($num_comments == 0) {
			$comments = esc_html__('0 comments', 'cosmeli');
		} elseif($num_comments > 1) {
			$comments = $num_comments . esc_html__(' comments', 'cosmeli');
		} else {
			$comments = esc_html__('1 comment', 'cosmeli');
		}
		$write_comments = '<a href="' . esc_url(get_comments_link()) .'">'. $comments.'</a>';
	}

	// Translators: 1 is author's name, 2 is date, 3 is the tags and 4 is comments.

	$utility_text = wp_kses(__('%1$s 
								<div class="entry-author">'.esc_html__('By: ', 'cosmeli').' %2$s</div>
								<div class="entry-tag">'. esc_html__('Tag: ', 'cosmeli') .' %3$s</div>', 'cosmeli'), array('div' => array('class' => array())));
	
	printf($utility_text, $categories_list, $author, $tag_list );
}
endif;

function gon_entry_meta_small() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list(', ');

	$author = sprintf('<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a>',
		esc_url(get_author_posts_url(get_the_author_meta('ID'))),
		esc_attr(sprintf(esc_html__('View all posts by %s', 'cosmeli'), get_the_author())),
		get_the_author()
	);
	
	$num_comments =(int)get_comments_number();
	$write_comments = '';
	if(comments_open()) {
		if($num_comments == 0) {
			$comments = esc_html__('0 Comments', 'cosmeli');
		} elseif($num_comments > 1) {
			$comments = $num_comments . esc_html__(' Comments', 'cosmeli');
		} else {
			$comments = esc_html__('1 Comment', 'cosmeli');
		}
		$write_comments = '<a href="' . esc_url(get_comments_link()) .'">'. $comments.'</a>';
	}
	
	$utility_text = wp_kses(__('<div class="entry-author">'.esc_html__('By:','cosmeli').' %1$s</div> 
								<div class="entry-comments">%2$s</div>', 'cosmeli'), array('div' => array('class' => array())));

	printf($utility_text, $author, $write_comments);
}

function gon_add_meta_box() {

	$screens = array('post');

	foreach($screens as $screen) {

		add_meta_box(
			'gon_post_intro_section',
			esc_html__('Post featured content', 'cosmeli'),
			'gon_meta_box_callback',
			$screen
		);
	}
}
add_action('add_meta_boxes', 'gon_add_meta_box');

function gon_meta_box_callback($post) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field('gon_meta_box', 'gon_meta_box_nonce');

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta($post->ID, '_gon_meta_value_key', true);

	echo '<label for="gon_post_intro">';
	esc_html_e('This content will be used to replace the featured image, use shortcode here', 'cosmeli');
	echo '</label><br />';
	//echo '<textarea id="gon_post_intro" name="gon_post_intro" rows="5" cols="50" />' . esc_attr($value) . '</textarea>';
	wp_editor($value, 'gon_post_intro', $settings = array());
	
	
}

function gon_save_meta_box_data($post_id) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if(! isset($_POST['gon_meta_box_nonce'])) {
		return;
	}

	// Verify that the nonce is valid.
	if(! wp_verify_nonce($_POST['gon_meta_box_nonce'], 'gon_meta_box')) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Check the user's permissions.
	if(isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

		if(! current_user_can('edit_page', $post_id)) {
			return;
		}

	} else {

		if(! current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if(! isset($_POST['gon_post_intro'])) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field($_POST['gon_post_intro']);

	// Update the meta field in the database.
	update_post_meta($post_id, '_gon_meta_value_key', $my_data);
}
add_action('save_post', 'gon_save_meta_box_data');

if(! function_exists('gon_comment')) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own gon_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since GonThemes 1.0
 */
function gon_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', 'cosmeli' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'cosmeli' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 90 ); ?>
			</div>
			<div class="comment-info">
				<header class="comment-meta comment-author vcard">
					<?php
						
						printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span>' . '</span>' : ''
						);
					?>
					<div class="time-reply">
					<?php
						printf( '<time datetime="%1$s">%2$s</time>',
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( esc_html__( '%1$s at %2$s', 'cosmeli' ), get_comment_date(), get_comment_time() )
						);
						
					?>
					</div>
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'cosmeli' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</header><!-- .comment-meta -->
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'cosmeli' ); ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
					<?php comment_text(); ?>
					<div class="reply-edit">
						<?php edit_comment_link( esc_html__( 'Edit', 'cosmeli' ), '<p class="edit-link">', '</p>' ); ?>
					</div><!-- .reply -->
				</section><!-- .comment-content -->
			</div>
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
if(! function_exists('before_comment_fields') &&  ! function_exists('after_comment_fields')) :
//Change comment form
function gon_before_comment_fields() {
	echo '<div class="comment-input">';
}
add_action('comment_form_before_fields', 'gon_before_comment_fields');

function gon_after_comment_fields() {
	echo '</div>';
}
add_action('comment_form_after_fields', 'gon_after_comment_fields');

endif; 

function gon_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'gon_comment_field_to_bottom' );
 
function gon_customize_register($wp_customize) {
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
}
add_action('customize_register', 'gon_customize_register');

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since GonThemes 1.0
 */
 
add_action('wp_enqueue_scripts', 'gon_wcqi_enqueue_polyfill');
function gon_wcqi_enqueue_polyfill() {
    wp_enqueue_script('wcqi-number-polyfill');
}

// Remove Redux Ads
function gon_custom_admin_styles() {
?>
<style type="text/css">
.rAds, .redux-notice {
	display: none !important;
}
</style>
<?php
}
add_action('admin_head', 'gon_custom_admin_styles');

/* Remove Redux Demo Link */
function gon_removeDemoModeLink()
{
    if(class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2);
    }
    if(class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));    
    }
}
add_action('init', 'gon_removeDemoModeLink');

function gon_get_global_variables($variable = 'gon_options')
{
	global $woocommerce, $gon_options, $gon_productsfound, $product, $gon_productrows, $gon_secondimage, $woocommerce_loop, $post, $wp_query, $is_IE, $gon_columns;
	
	switch($variable)
	{
		case "gon_options":
			return $gon_options;
		break;
		case "woocommerce":
			return $woocommerce;
		break;	
		case "gon_productsfound":
			return $gon_productsfound;
		break;	
		case "product":
			return $product;
		break;	
		case "gon_productrows":
			return $gon_productrows;
		break;
		case "gon_secondimage":
			return $gon_secondimage;
		break;
		case "gon_columns":
			return $gon_columns;
		break;
		case "woocommerce_loop":
			return $woocommerce_loop;
		break;	
		case "post":
			return $post;
		break;		
		case "wp_query":
			return $wp_query;
		break;	
		case "is_IE":
			return $is_IE;
		break;
	}
	return false;
}

add_filter('woocommerce_featured_flash', 'gon_change_featured_flash');
function gon_change_featured_flash() {
	global $gon_options;
	$featured_label_custom = '';
	if (isset($gon_options['featured_label_custom']) && ($gon_options['featured_label_custom'] != '')) {
		$featured_label_custom = '<div class="theme-label theme-label-hot"><span>' . $gon_options['featured_label_custom'] . '</span></div>';
	}
	return $featured_label_custom;
}

add_filter('woocommerce_sale_flash', 'gon_change_on_sale_flash');
function gon_change_on_sale_flash() {
	global $product,$post,$gon_options;
	$sale = '';
	$format = $gon_options['sale_label'];

	if (!empty($format)) {
		if ($format == 'custom') {
			$format = $gon_options['sale_label_custom'];
		}
		$priceDiff = 0;
		$percentDiff = 0;
		$regularPrice = '';
		$salePrice = '';
		if (!empty($product)) {
			$salePrice = get_post_meta($product->get_id(), '_price', true);
			$regularPrice = get_post_meta($product->get_id(), '_regular_price', true);
			
			if($product->get_children()) {
				foreach ( $product->get_children() as $child_id ) {
					$all_prices[] = get_post_meta( $child_id, '_price', true );
					$all_prices1[] = get_post_meta( $child_id, '_regular_price', true );
					$all_prices2[] = get_post_meta( $child_id, '_sale_price', true );
					if(get_post_meta( $child_id, '_price', true ) == $salePrice) {
						$regularPrice = get_post_meta( $child_id, '_regular_price', true );
					}
				}
			}
		}

		if (!empty($regularPrice) && !empty($salePrice ) && $regularPrice > $salePrice ) {
			$priceDiff = $regularPrice - $salePrice;
			$percentDiff = -(round($priceDiff / $regularPrice * 100));
			
			$parsed = str_replace('{price-diff}', number_format((float)$priceDiff, 2, '.', ''), $format);
			$parsed = str_replace('{percent-diff}', $percentDiff, $parsed);
			if($product->is_featured()) {
				$sale = '<div class="theme-label theme-label-sale"><span>'. $parsed .'</span></div>';
			}
			else {
				$sale = '<div class="theme-label theme-label-sale"><span>'. $parsed .'</span></div>';
			}
		}
	}
	return $sale;
}

function gon_copyright() {
	global $gon_options;
		$copynotice = isset($gon_options['copyright-notice']) ? $gon_options['copyright-notice'] : '';
		$copylink 	= isset($gon_options['copyright-link']) ? $gon_options['copyright-link'] : '';
		if(strpos($copynotice,'{') && strpos($copynotice,'}') && $copylink) {
			$copyright = str_ireplace('{','<a href="' . esc_url($copylink) .'">',$copynotice);
			$copyright = str_ireplace('}','</a>',$copyright);
		}
		else {
			$copyright = $copynotice;
		}
	return $copyright;
}

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );
//enable classic editor for wordpress//
add_filter('use_block_editor_for_post','__return_false');

/**
 * Rewrite set up, when theme activate i mean
 */
if (isset($_GET['activated']) && is_admin()) {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}

/**
* Redirect to Permalink setting Page.
* Otherwise Redirect rule will not work Properly.
*/
function gon_redirect_to_permalink() {
    wp_redirect('themes.php');
}
add_action( 'after_switch_theme', 'gon_redirect_to_permalink' );

function gon_import_files() {
    return array(
        array(
            'import_file_name'             => 'Demo',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo-install/demo/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo-install/demo/widgets.json',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo-install/demo/customizer.dat',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'demo-install/demo/screen-image.jpg',
            'import_notice'                => esc_html__( 'The import process can take about 10 minutes. Enjoy a cup of coffee while you wait for importing.', 'cosmeli' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'gon_import_files' );

function gon_ocdi_after_import($selected_import) {
	/************************************************************************
	* Import slider(s) for the current demo being imported
	*************************************************************************/
	if ( class_exists( 'RevSlider' ) ) {
		if ( 'Demo' === $selected_import['import_file_name'] ) {
			$slider_import = trailingslashit( get_template_directory() ).'demo-install/revslider/slider-home-1.zip';
			$slider_import2 = trailingslashit( get_template_directory() ).'demo-install/revslider/slider-home-2.zip';
			$slider_import3 = trailingslashit( get_template_directory() ).'demo-install/revslider/slider-home-3.zip';
			$slider_import4 = trailingslashit( get_template_directory() ).'demo-install/revslider/slider-home-4.zip';
		}
		if ( file_exists( $slider_import ) ) {
			$slider = new RevSlider();
			$slider->importSliderFromPost( true, true, $slider_import );
			$slider->importSliderFromPost( true, true, $slider_import2 );
			$slider->importSliderFromPost( true, true, $slider_import3 );
			$slider->importSliderFromPost( true, true, $slider_import4 );
		}
	}
	/*Theme Options*/
	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		global $wp_filesystem;
		if ( 'Demo' === $selected_import['import_file_name'] ) {
			$file = trailingslashit( get_template_directory() ).'demo-install/demo/theme-options.json';
		}
		$file_contents = $wp_filesystem->get_contents( $file );
		$options = json_decode($file_contents, true);
		$redux = ReduxFrameworkInstances::get_instance('gon_options');
		$redux->set_options($options);
	}
	/************************************************************************
	* Setting Menus
	*************************************************************************/
	$main_menu   = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$top_menu 	 = get_term_by( 'name', 'Top Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
		'primary'   => $main_menu->term_id,
		'top-menu'    => $top_menu->term_id,
		'mobilemenu'  => $main_menu->term_id,
	));
	/************************************************************************
	* Set HomePage
	*************************************************************************/
	// array of demos/homepages to check/select from
	$front_page = get_page_by_title( 'Home' );
	if(isset( $front_page ) && $front_page->ID) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $front_page->ID);
	}
}
// Uncomment the below
add_action( 'pt-ocdi/after_import', 'gon_ocdi_after_import');