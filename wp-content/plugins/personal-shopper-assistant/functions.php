<?php

define('DATA_PATH', ABSPATH.'data');
if (!is_dir(DATA_PATH)) mkdir(DATA_PATH);
if (!is_file(DATA_PATH.'/tasks.json')) file_put_contents(DATA_PATH.'/tasks.json', '[]');
if (!is_file(DATA_PATH.'/done.json')) file_put_contents(DATA_PATH.'/done.json', '[]');
if (!is_file(DATA_PATH.'/look-blacklist.json')) file_put_contents(DATA_PATH.'/look-blacklist.json', '[]');
define('CALIBRATION_URL', 'http://localhost/gear/cloth-snap');

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

add_filter('woocommerce_product_data_store_cpt_get_products_query', 'custom_search', 10, 2);

function custom_search($query, $query_vars) {
    if (!empty($query_vars['proposal'])) {
		$attribute_name = 'proposal';
		$attribute_value = $query_vars['proposal'];
		$serialized_value = serialize('name').serialize($attribute_name).serialize('value').serialize($attribute_value); 
		$query['meta_query'][] = array(
			'key'     => '_product_attributes',
			'value'   => $serialized_value,
			'compare' => 'LIKE'
		);
	}
	if (!empty($query_vars['reference'])) {
		$attribute_name = 'reference';
		$attribute_value = $query_vars['reference'];
		$serialized_value = serialize('name').serialize($attribute_name).serialize('value').serialize($attribute_value); 
		$query['meta_query'][] = array(
			'key'     => '_product_attributes',
			'value'   => $serialized_value,
			'compare' => 'LIKE'
		);
	}
	if (!empty($query_vars['ready'])) {
		$attribute_name = 'ready';
		$attribute_value = $query_vars['ready'];
		$serialized_value = serialize('name').serialize($attribute_name).serialize('value').serialize($attribute_value); 
		$query['meta_query'][] = array(
			'key'     => '_product_attributes',
			'value'   => $serialized_value,
			'compare' => 'LIKE'
		);
	}
	if (!empty($query_vars['setup'])) {
		$attribute_name = 'setup';
		$attribute_value = $query_vars['setup'];
		$serialized_value = serialize('name').serialize($attribute_name).serialize('value').serialize($attribute_value); 
		$query['meta_query'][] = array(
			'key'     => '_product_attributes',
			'value'   => $serialized_value,
			'compare' => 'LIKE'
		);
	}
	if (!empty($query_vars['brand'])) {
		$attribute_name = 'brand';
		$attribute_value = $query_vars['brand'];
		$serialized_value = serialize('name').serialize($attribute_name).serialize('value').serialize($attribute_value); 
		$query['meta_query'][] = array(
			'key'     => '_product_attributes',
			'value'   => $serialized_value,
			'compare' => 'LIKE'
		);
	}
	if (!empty($query_vars['color'])) {
		$attribute_name = 'color';
		$attribute_value = $query_vars['color'];
		$serialized_value = serialize('name').serialize($attribute_name).serialize('value').serialize($attribute_value); 
		$query['meta_query'][] = array(
			'key'     => '_product_attributes',
			'value'   => $serialized_value,
			'compare' => 'LIKE'
		);
    }
    return $query;
}

function create_new_user($request) {
	$resp = new stdClass;
	$body = $request->get_json_params();
	$resp->errors = [];
	if (!isset($body['lastname']) || count($body['lastname']) < 3 || count($body['lastname']) > 20) {
		array_push($resp->errors, 'Le Nom doit être compris entre 3 et 20 charactères.');
	}
	if (!isset($body['firstname']) || count($body['firstname']) < 3 || count($body['firstname']) > 20) {
		array_push($resp->errors, 'Le Nom doit être compris entre 3 et 20 charactères.');
	}
	if (!isset($body['email']) || !validate_email($body['email'])) {
		array_push($resp->errors, 'Le Nom doit être compris entre 3 et 20 charactères.');
	}

	if (count($resp->errors) === 0) {
		$resp->user = $body;
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	} else {
		$resp->message = 'Invalid form';
		$response = new WP_REST_Response($resp);
		$response->set_status(400);
	}


	return $response;
}

