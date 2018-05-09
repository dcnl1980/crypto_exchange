<?php

	include  'include/function.php';

	if(!(isset($_GET['pair'])))
		die;
	
	else if(!(is_numeric($_GET['pair'])))
		die;
	
	else if(SQL_Query("full","SELECT COUNT(`name`) FROM `pair` WHERE `id` = ".$_GET['pair'])['COUNT(`name`)'] == 0)
		die;
	
	$added_to = false;
	$payment = false;
	$crypto = false;
	$sec = null;
	$id = null;
	
	$row = SQL_Query("full","SELECT `name`, `f_sk`, `t_sk`, `d_type` FROM `pair` WHERE `id` = ".$_GET['pair']);
	
	if(isset($_POST["c_a"]) && isset($_POST["c_m"])) {
		if(!(is_numeric($_POST['c_m'])))
			die;
		
		$receiver = preg_replace("[^\w\d\s]","",$_POST["c_a"]); //Remove special
		$sec = time() + $_GET['pair']+ $_POST['c_m'] / 2; //Generate random int
		$t_send = $_POST["c_m"] * retPrice($row['d_type'],$row['f_sk'],$row['t_sk'])/1; //How much must send to client after payment. Use JS value is not secure
		
		SQL_Query("nfull","INSERT INTO `deals`(`sec`, `pair`, `f_amm`, `t_amm`, `receiver`) VALUES ('$sec','".$row['name']."','".$_POST['c_m']."','$t_send','".$_POST['c_a']."')");
		
		$row['name'] = "Successfull";
		$added_to = true;
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
				<?php 
				
					if($added_to) {
						echo '<img src="http://ddcsindhupalchowk.gov.np/wp-content/uploads/2017/01/handshake-flat.png">
						<br>Successfully added!
						<br>
						<span style="font-size: 22px;">You sec. code: <b>'.$sec.'</b> ← !!!SAVE IT!!!</span>';
						header("refresh: 10; url=/payment.php");
					} else {
						echo '<form method="post">
					<input type="number" class="material" style="max-width:170px;" step=".01" name="c_m" id="cs" placeholder="You give... '.$row['f_sk'].'" required><br>
					→ <span id="getting">0</span> '.$row['t_sk'].'
					<br>
					<br>
					<input type="text" class="material" name="c_a" placeholder="You card/wallet/etc" required><br>
					<button type="submit" class="btn-material">Submit</button>
				</form>
				<script src="js/main.js"></script>
				<script>caclGet('."'".$row['d_type']."'".', '.retPrice($row['d_type'], $row['f_sk'], $row['t_sk']).');</script>';
					}
				
				?>
			</div>
		</div>
	</body>
</html>