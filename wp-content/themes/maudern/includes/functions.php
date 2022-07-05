<?php

function wcproduct_add_attributes($productID, $arg_attributes) {
	$new_attributes = [];
	foreach($arg_attributes as $name=>$value) {
		array_push($new_attributes, [
			'name' => htmlspecialchars(stripslashes($name)),
			'value' => $value,
			'position' => 1,
			'is_visible' => 1,
			'is_variation' => 1,
			'is_taxonomy' => 0
		]);
	}

	$meta_attrs = get_post_meta($productID, '_product_attributes', true);
	$attributes = ($meta_attrs !== '') ? $meta_attrs : [];
	$attributes = array_merge($attributes, $new_attributes);
	update_post_meta($productID, '_product_attributes', $attributes);
}

function wcproduct_update_attribute($productID, $key, $value) {
	$product_attributes = get_post_meta($productID, '_product_attributes', true);
	$i = get_attr_index($product_attributes, $key);
	if ($i >= 0) {
		$product_attributes[$i]['value'] = $value;
		$resp->new_value = $product_attributes[$i]['value'];
		update_post_meta($productID, '_product_attributes', $product_attributes);
	}
	
}

function get_attr_index($attributes, $key) {

	$i = 0; $found = false;
	while (!$found && $i < count($attributes)) {
		$attr = $attributes[$i];
		if ($attr['name'] == $key) $found = true;
		else $i++;
	}
	
	return ($found) ? $i : -1;
}

