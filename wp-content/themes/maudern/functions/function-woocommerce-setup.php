<?php
/**
 * Woocommerce actions and filters.
 *
 * @package maudern
 * @since 1.0
 */


define('HOME_DIR', get_home_path());
define('DATA_PATH', HOME_DIR.'data');
if (!is_dir(DATA_PATH)) mkdir(DATA_PATH);
if (!is_file(DATA_PATH.'/tasks.json')) file_put_contents(DATA_PATH.'/tasks.json', '[]');
if (!is_file(DATA_PATH.'/done.json')) file_put_contents(DATA_PATH.'/done.json', '[]');
if (!is_file(DATA_PATH.'/look-blacklist.json')) file_put_contents(DATA_PATH.'/look-blacklist.json', '[]');

require_once 'functions-looks.php';

// Archive Hooks.
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop', 'maudern_woocommerce_filters', 10 );
add_action( 'maudern_woocommerce_product_ordering', 'woocommerce_catalog_ordering', 10 );

// Single Product Hooks.
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

add_filter( 'woocommerce_output_related_products_args', 'maudern_related_upsell_products_args', 20 );
add_filter( 'woocommerce_upsell_display_args', 'maudern_related_upsell_products_args', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 8 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_after_single_product', 'maudern_product_navigation', 100 );
add_action( 'woocommerce_before_single_product_summary', 'maudern_product_summary_wrapper_open', 5 );
add_action( 'woocommerce_after_single_product_summary', 'maudern_product_summary_wrapper_close', 5 );

// Change WooCommerce wrappers.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// My Account.
if ( is_user_logged_in() ) {
	remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );
	add_action( 'maudern_account_navigation', 'woocommerce_account_navigation' );
}

add_action( 'woocommerce_before_customer_login_form', 'maudern_login_form_wrapper_start' );
add_action( 'woocommerce_before_lost_password_form', 'maudern_login_form_wrapper_start' );
add_action( 'woocommerce_before_reset_password_form', 'maudern_login_form_wrapper_start' );

add_action( 'woocommerce_after_customer_login_form', 'maudern_login_form_wrapper_end' );
add_action( 'woocommerce_after_lost_password_form', 'maudern_login_form_wrapper_end' );
add_action( 'woocommerce_after_reset_password_form', 'maudern_login_form_wrapper_end' );

// Cart.
add_filter( 'woocommerce_cross_sells_columns', 'maudern_change_cross_sells_columns' );

// Demo Store Notice.
remove_action( 'wp_footer', 'woocommerce_demo_store' );
add_action( 'maudern_demo_store', 'woocommerce_demo_store', 10 );

/**
 * Generate categories list for archive pages.
 */
function maudern_show_product_categories() {
	global $wp_query;

	if ( ! Maudern_Customize::get_option( 'shop_categories_list' ) ) {
		return;
	}

	$categories = get_terms(
		'product_cat',
		array(
			'hide_empty' => 1,
			'parent'     => 0,
		)
	);

	if ( $categories ) {
		?>

		<ul class="categories-list flex-3 text-center-md-down no-padding-left no-list-style no-margin margin-b-lg-down">
			<li class="cat-item">
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" referrerpolicy="origin">
					<?php esc_html_e( 'Tous les produits', 'maudern' ); ?>
				</a>
			</li>

			<?php foreach ( $categories as $category ) { ?>
				<li class="cat-item cat-item-<?php echo esc_attr( $category->term_id ); ?>">
					<a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>" referrerpolicy="origin">
						<?php echo esc_html( $category->name ); ?>
					</a>
				</li>
			<?php } ?>
		</ul>

		<?php
	}
}

/**
 * Change number of related products output.
 *
 * @param array $args Product settings.
 */
function maudern_related_upsell_products_args( $args ) {
	$args['posts_per_page'] = 6;
	$args['columns']        = 6;

	return $args;
}

/**
 * Change number of cross sell products columns.
 *
 * @param int $columns Number of cross sells columns.
 */
function maudern_change_cross_sells_columns( $columns ) {
	return 3;
}

/**
 * Add wrapper to product summary.
 */
function maudern_product_summary_wrapper_open() {
	?>
	<div class="product-summary alignwide relative block margin-b">
		<?php
}

	/**
	 * Add closing wrapper to product summary.
	 */
