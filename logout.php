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
		<title>Login</title>

		<link rel="stylesheet" type="text/css" href="css/default.css">
		<!--http://www.dynamicdrive.com/forums/showthread.php?33400-redirect-to-another-url-in-5-seconds-->
		<meta http-equiv="refresh" content="5;URL=url">
		<script type="text/javascript">
			setTimeout("window.location='index.php'", 5000);
		</script>
	</head>
	<body>
		<?php 
		$include = 1; include("include/header.php");
		/* This is the logout page. It destroys the session information. */
		
		// Need the session:
		if (!isset($_SESSION['username'])) {
			header("Location: login.php");
			exit ;
		}
		// Reset the session array:
		$_SESSION = array();
		
		//Destroy the session
		session_destroy();
		?>
		<h1>BuyCD Catalog</h1>
		<p>
			You are now logged out.
		</p>
		<p>
			Thank you for using this site. We hope that you liked it.
		</p>

	</body>
</html>
