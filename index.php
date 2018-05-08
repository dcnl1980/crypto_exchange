<?php

	include 'include/function.php';
	
	$rezult = SQL_Query("full","SELECT COUNT(*) FROM `pair`");
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/my.css">
		<title>Cryptocoin exchange</title>
	</head>
	<body class="content">
		<div class="info-0">
			<span>No logs</span> | 
			<span>Best rate</span> | 
			<span>Fast exchange</span>
		</div>
		<div class="main">
			<div class="ilb">
				<table>
					<tr>
						<th>Pair</th>
						<th>Rate</th>
					</tr>
					<?php
					
						if($rezult['COUNT(*)'] > 0) {
							$row = SQL_Query("nfull","SELECT * FROM `pair`");
							
							while($row2 = $row->fetch_assoc()) {
								echo '					<tr>
						<td id="sct'.$row2['id'].'" onclick="Select('.$row2['id'].');">'.$row2['name'].'</td>
						<td>';
						
							if($row2['d_type'] == "f-c") {
								echo retPrice("f-c", $row2['f_sk'], $row2['t_sk']).' = 1';
							} else
								echo "1 = ".retPrice("c-f", $row2['f_sk'], $row2['t_sk']);
						
							echo '</td>
					</tr>'."\n";
							}
						} else {
							echo '<tr>
						<td colspan="2">No pair...</td>
					</tr>'."\n";
						}
					
					?>
				</table>
			</div>
			<div class="ilb">
				<br>
				Text about exchange here. More info is coming.
			</div>
		</div>
		<script src="js/main.js"></script>
	</body>
</html>