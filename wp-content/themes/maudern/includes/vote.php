<?php 

/* Template name: Vote script */
require_once 'wp-config.php';
require_once 'functions.php';

$resp = new stdClass;

$user = wp_get_current_user();

if (isset($_POST['ID']) && isset($_POST['vote']) && isset($_POST['action'])) {
    $lookID = intval($_POST['ID']);
    $vote = $_POST['vote']; 
    $action = $_POST['action'];
    $look = wc_get_product($lookID);
    $logged = is_user_logged_in();

    if ($look->get_attribute($vote) === '') {
        wcproduct_add_attributes($lookID, [
            $vote => 1
        ]);
        $resp->new_value = $value;
    } else {
        $value = intval($look->get_attribute($vote));
        $value = ($action === 'add') ? $value+1 : $value-1;
        $resp->value = $value;
        wcproduct_update_attribute($lookID, $vote, $value);
    }

    if ($logged) {
        $user_votes = get_user_meta($user->ID, 'votes', true);
        $user_votes = ($user_votes === '') ? new stdClass : json_decode($user_votes);

        if ($action === 'add') {
            $user_votes->$lookID = $vote;
        } else {
            unset($user_votes->$lookID);
        }

        update_usermeta($user->ID, 'votes', json_encode($user_votes));
        
        $resp->code = 200;
        $resp->votes = $user_votes;

    } else {
        $resp->code = 200;
    }


} else {
    $resp->code = 400;
}

echo json_encode($resp);