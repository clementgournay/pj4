<?php

require_once '../../../../wp-admin/admin.php';
require_once 'functions.php';

$resp = new stdClass;

if (isset($_POST['user_id']) && isset($_POST['seller_id'])) {
    $rows = $_POST['rows'];

    foreach($rows as $row) {
        $productID = $row['productID'];
        $attributes = [
            'comment' => $row['comment']
        ];
        wcproduct_add_attributes($productID, $attributes);
    }

    $resp->rows = $rows;
}

echo json_encode($resp);