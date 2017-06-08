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
				$this->getTable("Log");
				$this->getTable("Userpassword");
				$this->getTable("Username");
				$this->getTable("File");
				$this->getTable("Question");
				$this->getTable("Questionfile");

				// varsa çağır çıktısını işleme koy
				$this->response($this->$method($this->parameters));
			}
			else
				$this->response(null);
		}

		private function register($data)
		{
			if (!isset($data["usname"]) ||
				!isset($data["surname"]) ||
				!isset($data["usmail"]) ||
				!isset($data["password"]))
			{
				$this->saveLog($data, "", "", "R");
				return false;
			}
			$birth = new DateTime($data["birth"]);
		    if (!$birth)
				return false;

			// user tablosu
			$user = new User();
			$user->usname = $data["usname"];
			$user->surname = $data["surname"];
			$user->usmail = $data["usmail"];
			$user->uspoint = 0;
			$user->birth = $birth->format('Y-m-d');
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
			{
				$this->saveLog($data, "", "", "R");
				return array("exist" => 1);
			}

			$userId = $this->generateUserId();
			// use session
			$authKey = $this->generateAuthKey();
			$user->usid = $userId;
			$user->sticket = $authKey;

			$pass = new Userpassword();
			$pass->usid = $userId;

			$pass->password = md5(md5($userId . "--kodabug--" . $userId . "--kodabug--" . $data["password"]));

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
			{
				if ($user->save())
				{
					if ($pass->save())
					{
						return array("exist" => 0, "session_ticket" => $authKey);
					}
					else
					{
						$this->saveLog($data, $userId, $authKey, "E");
						return false;
					}
				}
				else
				{
					$this->saveLog($data, $userId, $authKey, "E");
					return false;
				}
			}
			else
			{
				$this->saveLog($data, $userId, $authKey, "E");
				return false;
			}
		}

		private function updateProfile($data)
		{
			if (!isset($data["session_ticket"]))
			{
				$this->saveLog($data);
				return false;
			}

			$user = new User();
			$user = $user
						->from()
						->where("user.sticket = :sticket", [
							"sticket" => $data["session_ticket"]
						])
						->select([
							"usid" => "usid"
						])
						->execute(true);
			if (!is_array($user))
			{
				$this->saveLog($data);
				return false;
			}

			if (isset($data["password"]) &&
				isset($data["newpassword"]))
			{
				$userId = $user["usid"];
				$password = new Userpassword();
				$password->password = md5(md5($userId . "--kodabug--" . $userId . "--kodabug--" . $data["password"]));
				$user = $password
							->from()
							->where("userpassword.usid = :id && userpassword.password = :pass", array(
								"id" => $userId,
								"pass" => $password->password
							))
							->select(array(
								"usid" => "usid"
							))
							->execute(true);

				if (is_array($user)) {
					$password->password = md5(md5($userId . "--kodabug--" . $userId . "--kodabug--" . $data["newpassword"]));

					if ($password->update("usid = :userid", ["userid" => $userId]))
					{
						$this->saveLog($data, $userId, $data["session_ticket"], "S");
						return 1;
					}

				} else {
					$this->saveLog($data, $userId, $data["session_ticket"], "E");
					return false;
				}

			}

			if (isset($data["username"]))
			{
				$username = new Username();
				$name = $username
							->from()
							->where("username.usname = :username", [
								"username" => $data["username"]
							])
							->select([
								"usid" => "usid"
							])
							->execute(true);
				if (is_array($name))
				{
					if ($name["usid"] != $user["usid"])
					{
						// alınmış kullanıcı id tekrar kullanılamaz
						return false;
					}
				}
				else
				{
					$username->usid = $user["usid"];
					$username->usname = $data["username"];

					// kişi daha önceden almış mı
					$name = $username
								->from()
								->where("username.usid = :usid", [
									"usid" => $user["usid"]
								])
								->select([
									"usid" => "usid"
								])
								->execute(true);
					if (is_array($name)) {
						// güncelle
						if(!$username->update("usid = :userid", ["userid" => $user["usid"]]))
							return false;
					} else {
						// kaydet
						if (!$username->save())
							return false;
					}
				}
			}


			$req = new Request();
			$fData = $req->files["file"];
			// file upload var mı ?
			if (count($fData) > 0)
			{
				$fileId = $this->generateAuthKey();

				$filePath = _FILE_DIR_ . $fileId . ".". pathinfo($fData["name"])["extension"];
				if (move_uploaded_file($fData["tmp_name"], $filePath))
				{
					$file = new File();
					$file->fid = $fileId;
					$file->usid = $user["usid"];
					$file->fname = $fData["name"];
					$file->ftype = pathinfo($fData["name"])["extension"];
					$file->ffunction = "P";
					$file->fpath = $filePath;
					if ($file->save())
					{
						$this->saveLog($data, $user["usid"], $data["session_ticket"], "S");
						return 1;
					}
					else
					{
						$this->saveLog($data, $user["usid"], $data["session_ticket"], "E");
						return false;
					}
				}
				else
				{
					$this->saveLog($data, $user["usid"], $data["session_ticket"], "E");
					return false;
				}
			}

			if (isset($data["usname"]) ||
				isset($data["surname"]) ||
				isset($data["usmail"]) ||
				isset($data["birth"]))
			{
				$upgradeUser = new User();
				$upgradeUser->usname = isset($data["usname"]) ? $data["usname"] : null;
				$upgradeUser->surname = isset($data["surname"]) ? $data["surname"] : null;
				$upgradeUser->usmail = isset($data["usmail"]) ? $data["usmail"] : null;
				$upgradeUser->birth = isset($data["birth"]) ? $data["birth"] : null;

				if ($upgradeUser->update("usid = :userid", ["userid" => $user["usid"]]))
				{
					$this->saveLog($data, $user["usid"], $data["session_ticket"], "S");
				}
				else
				{
					$this->saveLog($data, $user["usid"], $data["session_ticket"], "E");
					return false;
				}
			}

			return 1;
		}

		private function uploadGame($data)
		{
			if (!isset($data["session_ticket"]) ||
				!isset($data["question_name"]) ||
				!isset($data["question_type"]) ||
				!isset($data["question_option"]) ||
				!isset($data["question_true"]) ||
				!intval($data["question_type"]) != 0 ||
				!is_array($data["question_option"]))
			{
				$this->saveLog($data, "", "", "R");
				return false;
			}
			$user = new User();
			$user = $user
						->from()
						->where("user.sticket = :sticket", [
							"sticket" => $data["session_ticket"]
						])
						->select([
							"usid" => "usid"
						])
						->execute(true);
			if (!is_array($user))
			{
				$this->saveLog($data);
				return false;
			}

			$question = new Question();
			$question->qid = $this->generateAuthKey();
			$question->qusid = $user["usid"];
			$question->qname = $data["question_name"];
			$question->qtype = $data["question_type"];
			$question->qoption = json_encode($data["question_option"]);
			$question->qtrue = $data["question_true"];
			$question->qfrequency = 0;

			if ($question->save())
			{
				$req = new Request();
				$fData = $req->files["file"];
				// file upload var mı ?
				if (count($fData) > 0)
				{
					$fileId = $this->generateAuthKey();

					$filePath = _FILE_DIR_ . $fileId . ".". pathinfo($fData["name"])["extension"];
					if (move_uploaded_file($fData["tmp_name"], $filePath))
					{
						$file = new File();
						$file->fid = $fileId;
						$file->usid = $user["usid"];
						$file->fname = $fData["name"];
						$file->ftype = pathinfo($fData["name"])["extension"];
						$file->ffunction = "P";
						$file->fpath = $filePath;
						if ($file->save())
						{
							$this->saveLog($data, $user["usid"], $data["session_ticket"], "S");

							$questionfile = new Questionfile();
							$questionfile->qid = $question->qid;
							$questionfile->fid = $fileId;
							if ($questionfile->save())
							{
								$this->saveLog($data, $user["usid"], $data["session_ticket"], "S");
								return array("exist" => 0, "question_id" => $question->qid);
							}

							$this->saveLog($data, $user["usid"], $data["session_ticket"], "E");
							return false;
						}
						else
						{
							$this->saveLog($data, $user["usid"], $data["session_ticket"], "E");
							return false;
						}
					}
					else
					{
						$this->saveLog($data, $user["usid"], $data["session_ticket"], "E");
						return false;
					}
				}
				$this->saveLog($data);
				return array("exist" => 0, "question_id" => $question->qid);
			}
			else
			{
				$this->saveLog($data);
				return false;
			}
		}
	}
