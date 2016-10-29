<?php 

	class Type extends Database
	{
		public $qtype = null;
		public $tpname = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  type SET 
												qtype = ?,
												tpname = ?");
			$insert = $query->execute(array(
				$this->qtype,
				$this->tpname
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($fields, $where, $wValues)
		{
			$qtext = "UPDATE  type SET";
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

			$query = $this->db->prepare(" DELETE  FROM type 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}