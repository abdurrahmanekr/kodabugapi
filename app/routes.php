<?php

$app->get('/', function(){
	echo 'API\'ye hoşgeldin!';
});

$app->get('/UserController/', 'UserController');
$app->get('/RegisterController/', 'RegisterController');
$app->get('/GameController/', 'GameController');