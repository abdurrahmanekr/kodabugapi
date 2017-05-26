<?php

session_start();
require '../vendor/autoload.php';
$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
		'determineRouteBeforeAppMiddleware' => false,
		'db' => [
			'driver' => 'mysql',
			'host' => 'HOST',
			'database' => 'DB_NAME',
			'username' => 'DB_USER',
			'password' => 'DB_PASSWORD',
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => '',
		]
	]
]);

require __DIR__ . '/containers.php';
require __DIR__ . '/../app/routes.php';