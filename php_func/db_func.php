<?php
	
	include("/process_func.php");
	class dbClass
	{

		private function db_createManger()
		{
			try{
				$mongodbUrl = "mongodb://47.95.10.60:27017";
			  	$connStr = $mongodbUrl;
			  	return new MongoDB\Driver\Manager($connStr);
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
			  $cursor = $conn->executeQuery($mongoDB.".".$collection, $query);
			  foreach($cursor as $value) {
			  $data[] = (array)$value;
			  }
			  return $data;
			 } catch (Exception $e) {
			 }
			 return false;
		}
	}
?>