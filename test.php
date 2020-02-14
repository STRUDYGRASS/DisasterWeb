<?php
	include("/db_connect/db_func.php");
	$collection="yiyuan";
	$filter=[];
	$dbClass = new dbClass;
	$data=$dbClass->db_find($filter, $collection);
	print_r($data);
?>