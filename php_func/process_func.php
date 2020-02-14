
<?php

	function mongo_to_json_hsp($data)
	{
		$data_need = [];
		foreach ($data as $dataValue) {
			$data_need[] = [$dataValue['坐标x'],$dataValue['坐标y'],$dataValue['医院']];
			}
		return json_encode($data_need);
	}

	function mongo_to_json_site($data)
	{
		$data_need = [];
		foreach ($data as $dataValue) {
			$data_need[] = [$dataValue['x'],$dataValue['y'],$dataValue['省'].$dataValue['市'].$dataValue['区（县）'].$dataValue['小区']];
			}
		return json_encode($data_need);
	}

?>