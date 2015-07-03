<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>CD/DVD List</title>
		<link rel="stylesheet" type="text/css" href="css/table.css">
		<link rel="stylesheet" type="text/css" href="css/default.css">
		<script src="script/table.js"></script>
	</head>
	<body>
		<?php
	
		$include = 1;
		include ("include/header.php");
		?>
		<h1>CD/DVD List</h1>
		<?php
		//Elements show on the table
		$element = array("DVD Title", "Owner" ,"Studio", "Price", "Rating", "Year", "Genre");
		
		/*Fields from the SQL tables
		   * CONCAT means joining the fields together in SQL
	   */
		$key = array("dvd_title", "CONCAT(ow.givenname, ' ', ow.surname)","studio", "price", "rating", "year", "genre", "id");


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

		$useTable = 1;
		include ("view_tables.php");
		?>
	</body>
</html>
