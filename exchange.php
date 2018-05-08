<?php

	include  'include/function.php';

	if(!(isset($_GET['pair'])))
		die;
	
	else if(!(is_numeric($_GET['pair'])))
		die;
	
	else if(SQL_Query("full","SELECT COUNT(`name`) FROM `pair` WHERE `id` = ".$_GET['pair'])['COUNT(`name`)'] == 0)
		die;
	
	$row = SQL_Query("full","SELECT `name`, `f_sk`, `t_sk`, `d_type` FROM `pair` WHERE `id` = ".$_GET['pair']);
	

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $row['name']; ?> | Exchange</title>
	</head>
	<body>
		<input type="text" id="cs" placeholder="You give... <?php echo $row['f_sk']; ?>" required><br>
		To get: <span id="getting">0</span> <?php echo $row['t_sk']; ?>
		<script src="js/main.js"></script>
		<script>caclGet(<?php 
			echo "'".$row['d_type']."', ";
			echo retPrice($row['d_type'], $row['f_sk'], $row['t_sk']);
		?>);</script>
	</body>
</html>