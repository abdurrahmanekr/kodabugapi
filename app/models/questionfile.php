<?php 

	class Questionfile extends Database
	{
		public $qid = null;
		public $fid = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  questionfile SET 
												qid = ?,
												fid = ?");
			$insert = $query->execute(array(
				$this->qid,
				$this->fid
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  questionfile SET";
			$fields = array();
			
			if ($this->qid != null)
				$fields["qid"] = $this->qid;
			if ($this->fid != null)
				$fields["fid"] = $this->fid;
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

			$query = $this->db->prepare(" DELETE  FROM questionfile 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}