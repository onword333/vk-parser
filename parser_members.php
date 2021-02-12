<?php

require_once('vendor/autoload.php');

$phones = [];

$settings = parse_ini_file('settings.ini');

$vk = new VK\Client\VKApiClient();

$offset = 0;

while (true) {
  $members = $vk->groups()->getMembers($settings['access_token'], [
    //'group_id'  => [44557600],
    'group_id' => ['top_ali_shmot'],
    'fields' => ['contacts'],
    'offset' => $offset
  ]);
    
  foreach ($members['items'] as $member) {
    if (!empty($member['mobile_phone'])) {
      $phoneFormat = preg_replace('/[^0-9]/', '', $member['mobile_phone']);
      if (strlen($phoneFormat) >= 10) {
        $phones[] = $phoneFormat;
        echo $member['id'] . ' phone: ' . $phoneFormat . PHP_EOL;
      }
    }
  }

  file_put_contents('phones.txt', implode(PHP_EOL, $phones));

  $offset += count($members['items']);

  if ($members['count'] <= $offset) {
    break;
  }
}

echo $offset . PHP_EOL;

/*
$users = $vk->users()->get($settings['access_token'], [
  // 'user_ids'  => [367225543],
  'user_ids' => $response['items'],
  'fields' => ['contacts']
]);

foreach ($users as $user) {
  if (!empty($user['mobile_phone'])) {
    echo $user['id'] . ' phone: ' . $user['mobile_phone'] . PHP_EOL;
  }
}
*/


$a = 0;

?>
