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
				$this->getTable("Point");
				$this->getTable("Log");
				$this->getTable("File");

				// varsa çağır çıktısını işleme koy
				$this->response($this->$method($this->parameters));
			}
			else
				$this->response(null);
		}

		private  function getUserVCard($data)
		{
			$userId = isset($data["usid"]) ? $data["usid"] : null;
			if (!$userId)
				return null;
			if (!isset($data["session_ticket"]))
			{
				$this->saveLog($data);
				return false;
			}

			$meUser = new User();
			$meUser = $meUser
						->from()
						->where("user.sticket = :sticket", [
							"sticket" => $data["session_ticket"]
						])
						->select([
							"usid" => "usid"
						])
						->execute(true);
			if (!is_array($meUser))
				return false;


			$user = new User();
			$query = $user
						->from()
						->join("username", array("usid" => "usid"))
						->join("point", array("usid" => "usid"))
						->where("user.usmail = :id OR username.usname = :id", array(
							"id" => $userId
						))
						->select(array(
							"copo" => "copo",
							"hepo" => "hepo",
							"bugpo" => "bugpo",
							"fipo" => "fipo",
							"keypo" => "keypo",
							"usname" => "user.usname",
							"surname" => "user.surname",
							"uspoint" => "user.uspoint",
							"birth" => "user.birth",
							"usmail" => "user.usmail",
							"usid" => "user.usid",
							"username" => "username.usname"
						))
						->execute(true); // tek data olduğu için true
			if (is_array($query))
			{
				$file = new File();
				$photo = $file
							->from()
							->where("usid = :id AND ffunction = :type", array(
								"id" => $query["usid"],
								"type" => "P"
							))
							->select(array(
								"fid" => "fid",
								"ftype" => "ftype"
							))
							->execute(true);
				if (is_array($photo) && file_exists(_FILE_DIR_ . $photo["fid"] . "." . $photo["ftype"]))
					$photo = _SITE_URL_ . "/user-images/" . $photo["fid"] . "." . $photo["ftype"];
				else
					$photo = "";

				$result = array(
					"copo" => $query["copo"],
					"hepo" => $query["hepo"],
					"bugpo" => $query["bugpo"],
					"fipo" => $query["fipo"],
					"keypo" => $query["keypo"],
					"usname" => $query["usname"],
					"surname" => $query["surname"],
					"uspoint" => $query["uspoint"],
					"username" => $query["username"],
					"usid" => $userId,
					"photo" => $photo
				);

				// kendi ise özel bilgilerini gönder
				if ($query["usid"] == $meUser["usid"]) {
					$result["birth"] = $query["birth"];
					$result["usmail"] = $query["usmail"];
				}
				return $result;
			}
			return false;
		}

		private  function loginUser($data)
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
								"pass" => md5(md5($userId . "--kodabug--" . $userId . "--kodabug--" . $password))
							))
							->select(array(
								"usid" => "usid"
							))
							->execute(true);
				if (is_array($query))
				{
					// kullanıcı authkey yeniliyor
					$sticket = $this->generateAuthKey();
					$user->sticket = $sticket;
					$user->update("usid = :usid", array(
						"usid" => $userId
					));

					return array(
						"username" => 1,
						"password" => 1,
						"session_ticket" => $sticket
					);
				}
				else return array(
						"username" => 1,
						"password" => -1
					);
			}
			else return array(
					"username" => -1,
					"password" => -1
				);
		}
	}
