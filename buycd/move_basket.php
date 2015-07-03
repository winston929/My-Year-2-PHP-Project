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
		<title>Move to Basket</title>

		<link rel="stylesheet" type="text/css" href="css/default.css">
		<link rel="stylesheet" type="text/css" href="css/form.css">
	</head>
	<body>
		
		<?php
		$include = 1;
		include ("include/header.php");
		?>
		<?php
		//If the user isn't logged in
		if ($_SESSION['isLoggedIn'] == false) {
			header('Location: login.php');
			exit ;
		}
		//When the user selected items from the list
		if (isset($_POST['submit']) && !$_SESSION['moveBacketDone']) {
			$done = false;

			$itemsCompleted = "<ul>";
			
			//User ID
			$userID = $_SESSION['userID'];
			
			//Looping the values which are ticked from the checkboxes
			foreach ($_POST as $cdID => $isTicked) {
				//If the value not equal to submit
				if ($cdID != 'submit') {
					
					//Inserting the values on the MySQL table
					$query = "INSERT INTO orders (userID, cdID, orderDate) VALUES ($userID, $cdID, NOW())";
					if ($dbc -> query($query) === TRUE) {
						
						//Fetching the DVD titles from the database
						$query2 = "SELECT dvd_title FROM cds WHERE id = $cdID";

						if ($result = mysqli_query($dbc, $query2)) {
							$item = "";
							while ($row = mysqli_fetch_array($result)) {
								$item = $row['dvd_title'];
							}
							$itemsCompleted .="<li>" .$item . "</li>";
						}

						$done = true;
					} else {
						echo mysqli_error($dbc);
					}
					
				}

			}
			
			mysqli_close();
			
			//If the process is done
			if ($done) {
				$itemsCompleted .= "</ul>";
				echo "<h1>Congratulations</h1>";
				echo "<p align=\"left\">These items are add to the basket sucessfully:</p>";
				echo '<p class= "details">'.$itemsCompleted.'<p>';
				$_SESSION['moveBacketDone'] = true;
			} else {
				echo "<p align=\"center\">We are not able to the items to the basket</p>";
				$_SESSION['moveBacketDone'] = false;
			}
		} else {
			header("Location: index.php");
			exit ;
		}
		?>
	</body>
</html>