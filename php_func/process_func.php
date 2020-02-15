
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
			$data_need[] = [$dataValue['x'],$dataValue['y'],$dataValue['xiaoqu']];
			}
		return json_encode($data_need);
	}

?>