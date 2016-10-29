<?php 

	class Game extends Database
	{
		public $gid = null;
		public $gusid = null;
		public $grivalid = null;
		public $uspoint = null;
		public $rivalpoint = null;
		public $gmaxpoint = null;

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

		public function update($fields, $where, $wValues)
		{
			$qtext = "UPDATE  game SET";
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

			$query = $this->db->prepare(" DELETE  FROM game 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}