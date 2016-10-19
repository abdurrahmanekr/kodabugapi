<?php

	class Database extends Linq
	{
		public $db;

		function __construct()
		{
			try
			{
				$this->db = new PDO("mysql:host=". _HOST_NAME_ .";dbname=". _DB_NAME_, _DB_USER_, _DB_PASSWORD_);
			}
			catch ( PDOException $e )
			{
				print $e->getMessage();
			}
		}

		public function getTable($table)
		{
			if (file_exists("app/models/". $table . ".php"))
				include_once "app/models/". $table . ".php";
		}

		public function execute($type = false)
		{
			if ($type)
			{
				$result = $this->db->query($this->query, PDO::FETCH_ASSOC);

				if ($result == null || !$result->rowCount())
				{
					$result == null;
					return $result;
				}
				
				return $result;
			}

			$result = $this->db->query($this->query, PDO::FETCH_ASSOC);

			if ($result == null || !$result->rowCount())
			{
				$result == null;
				return $result;
			}
			
			return $result;

		}

		public function generateUserId()
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			return md5($characters.rand(0, strlen($characters) - 1) + microtime());
		}

	}