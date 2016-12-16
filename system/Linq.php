<?php

	class Linq
	{
		public $query = "";
		public $tableName;
		public $wValues = null;

		function __construct() {}

		/**
		 * Sorgunun yapılacağı tablo ismini belirler
		 * @param array $table
		*/
		public function from($table = null)
		{
			$this->query = "";
			if (!isset($table))
			{
				$this->tableName = strtolower(get_class($this));
				return $this;
			}

			$this->tableName = $table;
			return $this;
		}

		/**
		 * Seçilecek sütunları belirler
		 * @param array $cols
		*/
		public function select($cols = null)
		{
			$name = $this->tableName;
			if (!isset($cols))
			{
				$this->query = "SELECT * FROM $name" . $this->query;
				return $this;
			}

			$select = "SELECT ";
			$i = 0;
			foreach ($cols as $key => $value)
			{
				if (is_numeric($key))
					$select .= " $value";
				else
					$select .= " $value AS `$key`";
				
				if (++$i != count($cols))
					$select .= ", ";
			}
			$select .= " FROM $name";
			$this->query = $select . $this->query;
			return $this;
		}

		/**
		 * Tablo ismine ve değerlerine göre join çeker
		 * @param array $table
		 * @param string $equals
		*/
		public function join($table, $equals)
		{
			if (!isset($table) || !isset($equals))
			{
				throw new Exception("\$table or \$equals exists", 1);
				return false;
			}
			$name = $this->tableName;
			$this->query .= " LEFT JOIN $table ON";
			$i = 0;
			foreach ($equals as $key => $value) {
				if (is_array($value))
					$this->query .= " $name.$key = $value[0]";
				else
					$this->query .= " $name.$key = $table.$value";
				if (++$i != count($equals))
					$this->query .= " AND";
			}
			return $this;
		}

		/**
		 * Sorgunun Koşulu
		 * @param string $where
		*/
		public function where($where, $wValues = null)
		{
			if ($wValues != null)
				$this->wValues = $wValues;
			
			if (!isset($where))
			{
				throw new Exception("\$where exists", 1);
				return false;
			}
			$this->query .= " WHERE $where";
			return $this;
		}

		/**
		 * Sorguya sıra parametreleri ekler
		 * @param string $values
		*/
		public function orderBy($values)
		{
			if (!isset($values))
			{
				throw new Exception("\$value exists", 1);
				return false;
			}

			$this->query .= " ORDER BY $values";
			return $this;
		}

		/**
		 * Sorgu sıralaması tipini desc yapar
		*/
		public function desc()
		{
			$this->query .= " DESC";
			return $this;
		}

		/**
		 * Sorgu sıralaması tipini asc yapar
		*/
		public function asc()
		{
			$this->query .= " ASC";
			return $this;
		}

		/**
		 * Sorgunun limitini belirler default olarak 10'dur.
		 * @param integer $limit
		*/
		public function limit($limit = 10)
		{
			$this->query .= " LIMIT $limit";
			return $this;	
		}

		/**
		 * Database'e Tablo Oluşturmaya yarar
		 * @param string $name
		 * @param array $value
		*/
		public function create($name, $value)
		{
			$this->query .= " CREATE TABLE IF NOT EXISTS `$name` (";
			$i = 0;
			foreach ($value as $key => $item) {
				$this->query .= " `$key` $item";
				if (++$i != count($value))
					$this->query .= ", ";
			}
			$this->query .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
			return $this;
		}
	}