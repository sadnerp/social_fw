<?php

require_once 'vkapi.class.php';

$app = new vkapi();
$app->setProxy('255.255.255.0', '3128');
$app->setAccessToken("user token");/*
	https://oauth.vk.com/authorize?client_id=3382849&scope=offline&display=page&response_type=token
	*/

$current_user  = $app->usersGet();

var_dump($current_user);

?>