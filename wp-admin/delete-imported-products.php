<?php

require_once 'admin.php';

ini_set('max_execution_time', '0');

$attribute_name = 'added_by';
$attribute_value = 'import';
$serialized_value = serialize('name').serialize($attribute_name).serialize('value').serialize($attribute_value); 
$products_search = new WP_Query(array(
    'post_type'      => array('product'),
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key'     => '_product_attributes',
            'value'   => $serialized_value,
            'compare' => 'LIKE'
        ),
    ),
));


$count = 1;
foreach($products_search->posts as $post) {
    wp_delete_post($post->ID);
    $count++;
}

echo $count.' products deleted.';


