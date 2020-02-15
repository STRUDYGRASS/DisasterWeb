<?php
	function rand_aks()
	{
		$aks = array("Ck5MwFdvZW3R0OqG27fqNxbDPeodRUB6","i2tM7wogeLuw7LZtFladQIxCWkL3fUjD","SH2NPGNgDG87p6x41AZv3lOKDGSkKCCK","PmK5DyiprlSsD0pg1i3PGT9qL7EM4SsG","fiiQ7Nr8q3Yvamm1slbGWkCY70UykjQ8","WUIZXgr4TbPCgCA7INTnu6GADdpE6vkU","XXG5CO0mpTX9jKLCxYgtDNuBeK53hGDu","A9fKbmdvtbTbTypS5o3CStCsTDKu5GLQ","3ccb5362c4712a1dd2df47f58f49188a");
		$site = array_rand($aks);
		return $aks[$site];
	}
?>