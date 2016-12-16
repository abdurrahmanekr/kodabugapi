<?php

	class Router
	{
		public $url;

		function __construct()
		{
			$this->getUrl();
			// vandalizm (saldırı) kontrolü yapılıyor. bkz: [1.1.1]
			$log = $this->ctrlVandalism();
			// Debug modunda önemlidir!
			new Database();
			if ($log)
				$this->open($log);
			else
				echo "Not-Authorised";
		}

		public function getUrl()
		{
			$this->url = isset($_GET["url"]) ? $_GET["url"] : null;
			if ($this->url != null)
			{
				$this->url = rtrim($this->url, "/");
				$this->url = explode("/", $this->url);
			}
			else
				unset($this->url);
		}

		// 1.2.1
		public function open($parameters)
		{
			// servis ctrlVandalism çalışınca tetiklenmesi açıkları engellemiş olur.
			require_once "app/services/" . $this->url[1] . ".php";
			return new $this->url[1]($parameters);
		}

		// 1.1.1
		private function ctrlVandalism()
		{
			$req = new Request();
			// istek atıldı mı ?
			if (!isset($this->url) || $this->url[0] != "service") 
			{
				return false;
			}
			// service/<Servis adı> girildi mi ?
			else if (count($this->url) > 2)
			{
				return false;
			}
			// data var mı ? varsa nulldan farklı mı ve json mı ?
			else if (!isset($req->get["data"]) || $req->get["data"] == null || json_decode(base64_decode($req->get["data"]), true) == null)
			{
				return false;
			}
			// istekte bulunduğu servis var mı ?
			else if (!file_exists("app/services/" . $this->url[1] . ".php"))
				return false;
			
			return json_decode(base64_decode($req->get["data"]), true);
		}
	}
