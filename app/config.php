<?php

	error_reporting(E_NOTICE^E_ALL);

	if (isset($_SERVER['HTTP_ORIGIN'])) {
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 86400');
	}

	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
			header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
			header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

		exit(0);
	}

	date_default_timezone_set("Europe/Moscow");
	define("_MODE_", "release"); // release - debug
	// define("_MODE_", "debug"); // release - debug
	if (_MODE_ == "release") {

		define("_SITE_URL_", "http://api.kodabug.net");
		define("_FILE_DIR_", __DIR__ . "/uploads/");
		define("_HOST_NAME_", "localhost");
		define("_DB_NAME_", "kodabug");
		define("_DB_USER_", "root");
		define("_DB_PASSWORD_", "apo58apo");

	} else {

		define("_SITE_URL_", "http://localhost/kodabug");
		define("_FILE_DIR_", __DIR__ . "/uploads/");
		define("_HOST_NAME_", "localhost");
		define("_DB_NAME_", "kodabug");
		define("_DB_USER_", "root");
		define("_DB_PASSWORD_", "1234");
	}

	/* GAME */
	define("_MAX_GAME_TIMEOUT_", 25);
