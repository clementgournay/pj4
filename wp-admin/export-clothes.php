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
    $image_id = $product->get_image_id();
    $url = wp_get_attachment_image_url( $image_id, 'full' );
    if ($url !== '') {
        if (!is_dir('export')) mkdir('export');
        file_put_contents('export/'.$product->get_attribute('reference').'.jpg', file_get_contents($url));
        array_push($formated_products, $formated_product);
    }
}

file_put_contents('export/clothes.json', json_encode($formated_products));