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

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  follow SET";
			$fields = array();
			
			if ($this->usid != null)
				$fields["usid"] = $this->usid;
			if ($this->fusid != null)
				$fields["fusid"] = $this->fusid;
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

			$query = $this->db->prepare(" DELETE  FROM follow 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}