function format_product($wc_product) {
	$product = new stdClass;
	$product->id = $wc_product->get_id();
	$terms = get_the_terms($product->id, 'product_cat');
	$cat = (count($terms) > 0) ? $terms[0]->slug : 'unknown';

	$product->name = $wc_product->get_name();
	$product->brand = $wc_product->get_attribute('brand');
	$product->reference = $wc_product->get_attribute('reference');
	$product->composition = $wc_product->get_attribute('composition');
	$product->category = $cat;
	$product->org_category = $wc_product->get_attribute('org_category');
	$product->size_range = $wc_product->get_attribute('size_range');
	$product->image = wp_get_attachment_url($wc_product->get_image_id());
	$gallery_ids = $wc_product->get_gallery_image_ids();
	$product->gallery = [];
	foreach($gallery_ids as $id) {
		array_push($product->gallery, wp_get_attachment_url($id));
	}
	$product->price = $wc_product->get_price();
	$product->sale_price = $wc_product->get_attribute('sale_price');
	$product->cut = $wc_product->get_attribute('cut');
	$product->sleeve = $wc_product->get_attribute('sleeve');
	$product->neck = $wc_product->get_attribute('neck');
	$product->length = $wc_product->get_attribute('length');
	$product->proposal = $wc_product->get_attribute('proposal');
	$product->advices = $wc_product->get_attribute('advices');
	$product->origin = $wc_product->get_attribute('origin');
	$product->setup = $wc_product->get_attribute('setup');
	$product->ready = $wc_product->get_attribute('ready');
	$product->color = $wc_product->get_attribute('color');
	$product->collection = $wc_product->get_attribute('collection');


	return $product;
}

function get_products_of_category($request) {
	$categories = explode(',', $request['category']);
	$resp = new stdClass;
	$products = [];


	$args = [
		'category' => $categories,
		'limit' => -1,
		'ready' => 'true'
	];
	$wc_products = wc_get_products($args);
	
	foreach($wc_products as $wc_product) {
		$product = format_product($wc_product);
		array_push($products, $product);
	}

	$resp->data = $products;
	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;

}

function get_products_by_category($request) {

	$category = $request['category'];
	$resp = new stdClass;
	$categories = [];
	switch($category) {
		case 'vest':
		case 'coat':
			$categories = ['top_tshirt', 'shirt', 'cardigan', 'skirt', 'pants', 'short', 'accessory'];
			break;
		case 'top_tshirt':
		case 'shirt':
		case 'cardigan':
			$categories = ['vest', 'coat', 'skirt', 'pants', 'short', 'accessory'];
			break;
		case 'pants':
		case 'skirt':
		case 'short':
			$categories = ['vest', 'coat', 'top_tshirt', 'shirt', 'cardigan', 'accessory'];
			break;
		case 'jumpsuit':
			$categories = ['vest', 'coat', 'accessory'];
			break;
		case 'accessory':
			$categories = ['top_tshirt', 'shirt', 'cardigan', 'skirt', 'pants', 'short', 'vest', 'coat'];
			break;
	}


	$cat = get_term_by('slug', 'clothes', 'product_cat');
	$terms = get_terms('product_cat', array('child_of' => $cat->term_id, 'hide_empty' => false));

	$ids = [];

	$found = false; $i = 0;

	foreach($categories as $cat) {
		while (!$found && $i < count($terms)) {
			if ($terms[$i]->slug == $cat) $found = true;
			else $i++;
		}
		if ($found) array_push($ids, $terms[$i]->term_id);
	}
	 
	$wc_products = wc_get_products([
		'category' => $categories,
		'limit' => -1,
		'brand' => 'dika',
		'ready' => 'true',
		'proposal' => 'true'
	]);
	
	$clothes = new stdClass;

	foreach($wc_products as $wc_product) {
		$product = format_product($wc_product);
		$cat = $product->category;
		if (!isset($clothes->$cat)) $clothes->$cat = [];
		array_push($clothes->$cat, $product);
	}

	$resp->clothes = $clothes;

	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}


function get_clothes($request) {

	$resp = new stdClass;

	$args = [
		'limit' => -1,
		'proposal' => 'true',
		'category'  => array('clothes')
	];

	if (isset($request['setup'])) $args['setup'] = $request['setup'];
	if (isset($request['ready'])) $args['ready'] = $request['ready'];

	$resp->args = $args;

	$wc_products = wc_get_products($args);
	
	$resp->products = [];

	foreach($wc_products as $wc_product) {

		$terms = get_the_terms($wc_product->id, 'product_cat');
		$cat = (count($terms) > 0) ? $terms[0]->slug : 'unknown';

		if ($cat !== 'accessory') {
			$product = format_product($wc_product);
			array_push($resp->products, $product);
		}
	}

	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}


function get_specific_clothes($request) {

	$resp = new stdClass;
	$args = [
		'limit' => -1,
		'proposal' => 'true'
	];

	if (isset($request['category'])) {
		$categories = explode(',', $request['category']);
		$args['category'] = $categories;
	}

	if ($categories[0] !== 'accessory') {
		$args['proposal'] = 'true';
	}

	if (isset($request['color'])) {
		$args['color'] = $request['color'];
	}

	if (isset($request['brand'])) {
		$args['brand'] = $request['brand'];
	}

	$wc_products = wc_get_products($args);
	
	$resp->clothes = [];
	$resp->args = $args;

	foreach($wc_products as $wc_product) {

		$terms = get_the_terms($wc_product->id, 'product_cat');
		$cat = (count($terms) > 0) ? $terms[0]->slug : 'unknown';

		//if ($cat !== 'accessory') {
			$product = format_product($wc_product);
			array_push($resp->clothes, $product);
		//}
	}

	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}

