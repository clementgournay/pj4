<?php 

require_once '../../../../wp-admin/admin.php';

$resp = new stdClass;

$search = (isset($_GET['search'])) ? $_GET['search'] : '';

$users_query = new WP_User_Query( array(
    'search'         => '*'.esc_attr($search).'*',
    'search_columns' => array(
        'user_login',
        'user_nicename',
        'user_email',
        'user_url',
    ),
) );
$users = $users_query->get_results();

foreach($users as $user) {
    $user->firstname = get_user_meta($user->ID, 'firstname', true);
    $user->lastname = get_user_meta($user->ID, 'lastname', true);
}

$resp->code = 200;
$resp->data = $users;

echo json_encode($resp);