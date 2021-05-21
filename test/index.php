<?php

use SpireGG\OAuth2\Client\Provider\Twitch;

require '../vendor/autoload.php';

$config = [
    'clientId' => "",
    'clientSecret' => "",
    'redirectUri' => ""
];

$provider = new Twitch(
    $config
);

if (isset($_GET['code']) && $_GET['code']) {
    $token = $provider->getAccessToken("authorization_code", [
        'code' => $_GET['code']
    ]);

    $user = $provider->getResourceOwner($token);
    var_dump($user);


} else {
    header('Location: ' . $provider->getAuthorizationUrl());
}
