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
		<title>Registration</title>
        <link rel="stylesheet" type="text/css" href="css/form.css">
		<link rel="stylesheet" type="text/css" href="css/default.css">
	</head>
	<body>

		<?php
		$include = 1; include("include/header.php");
		//If the form isn't completed
		if (!isset($_SESSION['theForm'])) {
			//It will go back to the register page
			header("Location: register.php");
			session_destroy();
			exit ;
		} //If the form is completed
		else if ($_SESSION['theForm'] == 'completed') {
			//Matching the Session variables from the register
			$username = $_SESSION['username'];
			$forename = $_SESSION['forename'];
			$surname = $_SESSION['surname'];
			$password = $_SESSION['password'];
			$email = $_SESSION['email'];
			$gender = $_SESSION['gender'];

			$day = $_SESSION['day'];
			$month = $_SESSION['month'];
			$year = $_SESSION['year'];

			$address = $_SESSION['address'];
			$postcode = $_SESSION['postcode'];
			
			//It generates an activation code and it will be sent via email
			$activationID = md5(uniqid(rand()));

			// Connect and select:
			$query = "INSERT INTO users (username ,forename, surname, password, email, gender, isAdmin, dob, activationID, address, postcode) 
					VALUES ('$username','$forename', '$surname', '$password', '$email', '$gender', 0, '$year-$month-$day', '$activationID', '$address', '$postcode')";
			$to = $email;

			// Your subject
			$subject = "Your confirmation link here";

			// From
			$header = "From: Winston Chan <tchan001@gold.ac.uk>";

			// Your message
			$message = "Your Comfirmation link \r\n";
			$message .= "Click on this link to activate your account \r\n";
			$message .= 'http://doc.gold.ac.uk/~ma201tc/buycd/confirm.php?id=' . $activationID;
			
			//PHP mail function
			$sentmail = mail($to, $subject, $message, $header);

			// if your email succesfully sent
			if ($sentmail) {

				if ($dbc -> query($query) === TRUE) {
					print "<h1>Congratulations!</h1>";
					print "Your Confirmation link Has Been Sent To Your Email Address.<br />";
					print "$forename<br />";
					print "$surname<br />";
					print "$address<br />";
					print "$postcode<br />";
				} else {
					print '<p style="color: red;">Could not add the entry because:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
				}

			} else {
				echo "Cannot send Confirmation link to your e-mail address";
			}

			mysqli_close($dbc);
			session_destroy();
		}
	?>
</body>
</html>