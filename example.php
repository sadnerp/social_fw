<?php

require_once 'vkapi.class.php';

$app = new vkapi();
$app->proxy = '192.168.0.2:3128';

/**
 * @see https://oauth.vk.com/authorize?client_id=3382849&scope=offline&display=page&response_type=token
 */
$app->access_token = "user token";


$current_user  = $app->usersGet();

var_dump($current_user);

?>