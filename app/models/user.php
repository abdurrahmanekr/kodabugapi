<?php 

	class User extends Database
	{
		public $usid = null;
		public $usname = null;
		public $surname = null;
		public $usmail = null;
		public $uspoint = null;
		public $birth = null;
		public $auth = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  user SET 
												usid = ?,
												usname = ?,
												surname = ?,
												usmail = ?,
												uspoint = ?,
												birth = ?,
												auth = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->usname,
				$this->surname,
				$this->usmail,
				$this->uspoint,
				$this->birth,
				$this->auth
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($fields, $where, $wValues)
		{
			$qtext = "UPDATE  user SET";
			for ($i=0; $i < count($fields); $i++) { 
				$qtext .= " " . $fields[$i] . "= :$fields[$i] ";
				if ($i != count($fields) - 1)
					$qtext .= ",";
			}

			$qtext .= " WHERE $where";
			$query = $this->db->prepare($qtext);
			
			$update = $query->execute($wValues);
			if ($update)
				return true;
			return false;
		}
		
		public function delete($where, $wValues)
		{

			$query = $this->db->prepare(" DELETE  FROM user 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}