<?php

	function mongo_to_json_hsp($data)
	{
		$data_need = [];
		foreach ($data as $dataValue) {
			$data_need[] = [$dataValue['x'],$dataValue['y'],$dataValue['yiyuan']];
			}
		return json_encode($data_need);
	}

	function mongo_to_json_site($data)
	{
		$data_need = [];
		foreach ($data as $dataValue) {
			$data_need[] = [$dataValue['x'],$dataValue['y'],$dataValue['shi']."市".$dataValue['quorxian'].$dataValue['xiaoqu']];
			}
		return json_encode($data_need);
	}

	function mongo_to_json_time($data)
	{
		
		return json_encode($data);
	}

?>
