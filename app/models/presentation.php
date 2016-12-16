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

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  presentation SET";
			$fields = array();
			
			if ($this->usid != null)
				$fields["usid"] = $this->usid;
			if ($this->qid != null)
				$fields["qid"] = $this->qid;
			if ($this->prdate != null)
				$fields["prdate"] = $this->prdate;
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

			$query = $this->db->prepare(" DELETE  FROM presentation 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}