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

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  question SET";
			$fields = array();
			
			if ($this->qid != null)
				$fields["qid"] = $this->qid;
			if ($this->qusid != null)
				$fields["qusid"] = $this->qusid;
			if ($this->qname != null)
				$fields["qname"] = $this->qname;
			if ($this->qtype != null)
				$fields["qtype"] = $this->qtype;
			if ($this->qoption != null)
				$fields["qoption"] = $this->qoption;
			if ($this->qtrue != null)
				$fields["qtrue"] = $this->qtrue;
			if ($this->qfrequency != null)
				$fields["qfrequency"] = $this->qfrequency;
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

			$query = $this->db->prepare(" DELETE  FROM question 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}