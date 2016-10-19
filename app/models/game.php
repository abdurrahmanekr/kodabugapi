<?php 

	class Game extends Database
	{
		public $gid, $gusid, $grivalid, $uspoint, $rivalpoint, $gmaxpoint;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  game SET 
												gid = ?,
												gusid = ?,
												grivalid = ?,
												uspoint = ?,
												rivalpoint = ?,
												gmaxpoint = ?");
			$insert = $query->execute(array(
				$this->gid,
				$this->gusid,
				$this->grivalid,
				$this->uspoint,
				$this->rivalpoint,
				$this->gmaxpoint
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{

			$query = $this->db->prepare(" UPDATE  game SET 
											gid = ?,
											gusid = ?,
											grivalid = ?,
											uspoint = ?,
											rivalpoint = ?,
											gmaxpoint = ?
									WHERE $where");
			
			$update = $query->execute($wValues);
			if ($update)
				return true;
			return false;
		}
		
		public function delete($where, $wValues)
		{

			$query = $this->db->prepare(" DELETE  FROM game 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}