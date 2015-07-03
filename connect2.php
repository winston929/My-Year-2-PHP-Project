<?php
// Create connection
$dbc = mysqli_connect("localhost", "webminer_edit", "akqj10", "webminer_buycd2");

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
	echo "Connected<br>";
	$result = mysqli_query($dbc,"SELECT NOW()");
	$row = mysqli_fetch_row($result);
	$date = date_create($row[0]);

	echo date_format($date, 'Y-m-d H:i:s')."<br>";
	#output: 2012-03-24 17:45:12

	echo date_format($date, 'd/m/Y H:i:s')."<br>";
	#output: 24/03/2012 17:45:12

	echo date_format($date, 'd/m/y')."<br>";
	#output: 24/03/12

	echo date_format($date, 'g:i A')."<br>";
	#output: 5:45 PM

	echo date_format($date, 'G:ia')."<br>";
	#output: 05:45pm

	echo date_format($date, 'g:ia \o\n l jS F Y')."<br>";
	#output: 5:45pm on Saturday 24th March 2012
}
?>
