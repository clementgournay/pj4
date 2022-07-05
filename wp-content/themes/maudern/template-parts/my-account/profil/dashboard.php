<?php 
require_once 'init.php';
define('PAGE', 'dashboard');

$user = wp_get_current_user();
define('USER_ID', $user->ID);

get_template_part('template-parts/my-account/parts/nav');
get_template_part('template-parts/my-account/parts/dashboard');
?>

