<?php

	include 'include/function.php';

	//echo retPrice("f-c", 'CZK', 'ETH');

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
					<tr>
						<td id="sct5" onclick="Select(5);">Sberbank → Bitcoin</td>
						<td>246 000 = 1</td>
					</tr>
					<tr>
						<td id="sct6" onclick="Select(6);">Bitcoin → Sberbank</td>
						<td>246 000 = 1</td>
					</tr>
					<tr>
						<td colspan="3">Design and more is coming soon...</td>
					</tr>
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