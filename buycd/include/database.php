
<?php

$dbc = mysqli_connect("localhost", "webminer_edit", "akqj10", "webminer_buycd2");
// Check connection
mysqli_set_charset($dbc, "utf8");
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>