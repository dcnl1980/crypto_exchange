<?php

	include  'include/function.php';

	checkExch();
	
	$row = SQL_Query("full","SELECT `name`, `f_sk`, `t_sk`, `d_type` FROM `pair` WHERE `id` = ".$_GET['pair']);
	$p_price = retPrice($row['d_type'], $row['f_sk'], $row['t_sk']);
	$added_to = false;
	$sec = null;
	
	if(isset($_POST["c_a"]) && isset($_POST["c_m"])) {
		if(!(is_numeric($_POST['c_m'])))
			die;
		
		$receiver = preg_replace("[^\w\d\s]","",$_POST["c_a"]); //Remove special
		$t_send = retAmmount($row['d_type'],$p_price,$_POST['c_m']);
		$sec = uniqid(time(),false); //Generate random int
		
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
						<span style="font-size: 22px;">You sec. code: <q><b>'.$sec.'</b></q> ← !!!SAVE IT!!!</span>';
						header("refresh: 10; url=/payment.php");
					} else {
						$rec_name = null;
						
						if($row['d_type'] == "f-c") {
							$rec_name = "You wallet";
						} else {
							$rec_name = "You card";
						}
						
						echo '<form method="post">
					<input type="number" class="material" style="max-width:170px;" step=".01" name="c_m" id="cs" placeholder="You give... '.$row['f_sk'].'" required><br>
					→ <span id="getting">0</span> '.$row['t_sk'].'
					<br>
					<br>
					<input type="text" class="material" name="c_a" placeholder="'.$rec_name.'" required><br>
					<button type="submit" class="btn-material">Submit</button>
				</form>
				<script src="js/main.js"></script>
				<script>caclGet('."'".$row['d_type']."'".', '.$p_price.');</script>';
					}
				
				?>
			</div>
		</div>
	</body>
</html>