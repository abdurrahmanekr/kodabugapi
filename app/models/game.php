<?php 

	class Game extends Database
	{
		public $gid = null;
		public $gusid = null;
		public $grivalid = null;
		public $uspoint = null;
		public $rivalpoint = null;
		public $gmaxpoint = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  game SET 
												gid = ?,
												gusid = ?,
												grivalid = ?,
												uspoint = ?,
												rivalpoint = ?,
												gmaxpoint = ?");
			$insert = $query->execute(array(
				$this->gid,
				$this->gusid,
				$this->grivalid,
				$this->uspoint,
				$this->rivalpoint,
				$this->gmaxpoint
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  game SET";
			$fields = array();
			
			if ($this->gid != null)
				$fields["gid"] = $this->gid;
			if ($this->gusid != null)
				$fields["gusid"] = $this->gusid;
			if ($this->grivalid != null)
				$fields["grivalid"] = $this->grivalid;
			if ($this->uspoint != null)
				$fields["uspoint"] = $this->uspoint;
			if ($this->rivalpoint != null)
				$fields["rivalpoint"] = $this->rivalpoint;
			if ($this->gmaxpoint != null)
				$fields["gmaxpoint"] = $this->gmaxpoint;
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

			$query = $this->db->prepare(" DELETE  FROM game 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}