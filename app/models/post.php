<?php 
	class Post 
	{
		public $postId, $postImage, $postTitle, $postContent, $timestamp, $userId;

		public function save()
		{

			$query = $db->prepare("INSERT INTO  post SET 
												post_id = ?,
												post_image = ?,
												post_title = ?,
												post_content = ?,
												timestamp = ?,
												user_id = ?");
			$insert = $query->execute(array(
				$postId,
	     		$postImage,
	     		$postTitle,
	     		$postContent,
	     		$timestamp,
	     		$userId
			));
			if ($insert)
			    return true;
			return false;
		}

		public function update($where)
		{

			$query = $db->prepare(" UPDATE  post SET 
											post_id = ?,
											post_image = ?,
											post_title = ?,
											post_content = ?,
											timestamp = ?,
											user_id = ?
								   	WHERE $where");
			
			$update = $query->execute(array(
				$postId,
	     		$postImage,
	     		$postTitle,
	     		$postContent,
	     		$timestamp,
	     		$userId
			));
			if ($update)
			    return true;
			return false;
		}
		
		public function delete($where)
		{

			$query = $db->prepare(" DELETE  FROM post 
						   			WHERE :whr ");

			$delete = $query->execute(array(
				'whr' => $where
			));
			if ($delete)
			    return true;
			return false;
		}

		public function select($where = "true=true", $order = "", $cols = "*", $limit = null)
		{
			$result = null;
			if($limit == null)
				$result = $db->query(" SELECT $cols FROM post 
				   				  	   WHERE $where ", PDO::FETCH_ASSOC);
   			else
   				$result = $db->query(" SELECT $cols FROM post 
			   				  		   WHERE $where LIMIT $limit ", PDO::FETCH_ASSOC);
			if ($result->rowCount()){
			    return $result;
			}
			return null;
		}

		
	}