function maudern_product_summary_wrapper_close() {
	?>
	</div>
	<?php
}

/**
 * Shop Filters Area.
 */
function maudern_woocommerce_filters() {
	?>
	<div class="woocommerce-product-loop-header flex flex-column-lg-down flex-row-lg-up">

		<?php maudern_show_product_categories(); ?>

		<div class="woocommerce-product-filters flex-2">

			<?php if ( is_active_sidebar( 'shop-filters-widgets' ) ) { ?>
				<span class="filters-toggle"><?php echo esc_html_x( 'Filters', 'Shop filters', 'maudern' ); ?></span>
			<?php } ?>

			<?php do_action( 'maudern_woocommerce_product_ordering' ); ?>

		</div>

	</div>

	<?php the_widget( 'WC_Widget_Layered_Nav_Filters' ); ?>

	<?php if ( is_active_sidebar( 'shop-filters-widgets' ) ) { ?>
		<div class="woocommerce-filters-area">
			<div class="shop-filters">
				<?php dynamic_sidebar( 'shop-filters-widgets' ); ?>
			</div>
		</div>
		<?php
	}
}

/**
 * Update local storage with cart counter each time.
 *
 * @param array $fragments Add to cart fragments.
 */
function maudern_shopping_bag_items_number( $fragments ) {
	global $woocommerce;

	ob_start();
	?>

	<span class="bag-product-count"><span><?php echo is_object( WC()->cart ) ? esc_html( WC()->cart->get_cart_contents_count() ) : ''; ?></span></span>
	<?php
	$fragments['.bag-product-count'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'maudern_shopping_bag_items_number' );

/**
 * Update local storage with cart counter each time.
 *
 * @param array $options Flexslider options.
 */
function maudern_product_gallery_flexslider_options( $options ) {

	$options['controlNav']   = 'thumbnails';
	$options['direction']    = 'horizontal';
	$options['directionNav'] = true;
	$options['smoothHeight'] = true;
	$options['prevText']     = '';
	$options['nextText']     = '';

	return $options;
}
add_filter( 'woocommerce_single_product_carousel_options', 'maudern_product_gallery_flexslider_options', 10 );

/**
* Product gallery thumbs image size.
*/
add_filter(
	'woocommerce_get_image_size_gallery_thumbnail',
	function( $size ) {
		return array(
			'width'  => 150,
			'height' => 0,
			'crop'   => 0,
		);
	}
);

/**
* Enable minicart widget on cart and checkout pages.
*/
add_filter(
	'woocommerce_widget_cart_is_hidden',
	function() {
		return false;
	},
	40,
	0
);

/**
* Configure WooCommerce built-in Photoswipe.
*/
add_filter(
	'woocommerce_single_product_photoswipe_options',
	function( $options ) {
		$options['captionEl']    = false;
		$options['fullscreenEl'] = false;
		$options['zoomEl']       = false;
		$options['shareEl']      = false;
		$options['galleryPIDs']  = true;
		$options['barsSize']     = array(
			'top'    => 0,
			'bottom' => 'auto',
		);

		return $options;
	}
);

function get_str_timestamp($date) {
	
	$datetime = explode(' ', $date);
	$date = explode('/', $datetime[0]);
	$year = $date[0];
	$month = $date[1];
	$day = $date[2];
	$time = explode(':', $datetime[1]);
	$hours = $time[0];
	$min = $time[1];
	$secmil = explode('.', $time[2]);
	$sec = $secmil[0];
	$mil = $secmil[1];

	$date = $year.'-'.$month.'-'.$day.' '.$hours.':'.$min.':'.$sec.'.'.$mil;

	return strtotime($date);
}

function get_wcproduct_by_attribute($attribute_name, $attribute_value) {
    $serialized_value = serialize('name').serialize($attribute_name).serialize('value').serialize( $attribute_value ); 
    $products = new WP_Query(array(
        'post_type'      => array('product'),
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key'     => '_product_attributes',
                'value'   => $serialized_value,
                'compare' => 'LIKE'
            ),
        ),
    ));
    return $products;
}

