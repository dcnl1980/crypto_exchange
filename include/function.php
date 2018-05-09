<?php

	function cryptoID($name) {
		$massive = implode('', file("https://api.coinmarketcap.com/v2/listings/"));
		$massive = json_decode($massive, true);
		
		for($i =0; $i != count($massive['data']); $i++)
			if($massive['data'][$i]['symbol'] == "$name")
				return $massive['data'][$i]['id'];
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
			return $massive['data']['quotes']["$fiat"]['price']+$massive['data']['quotes']["$fiat"]['price']*5/100; // Add 5% to buy price
		else
			return $massive['data']['quotes']["$fiat"]['price']*95/100; //Minus 5% to sell price
			
	}
	
	function sendMessage($message) {
		include 'settings.php';
		
		file("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$ch_id&text=$message");
	}
	
	function Find_Payment($tx_id, $crypto, $price) {
		include 'settings.php';

		try {
			if($crypto == "XMR") {
				$var = file('https://xmrchain.net/myoutputs/'.$tx_id."/$xmr/$vwk");
				
				for($i=160; $i != sizeof($var); $i++)
					if(strstr($var[$i], $price))
						return true;
			}
			
			else if($crypto == "ETH") {
				$massive = implode('', file("https://api.ethplorer.io/getTxInfo/$tx_id?apiKey=freekey"));
				$massive = json_decode($massive, true);
				
				if($massive['to']==$eth)
					if($massive['value'] >= $price)
						return true;
			}
			
			else if($crypto == "BTC") {
				$pr_lin = 0;
				$sa_pr = $price*10**8;
		
				$var = file('https://blockchain.info/rawtx/'.$tx_id);
				
				for($i=10; $i != sizeof($var); $i++)
					if(strstr($var[$i], $btc))
						$pr_lin = $i+1;

				$p_p_btc = substr($var[$pr_lin], 17, -2);
				
				if ($p_p_btc >= $sa_pr)
					return true;
			}
			
			else if($crypto == "LTC") {
				$massive = implode('', file("https://chainz.cryptoid.info/explorer/tx.raw.dws?coin=ltc&id=$tx_id&fmt.js"));
				$massive = json_decode($massive, true);
				
				for($i =0; $i != count($massive['vout']); $i++)
					if($massive['vout'][$i]['value'] >= "$price")
						if($massive['vout'][$i]['scriptPubKey']['addresses'][0] == "$ltc")
							return true;
			}
			
			else if($crypto == "DASH") {
				$massive = implode('', file("https://chainz.cryptoid.info/explorer/tx.raw.dws?coin=dash&id=$tx_id&fmt.js"));
				$massive = json_decode($massive, true);
				
				for($i =0; $i != count($massive['vout']); $i++)
					if($massive['vout'][$i]['value'] >= "$price")
						if($massive['vout'][$i]['scriptPubKey']['addresses'][0] == "$dash")
							return true;
			} else {
				die;
			}
			return false;
		} catch(Exception $e) {
			return false;
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