<?php

	class Router
	{
		public $url;

		function __construct()
		{
			$this->getUrl();
			$this->open();
		}

		public function getUrl() {
	        $this->url = isset($_GET["url"]) ? $_GET["url"] : null;
	        if ($this->url != null) {
	            $this->url = rtrim($this->url, "/");
	            $this->url = explode("/", $this->url);
	        } else {
	            unset($this->url);
	        }
	    }

	    public function open()
	    {
	    	// Alınan servis gerçekten varmı ?
	    	if (isset($this->url[0]) && isset($this->url[1])) {
    			if (file_exists("app/services/" . $this->url[1] . ".php")) {
					// varsa dahil et ve çalıştır.
					include "app/services/" . $this->url[1] . ".php";
					new $this->url[1]();
				}
	    	}
	    }
	}