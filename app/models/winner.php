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

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  winner SET";
			$fields = array();
			
			if ($this->gid != null)
				$fields["gid"] = $this->gid;
			if ($this->usid != null)
				$fields["usid"] = $this->usid;
			if ($this->windate != null)
				$fields["windate"] = $this->windate;
			$i = 0;
			foreach ($fields as $key => $value)
			{ 
				$qtext .= " $key = :$key ";
				if ($i++ != count($fields) - 1)
					$qtext .= ",";
			}
			$wValues = array_merge($fields, $wValues);
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