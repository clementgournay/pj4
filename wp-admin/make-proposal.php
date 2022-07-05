<?php 

require_once 'admin.php';

$products = wc_get_products([
    'limit' => -1,
    'ready' => 'true'
]);

foreach($products as $product) {
    if ($product->get_attribute('proposal') === '') {
        wcproduct_add_attributes($product->get_id(), [
            'proposal' => 'true',
            'setup' => 'true',
            'ready' => 'true'
        ]);

    }
}