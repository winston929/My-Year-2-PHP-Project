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
		<link rel="stylesheet" type="text/css" href="css/form.css">
	</head>
	<body>
		<?php
		$include = 1;
		include ("include/header.php");
		$onError = "";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Handle the form:
			if ((!empty($_POST['username'])) && (!empty($_POST['password']))) {
				$username = ($_POST['username']);
				//Password typed
				$password1 = ($_POST['password']);
				//The password in the server
				$password2="";
				
				//Is the account activated?
				$isActivated = true;
				
				// Connect and select:
				$query = "SELECT * FROM users WHERE username ='" . $username . "' AND
					password='" . $password1 . "'";

				if ($result = mysqli_query($dbc, $query)) {
					while ($row = mysqli_fetch_array($result)) {
						//Fetch the fields
						$userID = $row['id'];
						$password2 = $row['password'];
						$forename = $row['forename'];
						$surname = $row['surname'];
						$isActivated = $row['isActivated'];
						$isAdmin = $row['isAdmin'];
						$address = $row['address'];
						$postcode = $row['postcode'];
						$postcode = $row['postcode'];
					}
					if ($isActivated == TRUE && $password1 == $password2) {// Correct!

						//Create session variables
						$_SESSION['username'] = $_POST['username'];
						$_SESSION['loggedin'] = time();
						$_SESSION['forename'] = $forename;
						$_SESSION['surname'] = $surname;
						$_SESSION['isLoggedIn'] = true;
						$_SESSION['isAdmin'] = $isAdmin;
						$_SESSION['address'] = $address;
						$_SESSION['postcode'] = $postcode;
						$_SESSION['userID'] = $userID;

						mysqli_close($dbc);
						// Redirect the user to the welcome page!

						header('Location: welcome.php');
						exit();

					}//If the account isn't activated
					elseif ($isActivated == FALSE) {
						$onError = '* Your account hasn\'t been activated!';
					} else {// Username/Passowrd Incorrect!

						$onError = '* The submitted username and/or password is not valid!';

					}

				}
			} else {
				$onError = '* Please make sure you enter both username and password!';
			}
			mysqli_close($dbc);
		}
 ?>
<!--Login Fields--> 
 <h1>User Login</h1><div class="loginContent">
			<div class="error"><?php echo $onError; ?></div>
		<form action="login.php" method="post">
			<table><tr>
				<td><span class="majorData">Username</span></td>
				<td><input type="text" name="username" size="20" /></td>
			</tr>
			<tr>
				<td><span class="majorData">Password</span></td>
				<td><input type="password" name="password" size="20" /></td>
			</tr>
			</table>
			<p>
				<input type="submit" name="submit" value="Log In!" />
			</p>
		</form>
	</div>
	</body>
</html>