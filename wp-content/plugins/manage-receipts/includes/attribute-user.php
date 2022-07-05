<?php 

require_once '../../../../wp-admin/admin.php';

$resp = new stdClass;

if (isset($_GET['order_id'])) {

    $order_id = $_GET['order_id'];

    if (isset($_GET['remove']) && $_GET['remove'] == 'true') {
        delete_post_meta($order_id, '_customer_user');
        $resp->code = 200;
    } else {
        if (isset($_GET['user_id'])) {
            $user_id = intval($_GET['user_id']);
            $user = get_userdata($user_id)->data;
            $user->lastname = get_user_meta($user_id, 'lastname');
            $user->firstname = get_user_meta($user_id, 'firstname');
            update_post_meta($order_id, '_customer_user', $user_id);
            $resp->code = 200;
            $resp->data = $user;
        } else {
            $resp->code = 401;
        }
    }
    
} else {
    $resp->code = 401;
}

echo json_encode($resp);