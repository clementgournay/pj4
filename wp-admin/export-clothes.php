<?php

require_once 'admin.php';

$products = wc_get_products([
    'proposal' => 'true',
    'ready' => 'true',
    'setup' => 'true',
    'limit' => -1
]);

$formated_products = [];

foreach($products as $product) {
    $formated_product = format_product($product);
    $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($formated_product->get_id());
    array_push($formated_products, $formated_product);
}