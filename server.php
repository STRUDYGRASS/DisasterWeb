<?php
	include("/php_func/db_func.php");
	include("/php_func/process_func.php");

	$time = $_POST['m_time']
	$thing = $_POST['m_thing']

	$dbClass = new dbClass;
	if($thing == "医院")
	{
		$filter = [];
		$collection = 'yiyuan';
		$data_array = $dbClass->db_find($filter, $collection);
		$data = mongo_to_json_hsp($data_array);
		echo $data;
	}
	elseif ($thing == "小区") 
	{
		$filter = [];
		$collection = 'dili';
		$data_array = $dbClass->db_find($filter, $collection);
		$data = mongo_to_json_site($data_array);
		echo $data;
	}
?>