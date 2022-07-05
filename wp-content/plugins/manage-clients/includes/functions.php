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

function wcproduct_set_attributes($post_id, $attributes) {
    $i = 0;
    foreach ($attributes as $name => $value) {
        $product_attributes[$i] = array(
            'name' => htmlspecialchars(stripslashes($name)),
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

function save_image($base64_img, $title) {

	// Upload dir.
	$upload_dir  = wp_upload_dir();
	$upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

	$img             = str_replace( 'data:image/png;base64,', '', $base64_img );
	$img             = str_replace( ' ', '+', $img );
	$decoded         = base64_decode( $img );
	$filename        = $title . '.jpeg';
	$file_type       = 'image/jpeg';
	$hashed_filename = md5( $filename . microtime() ) . '_' . $filename;

	// Save the image in the uploads directory.
	$upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );

	$attachment = array(
		'post_mime_type' => $file_type,
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
		'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
	);

    $attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );
    return $attach_id;
}