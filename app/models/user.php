<?php 

	class User extends Database
	{
		public $usid = null;
		public $usname = null;
		public $surname = null;
		public $usmail = null;
		public $uspoint = null;
		public $birth = null;
		public $sticket = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  user SET 
												usid = ?,
												usname = ?,
												surname = ?,
												usmail = ?,
												uspoint = ?,
												birth = ?,
												sticket = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->usname,
				$this->surname,
				$this->usmail,
				$this->uspoint,
				$this->birth,
				$this->sticket
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  user SET";
			$fields = array();
			
			if ($this->usid != null)
				$fields["usid"] = $this->usid;
			if ($this->usname != null)
				$fields["usname"] = $this->usname;
			if ($this->surname != null)
				$fields["surname"] = $this->surname;
			if ($this->usmail != null)
				$fields["usmail"] = $this->usmail;
			if ($this->uspoint != null)
				$fields["uspoint"] = $this->uspoint;
			if ($this->birth != null)
				$fields["birth"] = $this->birth;
			if ($this->sticket != null)
				$fields["sticket"] = $this->sticket;
			$i = 0;
			foreach ($fields as $key => $value)
			{ 
				$qtext .= " $key = :$key ";
				if ($i++ != count($fields) - 1)
					$qtext .= ",";
			}
			$wValues = array_merge($fields, $wValues);
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