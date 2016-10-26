<?php 

	class Username extends Database
	{
		public $usid = null;
		public $usname = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  username SET 
												usid = ?,
												usname = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->usname
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{

			$query = $this->db->prepare(" UPDATE  username SET 
											usid = ?,
											usname = ?
									WHERE $where");
			
			$update = $query->execute($wValues);
			if ($update)
				return true;
			return false;
		}
		
		public function delete($where, $wValues)
		{

			$query = $this->db->prepare(" DELETE  FROM username 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}