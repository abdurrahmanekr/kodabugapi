<?php
	
	/**
	* @author: Abdurrahman Eker - 2016 Kodofisi
	* date : 24.10.2016
	* time: 20:57 - 08:57 PM
	*/
	
	class KosUp {

		function __construct($db)
		{
			$result = array();

			$this->GenerateKosUp($result, $db);
		}

		private function GenerateKosUp($result, $db)
		{
			$q = "SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='"._DB_NAME_."'";
			$query = $db->query($q, PDO::FETCH_ASSOC);
			$table = array();
			$column = array();
			foreach ($query as $item)
				if (!isset($table[$item["TABLE_NAME"]])) {
					$table[$item["TABLE_NAME"]] = array();
					$table[$item["TABLE_NAME"]][] = $item["COLUMN_NAME"];
				} else if(isset($table[$item["TABLE_NAME"]]))
					$table[$item["TABLE_NAME"]][] = $item["COLUMN_NAME"];
				
			/* veri tabanında tablo olmasına dikkat ediyoruz */
			if (count($table) < 1) {
				$result[] = "Veri tabanında tablo yok. Kontrol edin !";
			} else {
				$result[] = "Güzel... veri tabanında ".count($table)." tablo var.";
				$this->addClasses($result, $table);
			}
		}

		private function addClasses($result, $fields)
		{
	$arr = array();
	$cls = "";
	foreach ($fields as $key => $item)
	{
		$cls = "<?php 

	class ";
		$cls .= ucfirst($this->camelCase($key))." extends Database
	{";
		//fields ekleniyor
		$cls .= "
		";
		for($i = 0; $i < count($item); $i++)
		{
			$cls .= 'public $'.$this->camelCase($item[$i]);
			if ($i == count($item)-1)
				$cls .= " = null;";
			else
				$cls .= " = null;
		";
		}
		//save
		$cls .= "

		public function save()
		{

			\$query = \$this->db->prepare(\"INSERT INTO  $key SET 
												";
		for ($i = 0; $i < count($item); $i++)
			if ($i == count($item) -1)
				$cls .= $item[$i]." = ?";
			else
				$cls .= $item[$i]." = ?,
												";
		$cls .= "\");";
		$cls .= "
			\$insert = \$query->execute(array(
				";

		for ($i=0; $i < count($item); $i++){
			if ($i != 0) {
				$cls .= ",
				";
			}
			$cls .= "\$this->".$this->camelCase($item[$i]);
		}
			$cls .= "
			));
			if (\$insert)
				return true;
			return false;
		}";
		//update

		$cls .= "

		public function update(\$where, \$wValues)
		{
			if(!isset(\$where) || !isset(\$wValues))
				return false;
			\$qtext = \"UPDATE  $key SET\";
			\$fields = array();
			";
		for ($i=0; $i < count($item); $i++) { 
			$cls .= "
			if (\$this->".$this->camelCase($item[$i])." != null)
				\$fields[\"". $this->camelCase($item[$i]) ."\"] = \$this->".$this->camelCase($item[$i]) .";";
		}
			$cls .= "
			\$i = 0;
			foreach (\$fields as \$key => \$value)
			{ 
				\$qtext .= \" \$key = :\$key \";
				if (\$i++ != count(\$fields) - 1)
					\$qtext .= \",\";
			}
			\$wValues = array_merge(\$fields, \$wValues);
			\$qtext .= \" WHERE \$where\";
			\$query = \$this->db->prepare(\$qtext);
			";
		$cls .= "
			\$update = \$query->execute(\$wValues);
			if (\$update)
				return true;
			return false;
		}
		
		";
		//delete

		$cls .= "public function delete(\$where, \$wValues)
		{

			\$query = \$this->db->prepare(\" DELETE  FROM $key 
									WHERE \$where\");
";
		$cls .= "
			\$delete = \$query->execute(\$wValues);
			if (\$delete)
				return true;
			return false;
		}

		";
		//class ended
		$cls .= "
	}";

		$arr[] = $cls;
		$fName = $this->camelCase($key);
		$this->writeFile("app/models/$fName.php",$cls);
	}
		}

		private function writeFile($fileName, $write)
		{
			if (file_exists($fileName)) {
				unlink($fileName);
			}
			$file = fopen($fileName,"a+");
			fwrite($file, $write);
			fclose($file);
		}

		private function camelCase($str) {
			$i = array("-","_");
			$str = preg_replace('/([a-z])([A-Z])/', "\\1 \\2", $str);
			$str = preg_replace('@[^a-zA-Z0-9\-_ ]+@', '', $str);
			$str = str_replace($i, ' ', $str);
			$str = str_replace(' ', '', ucwords(strtolower($str)));
			$str = strtolower(substr($str,0,1)).substr($str,1);
			return $str;
		}
	} 	