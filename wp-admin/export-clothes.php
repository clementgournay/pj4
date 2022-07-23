<?php

require_once 'admin.php';

define('S3_PATH', '../../S3/thumbnail');
define('PRODUCT_DATA_PATH', '../product-data');

$products = wc_get_products([
    'proposal' => 'true',
    'limit' => -1
]);

$formated_products = [];

foreach($products as $product) {
    $formated_product = format_product($product);
    $image_id = $product->get_image_id();
    $path = get_attached_file($image_id, 'full');
    if ($path !== '') {
        if (!is_dir(PRODUCT_DATA_PATH)) mkdir(PRODUCT_DATA_PATH);
        if (!is_dir(S3_PATH)) mkdir(S3_PATH);
        copy($path, S3_PATH.'/'.$product->get_id().'.jpg');
        array_push($formated_products, $formated_product);
    }
}

file_put_contents(PRODUCT_DATA_PATH.'/products.json', json_encode($formated_products));