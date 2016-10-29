<?php 

	class Winner extends Database
	{
		public $gid = null;
		public $usid = null;
		public $windate = null;

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

		public function update($fields, $where, $wValues)
		{
			$qtext = "UPDATE  winner SET";
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

			$query = $this->db->prepare(" DELETE  FROM winner 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}