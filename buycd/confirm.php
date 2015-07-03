<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Confirm Link</title>
		<link rel="stylesheet" type="text/css" href="css/default.css">
		</style>
	</head>
	<body>
		
		<?php
		$include = 1;
		include ("include/header.php");
	?>
		<h1>Email Activation</h1>
		<div align="center">
		<?php
		
		//Activation code
		$passkey = "";
		$isActivated = "";
		
		//This let the GET method to fetch the activated code
		if (isset($_GET['id'])) {
			$passkey = $_GET['id'];
		}

		$query = "SELECT id, isActivated FROM users WHERE activationID='$passkey'";
		$result = mysqli_query($dbc, $query);

		if ($result) {
			// Count how many row has this passkey
			$count = mysqli_num_rows($result);
			while ($row = mysqli_fetch_array($result)) {
				//Fetch the fields from the SQL table
				$userID = $row['id'];
				$isActivated = $row['isActivated'];
			}
			if ($count == 1 && $isActivated == 0) {
				echo "Your account has been activated successfully!";
			} elseif ($count == 1 && $isActivated == 1) {
				echo "Your account is already activated!";
			} else {
				echo "Wrong Confirmation code";
			}
			//When the activation code matches, it will set the user activated
			$query = "UPDATE users SET isActivated=1 WHERE id='$userID'";
			mysqli_query($dbc, $query);
		}

		mysqli_close($dbc);
		?></div>
	</body>
</html>