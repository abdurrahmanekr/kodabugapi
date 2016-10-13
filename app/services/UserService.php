<?php
	
	/**
	* @author: Abdurrahman Eker
	* date : 12.10.2016
	* time: 22:04 - 10:04 PM
	*/
	class UserService
	{
		public $parameter;

		function __construct() {
			// UserService içine atılmış istekleri parameter içine atıyoruz.
			$this->parameter = new Request();

			$this->getUserVCard();
		}

		public function getUserVCard()
		{
			if (isset($this->parameter->get["data"])) {
				$data = base64_decode($this->parameter->get["data"]);

				$data = json_decode($data, true);

				if (!$data) {
					echo "boş";
				} else {
					print_r($data);
				}
			}
		}
	}