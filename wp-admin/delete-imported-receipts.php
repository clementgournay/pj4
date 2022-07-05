<?php


require_once 'admin.php';

ini_set('max_execution_time', '0');

$search_orders = wc_get_orders(array(
    'limit'        => -1,
    'orderby'      => 'date',
    'order'        => 'DESC',
    'meta_key'     => 'added_by',
    'meta_value'   => 'import',
    'meta_compare' => '=',
));

$count = 1;

foreach ($search_orders as $order) {
    wp_delete_post($order->ID);
    $count++;
}

echo $count.' orders deleted.';

