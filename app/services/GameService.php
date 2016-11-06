<?php
	
	/**
	* @author: Abdurrahman Eker
	* date : 06.11.2016
	* time: 13:15 - 01:15 PM
	*/
	class GameService extends Service
	{
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
				$this->getTable("Question");
				$this->getTable("Log");

				// varsa çağır çıktısını işleme koy
				$this->response($this->$method($this->parameters));
			}
			else
				$this->response(null);
		}

		private function getGame($data)
		{
			$_SESSION["gameRequest"] = true;
			if (time() - $_SESSION["timeout"] <= _MAX_GAME_TIMEOUT_ && $_SESSION["questionId"])
			{
				$question = new Question();
				$query = $question
								->from()
								->where("qid = :qid", ["qid" => $_SESSION["questionId"]])
								->select([
									"qname" => "qname",
									"qoption" => "qoption"
								])
								->execute(true);
				if (!is_array($query))
				{
					$this->saveLog($data, "", "", "E");
					return false;
				}

				return $query;
			}
			else
			{
				$this->saveLog($data, "", "", "E");
				$_SESSION["questionId"] = null;
				$_SESSION["gameRequest"] = false;
				return false;
			}
		}

		private function getRandomGame($data)
		{
			$_SESSION["timeout"] = time();
			$question = new Question();
			$query = $question
							->from()
							->orderBy("RAND()")
							->limit(1)
							->select([
								"question.*"
							])
							->execute(true);
			if (!is_array($query))
			{
				$this->saveLog($data, "", "", "E");
				return false;
			}
			print_r($query);
			$_SESSION["questionId"] = $query["qid"];
			$_SESSION["gameRequest"] = false;
			return 1;
		}

		private function getTrueOption($data)
		{
			if (time() - $_SESSION["timeout"] <= _MAX_GAME_TIMEOUT_ && $_SESSION["gameRequest"] == true && $_SESSION["questionId"])
			{
				$question = new Question();
				$query = $question
								->from()
								->where("qid = :qid", ["qid" => $_SESSION["questionId"]])
								->select([
									"qtrue" => "qtrue"
								])
								->execute(true);
				if (!is_array($query))
				{
					$this->saveLog($data, "", "", "E");
					return false;
				}

				$_SESSION["questionId"] = null;
				return $query["qtrue"];
			}
			else
			{
				$this->saveLog($data, "", "", "E");
				$_SESSION["questionId"] = null;
				$_SESSION["gameRequest"] = false;
				return false;
			}
		}

	}