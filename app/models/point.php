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

			$query = $this->db->prepare(" UPDATE  point SET 
											usid = ?,
											copo = ?,
											hepo = ?,
											bugpo = ?,
											fipo = ?,
											keypo = ?,
											last = ?
									WHERE $where");
			
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