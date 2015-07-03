<!DOCTYPE html>
<html lang="en">
<?php
$keyword = "";
$search = true;
if (isset($_GET['keyword'])) {
	$keyword = $_GET['keyword'];
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo "Search Results- $keyword"; ?></title>
<link rel="stylesheet" type="text/css" href="css/default.css">
<link rel="stylesheet" type="text/css" href="css/table.css">
<script src="script/table.js"></script>
</head>
<body>
<?php
$include = 1;
include ("include/header.php");
?>

<h1>Search Results</h1>
<?php

//Elements show on the table
$element = array("DVD Title", "Owner", "Studio", "Price", "Rating", "Year", "Genre");

//Elements show on the table
$key = array("dvd_title", "CONCAT(ow.givenname, ' ', ow.surname)", "studio", "price", "rating", "year", "genre", "id");

//Keys the join the SQL statement
$key2 = array("dvd_title", "ow.givenname", "ow.surname", "studio", "price", "rating", "year", "genre", "id");

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

//Join the query
for ($i = 0; $i < count($key); $i++) {
	$matches[$i] = "$key2[$i] LIKE '%$keyword%' ";
}
$useTable = 2;
include ("view_tables.php");
		?>
	</body>
</html>
