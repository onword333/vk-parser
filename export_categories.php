<?php
require_once('vendor/autoload.php');
$settings = parse_ini_file('settings.ini');
$publicID = -198351262;
$vk = new VK\Client\VKApiClient();







$vkMarket = $vk->market();
$a = 0;
$data = [];
$offset = 0;
while (true) {
  $param = ['offset' => $offset, 'count' => 100];
  $categories = $vkMarket->getCategories($settings['access_token'], $param);

  foreach ($categories['items'] as $item) {
    $id = $item['id'];
    $name = $item['name'];
    $idSection = $item['section']['id'];
    $nameSection = $item['section']['name'];
    $data[] = [
      'id_section' => $idSection, 
      'name_section' => $nameSection,
      'id' => $id,
      'name' => $name
    ];
    $offset++;
  }

  if (count($categories['items']) <= 0) {
    break;
  }
}

saveToCSV('categories.csv', $data);


function saveToCSV($filename, $data, string $mode = 'a') {
  $separate = ';';
  // open the file or create
  $file = fopen($filename, $mode);

  // save the column headers
  if (filesize($filename) < 1) {
    if (count($data) > 0) {
      $colums = array_keys($data[0]);
      fputcsv($file, $colums, $separate);
    }
  }

  // save each row of the data
  foreach ($data as $row) {
    fputcsv($file, $row, $separate);
  }

  fclose($file);
}

?>