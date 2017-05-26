<?php

$config = $app->getContainer();
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($config['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$config['db'] = function($config) use ($capsule){
	return $capsule;
};

$config['UserController'] = function(){
	return new \App\Controllers\UserController;
};

$config['RegisterController'] = function(){
	return new \App\Controllers\RegisterController;
};

$config['GameController'] = function(){
	return new \App\Controllers\GameController;
};