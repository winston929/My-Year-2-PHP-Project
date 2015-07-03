<?php
// Create connection
$dbc = mysqli_connect("localhost", "webminer_edit", "akqj10", "webminer_buycd2");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
else {
	echo "Connected";
}
?> 