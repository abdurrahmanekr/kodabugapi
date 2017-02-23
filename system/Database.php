<?php

	class Database extends Linq
	{
		public $db;

		function __construct()
		{
			try
			{
				// debug modunda çalışılması tavsiye edilir, canlıya geçildiğinde performans kaybına neden olur
				$this->db = new PDO("mysql:host=". _HOST_NAME_ .";charset=utf8", _DB_USER_, _DB_PASSWORD_);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->query("CREATE DATABASE IF NOT EXISTS ". _DB_NAME_);
				$this->db->query("use ". _DB_NAME_);

				$this->load();
				foreach (explode(";", $this->query) as $key => $value)
					if ($value)
						$this->db->exec($value);

				// new KosUp($this->db);
			}
			catch ( PDOException $e )
			{
				print $e->getMessage();
			}
		}

		public function load()
		{
			$this->query = "";
			$this
				->create("confirmation", array(
					"qid" => "INT NOT NULL",
					"conf" => "ENUM('X', '')"
				))
				->create("follow", array(
					"usid" => "VARCHAR(255) NOT NULL",
					"fusid" => "INT NOT NULL"
				))
				->create("game", array(
					"gid" => "VARCHAR(255) NOT NULL PRIMARY KEY",
					"gusid" => "VARCHAR(255) NOT NULL",
					"grivalid" => "VARCHAR(255) NOT NULL",
					"uspoint" => "INT NOT NULL",
					"rivalpoint" => "INT NOT NULL",
					"gmaxpoint" => "INT NOT NULL"
				))
				->create("presentation", array(
					"usid" =>  "VARCHAR(255)",
					"qid" =>  "INT",
					"prdate" =>  "VARCHAR (20)"
				))
				->create("question", array(
					"qid" => "VARCHAR(255) NOT NULL PRIMARY KEY",
					"qusid" => "VARCHAR(255) NOT NULL",
					"qname" => "VARCHAR (255) NOT NULL",
					"qtype" => "INT NOT NULL",
					"qoption" => "TEXT NOT NULL",
					"qtrue" => "INT NOT NULL",
					"qfrequency" => "INT NOT NULL"
				))
				->create("type", array(
					"qtype" => "INT NOT NULL",
					"tpname" => "VARCHAR (255)"
				))
				->create("user", array(
					"usid" => "VARCHAR(255) NOT NULL PRIMARY KEY",
					"usname" => "VARCHAR (255)",
					"surname" => "VARCHAR (255)",
					"usmail" => "VARCHAR(320)", // {64}@{255} '.url dahil'
					"uspoint" => "INT NOT NULL",
					"birth" => "VARCHAR (20)",
					"sticket" => "VARCHAR(255)"
				))
				->create("winner", array(
					"gid" =>  "VARCHAR(255) NOT NULL PRIMARY KEY",
					"usid" =>  "VARCHAR(255) NOT NULL",
					"windate" =>  "VARCHAR(20)"
				))
				->create("point", array(
					"usid" => "VARCHAR(255) NOT NULL PRIMARY KEY",
					"copo" => "INT NOT NULL",
					"hepo" => "INT NOT NULL",
					"bugpo" => "INT NOT NULL",
					"fipo" => "INT NOT NULL",
					"keypo" => "INT NOT NULL",
					"last" => "VARCHAR(20)"
				))
				->create("username", array(
					"usid" => "VARCHAR(255) NOT NULL PRIMARY KEY",
					"usname" => "VARCHAR(255) NOT NULL UNIQUE"
				))
				->create("userpassword", array(
					"usid" => "VARCHAR(255) NOT NULL PRIMARY KEY",
					"password" => "VARCHAR(255) NOT NULL"
				))
				->create("log", array(
					"lgid" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"lgdate" => "VARCHAR(20) NOT NULL",
					"usid" => "VARCHAR(255)",
					"sticket" => "VARCHAR(255)",
					"type" => "ENUM('E', 'S', 'R', 'A')", // E->error, S->success, R-> Request, A-> Anonymouss
					"result" => "TEXT"
				))
				->create("file", array(
					"fid" => "VARCHAR(255) NOT NULL PRIMARY KEY",
					"usid" => "VARCHAR(255) NOT NULL",
					"fname" => "VARCHAR(255) NOT NULL",
					"ftype" => "VARCHAR(20)",
					"ffunction" => "ENUM('P', 'G', 'S', '') NOT NULL", // P -> profile, G -> game, S -> system, 
					"fpath" => "TEXT"
				))
				->create("questionfile", array(
					"qid" => "VARCHAR(255) NOT NULL PRIMARY KEY",
					"fid" => "VARCHAR(255) NOT NULL"
				));
		}

		public function getTable($table)
		{
			$table = strtolower($table);

			if (file_exists("app/models/". $table . ".php"))
				require_once "app/models/". $table . ".php";
			
		}

		public function execute($type = false)
		{
			if ($type)
			{
				if ($this->wValues == null)
					$result = $this->db->query($this->query)->fetch(PDO::FETCH_ASSOC);
				else
				{
					$result = $this->db->prepare($this->query);
					$result->execute($this->wValues);
					if ($result->rowCount() > 0)
						return $result->fetch(PDO::FETCH_ASSOC);
					return null;
				}
				if ($result)
					return $result;
			}
			// değilse 
			if ($this->wValues == null)
				$result = $this->db->query($this->query, PDO::FETCH_ASSOC);
			else 
			{
				$result = $this->db->prepare($this->query);
				$result->execute($this->wValues);
				if ($result->rowCount() > 0)
					return $result->fetchAll(PDO::FETCH_ASSOC);
				return null;
			}

			if ($result == null || !$result->rowCount())
			{
				$result == null;
				return $result;
			}
			
			return $result;

		}
	}