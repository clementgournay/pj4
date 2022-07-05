<?php

require_once 'admin.php';

$id = 28033;

$wc_order = wc_get_order($id);
$wc_order->add_meta_data('user_specific', true);
$wc_order->save();