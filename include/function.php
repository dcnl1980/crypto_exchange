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
	
	function Find_Payment($tx_id, $crypto, $price) {	

		if($crypto == "xmr") {
			$vwk = ""; //Monero view-key here.
			
			$var = file('https://xmrchain.net/myoutputs/'.$tx_id."/$xmr/$vwk");
			
			for($i=160; $i != sizeof($var); $i++) {
				if(strstr($var[$i], $price)) {
					return true;
				}
			}
			
		}
		
		else if($crypto == "eth") {
			$var = file("https://api.ethplorer.io/getTxInfo/$tx_id?apiKey=freekey");
			$var2 = explode(",", $var[0]);
			
			if(strstr($var2[6], $eth)) {
				if(substr($var2[7], 8, -3) == $price) {
					return true;
				}
			}
		}
		
		else if($crypto == "btc") {
			$pr_lin = 0;
			$sa_pr = $price*10**8;
	
			$var = file('https://blockchain.info/rawtx/'.$tx_id);
			
			for($i=10; $i != sizeof($var); $i++) {
				if(strstr($var[$i], $btc)) {
					$pr_lin = $i+1;
				}
			}
			
			$p_p_btc = substr($var[$pr_lin], 17, -2);
			
			if ($p_p_btc == $sa_pr) {
				return true;
			}
		}
		
		else if($crypto == "ltc") {
			$var = file("https://chainz.cryptoid.info/explorer/tx.raw.dws?coin=ltc&id=$tx_id&fmt.js");
			for($i = 0; $i != sizeof($var2)-1; $i++) {
				if(strstr($var2[$i], $ltc)) {
					if(strstr($var2[$i-6], $price)) {
						return true;
					}
				}
			}
		}
		
		else if($crypto == "dash") {
			$var = file("https://chainz.cryptoid.info/explorer/tx.raw.dws?coin=dash&id=$tx_id&fmt.js");
			$var2 = explode(",", $var[0]);
	
			for($i = 0; $i != sizeof($var2)-1; $i++) {
				if(strstr($var2[$i], $dash)) {
					if(strstr($var2[$i-7], $price)) {
						return true;
					}
				}
			}
		} else {
			die;
		}
	}
	
	function SQL_Query($tp, $sql) {
		$conn = new mysqli("localhost", "root", "", "exchange");
		$result = $conn->query($sql);
		if($tp == "full") {
			$row = $result->fetch_assoc();
			$conn->close();
			
			return $row;
		} else {
			$conn->close();
			
			return $result;
		}
	}

?>