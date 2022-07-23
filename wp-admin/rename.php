<?php 

require_once 'admin.php';
$path = '../../S3/normal';
$folder = scandir($path);

foreach($folder as $file) {

    if ($file !== '.' && $file !== '..') {
        $ref = str_replace('.png', '', $file);
        $products = wc_get_products([
            "reference" => $ref
        ]);
        if (count($products) >= 0) {
            var_dump($products[0]);
            
            //copy($path.'/'.$file, $path.'/'.$products[0]->get_id().'png');
        }
    }
}