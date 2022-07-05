<?php

$resp = new stdClass;

if (isset($_POST['product_id'])) {
    $resp->code = 200;
} else {
    $resp->code = 400;
}

echo json_encode($resp);