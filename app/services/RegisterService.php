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
				$this->getTable("Log");
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
			{
				$this->saveLog($data, "", "", "R");
				return array("exist" => 1);
			}
			
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
			{
				if ($user->save())
				{
					if ($pass->save())
					{
						return array("exist" => 0, "auth" => $authKey);
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
			if (!isset($data["auth"]))
			{
				$this->saveLog($data);
				return false;
			}

			$user = new User();
			$user = $user
						->from()
						->where("user.auth = :auth", [
							"auth" => $data["auth"]
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
						$this->saveLog($data, $user["usid"], $data["auth"], "S");
						return array("result" => 1);
					}
					else
					{
						$this->saveLog($data, $user["usid"], $data["auth"], "E");
						return false;
					}
				}
				else
				{
					$this->saveLog($data, $user["usid"], $data["auth"], "E");
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
					$this->saveLog($data, $user["usid"], $data["auth"], "S");
				}
				else
				{
					$this->saveLog($data, $user["usid"], $data["auth"], "E");
					return false;
				}
			}

			if (isset($data["password"]))
			{
				$password = new Userpassword();
				$password->password = md5(md5($user["usid"] . "mustafa sandal ama kürekte yok") . $user["usid"] . "ne var ne yok dopin yoksa sana madalya yok" . $data["password"] . md5("kormada var gül diye sevdiğim dikende var"));
				if ($password->update("usid = :userid", ["userid" => $user["usid"]]))
				{
					$this->saveLog($data, $user["usid"], $data["auth"], "S");
				}
				else
				{
					$this->saveLog($data, $user["usid"], $data["auth"], "E");
					return false;
				}
				
			}

			return array("result" => 1);
		}

		private function uploadGame($data)
		{
			if (!isset($data["auth"]) ||
				!isset($data["question_name"]) ||
				!isset($data["question_type"]) ||
				!isset($data["question_option"]) ||
				!isset($data["question_true"]) ||
				empty(json_decode($data["question_option"])))
			{
				$this->saveLog($data, "", "", "R");
				return false;
			}
			$user = new User();
			$user = $user
						->from()
						->where("user.auth = :auth", [
							"auth" => $data["auth"]
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
			$question->qoption = $data["question_option"];
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
							$this->saveLog($data, $user["usid"], $data["auth"], "S");
							
							$questionfile = new Questionfile();
							$questionfile->qid = $question->qid;
							$questionfile->fid = $fileId;
							if ($questionfile->save())
							{
								$this->saveLog($data, $user["usid"], $data["auth"], "S");
								return array("result" => 1);
							}
							
							$this->saveLog($data, $user["usid"], $data["auth"], "E");
							return false;
						}
						else
						{
							$this->saveLog($data, $user["usid"], $data["auth"], "E");
							return false;
						}
					}
					else
					{
						$this->saveLog($data, $user["usid"], $data["auth"], "E");
						return false;
					}
				}
				$this->saveLog($data);
				return array("result" => 1);
			}
			else
			{
				$this->saveLog($data);
				return array("result" => 1);
			}
		}
	}