function clothes_setup($request) {

	$resp = new stdClass;

	ini_set('memory_limit', '1000M');

	$body = $request->get_json_params();

	$ref = $body['reference'];

	$attrs = [
		'setup' => 'true',
		'cut' => $body['cut']
	];

	if(isset($body['sleeve'])) $attrs['sleeve'] = $body['sleeve'];
	if(isset($body['neck'])) $attrs['neck'] = $body['neck'];
	if(isset($body['length'])) $attrs['length'] = $body['length'];

	$products = wc_get_products([
		'reference' => $ref,
		'limit' => 1
	]);

	$wc_product = $products[0];	
	$url = wp_get_attachment_url($wc_product->get_image_id());
	$uploads = wp_upload_dir();
	$file_path = str_replace($uploads['baseurl'], $uploads['basedir'], $url);

    $img = new Imagick($file_path);
    $img->transparentPaintImage('rgb(255,255,255)', 0, 2000, false);
    $img->trimImage(0);
    $img->setImageFormat('png');
    $img->writeImage(ABSPATH.'/../cloth-snap/assets/images/clothes/'.$ref.'.png');
    $img->destroy();

	wcproduct_add_attributes($wc_product->get_id(), $attrs);

	$resp->image = ABSPATH.'/../cloth-snap/assets/images/clothes/'.$ref.'.png';
	$resp->ref = $ref;
	$resp->message = 'OK';
	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}


function clothes_attribute($request) {
	$resp = new stdClass;

	$reference = $request['reference'];
	$attr = $request['attribute'];
	$value = $request['value'];

	$resp->attr = $attr;
	$resp->value = $value;

	$products = wc_get_products([
		'reference' => $reference,
		'limit' => 1
	]);

	wcproduct_update_attribute($products[0]->get_id(), $attr, $value);

	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}

function get_suggestions($request) {
	$resp = new stdClass;
	$user_id = $request['user_id'];
	$seller_id = $request['seller_id'];
	$all_suggested_looks = get_user_meta($user_id, 'suggested_looks', true);
	if ($all_suggested_looks === '') $all_suggested_looks = [];
	$suggested_looks = [];
	foreach($all_suggested_looks as $look) {
		if ($look->seller_id == $seller_id) array_push($suggested_looks, $look);
	}
	$resp->data = $suggested_looks;
	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}

function get_suggested_looks($request) {
	$resp = new stdClass;
	$user_id = $request['user_id'];
	$suggestions = get_user_meta($user_id, 'suggested_looks', true);
	if ($suggestions === '') $suggestions = [];
	$looks = [];
	foreach($suggestions as $suggestion) {
		$products = explode('-', $suggestion->products);
		$look = [];
		foreach($products as $productID) {
			$wc_product = wc_get_product($productID);
			$terms = get_the_terms($productID, 'product_cat');
			$cat = (count($terms) > 0) ? $terms[0]->slug : 'unknown';
			$product = new stdClass;
			$product->id = $wc_product->get_id();
			$product->name = $wc_product->get_name();	
			$product->brand = $wc_product->get_attribute('brand');
			$product->reference = $wc_product->get_attribute('reference');
			$product->origin = $wc_product->get_attribute('origin');
			$product->composition = $wc_product->get_attribute('composition');
			$product->category = $cat;
			$product->org_category = $wc_product->get_attribute('org_category');
			$product->size_range = $wc_product->get_attribute('size_range');
			$product->image = wp_get_attachment_url($wc_product->get_image_id());
			$gallery_ids = $wc_product->get_gallery_image_ids();
			$product->gallery = [];
			foreach($gallery_ids as $id) {
				array_push($product->gallery, wp_get_attachment_url($id));
			}
			$product->price = $wc_product->get_price();
			$product->sale_price = $wc_product->get_attribute('sale_price');
			array_push($look, $product);
		}
		array_push($looks, $look);
	}
	$resp->data = $looks;
	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}


