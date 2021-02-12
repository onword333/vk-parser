<?php
require_once('vendor/autoload.php');
$settings = parse_ini_file('settings.ini');

$client_id = $settings['client_id'];
$client_secret = $settings['secret_state_code'];
$redirect_uri =  $settings['redirect_uri'];
$code = '';

if (!empty($_GET['code'])) {
  $code = $_GET['code'];
  $oauth = new VK\OAuth\VKOAuth();
  $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
  
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Завершение получения токена</title>
</head>

<body>
  Токен: <?= $response['access_token']; ?><br>
  Время жизни: <?= $response['expires_in']; ?>

  <? if (!empty($response['access_token'])) { ?>
    <p style="color: green; font-weight: bold;">Токен получен успешно</p>
    <? saveSettingValue('settings.ini', 'access_token', $response['access_token']); ?>
  <? } else { ?>
    <p style="color: red; font-weight: bold;">Токен НЕ получен</p>
  <? } ?>
</body>

</html>

<?

function saveSettingValue(string $filename, string $parametr, string $newValue) {
  $contents = file_get_contents($filename);

  $pattern = '/(' . $parametr . ') = (.*)/';
  $replacement = '${1} = ' . $newValue; 

  $updatedConfig = preg_replace($pattern, $replacement, $contents);

  $fh = fopen($filename, "w");
  fwrite($fh, $updatedConfig);
}
?>