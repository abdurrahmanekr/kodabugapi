<?php 

	class Follow extends Database
	{
		public $usid, $fusid;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  follow SET 
												usid = ?,
												fusid = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->fusid
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{

			$query = $this->db->prepare(" UPDATE  follow SET 
											usid = ?,
											fusid = ?
									WHERE $where");
			
			$update = $query->execute($wValues);
			if ($update)
				return true;
			return false;
		}
		
		public function delete($where, $wValues)
		{

			$query = $this->db->prepare(" DELETE  FROM follow 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}