function send_suggestion_look($request) {

	$user_id = $request['user_id'];
	$body = $request->get_json_params();
	$look = $body['look'];
	$seller_id = $body['seller_id'];
	$resp = new stdClass;

	$suggested_looks = get_user_meta($user_id, 'suggested_looks', true);
	if ($suggested_looks === '') $suggested_looks = [];

	$messages = get_user_meta($user_id, 'messages', true);
	if ($messages === '') $messages = [];

	$new_look = new stdClass;
	$new_look->seller_id = $seller_id;
	$new_look->status = $status;
	$new_look->products = $look;
	array_push($suggested_looks, $new_look);
	$message = new stdClass;
	$message->seller_id = $seller_id;
	$message->look = $look;
	$message->text = 'Votre personal shopper vous suggère un nouveau look.';
	array_push($messages, $message);

	update_user_meta($user_id, 'suggested_looks', $suggested_looks);
	update_user_meta($user_id, 'messages', $messages);

	$resp->data = $suggested_looks;
	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}

function remove_suggestion_look($request) {

	$user_id = $request['user_id'];
	$body = $request->get_json_params();
	$look = $body['look'];
	$resp = new stdClass;

	$suggested_looks = get_user_meta($user_id, 'suggested_looks', true);
	if ($suggested_looks === '') $suggested_looks = [];

	$messages = get_user_meta($user_id, 'messages', true);
	if ($messages === '') $messages = [];

	$i = 0; $found = false; 
	while(!$found && $i < count($suggested_looks)) {
		if ($suggested_looks[$i]->products === $look) $found = true;
		else $i++;
	}
	if ($found) {
		array_splice($suggested_looks, $i, 1);

		$x = 0; $found_message = false;
		while($found_message && $x < count($messages)) {
			if ($messages[$x]->look === $look) $found_message = true;
			else $x++;
		}
		if ($found_message) {
			array_splice($messages, $x, 1);
		}

		update_user_meta($user_id, 'suggested_looks', $suggested_looks);
		update_user_meta($user_id, 'messages', $messages);
		$resp->data = $suggested_looks;
		$response = new WP_REST_Response($resp);
		$response->set_status(200);
	} else {
		$response = new WP_REST_Response($resp);
		$response->set_status(404);
	}

	return $response;
}

function get_favorite_looks($request) {
	$resp = new stdClass;
	$user_id = $request['user_id'];
	$for = $request['for'];
	$all_favorites = get_user_meta($user_id, 'favorites', true);
	if ($all_favorites === '') $all_favorites = [];
	$favorites = [];
	foreach($all_favorites as $favorite) {
		if ($favorite->for === $for || !isset($request['for'])) {
			array_push($favorites, $favorite);
		}
	}
	$resp->data = $favorites;
	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}

function like_look($request) {
	$resp = new stdClass;
	$body = $request->get_json_params();
	$look = $body['look'];
	$user_id = $body['user_id'];
	$for = $body['for'];

	$lookID = '';
	$i = 0;
	foreach($look as $product) {
		$lookID .= $product['id'];
		if ($i < count($look) - 1) $lookID .= '-';
		$i++;
	}

	$favorites = get_user_meta($user_id, 'favorites', true);
	if ($favorites === '') $favorites = [];

	$i = 0; $found = false; 
	while(!$found && $i < count($favorites)) {
		if ($favorites[$i]->lookID === $lookID) $found = true;
		else $i++;
	}
	if (!$found) {
		$favorite = new stdClass;
		$favorite->lookID = $lookID;
		$favorite->look = $look;
		if (isset($body['for'])) $favorite->for = $for;
		array_push($favorites, $favorite);
		update_user_meta($user_id, 'favorites', $favorites);
		$resp->message = 'ok';
		$resp->data = $favorites;
	} else {
		$resp->message = 'Already liked';
	}

	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}

function remove_favorite_look($request) {
	$resp = new stdClass;
	$body = $request->get_json_params();
	$look_id = $request['look_id'];
	$user_id = $request['user_id'];

	$favorites = get_user_meta($user_id, 'favorites', true);
	if ($favorites === '') $favorites = [];

	$i = 0; $found = false; 
	while(!$found && $i < count($favorites)) {
		if ($favorites[$i]->lookID === $look_id) $found = true;
		else $i++;
	}
	if ($found) {
		array_splice($favorites, $i, 1);
		update_user_meta($user_id, 'favorites', $favorites);
		$resp->message = 'ok';
		$resp->data = $favorites;
		
	} else {
		$resp->message = 'Already disliked.';
		$resp->data = $favorites;
	}
	
	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}

function dislike_look ($request) {
	$resp = new stdClass;
	$look_id = $request['look_id'];
	$blacklist_path = DATA_PATH.'/look-blacklist.json';
	
	$blacklist = json_decode(file_get_contents($blacklist_path));

	$exists = array_search($look_id, $blacklist);
	if ($exists < 0 || $exists === false) {
		array_push($blacklist, $look_id);
		file_put_contents($blacklist_path, json_encode($blacklist, JSON_PRETTY_PRINT));
	} else {
		$resp->message = 'Already added';
	}

	$resp->data = $blacklist;
	$response = new WP_REST_Response($resp);
	$response->set_status(200);
	return $response;
}