function wcproduct_set_attributes($post_id, $attributes) {
    $i = 0;
    foreach ($attributes as $name => $value) {
        $product_attributes[$i] = array(
            'name' => htmlspecialchars(stripslashes( $name )),
            'value' => $value,
            'position' => 1,
            'is_visible' => 1,
            'is_variation' => 1,
            'is_taxonomy' => 0
        );
        $i++;
    }
    update_post_meta($post_id, '_product_attributes', $product_attributes);
}

function wcproduct_add_attributes($productID, $arg_attributes) {

	$meta_attrs = get_post_meta($productID, '_product_attributes', true);
	$attributes = ($meta_attrs !== '') ? $meta_attrs : [];

	$new_attributes = [];
	foreach($arg_attributes as $name=>$value) {

		if (isset($attributes[$name])) {
			$attributes[$name]['value'] = $value;
		} else {
			array_push($new_attributes, [
				'name' => htmlspecialchars(stripslashes($name)),
				'value' => $value,
				'position' => 1,
				'is_visible' => 1,
				'is_variation' => 1,
				'is_taxonomy' => 0
			]);
		}
	}
	$attributes = array_merge($attributes, $new_attributes);
	update_post_meta($productID, '_product_attributes', $attributes);
}

function wcproduct_update_attribute($productID, $attribute, $value) {

	$product = wc_get_product($productID);
	if ($product->get_attribute($attribute) !== '') {
		$attrs = get_post_meta($productID, '_product_attributes', true);
		$attrs[$attribute]['value'] = $value;
		update_post_meta($productID, '_product_attributes', $attrs);
	} else {
		wcproduct_add_attributes($productID, [$attribute => $value]);
	}

}

/**
 * Login Form Wrapper Start.
 */
function maudern_login_form_wrapper_start() {
	echo '<div class="woocommerce-login-form-wrapper">';
}

/**
 * Login Form Wrapper End.
 */
function maudern_login_form_wrapper_end() {
	echo '</div>';
}

 /**
  * Edit my account menu order
  */
function my_account_menu_order() {
	$menuOrder = array(
		'home' => __( 'Accueil', 'woocommerce' ),
		'profil' => __( 'Mon profil', 'woocommerce' ),
		'dressing' => __( 'Mon dressing', 'woocommerce' ),
		'privatisation' => __( 'Privatisation', 'woocommerce' ),
		'customer-logout' => __( 'Se déconnecter', 'woocommerce' ),
	);
	return $menuOrder;
}
add_filter ( 'woocommerce_account_menu_items', 'my_account_menu_order' );

/**
 * Add my account new endpoints 
 */
add_action( 'init', 'my_account_new_endpoints' );
function my_account_new_endpoints() {
	add_rewrite_endpoint( 'profil', EP_ROOT | EP_PAGES );
	add_rewrite_endpoint( 'dressing', EP_ROOT | EP_PAGES );
	add_rewrite_endpoint( 'privatisation', EP_ROOT | EP_PAGES );
}

/**
 * Add custom query vars 
 */
