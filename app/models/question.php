<?php 

	class Question extends Database
	{
		public $qid, $qusid, $qname, $qtype, $qoption, $qtrue, $qfrequency;

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

		public function update($where, $wValues)
		{

			$query = $this->db->prepare(" UPDATE  question SET 
											qid = ?,
											qusid = ?,
											qname = ?,
											qtype = ?,
											qoption = ?,
											qtrue = ?,
											qfrequency = ?
									WHERE $where");
			
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