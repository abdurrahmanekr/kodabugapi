<?php 

	class Confirmation extends Database
	{
		public $qid, $conf;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  confirmation SET 
												qid = ?,
												conf = ?");
			$insert = $query->execute(array(
				$this->qid,
				$this->conf
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{

			$query = $this->db->prepare(" UPDATE  confirmation SET 
											qid = ?,
											conf = ?
									WHERE $where");
			
			$update = $query->execute($wValues);
			if ($update)
				return true;
			return false;
		}
		
		public function delete($where, $wValues)
		{

			$query = $this->db->prepare(" DELETE  FROM confirmation 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}