<?php
	
	class Service extends Database
	{
		function __construct() {}

		/**
		 * Gelen istek doğrultusunda kullanıcıya verilecek data çıkış yeridir.
		 * @param object $result
		*/
		public function response($result)
		{
			if ($result && $result != null)
				echo json_encode($result);
			else
			{
				$result = array("result" => -1);
				echo json_encode($result);
			}
		}

		public function generateAuthKey()
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			return md5(rand(0, strlen($characters) - 1) . uniqid());
		}

		public function generateUserId()
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			return md5(rand(0, strlen($characters) - 1) . uniqid());
		}
	}