<?php 

	class User extends Database
	{
		public $usid, $name, $surname, $uspoint, $birth;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  user SET 
												usid = ?,
												name = ?,
												surname = ?,
												uspoint = ?,
												birth = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->name,
				$this->surname,
				$this->uspoint,
				$this->birth
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{

			$query = $this->db->prepare(" UPDATE  user SET 
											usid = ?,
											name = ?,
											surname = ?,
											uspoint = ?,
											birth = ?
									WHERE $where");
			
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