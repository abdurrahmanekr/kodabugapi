<?php 

	class Point extends Database
	{
		public $usid, $copo, $hepo, $bugpo, $fipo, $keypo;

		public function save()
		{

			$query = $this->db->prepare("INSERT INTO  point SET 
												usid = ?,
												copo = ?,
												hepo = ?,
												bugpo = ?,
												fipo = ?,
												keypo = ?");
			$insert = $query->execute(array(
				$this->usid,
				$this->copo,
				$this->hepo,
				$this->bugpo,
				$this->fipo,
				$this->keypo
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
											keypo = ?
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