<?php
require_once('vendor/autoload.php');
$settings = parse_ini_file('settings.ini');

$data = simplexml_load_file(__DIR__ . '/YML_sample.xml');
$category = $data->shop->categories->category;



if (count($category) <= 0) {
  return;
}


$publicID = -198351262;
$vk = new VK\Client\VKApiClient();

$arCategories = $vk->market()->getAlbums($settings['access_token'], 
  [
    'owner_id' => $publicID,
    'offset' => 0,
    'count' => 100
  ]
);

?>