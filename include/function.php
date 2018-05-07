<?php

	function cryptoID($name) {
		$massive = implode('', file("https://api.coinmarketcap.com/v2/listings/"));
		$massive = json_decode($massive, true);
		
		for($i =0; $i != count($massive['data']); $i++) {
			if($massive['data'][$i]['symbol'] == "$name") {
				return $massive['data'][$i]['id'];
			}
		}
	}
	
	function retPrice($tp, $t0, $t1) {
		
		$fiat = 0;
		$crypto = 0;

		if($tp == "f-c") {
			$fiat = $t0;
			$crypto = $t1;
		} else {
			$fiat = $t1;
			$crypto = $t0;
		}
		
		$c_id = cryptoID($crypto);
		$massive = implode('', file("https://api.coinmarketcap.com/v2/ticker/$c_id/?convert=$fiat"));
		$massive = json_decode($massive, true);
		
		if($tp == "f-c")
			return $massive['data']['quotes']["$fiat"]['price']+$massive['data']['quotes']["$fiat"]['price']*2/100;
		else
			return $massive['data']['quotes']["$fiat"]['price']*99/100;
			
	}

?>