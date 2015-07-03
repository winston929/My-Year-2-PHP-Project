<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<title>My Purchases</title>
		<link rel="stylesheet" type="text/css" href="css/default.css">
		<link rel="stylesheet" type="text/css" href="css/table.css">
		<script src="script/table.js"></script>
	</head>

	<body>
		<?php $include = 1; include("include/header.php");
		
		//This will return to homepage if user hasn't logged in
		if($_SESSION['isLoggedIn']==false){
			header("Location: index.php");
			exit;
		}
		?>
				<h1>My Purchases</h1>
		<?php
		$basket=true;
		
		//User ID of the user
		$userID=$_SESSION['userID'];
		
		
		//Elements show on the table
		$element = array("DVD Title", "Owner", "Year", "Genre", "Rating", "Ordered Date", "Price");
		
		/*Fields from the SQL tables
		   * CONCAT means joining the fields together in SQL
	   */
		$key = array("dvd_title", "CONCAT(ow.givenname, ' ', ow.surname)","year", "genre", "rating", "orderDate", "price", "c.id");

		//The GET method fields
		if (!isset($_GET['page'])) {
			$_GET['page'] = 1;
		}
		$page = $_GET['page'];

		if (!isset($_GET['field'])) {
			$_GET['field'] = $key[0];
		}
		$field = $_GET['field'];

		if (!isset($_GET['sortin'])) {
			$_GET['sortin'] = "asc";
		}
		$sortin = $_GET['sortin'];

		$useTable = 3;
		//Use view_tables.php
		include ("view_tables.php");?>
	</body>
</html>
