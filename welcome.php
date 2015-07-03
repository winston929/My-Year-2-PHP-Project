<?php

// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// always modified
header("Last-Modifed: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");
// define variables and set to empty values
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Welcome to BuyCD</title>

		<link rel="stylesheet" type="text/css" href="css/default.css">
		<!--http://www.dynamicdrive.com/forums/showthread.php?33400-redirect-to-another-url-in-5-seconds
			It will redirect to the index.php in 5 secs	
		-->
		<meta http-equiv="refresh" content="5;URL=index.php">
		<script type="text/javascript">
			setTimeout("window.location='index.php'", 5000);
		</script>
	</head>
	<body>
		<?php 
		$include = 1; include("include/header.php");
		/* This is the welcome page. The user is redirected here
		 after they successfully log in. */

		// Need the session:
		if (!isset($_SESSION['username'])) {
			header("Location: login.php");
			exit ;
		}
		// Print the welcome message:
		print '<h2>Welcome to the BuyCD store</h2>';
		print '<p>Hello ' . $_SESSION['forename'] . ' (' . $_SESSION['username'] . ')!</p>';
		// Print how long they've been logged in:
		date_default_timezone_set('Europe/London');
		print '<p>You have been logged in since: ' . date('g:i a', $_SESSION['loggedin']) . '</p>';
		print '<p><b><i>This page will redirect in 5 seconds</i></b></p>';
		?>
	</body>
</html>

