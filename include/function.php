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
				$massive = implode('', file("https://blockchain.info/rawtx/$tx_id"));
				$massive = json_decode($massive, true);
					
				for($i =0; $i != count($massive['out']); $i++)
					if($massive['out'][$i]['addr'] == $btc)
						if($massive['out'][$i]['value'] >= $price*10**8)
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
		include 'settings.php';
		
		$conn = new mysqli($host, $user, $passw, "exchange");
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
	
	function retWallet($name) {
		include 'settings.php';
		
		if($name = "XMR")
			return $xmr;
		else if($name = "ETH")
			return $eth;
		else if($name = "BTC")
			return $btc;
		else if($name = "DASH")
			return $dash;
		else if($name = "LTC")
			return $ltc;
	}
	
	function retCrypto() {
		
	}
	
	function retAmmount($d_type, $price,$ammo) {
		if($d_type == "f-c")
			return 1*$ammo/$price;
		else
			return $ammo*$price/1; 
	}
	
	function checkExch() {
		if(!(isset($_GET['pair'])))
			die;
		
		else if(!(is_numeric($_GET['pair'])))
			die;
		
		else if(SQL_Query("full","SELECT COUNT(`name`) FROM `pair` WHERE `id` = ".$_GET['pair'])['COUNT(`name`)'] == 0)
			die;
	}
	
	function retDType($pair) {
		$row = SQL_Query("full", "SELECT `d_type` FROM `pair` WHERE `name`= '".$pair."'");
		
		return $row['d_type'];
	}
	
	function retPNAME($sec) {
		$row = SQL_Query("full","SELECT `pair` FROM `deals` WHERE `sec` = '".$sec."'");
		
		return $row['pair'];
	}
	
	function retText($sec) {
		$wallet = null;
		
		include 'include/settings.php';
		
		$row = SQL_Query("full", "SELECT `f_amm`, `t_amm` FROM `deals` WHERE `sec` = '$sec'");
		$row2 = SQL_Query("full", "SELECT  `f_sk`, `t_sk` FROM `pair` WHERE `name` = '".retPNAME($sec)."'");
		
		if(retDType(retPNAME($sec)) == "f-c") {
			$wallet = $card;
		} else {
			$wallet = retWallet($row2['f_sk']);
		}
	
		return '<span style="font-size: 20px;">Hi, you must send '.$row['f_amm'].' '.$row2['f_sk'].' to <b>'.$wallet.'</b><br>With description: <b>'.$sec.'</b><br>And you get: '.$row['t_amm'].' '.$row2['t_sk'].'</span>';;
	}
	
?>