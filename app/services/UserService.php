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

			$user = new User();
			$query = $user
						->from()
						->join("username", array("usid" => "usid"))
						->where("user.usid = :id", array("id" => "5cf88c46942e1ee7f3ceecd22457f705"))
						->select(array(
							"usid" => "user.usid"
						))
						->execute(true); // tek data olduğu için true
			if (is_array($query))
			{
				$auth = $this->generateAuthKey();
				return array("auth" => $auth);
			}
			else if ($query->rowCount() == 0)
			{
			}
		}
	}