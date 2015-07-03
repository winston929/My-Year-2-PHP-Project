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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Add a CD Entry</title>
		<link rel="stylesheet" type="text/css" href="css/form.css">
		<link rel="stylesheet" type="text/css" href="css/default.css">
	</head>
	<body>
		<?php $include = 1; include("include/header.php");?>
		<h1>Add a new DVD record</h1>
		<?php // Script 12.6 - add_cds.php #2
			/* This script adds a CD entry to the database. It now does so securely! */
			/* Adapted from Ullman's add_entries.php */
			
			$allKeys = array("DVD_Title", "Studio", "Released", "Status", "Sound", "Versions", "Price", "Rating", "Year", "Genre", "Aspect", "UPC", "DVD_ReleaseDate", "Timestamp");
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {// Handle the form.

				// Connect and select:

				// Validate and secure the form data:
				$problem = FALSE;
				if (!empty($_POST['title']) && !empty($_POST['artist']) && !empty($_POST['artist'])) {
					$title = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['title'])));
					$artist = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['artist'])));
					$year = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['year'])));
				} else {
					print '<p style="color: red;">Please submit the required information</p>';
					$problem = TRUE;
				}

				if (!$problem) {
					
					// Define the query:
					$elements;
			foreach ($_POST as $cdID => $isTicked) {
				if ($cdID != 'submit') {
					$query = "INSERT INTO cds (" . implode(', ', $key) . ") VALUES ('".implode("', '", $elements)."')";

					// Execute the query:
					if ($dbc -> query($query) === TRUE) {
						print '<p>The CD entry has been added!</p>';
					} else {
						print '<p style="color: red;">Could not add the entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
					}
				}
								}

				}// No problem!

				mysqli_close($dbc);
				// Close the connection.

			} // End of form submission IF.

			// Display the form:
		?>
<form action="add_cds.php" method="post"><?php 
	
	$fields= array("DVD Title", "Studio", "Released", "Status", "Sound", "Versions", "Price(£)", "Rating", "Year", "Genre", "Aspect", "UPC", "DVD ReleaseDate", "Timestamp");
			print "<table>";
			for($i=0;$i<count($fields);$i++){
			 print "<tr>";
			 print "<td>$fields[$i]</td>";
			 print '<td><input type="text" name="'.$allKeys[$i].'" size="30" /></td></tr>';
			}
			print "</table>";
			?>
			<br />
			<input type="submit" name="submit" value="Post This Entry!" />
		</form>
	</body>
</html>