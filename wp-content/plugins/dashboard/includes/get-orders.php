<?php


require_once '../../../../wp-admin/admin.php';

$resp = new stdClass;

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    $search_orders = wc_get_orders( array(
        'limit' => -1,
        'date_paid' => $start_date.'...'.$end_date,
    ));

    $orders = [];

    foreach($search_orders as $order) {
        $new_order = new stdClass;
        $new_order->total = $order->get_total();
        $new_order->date = $order->get_date_paid();
        $new_order->items = [];
        foreach($order->get_items() as $item) {
            $new_item = new stdClass;
            $new_item->name = $item['name'];
            $new_item->total = $item->get_total();
            $new_item->product_id = $product_id;
            $product_id = $item['product_id'];
            $product = new WC_Product($product_id);
            $new_item->category = $product->get_attribute('category');
            array_push($new_order->items, $new_item);
        }
        array_push($orders, $new_order);
    }

    $resp->data = $orders;
    $resp->code = 200;

} else {
    $resp->code = 400;
}



echo json_encode($resp);