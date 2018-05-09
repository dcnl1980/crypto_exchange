<?php

	include  'include/function.php';

	if(isset($_POST['payment']) && isset($_POST['tx_id']) ) {
		$crypto = true;
		$tx_id = preg_replace("[^\w\d\s]","",$_POST["tx_id"]);
		
		$payment = Find_Payment($tx_id, $row['f_sk'], retCrypto($_POST['c_m'], retPrice($row['d_type'], $row['f_sk'], $row['t_sk'])));
	}

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/my.css">
		<title><?php echo $row['name']; ?> | Exchange</title>
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
				In process
			</div>
		</div>
	</body>
</html>