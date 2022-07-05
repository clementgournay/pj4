<?php 
/* Template name: Share look script */
$resp = new stdClass;


require_once 'wp-config.php';
    
$dir = ABSPATH . 'wp-content/uploads/looks';

if (isset($_POST['img'])) {
    if (!is_dir($dir)) mkdir($dir);
    $id = uniqid();
    $path = $dir.'/'.$id.'.png';
    file_put_contents($path, file_get_contents($_POST['img']));
    $resp->code = 200;
    $resp->id = $id;
    $resp->imgURL = get_site_url().'/looks/?id='.$id;
} else {
    $resp->code = 400;
    $resp->message = 'Le paramètre image n\'a pas été défini correctement.';
}


echo json_encode($resp);
