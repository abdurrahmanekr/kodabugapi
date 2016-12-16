<?php 

	class File extends Database
	{
		public $fid = null;
		public $usid = null;
		public $fname = null;
		public $ftype = null;
		public $ffunction = null;
		public $fpath = null;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  file SET 
												fid = ?,
												usid = ?,
												fname = ?,
												ftype = ?,
												ffunction = ?,
												fpath = ?");
			$insert = $query->execute(array(
				$this->fid,
				$this->usid,
				$this->fname,
				$this->ftype,
				$this->ffunction,
				$this->fpath
			));
			if ($insert)
				return true;
			return false;
		}

		public function update($where, $wValues)
		{
			if(!isset($where) || !isset($wValues))
				return false;
			$qtext = "UPDATE  file SET";
			$fields = array();
			
			if ($this->fid != null)
				$fields["fid"] = $this->fid;
			if ($this->usid != null)
				$fields["usid"] = $this->usid;
			if ($this->fname != null)
				$fields["fname"] = $this->fname;
			if ($this->ftype != null)
				$fields["ftype"] = $this->ftype;
			if ($this->ffunction != null)
				$fields["ffunction"] = $this->ffunction;
			if ($this->fpath != null)
				$fields["fpath"] = $this->fpath;
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

			$query = $this->db->prepare(" DELETE  FROM file 
									WHERE $where");

			$delete = $query->execute($wValues);
			if ($delete)
				return true;
			return false;
		}

		
	}