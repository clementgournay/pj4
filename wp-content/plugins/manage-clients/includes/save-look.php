<?php 

require_once '../../../../wp-admin/admin.php';
require_once 'functions.php';

$resp = new stdClass;

if (isset($_POST['user_id']) && isset($_POST['img'])) {

    $category = get_term_by('slug', 'look', 'product_cat');
    $cat_id = $category->term_id;
    $products = (isset($_POST['products'])) ? $_POST['products'] : [];
    $img = $_POST['img'];
    $product_ids = [];

    foreach($products as $product) {
        array_push($product_ids, $product['id']);
    }

    // If look update
    if (isset($_POST['id']) && $_POST['id'] !== '') {

        $productID = intval($_POST['id']);
        
        $product = wc_get_product($productID);
        $product->set_children($product_ids);
        $product->save();

        $media_id = save_image($img, 'Look');
        set_post_thumbnail($productID, $media_id);

        $product_attributes = get_post_meta($productID ,'_product_attributes', true);

        if (isset($_POST['submit']) && $_POST['submit']!== '') {
            for ($i = 0; $i < count($product_attributes); $i++) {
                $attr = $product_attributes[$i];
                switch ($attr['name']) {
                    case 'confirm_status':
                        $product_attributes[$i]['value'] = 'pending';
                        break;
                }
            }
        }

        $list = [];
        for ($i = 0; $i < count($product_attributes); $i++) {
            $attr = $product_attributes[$i];
            array_push($list, $attr);
            switch ($attr['name']) {
                case 'transforms':
                    $product_attributes[$i]['value'] = json_encode($products);
                    break;
            }
        }

        update_post_meta($productID, '_product_attributes', $product_attributes);

        $resp->code = 200;
        $resp->list = $list;
        $resp->id = $productID;
        $resp->products = $products;
        $resp->attributes = $product_attributes;

    } else { // If look creation

        $userID = $_POST['user_id'];
        $sellerID = wp_get_current_user()->ID;
        
        $target_user = get_user_by('id', $userID);

        $product = new WC_Product_Grouped();
        $product->set_name('Look suggéré pour '.$target_user->display_name);
        $product->set_status('publish');
        $product->set_category_ids([$cat_id]);
        $product->set_children($product_ids);
        $product->save();

        $productID = $product->get_id();

        $media_id = save_image($img, 'Look');
        set_post_thumbnail($productID, $media_id);

        $attributes = [
            'confirm_status' => 'draft',
            'target_user' => $userID,
            'transforms' => json_encode($products)
        ];
        wcproduct_add_attributes($productID, $attributes);
        
        $resp->id = $productID;
        $resp->products = $products;
        $resp->code = 200;
    }
   
} else {
    $resp->code = 401;
}

echo json_encode($resp);