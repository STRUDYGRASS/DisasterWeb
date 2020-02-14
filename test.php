<?php
	include("/db_connect/db_func.php");
	$collection="dili";
	$filter=[];
	$dbClass = new dbClass;
	$data=$dbClass->db_find($filter, $collection);
	print_r($data);
?>