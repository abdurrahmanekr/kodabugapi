<?php 

	class Presentation extends Database
	{
		public $usid = null;
		public $qid = null;
		public $prdate = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  presentation SET 
												usid = ?,
												qid = ?,
												prdate = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->qid,
				$this->prdate
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($fields, $where, $wValues)
		{
			$qtext = "UPDATE  presentation SET";
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

			$query = $this->db->prepare(" DELETE  FROM presentation 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}