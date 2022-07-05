<?php

require_once '../../../../wp-admin/admin.php';

$resp = new stdClass;

if (isset($_POST['id'])) {
    $lookID = $_POST['id'];
    $post = get_post($lookID);
    if ($post->post_author == wp_get_current_user()->ID) {
        wp_delete_post($lookID);
        $resp->code = 200;
    } else {
        $resp->code = 401;
    }
} else {
    $resp->code = 400;
}

echo json_encode($resp);