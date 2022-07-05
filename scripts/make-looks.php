<?php 

require_once 'config.php';
require_once 'functions.php';

$category = 'cardigan';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SITE_URL.'/wp-json/wp/v2/products?category='.$category);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
curl_setopt($ch, CURLOPT_HEADER, 0);  
$result = curl_exec($ch);
curl_close($ch);

$data = json_decode($result);

$clothes = $data->clothes;
$looks = [];
switch ($category) {
    case 'coat':
    case 'vest':
        $looks = get_fullbody_looks($clothes);
        break;
    case 'top_tshirt':
    case 'shirt':
    case 'cardigan':
        $looks = get_torse_looks($clothes);
        break;
    case 'pants':
    case 'skirt':
    case 'short':
        $looks = get_legs_looks($clothes);
        break;
    case 'accessory':
        break;
    case 'jumpsuit':
        break;
}

var_dump($looks);