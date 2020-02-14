<?php
	
	include("/process_func.php");
	class dbClass
	{

		private function db_createManger()
		{
			try{
				$mongodbUrl = "mongodb://10.0.0.9:27017";
				$username = "yiqing";
				$password = "HQU@2017";
			  	$connStr = $mongodbUrl;
			  	$options = array(
				   'username' => $username,
				   'password' => $password,
				  );
			  	return new MongoDB\Driver\Manager($connStr, $options);
			}
			catch(Exception $e){
	  			return false;
	 		}
		}

		public function db_find($filter, $collection)
		{
			$mongoDB = "yiqingditu";
			 $conn = $this->db_createManger();
			 if (empty($conn)) 
			 {
			  	return false;
			 }
			 try {
			  $data = array();
			  $options = ['projection' => ['_id' => 0]];
			  $query = new MongoDB\Driver\Query($filter, $options);
			  echo "------";
			  $cursor = $conn->executeQuery($mongoDB.".".$collection, $query);
			  foreach($cursor as $value) {
			  $data[] = (array)$value;
			  }
			  print_r($data);
			  return $data;
			 } catch (Exception $e) {
			 }
			 return false;
		}
	}
?>