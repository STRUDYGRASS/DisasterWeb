<?php
	function rand_aks()
	{
		$aks = array("Ck5MwFdvZW3R0OqG27fqNxbDPeodRUB6","2z3OR5c4NNdb4sTbI4u1dbNSHRK929ha","lHeMiBL8TM4WcyRprCXsjOfafE4G0zi6","PmK5DyiprlSsD0pg1i3PGT9qL7EM4SsG","fHBrTsM7tcClb8VNBRPbGVmtsTHzLNn0","XIwxInWpkBxao8gutBoPZZTKXRNW4jEL","XXG5CO0mpTX9jKLCxYgtDNuBeK53hGDu","A9fKbmdvtbTbTypS5o3CStCsTDKu5GLQ","3ccb5362c4712a1dd2df47f58f49188a","3b2MXU9AQUm2uCdwk6NNagIS17vNjZ8K");
		$site = array_rand($aks);
		return $aks[$site];
	}
?>