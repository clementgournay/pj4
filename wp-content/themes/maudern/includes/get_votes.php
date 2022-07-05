<?php 

/* Template name: Get votes script */
require_once 'wp-config.php';

$resp = new stdClass;

$user = wp_get_current_user();

$votes = get_user_meta($user->ID, 'votes', true);

$resp->votes = ($votes !== '') ? json_decode($votes) : new stdClass;
$resp->code = 200;

echo json_encode($resp);