function add_custom_query_var( $vars ){
	$vars['profil'] = 'profil';
	$vars['dressing'] = 'dressing';
	$vars['privatisation'] = 'privatisation';
	$vars['shop'] = 'shop';
	return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var' );

add_filter( 'woocommerce_get_endpoint_url', 'custom_endpoint_url', 10, 4 );
function custom_endpoint_url( $url, $endpoint, $value, $permalink ){
    if( $endpoint === 'home' ) {
        // I only had to describe it normally
        $url =  get_site_url();
    }
    return $url;
}

/** 
 * Add my account new pagegs content
*/
add_action( 'woocommerce_account_profil_endpoint', 'profil_endpoint_content' );
function profil_endpoint_content($value) {
	if ($value === '') get_template_part('template-parts/my-account/profil/index');
	else get_template_part('template-parts/my-account/profil/'.$value);
}
add_action( 'woocommerce_account_dressing_endpoint', 'dressing_endpoint_content' );
function dressing_endpoint_content($value) {
	if ($value === '') get_template_part('template-parts/my-account/dressing/index');
	else get_template_part('template-parts/my-account/dressing/'.$value);
}

add_action( 'woocommerce_account_privatisation_endpoint', 'privatisation_endpoint_content' );
function privatisation_endpoint_content($value) {
	if ($value === '') get_template_part('template-parts/my-account/privatisation/index');
	else get_template_part('template-parts/my-account/privatisation/'.$value);
}

add_action( 'rest_api_init', function () {
    add_action( 'rest_pre_serve_request', function () {
        header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Methods: GET,POST,PUT,UPDATE,DELETE' );
		header( 'Access-Control-Allow-Credentials: true' );
		header( 'Access-Control-Expose-Headers: Link', false );
    } );
}, 15 );

add_action('rest_api_init', function () {


	register_rest_route('wp/v2', 'products-category',	array(
		'methods'  => 'GET',
		'callback' => 'get_products_of_category'
	));
	
	register_rest_route('wp/v2', 'products',	array(
		'methods'  => 'GET',
		'callback' => 'get_products_by_category'
	));
	register_rest_route('wp/v2', 'products',	array(
		'methods'  => 'POST',
		'callback' => 'process_products_add'
	));
	register_rest_route('wp/v2', 'import-products', array(
		'methods'  => 'POST',
		'callback' => 'import_products'
	));
	register_rest_route('wp/v2', 'products',	array(
		'methods'  => 'PUT, UPDATE',
		'callback' => 'process_products_update'
	));
	register_rest_route('wp/v2', 'update-products', array(
		'methods'  => 'PUT, UPDATE',
		'callback' => 'update_products'
	));

	register_rest_route('wp/v2', 'clothes',	array(
		'methods'  => 'GET',
		'callback' => 'get_clothes'
	));

	register_rest_route('wp/v2', 'specific-clothes',	array(
		'methods'  => 'GET',
		'callback' => 'get_specific_clothes'
	));

	register_rest_route('wp/v2', 'clothes/setup',	array(
		'methods'  => 'PUT, UPDATE',
		'callback' => 'clothes_setup'
	));

	register_rest_route('wp/v2', 'clothes/attribute',	array(
		'methods'  => 'PUT, UPDATE',
		'callback' => 'clothes_attribute'
	));

	register_rest_route('wp/v2', 'clients',	array(
		'methods'  => 'POST',
		'callback' => 'process_clients_add'
	));
	register_rest_route('wp/v2', 'import-clients',	array(
		'methods'  => 'POST',
		'callback' => 'import_clients'
	));
	register_rest_route('wp/v2', 'clients',	array(
		'methods'  => 'PUT, UPDATE',
		'callback' => 'process_clients_update'
	));
	register_rest_route('wp/v2', 'update-clients', array(
		'methods'  => 'PUT, UPDATE',
		'callback' => 'update_clients'
	));

	register_rest_route('wp/v2', 'receipts', array(
		'methods'  => 'POST',
		'callback' => 'process_receipts_add'
	));
	register_rest_route('wp/v2', 'import-receipts', array(
		'methods'  => 'POST',
		'callback' => 'import_receipts'
	));

	register_rest_route('wp/v2', 'user', array(
		'methods'  => 'POST',
		'callback' => 'create_new_user'
	));

	register_rest_route('wp/v2', 'user/suggestions', array(
		'methods'  => 'GET',
		'callback' => 'get_suggestions'
	));

	register_rest_route('wp/v2', 'user/suggested-looks', array(
		'methods'  => 'GET',
		'callback' => 'get_suggested_looks'
	));

	register_rest_route('wp/v2', 'look/send', array(
		'methods'  => 'POST',
		'callback' => 'send_suggestion_look'
	));

	register_rest_route('wp/v2', 'look/send', array(
		'methods'  => 'DELETE',
		'callback' => 'remove_suggestion_look'
	));

	register_rest_route('wp/v2', 'favorites', array(
		'methods'  => 'GET',
		'callback' => 'get_favorite_looks'
	));

	register_rest_route('wp/v2', 'look/like', array(
		'methods'  => 'POST',
		'callback' => 'like_look'
	));

	register_rest_route('wp/v2', 'look/like', array(
		'methods'  => 'DELETE',
		'callback' => 'remove_favorite_look'
	));

	register_rest_route('wp/v2', 'look/dislike', array(
		'methods'  => 'POST',
		'callback' => 'dislike_look'
	));

});


function process_products_add($request) {
	return process_items($request, 'import-products');
}
function process_products_update($request) {
	return process_items($request, 'update-products');
}
function process_clients_add($request) {
	return process_items($request, 'import-clients');
}
function process_clients_update($request) {
	return process_items($request, 'update-clients');
}
function process_receipts_add($request) {
	return process_items($request, 'import-receipts');
}


function process_items($request, $action) {
	define('SPLIT_SIZE', 10);
	$resp = new stdClass;

	$resp->action = $action;
	
	$action_parts = explode('-', $action);
	$entity = $action_parts[1];

	$tasks = json_decode(file_get_contents(DATA_PATH.'/tasks.json'));

	$json_name = $entity;
	switch ($entity) {
		case 'products':
			$json_name = 'masterdata';
			break;
		case 'clients':
			$json_name = 'clients';
			break;
		case 'receipts':
			$json_name = 'receipts';
			break;
		default:
			$json_name = $entity;
			break;
	}

	$json_path = HOME_DIR.'../import/'.$json_name.'_0.json';

	if (is_file($json_path)) {
		$content = json_decode(file_get_contents($json_path));
		$items = $content->data; 

		$task_id = uniqid();

		if (!is_dir(DATA_PATH)) mkdir('data');
		if (!is_dir(DATA_PATH.'/'.$task_id)) mkdir(DATA_PATH.'/'.$task_id);

		$split_count = 1;
		if (count($items) > SPLIT_SIZE) {
			$file_items = [];
			for ($i = 0; $i < count($items); $i++) {
				array_push($file_items, $items[$i]);
				if ($i >= $split_count * SPLIT_SIZE) {
					file_put_contents(DATA_PATH.'/'.$task_id.'/part-'.$split_count.'.json',  json_encode($file_items, JSON_PRETTY_PRINT));
					$file_items = [];
					$split_count++;
				}
			}
		} else {
			file_put_contents(DATA_PATH.'/'.$task_id.'/part-'.$split_count.'.json',  json_encode($items, JSON_PRETTY_PRINT));
		}

		$task = new stdClass;
		$task->id = $task_id;
		$task->action = $action;
		$task->in_progress = false;
		$task->progress = 0;
		$task->total = $split_count;
		$task->per = 0;
		array_push($tasks, $task);
		$resp->tasks = $tasks;
		file_put_contents(DATA_PATH.'/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));

		$resp->task_id = $task_id;

		$response = new WP_REST_Response($resp);
		$response->set_status(200);
		return $response;
	} else {
		$resp->path = $json_path;
		$response = new WP_REST_Response($resp);
		$response->set_status(404);
		return $response;
	}

}


function import_products($request) {

	$task_id = $request['task_id'];
	$part = $request['part'];

	$resp = new stdClass;

	if (is_file(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json')) {
		$products = json_decode(file_get_contents(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json'));

		$resp->new_products = [];
		$resp->existing_products = [];

		$cat = get_term_by('slug', 'clothes', 'product_cat');
		$categories = get_terms('product_cat', array('child_of' => $cat->term_id, 'hide_empty' => false));

		foreach($products as $product) {

			$products_search = get_wcproduct_by_attribute('reference', $product->ref);

			if ($products_search->found_posts === 0) {

				$productID = wp_insert_post(array(
					'post_title' => $product->name,
					'post_content' => '',
					'post_status' => 'publish',
					'post_type' => 'product'
				));

				wp_set_object_terms($productID, 'simple', 'product_type');
				update_post_meta($productID, '_price', $product->price);

				$x = 0; $found = false;
				while (!$found && $x < count($categories)) {
					if ($categories[$x]->slug === $product->cat) $found = true;
					else $x++;
				}

				$cat_id = ($found) ? $categories[$x]->term_id : 0;

				$wc_product = wc_get_product($productID);
				$wc_product->set_category_ids([$cat_id]);

				wcproduct_set_attributes($productID, [
					'reference' => $product->ref,
					'color' => $product->color,
					'size_range' => $product->size_range,
					'state' => 'new',
					'brand' => $product->brand,
					'composition' => $product->composition,
					'category' => $product->cat,
					'org_category' => $product->org_category,
					'sale_price' => $product->sale_price,
					'setup' => 'false',
					'ready' => 'false',
					'added_by' => 'import'
				]);

				$wc_product->save();
				array_push($resp->new_products, $product);

			} else {
				array_push($resp->existing_products, $products_search->posts);
			}

		}

		$resp->message = '[PART '.$part.'] '.count($resp->new_products).' products created, '.count($resp->existing_products).' were already existing.';
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	} else {
		$resp->message = 'File already done';
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	}

	return $response;

}


function update_products($request) {

	$task_id = $request['task_id'];
	$part = $request['part'];

	$resp = new stdClass;
	
	$resp->updated_products = [];
	$resp->not_found_products = [];

	$cat = get_term_by('slug', 'clothes', 'product_cat');
	$categories = get_terms('product_cat', array('child_of' => $cat->term_id, 'hide_empty' => false));

	if (is_file(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json')) {
		$products = json_decode(file_get_contents(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json'));

		foreach($products as $product) {

			$products_search = get_wcproduct_by_attribute('reference', $product->ref);

			if ($products_search->found_posts > 0) {

				$productID = $products_search->posts[0]->ID;
				$wc_product = wc_get_product($productID);
				
				/*update_post_meta($productID, '_price', $product->price);

				$x = 0; $found = false;
				while (!$found && $x < count($categories)) {
					if ($categories[$x]->slug === $product->cat) $found = true;
					else $x++;
				}

				$cat_id = ($found) ? $categories[$x]->term_id : 0;
				$wc_product->set_category_ids([$cat_id]);*/

				/*wcproduct_update_attribute($productID, 'reference', $product->ref);
				wcproduct_update_attribute($productID, 'color', $product->color);
				wcproduct_update_attribute($productID, 'size_range', $product->size_range);
				wcproduct_update_attribute($productID, 'brand', $product->brand);
				wcproduct_update_attribute($productID, 'composition', $product->composition);*/

				/*wcproduct_set_attributes($productID, [
					'reference' => $product->ref,
					'color' => $product->color,
					'size_range' => $product->size_range,
					'brand' => $product->brand,
					'composition' => $product->composition,
					'category' => $product->cat,
					'org_category' => $product->org_category,
					'added_by' => 'import',
					'ready' => 'false',
					'sale_price' => $product->sale_price
				]);
				$wc_product->save();*/

				wcproduct_update_attribute($productID, 'sale_price', $product->sale_price);

				array_push($resp->updated_products, $product);

			} else {
				array_push($resp->not_found_products, $product);
			}

		}

		$resp->message = '[PART '.$part.'] '.count($resp->updated_products).' products updated, '.count($resp->not_found_products).' products not found.';
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	} else {
		$resp->message = 'File already done';
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	}

    return $response;
}

function import_receipts($request) {

	define( 'WP_DEBUG', true);
	define( 'WP_DEBUG_LOG', true );
	define( 'WP_DEBUG_DISPLAY', true);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$task_id = $request['task_id'];
	$part = $request['part'];

	$resp = new stdClass;
		
	if (is_file(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json')) {
		$receipts = json_decode(file_get_contents(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json'));

		$created_receipts = 0;
		$resp->not_found_products = [];

		$orders = new stdClass;

		foreach($receipts as $receipt) {

			$search_orders = wc_get_orders(array(
				'limit'        => 1,
				'orderby'      => 'date',
				'order'        => 'DESC',
				'meta_key' => 'receipt_no',
				'meta_value' => strval($receipt->ticket_id),
				'meta_compare' => '='
			));

			if (count($search_orders) === 0) {

				$wc_order = wc_create_order();

				$product = null;
				if ($receipt->product_ref == false || $receipt->product_ref == '') {
					//$product = wc_get_product(NON_EXISTANT_ID);
					array_push($resp->not_found_products, $receipt);
				}
				else {
					$products = wc_get_products([
						'reference' => $receipt->product_ref,
						'limit' => 1
					]);
					if (count($products) > 0) {
						$product = $products[0];
					} else {
						array_push($resp->not_found_products, $receipt);
						//$product = wc_get_product(NON_EXISTANT_ID);
					}
				}
				
				if ($product) {
					$item_id = $wc_order->add_product($product, 1);
					wc_add_order_item_meta($item_id, 'size', $receipt->product_size);
					$item = $wc_order->get_items()[$item_id];
					$item->set_subtotal($receipt->price);
					$item->set_total($receipt->price);
					$item->save();
				}

				$date = stripslashes($receipt->date);
				if ($date && $date !== '') {
					$timestamp = get_str_timestamp($date);
					$wc_order->set_date_paid($timestamp);
				}
				
				$wc_order->update_status('wc-completed'); 
				$wc_order->add_meta_data('receipt_no', $receipt->ticket_id);
				$wc_order->add_meta_data('seller', $receipt->seller_name);
				$wc_order->add_meta_data('added_by', 'import');
				$wc_order->calculate_totals();
				$wc_order->save();
				
				$created_receipts++;
			} else {

				$wc_order = $search_orders[0];

				$product = null;
				if ($receipt->product_ref == false || $receipt->product_ref == '') {
					//$product = wc_get_product(NON_EXISTANT_ID);
					array_push($resp->not_found_products, $receipt);
				}
				else {
					$products = wc_get_products([
						'reference' => $receipt->product_ref,
						'limit' => 1
					]);
					if (count($products) > 0) {
						$product = $products[0];
					} else {
						//$product = wc_get_product(NON_EXISTANT_ID);
						array_push($resp->not_found_products, $receipt);
					}
				}
				
				if ($product) {
					$item_id = $wc_order->add_product($product, 1);
					wc_add_order_item_meta($item_id, 'size', $receipt->product_size);
					$item = $wc_order->get_items()[$item_id];
					$item->set_subtotal($receipt->price);
					$item->set_total($receipt->price);
					$item->save();
				}

				$wc_order->calculate_totals();
				$wc_order->save(); 

			}

			$resp->message = $created_receipts.' receipts created, '.count($resp->not_found_products).' products were not found.';
			$response = new WP_REST_Response($resp);
			$response->set_status(200);

		}

	} else {
		$resp->message = 'Receipts file is missing.';
			$response = new WP_REST_Response($resp);
			$response->set_status(400);

	}

    return $response;
}




function import_clients($request) {

	$task_id = $request['task_id'];
	$part = $request['part'];

	$resp = new stdClass;
	$resp->new_clients = [];
	$resp->existing_clients = [];

	$warnings = [];

	if (is_file(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json')) {
		$customers = json_decode(file_get_contents(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json'));

		foreach($customers as $customer) {

			$search_users = get_users(array(
				'meta_key' => 'customer_id',
				'meta_value' => $customer->customer_id
			));

			if (count($search_users) === 0) {
				$result = wp_create_user($customer->customer_id, 'iR67XWlt$', $customer->email);
				if(is_wp_error($result)){
					array_push($warnings, $result->get_error_message());
				} else{
					$exclude_cols = ['email'];

					foreach ($customer as $key=>$value) {
						if (!in_array($key, $exclude_cols)) {
							update_usermeta($result, $key, $value);
						}
					}
					update_usermeta($result, 'added_by', 'import');

					$user = new WP_User($result);
					$user->add_role('customer');

					array_push($resp->new_clients, $user);

				}
			} else {
				array_push($resp->existing_clients, $customer->customer_id);
			}
			

		}
		$resp->message = count($resp->new_clients).' clients created, '.count($resp->existing_clients).' clients already existing.';
		$resp->warnings = $warnings;
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	} else {
		$resp->message = 'File already done';
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	}
	return $response;
	
}

function update_clients($request) {
	
	$task_id = $request['task_id'];
	$part = $request['part'];

	$resp = new stdClass;
	$resp->updated_clients = [];
	$resp->not_found_clients = [];

	if (is_file(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json')) {
		$customers = json_decode(file_get_contents(ABSPATH.'data/'.$task_id.'/part-'.$part.'.json'));

		foreach($customers as $customer) {

			$search_users = get_users(array(
				'meta_key' => 'customer_id',
				'meta_value' => $customer->customer_id
			));

			if (count($search_users) >= 0) {
				$user = $search_users[0];
				
				$exclude_cols = ['customer_id', 'email'];

				foreach ($customer as $key=>$value) {
					if (!in_array($key, $exclude_cols)) {
						update_usermeta($result, $key, $value);
					}
				}

				update_usermeta($result, 'added_by', 'import');

				$user = new WP_User($result);
				$user->add_role('customer');

				array_push($resp->updated_clients, $user);

				
			} else {
				array_push($resp->not_found_clients, $customer->customer_id);
			}
			
		}
		$resp->message = count($resp->updated_clients).' clients updated, '.count($resp->not_found_clients).' were not found.';
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	} else {
		$resp->message = 'File already done';
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	}

	return $response;

	
}