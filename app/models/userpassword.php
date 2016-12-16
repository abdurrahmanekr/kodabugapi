<?php 

	class Userpassword extends Database
	{
		public $usid = null;
		public $password = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  userpassword SET 
												usid = ?,
												password = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->password
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  userpassword SET";
			$fields = array();
			
			if ($this->usid != null)
				$fields["usid"] = $this->usid;
			if ($this->password != null)
				$fields["password"] = $this->password;
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

			$query = $this->db->prepare(" DELETE  FROM userpassword 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}