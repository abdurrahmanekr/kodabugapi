<?php 

	class Type extends Database
	{
		public $qtype = null;
		public $tpname = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  type SET 
												qtype = ?,
												tpname = ?");
			$insert = $query->execute(array(
				$this->qtype,
				$this->tpname
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  type SET";
			$fields = array();
			
			if ($this->qtype != null)
				$fields["qtype"] = $this->qtype;
			if ($this->tpname != null)
				$fields["tpname"] = $this->tpname;
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

			$query = $this->db->prepare(" DELETE  FROM type 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}