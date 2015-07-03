<!DOCTYPE html>
<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="css/form.css">
		<link rel="stylesheet" type="text/css" href="css/default.css">
	</head>
	<body>
		<?php
		$include = 1; include("include/header.php");
		?>
		<!--A simple search system powered by MySQL-->
		<div class="searchContent">
		<form action="search_results.php" method="GET">
			<h1>Quick Search</h1>
			<input type="text" name="keyword" />
			&nbsp;
			<input type="submit" value="Search!" />
		</form>
		</div>
	</body>
</html>