<?php 

	class Winner extends Database
	{
		public $gid, $usid, $windate;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  winner SET 
												gid = ?,
												usid = ?,
												windate = ?");
			$insert = $query->execute(array(
				$this->gid,
				$this->usid,
				$this->windate
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{

			$query = $this->db->prepare(" UPDATE  winner SET 
											gid = ?,
											usid = ?,
											windate = ?
									WHERE $where");
			
			$update = $query->execute($wValues);
			if ($update)
				return true;
			return false;
		}
		
		public function delete($where, $wValues)
		{

			$query = $this->db->prepare(" DELETE  FROM winner 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}