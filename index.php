<?php

	/**
	 * @author Abdurrahman Eker
	 * date: 12.10.2016
	 * time: 21:21 - 09:21 PM
	 */
	session_start();
	ob_start();

	// Servisin ayarlarının bulunduğu dosyayı include ediyor
	require_once __DIR__ . "/app/config.php";


	// Tüm sistem çalıştırmak için gerekli dosyaları include yapıyor
	function __autoload($className) {
		require_once __DIR__ . "/system/" . $className . ".php";
	}

	// sitenin yönlendirmelerini başlamasını yönetiyor
	$router = new Router();
	ob_flush();
