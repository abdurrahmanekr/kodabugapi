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
				$this->getTable("Userpassword");

				// varsa çağır çıktısını işleme koy
				$this->response($this->$method($this->parameters));
			}
			else
				$this->response(null);
		}

		private function register($data)
		{
			// user tablosu
			$user = new User();
			$user->usname = $data["usname"];
			$user->surname = $data["surname"];
			$user->usmail = $data["usmail"];
			$user->uspoint = 0; 
			$user->birth = $data["birth"];
			$query = $user
						->from()
						->join("username", array("usid" => "usid"))
						->where("user.usmail = :mail", array(
							"mail" => $data["usmail"]
						))
						->select(array(
							"usid" => "user.usid"
						))
						->execute(true); // tek data olduğu için true
			
			if (is_array($query))
				return array("exist" => 1);
			
			$userId = $this->generateUserId();
			// use session
			$authKey = $this->generateAuthKey();
			$user->usid = $userId;
			$user->auth = $authKey;
			
			$pass = new Userpassword();
			$pass->usid = $userId;

			$pass->password = md5(md5($userId . "mustafa sandal ama kürekte yok") . $userId . "ne var ne yok dopin yoksa sana madalya yok" . $data["password"] . md5("kormada var gül diye sevdiğim dikende var"));

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
					if ($pass->save())
						return array("result" => array("usid" => $userId, "auth" => $authKey));
		}

		private function updateProfile($data)
		{
			# code...
		}

		private function uploadGame($data)
		{
			# code...
		}
	}