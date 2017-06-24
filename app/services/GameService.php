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
				$this->getTable("Game");
				$this->getTable("Username");

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
									"qoption" => "qoption",
									"qtype" => "qtype",
								])
								->execute(true);
				if (!is_array($query))
				{
					$this->saveLog($data, "", "", "E");
					return false;
				}

				$query["qoption"] = json_decode($query["qoption"]);

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
			$_SESSION["questionId"] = $query["qid"];
			$_SESSION["gameRequest"] = false;
			return 1;
		}

		private function getTrueOption($data)
		{
			if (time() - $_SESSION["timeout"] <= _MAX_GAME_TIMEOUT_ && $_SESSION["gameRequest"] == true && $_SESSION["questionId"] && isset($data["session_ticket"]) && isset($data["try"]))
			{
				$question = new Question();
				$query = $question
								->from()
								->where("question.qid = :qid", [
									"qid" => $_SESSION["questionId"]
								])
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

		private function getGameList($data)
		{
			$sticket = $data["session_ticket"] ? $data["session_ticket"] : null;
			if ($sticket == null)
				return false;

			$game = new Game();
			$query = $game
						->from()
						->join("user", ["gusid" => "usid"])
						->join(["rivaluser" => "user"], ["grivalid" => "usid"])
						->where("user.sticket = :sticket", [
							"sticket" => $sticket
						])
						->select([
							"gid" => "game.gid",
							"gusid" => "user.usmail",
							"grivalid" => "rivaluser.usmail",
							"uspoint" => "game.uspoint",
							"rivalpoint" => "game.rivalpoint",
							"gmaxpoint" => "game.gmaxpoint"
						])
						->execute();
			if (is_array($query))
				return $query;
			return false;
		}

		private function startGame($data)
		{
			$sticket = $data["session_ticket"] ? $data["session_ticket"] : null;
			if ($sticket == null)
				return false;
			$user = new User();
			$user = $user
						->from()
						->where("user.sticket = :sticket", [
							"sticket" => $sticket
						])
						->select([
							"usid" => "usid"
						])
						->execute(true);
			if (!is_array($user))
				return false;
			if (!isset($data["usid"]))
			{
				$rival = new User();
				$rival = $rival
							->from()
							->join("username", array("usid" => "usid"))
							->where("user.usid != :userId", array(
								"userId" => $user["usid"]
							))
							->orderBy("RAND()")
							->limit(1)
							->select(array(
								"usid" => "user.usid",
								"usmail" => "user.usmail",
								"usname" => "username.usname"
							))
							->execute(true);
				if (is_array($rival))
				{
					$game = new Game();
					$game->gid = $this->generateAuthKey();
					$game->gusid = $user["usid"];
					$game->grivalid = $rival["usid"];
					$game->uspoint = 0;
					$game->rivalpoint = 0;
					$game->gmaxpoint = 0;
					if (!$game->save())
						return false;
					else
						return array("gid" => $game->gid, "rival" => isset($rival["usname"]) ? $rival["usname"] : $rival["usmail"]);
				}
				return false;
			}
			else
			{
				$rival = new User();
				$rival = $rival
							->from()
							->join("username", array("usid" => "usid"))
							->where("user.usmail = :usname OR username.usname = :usname", array(
								"usname" => $data["usid"]
							))
							->select(array(
								"usid" => "user.usid",
								"usmail" => "user.usmail",
								"usname" => "username.usname"
							))
							->execute(true);
				if (is_array($rival))
				{
					$game = new Game();
					$game->gid = $this->generateAuthKey();
					$game->gusid = $user["usid"];
					$game->grivalid = $rival["usid"];
					$game->uspoint = 0;
					$game->rivalpoint = 0;
					$game->gmaxpoint = 0;
					if (!$game->save())
						return false;
					else
						return array("gid" => $game->gid, "rival" => isset($rival["usname"]) ? $rival["usname"] : $rival["usmail"]);
				}
				return false;
			}
		}
	}
