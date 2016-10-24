<?php
	
	/**
	* @author: Abdurrahman Eker
	* date : 16.10.2016
	* time: 22:10 - 10:10 PM
	*/
	class RegisterService extends Service
	{
		public $parameters;

		function __construct($parameters)
		{
			// UserService içine atılmış istekleri parameter içine atıyoruz.
			$this->parameters = $parameters;
			$method = isset($this->parameters["method"]) ? $this->parameters["method"] : null;
			// method var mı yok mu ?
			if (isset($method) && method_exists($this, $method))
			{
				// serviste kullanılacak tablolar çekiliyor
				$this->getTable("User");
				$this->getTable("Point");
				
				// varsa çağır çıktısını işleme koy
				$this->response($this->$method($this->parameters));
			}
			else
				$this->response(null);
		}

		public function register($data)
		{
			$userId = $this->generateUserId();
			// user tablosu
			$user = new User();
			$user->usid = $userId;
			$user->name = $data["name"];
			$user->surname = $data["surname"];
			$user->uspoint = 0; 
			$user->birth = $data["birth"];

			// kullanıcı puanı
			$point = new Point();
			$point->usid = $userId;
			$point->copo = 0;
			$point->hepo = 0;
			$point->bugpo = 0;
			$point->fipo = 0;
			$point->keypo = 0;
			$point->last = 0;

			if ($point->save())
				if ($user->save())
					return array("result" => array("usid" => $userId, "auth" => ""));
		}
	}