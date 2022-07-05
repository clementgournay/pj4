<?php 

require_once 'admin.php';

$products = wc_get_products([
    'limit' => -1,
    'proposal' => 'true'
]);

foreach($products as $product) {
    $url = wp_get_attachment_image_url($product->get_image_id());
    mkdir('export');
    file_put_contents('export/'.$product->get_attribute('reference').'.jpg', file_get_contents($url));
}