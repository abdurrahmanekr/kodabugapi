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
	}