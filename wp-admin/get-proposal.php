<?php 

require_once 'admin.php';

$products = wc_get_products([
    'proposal' => 'true',
    'limit' => -1
]);

var_dump(count($products));

$non_ready = [];
$ready = [];
foreach($products as $product) {
    if ($product->get_attribute('ready') !== 'true') array_push($non_ready, $product);
    else array_push($ready, $product);
}

/*
echo '<hr>';
echo 'Non ready: <br>';
var_dump(count($non_ready));
foreach($non_ready as $product) {
    wcproduct_update_attribute($product->get_id(), 'ready', 'true');
    echo '<a href="'.get_site_url().'/wp-admin/post.php?post='.$product->get_id().'&action=edit&message=1" target="_blank">'.$product->get_attribute('reference').' '.$product->get_name().'</a><br>';
}*/

foreach($products as $product) {
    $url = wp_get_attachment_image_url($product->get_image_id());
    if (!$url) {
        echo '<a href="'.get_site_url().'/wp-admin/post.php?post='.$product->get_id().'&action=edit&message=1" target="_blank">'.$product->get_attribute('reference').' '.$product->get_name().'</a><br>';

    }
}