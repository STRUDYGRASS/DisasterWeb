
<?php

	function mongo_to_json_hsp($data, $field = array())
	{
		$data_need = [];
		foreach ($data as $dataValue) {
			$data_need[] = [$dataValue['x'],$dataValue['x'],$dataValue['dz']];
			}
		return json_encode($data_need);
	}

	function mongo_to_json_site($data, $field = array())
	{
		$data_need = [];
		foreach ($data as $dataValue) {
			$data_need[] = [$dataValue['坐标x'],$dataValue['坐标y'],$dataValue['医院']];
			}
			print($data_need);
		return json_encode($data_need);
	}

?>