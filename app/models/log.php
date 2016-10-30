<?php 

	class Log extends Database
	{
		public $lgid = null;
		public $lgdate = null;
		public $usid = null;
		public $auth = null;
		public $type = null;
		public $result = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  log SET 
												lgid = ?,
												lgdate = ?,
												usid = ?,
												auth = ?,
												type = ?,
												result = ?");
			$insert = $query->execute(array(
				$this->lgid,
				$this->lgdate,
				$this->usid,
				$this->auth,
				$this->type,
				$this->result
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  log SET";
			$fields = array();
			
			if ($this->lgid != null)
				$fields["lgid"] = $this->lgid;
			if ($this->lgdate != null)
				$fields["lgdate"] = $this->lgdate;
			if ($this->usid != null)
				$fields["usid"] = $this->usid;
			if ($this->auth != null)
				$fields["auth"] = $this->auth;
			if ($this->type != null)
				$fields["type"] = $this->type;
			if ($this->result != null)
				$fields["result"] = $this->result;
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

			$query = $this->db->prepare(" DELETE  FROM log 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}