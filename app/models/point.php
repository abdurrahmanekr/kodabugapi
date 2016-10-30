<?php 

	class Point extends Database
	{
		public $usid = null;
		public $copo = null;
		public $hepo = null;
		public $bugpo = null;
		public $fipo = null;
		public $keypo = null;
		public $last = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  point SET 
												usid = ?,
												copo = ?,
												hepo = ?,
												bugpo = ?,
												fipo = ?,
												keypo = ?,
												last = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->copo,
				$this->hepo,
				$this->bugpo,
				$this->fipo,
				$this->keypo,
				$this->last
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  point SET";
			$fields = array();
			
			if ($this->usid != null)
				$fields["usid"] = $this->usid;
			if ($this->copo != null)
				$fields["copo"] = $this->copo;
			if ($this->hepo != null)
				$fields["hepo"] = $this->hepo;
			if ($this->bugpo != null)
				$fields["bugpo"] = $this->bugpo;
			if ($this->fipo != null)
				$fields["fipo"] = $this->fipo;
			if ($this->keypo != null)
				$fields["keypo"] = $this->keypo;
			if ($this->last != null)
				$fields["last"] = $this->last;
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

			$query = $this->db->prepare(" DELETE  FROM point 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}