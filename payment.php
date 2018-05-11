<?php

	include  'include/function.php';
	
	$info = null;
	
	if(isset($_POST['tx_id']) && strlen($_POST['tx_id']) > 4 && strlen($_POST['tx_id']) < 65 && isset($_POST['sec'])) {
		$payment = false;
		$sec = preg_replace("[^\w\d\s]","",$_POST['sec']);
		$tx_id = preg_replace("[^\w\d\s]","",$_POST["tx_id"]);
		
		if(checkTX($tx_id)) {
			$info = "TX already used.";
		} else {
			$row = SQL_Query("full","SELECT `f_amm`,`t_amm`,`receiver` FROM `deals` WHERE `sec` = '".$sec."'");
			$row2 = SQL_Query("full","SELECT `f_sk`, `t_sk` FROM `pair` WHERE `name` = '".retPNAME($sec)."'");
			
			if(retDType(retPNAME($sec)) == "f-c") {
				echo "ssss";
				if($tx_id == "Payed") {
					$payment = true;
				}
			} else {
				$payment = Find_Payment($tx_id, $row2['f_sk'], $row['f_amm']);
			}
			
			if($payment) {
				if(retDType(retPNAME($sec)) == "f-c") {
					sendMessage(urlencode("If you received payment with desc.: ".$sec." with ".$row['f_amm']." ".$row2['f_sk']."\nPair: ".retPNAME($sec)."\nSend: ".$row['t_amm']." ".$row2['t_sk']."\nTo: ".$row['receiver']));
				} else 
					sendMessage(urlencode("Client maked payment, pair: ".retPNAME($sec)."\nSend: ".$row['t_amm']." ".$row2['t_sk']."\nTo: ".$row['receiver']));
				
				SQL_Query("nfull", 'UPDATE `deals` SET `pair`="",`f_amm`="",`t_amm`="",`receiver`="",`date`="",`payment`="", `sec`="" WHERE `sec`= "'.$sec.'"');
				SQL_Query("nfull", "INSERT INTO `tx_id`(`tx_id`) VALUES ('$tx_id')");
				$info = "<b>Succesfull</b>! Please wait 5-10 min.";
			} else {
				$info = "Payment not found.";
			}
		}
	} else if (isset($_POST['sec'])) {
		$sec = preg_replace("[^\w\d\s]","",$_POST['sec']);
		
		if(SQL_Query("full","SELECT COUNT(`id`) FROM `deals` WHERE `sec` = '".$sec."'")['COUNT(`id`)'] == 0) {
			$info = 'Not found...';
		} else {
			$info = retText($sec);
		}
	}

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/my.css">
		<title>Payment | Exchange</title>
	</head>
	<body class="content">
		<div class="info-0">
			<span>No logs</span> | 
			<span>Best rate</span> | 
			<span>Fast exchange</span>
		</div>
		<div class="main">
			<div class="ilb2">
				<br>
				<br>
				<br>
				<form method="post">
					<input type="text" class="material" name="sec" placeholder="# You sec. code" required>
					<br>
					<br>
					<input type="text" class="material" name="tx_id" placeholder="TX ID">
					<br>
					<br>
					<button type="submit" class="btn-material">Submit</button>
				</form>
				<br>
				<br>
				<?php echo $info; ?>
			</div>
		</div>
	</body>
</html>