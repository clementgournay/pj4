<?php 
if (!isset($_GET['user_id'])) header('Location: ./admin.php?page=manage_clients');
$userID = $_GET['user_id'];
define('USER_ID', $userID);
require_once 'parts/client-actions.php'; 
?>