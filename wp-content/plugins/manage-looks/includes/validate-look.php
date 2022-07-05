<?php 

require_once '../../../../wp-admin/admin.php';

$resp = new stdClass;

if (isset($_POST['id']) && $_POST['id'] !== '') {

    $productID = intval($_POST['id']);
    
    $product = wc_get_product($productID);
    $product_attributes = get_post_meta($productID ,'_product_attributes', true);

    for ($i = 0; $i < count($product_attributes); $i++) {
        $attr = $product_attributes[$i];
        switch ($attr['name']) {
            case 'confirm_status':
                $product_attributes[$i]['value'] = 'pending';
                break;
        }
    }
    update_post_meta($productID, '_product_attributes', $product_attributes);

    $resp->code = 200;
    $resp->id = $productID;
    $resp->attributes = $product_attributes;
   
} else {
    $resp->code = 401;
}

echo json_encode($resp);