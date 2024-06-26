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
			{
				if ($log == 'user-images')
					$this->userImages($this->url[1]);
				else
					$this->open($log);
			}
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

		public function open($parameters)
		{
			// servis ctrlVandalism çalışınca tetiklenmesi açıkları engellemiş olur.
			require_once "app/services/" . $this->url[1] . ".php";
			return new $this->url[1]($parameters);
		}

		public function userImages($file)
		{
			$extension = explode('.', $file);
			$extension = $extension[count($extension) - 1];
			if(file_exists(_FILE_DIR_ . $file)) {
				header("Content-type: image/$extension");
				passthru("cat " . _FILE_DIR_ . $file);
			} else
				header("HTTP/1.0 404 Not Found");

		}

		private function ctrlVandalism()
		{
			$req = new Request();
			// istek atıldı mı ?
			if (!isset($this->url) || $this->url[0] != "service")
			{
				// user-image
				if ($this->url[0] == 'user-images' && isset($this->url[1]))
					return "user-images";
				return false;
			}
			// service/<Servis adı> girildi mi ?
			else if (count($this->url) > 2)
			{
				return false;
			}
			// data var mı ? varsa nulldan farklı mı ve json mı ?
			else if (!isset($req->get["data"]) || $req->get["data"] == null)
			{
				return false;
			}
			// istekte bulunduğu servis var mı ?
			else if (!file_exists("app/services/" . $this->url[1] . ".php"))
				return false;

			if (base64_decode($req->get["data"])) {
				$data = json_decode(base64_decode(htmlspecialchars_decode($req->get["data"])), true);
				if (isset($data))
					return $data;
			}

			return json_decode(htmlspecialchars_decode($req->get["data"]), true);
		}

	}
