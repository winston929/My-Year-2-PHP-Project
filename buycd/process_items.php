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
		<meta charset="utf-8">

		<title>Processing items</title>

		<link rel="stylesheet" type="text/css" href="css/default.css">
		<link rel="stylesheet" type="text/css" href="css/form.css">
		<link rel="stylesheet" type="text/css" href="css/table.css">

		<script src="script/table.js"></script>

	</head>

	<body>
		<?php
		$include = 1;
		include ("include/header.php");
		if (!$_SESSION['processDone']) {

			$itemsCompleted = "<ul>";
			
			//The arrays for ids selected from the form
			$idsList = array();
			$idsList2 = array();
			
			//If purchase is selected
			if (isset($_POST['purchase'])) {
				$completed = true;

				foreach ($_POST as $cdID => $isTicked) {
					if ($cdID != 'purchase') {
						array_push($idsList, "c.id=" . $cdID);
						array_push($idsList2, "cdID=" . $cdID);
					}
				}
				if ($completed) {
					$paying = true;

					$itemsCompleted .= "</ul>";
					
					//Message on the screen
					echo "<h1>Congratulations</h1>";
					echo "<p align=\"left\">These items will be sent to your home within 5 days:</p>";
					
					//Elements show on the table
					$element = array("DVD Title", "Owner", "Ordered Date", "From", "Price");
					/*Fields from the SQL tables
		   				* CONCAT means joining the fields together in SQL
	   				*/
					$key = array("dvd_title", "CONCAT(ow.givenname, ' ', ow.surname)", "orderDate", "CONCAT( ow.address, ', ', ow.town, ', ', ow.postcode )", "price");

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
					
					//View the tables
					$useTable = 4;
					include ("view_tables.php");
					
					//Update query for setting the orders are paid
					$query = "UPDATE orders SET isPaid =1 WHERE ".implode(" OR ", $idsList2);
					
					// Execute the query:
					if ($dbc -> query($query) === TRUE) {
						$complete = true;
							//Shipping details
							echo "<p align=\"left\">Your shipping details:</p>";
							echo $_SESSION['forename']."<br>";
							echo $_SESSION['surname']."<br>";
							echo $_SESSION['address']."<br>";
							echo $_SESSION['postcode']."<br>";
							
							//A Paypal button
							echo '<a href="index.php">
							<img src="img/paypal.png" width="10%" height="10%"></a>';
				
					} else {
						$complete = false;
						echo mysqli_error($dbc);
					}

					$_SESSION['processDone'] = true;
				} else {
					echo "Failed";
					$_SESSION['processDone'] = false;
				}

			}//If the remove button is clicked 
			else if (isset($_POST['remove'])) {
				$completed = true;
				//Delete the values which are selected from the list
				foreach ($_POST as $cdID => $isTicked) {
					if ($cdID != 'remove') {
						$query = "DELETE FROM orders
								  WHERE orders.cdID = $cdID";
						$query2 = "SELECT dvd_title FROM cds WHERE id = $cdID";

						if ($result = mysqli_query($dbc, $query2)) {
							$item = "";
							while ($row = mysqli_fetch_array($result)) {
								$item = $row['dvd_title'];
							}
							$itemsCompleted .= "<li>" . $item . "</li>";
						}

						// Execute the query:
						if ($dbc -> query($query) === TRUE) {
							$completed = true;
						} else {
							$completed = false;
						}
					}
				}
				if ($completed) {
					$itemsCompleted .= "</ul>";
					echo "<h1>Items Deleted</h1>";
					echo "<p align=\"left\">These items are deleted successfully:</p>";
					echo '<p class= "details">' . $itemsCompleted . '<p>';
					$_SESSION['processDone'] = true;
				} else {
					echo "Failed";
					$_SESSION['processDone'] = false;
				}
			}
		}

		mysqli_close($dbc);
		$_SESSION['processDone'] = true;
		?>
	</body>
</html>