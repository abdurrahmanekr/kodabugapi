<?php 

	class Follow extends Database
	{
		public $usid = null;
		public $fusid = null;

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

		public function update($fields, $where, $wValues)
		{
			$qtext = "UPDATE  follow SET";
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

			$query = $this->db->prepare(" DELETE  FROM follow 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}