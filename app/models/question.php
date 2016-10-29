<?php 

	class Question extends Database
	{
		public $qid = null;
		public $qusid = null;
		public $qname = null;
		public $qtype = null;
		public $qoption = null;
		public $qtrue = null;
		public $qfrequency = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  question SET 
												qid = ?,
												qusid = ?,
												qname = ?,
												qtype = ?,
												qoption = ?,
												qtrue = ?,
												qfrequency = ?");
			$insert = $query->execute(array(
				$this->qid,
				$this->qusid,
				$this->qname,
				$this->qtype,
				$this->qoption,
				$this->qtrue,
				$this->qfrequency
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($fields, $where, $wValues)
		{
			$qtext = "UPDATE  question SET";
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

			$query = $this->db->prepare(" DELETE  FROM question 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}