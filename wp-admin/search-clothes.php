<?php 

require_once 'admin.php';

$products = wc_get_products([
    'proposal' => 'true',
    'setup' => 'true',
    'limit' => -1
]);

foreach($products as $product) {
    //wcproduct_update_attribute($product->get_id(), 'setup', 'false');
    echo '<a href="post.php?post='.$product->get_id().'&action=edit" target="_blank">'.$product->get_name().'</a><br>';
}