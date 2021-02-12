<?php

require_once('vendor/autoload.php');

$settings = parse_ini_file('settings.ini');




$oauth = new VK\OAuth\VKOAuth();
$client_id = $settings['client_id'];
$client_secret = $settings['secret_state_code'];
$redirect_uri =  $settings['redirect_uri'];
$display = VK\OAuth\VKOAuthDisplay::PAGE;
$scope = [
  VK\OAuth\Scopes\VKOAuthUserScope::WALL, 
  VK\OAuth\Scopes\VKOAuthUserScope::GROUPS, 
  VK\OAuth\Scopes\VKOAuthUserScope::MARKET // доступ к товарам
];
$state = $settings['secret_state_code'];
$code = $settings['code'];

$browser_url = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);

?>


<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ссылка получения токена</title>
</head>
<body>
  <a href="<?= $browser_url; ?>">Авторизация</a>
</body>
</html>