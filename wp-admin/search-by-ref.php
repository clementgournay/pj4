<?php


require 'admin.php';

$ref = $_GET['reference'];

$products = wc_get_products(array(
    'limit' => -1,
    'reference' => $ref
));

foreach($products as $product) {
    echo '<a href="'.get_site_url().'/wp-admin/post.php?post='.$product->get_id().'&action=edit" target="_blank">'.$product->get_name().'</a><br>';
}