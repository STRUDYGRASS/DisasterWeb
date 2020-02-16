<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/php_func/db_func.php";
  	include_once $_SERVER['DOCUMENT_ROOT']."/php_func/process_func.php";

	$dbClass = new dbClass;
	$filter = [];
	$collection = 'yiyuan';
	//$data_array = $dbClass->db_find($filter, $collection);
	$data_array[] =['2020-02-13','2020-02-13','2020-02-13'，'2020-02-13']
	$data = mongo_to_json_time($data_array);
	echo $data;
?>