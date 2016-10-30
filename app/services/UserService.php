<?php
	
	/**
	* @author: Abdurrahman Eker
	* date : 12.10.2016
	* time: 22:04 - 10:04 PM
	*/
	class UserService extends Service
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
				$this->getTable("Userpassword");
				
				// varsa çağır çıktısını işleme koy
				$this->response($this->$method($this->parameters));
			}
			else
				$this->response(null);
		}

		public function getUserVCard($data)
		{
			$userId = isset($data["usid"]) ? $data["usid"] : null;
			if (!$userId)
				return null;

			$user = new User();
			$query = $user
						->from()
						->join("point", array("usid" => "usid"))
						->where("user.usid = '$userId'")
						->select(array(
							"usid" => "usid",
							"copo" => "copo",
							"hepo" => "hepo",
							"bugpo" => "bugpo",
							"fipo" => "fipo",
							"keypo" => "keypo"

						))
						->execute(true); // tek data olduğu için true
			if ($query == null)
				return $user->query;

			
			$result = array();
			foreach ($query as $item)
				array_push($result, $item);
			return $result;
		}

		public function loginUser($data)
		{
			$userId = isset($data["usname"]) ? $data["usname"] : null;
			if (!$userId)
				return null;
			$password = $data["password"];
			$user = new User();
			$query = $user
						->from()
						->join("username", array("usid" => "usid"))
						->where("user.usid = :id OR user.usmail = :id OR username.usname = :id", array(
							"id" => $userId
						))
						->select(array(
							"usid" => "user.usid"
						))
						->execute(true); // tek data olduğu için true
			
			if (is_array($query))
			{
				$userId = $query["usid"];
				$userpassword = new Userpassword();
				$query = $userpassword
							->from()
							->where("userpassword.usid = :id && userpassword.password = :pass", array(
								"id" => $userId,
								"pass" => md5(md5($userId . "mustafa sandal ama kürekte yok") . $userId . "ne var ne yok dopin yoksa sana madalya yok" . $password . md5("kormada var gül diye sevdiğim dikende var"))
							))
							->select(array(
								"usid" => "usid"
							))
							->execute(true);
				if (is_array($query))
				{
					// kullanıcı authkey yeniliyor
					$auth = $this->generateAuthKey();
					$user->auth = $auth;
					$user->update("usid = :usid", array(
						"usid" => $userId
					));
					return array(
						"username" => 1,
						"password" => 1,
						"auth" => $auth
					);
				}
				else if ($query->rowCount() == 0) 
					return array(
						"username" => 1,
						"password" => -1
					);
			}
			else if ($query->rowCount() == 0)
				return array(
					"username" => -1,
					"password" => -1
				);
		}
	}