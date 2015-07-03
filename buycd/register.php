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

<!--Referenced from http://www.w3schools.com/php/php_form_validation.asp
					http://www.w3schools.com/Php/php_sessions.asp
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign up for BuyCD</title>
 	<link rel="stylesheet" type="text/css" href="css/form.css">
 	<link rel="stylesheet" type="text/css" href="css/default.css">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<body>
<?php $include = 1; include("include/header.php");

// Define variables and set to empty values
$fornameErr = $surnameErr = $usernameErr = $passwordErr = $emailErr = $genderErr = $dobErr = $addressErr = '';
$forename = $surname = $username = $password = $confirm = $email = $gender = $address = '';
$day = $month = $year = 0;

//Boolean for registration is completed or not
$completed = TRUE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//Checking forname
	if (empty($_POST["forename"])) {$fornameErr = "Forename is required";
		$completed = FALSE;
	} else {
		$forename = test_input($_POST["forename"]);
		if (!preg_match("/^[a-zA-Z -]*$/", $forename)) {
			$fornameErr = "Only letters and white space allowed";
			$completed = FALSE;
		} else {
			$forename = test_input($_POST["forename"]);
		}
	}
	//Checking surname
	if (empty($_POST["surname"])) {$surnameErr = "Surname is required";
		$completed = FALSE;
	} else {
		$surname = test_input($_POST["surname"]);
		if (!preg_match("/^[a-zA-Z '\-]*$/", $surname)) {
			$surnameErr = "Only letters and white space allowed";
			$completed = FALSE;
		} else {
			$surname = test_input($_POST["surname"]);
		}
	}
	//Checking username
	if (empty($_POST["username"])) {$usernameErr = "Username is required";
		$completed = FALSE;
	} else {
		$username = test_input($_POST["username"]);
		if (!preg_match("^[a-z0-9_-]{3,15}$^", $username)) {
			$usernameErr = "Only letters and number from 3-15 characters are allowed";
			$completed = FALSE;
		} else {
			$username = test_input($_POST["username"]);
		}
	}
	//Checking email
	if (empty($_POST["email"])) {$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
			$emailErr = "Email format is not valid";
			$completed = FALSE;
		} else {
			$email = test_input($_POST["email"]);
		}
	}
	
	//Checking password
	if (empty($_POST["password"])) {$passwordErr = "Password is required";
		$completed = FALSE;
	} else {
		//Matching password
		if (($_POST["password"]) != ($_POST["confirm"])) {
			$passwordErr = "Your passwords do not match. Please try again";
			$completed = FALSE;
		} else {
			if (preg_match("^.{6,15}$^", ($_POST["password"]))) {
				$password = test_input($_POST["password"]);
				$confirm = test_input($_POST["confirm"]);
			} else {
				$passwordErr = "Your password should be between 6-15 characters";
			}
		}

	}
	//Checking gender
	if (empty($_POST["gender"])) {$genderErr = "Gender is required";
		$completed = FALSE;
	} else {
		$gender = test_input($_POST["gender"]);
	}
	//Checking DOB
	if (empty($_POST["day"]) || empty($_POST["month"]) || empty($_POST["year"])) {
		$dobErr = "Date of birth is required";
		$completed = FALSE;
	} else {
		$day = $_POST["day"];
		$month = $_POST["month"];
		$year = $_POST["year"];
	}
	
	//Checking address
	if (empty($_POST["address"])) {$addressErr = "Address is required";
		$completed = FALSE;
	} else {
		$address = test_input($_POST["address"]);
	}
	//When submit button is clicked
	if (!empty($_POST['submit'])) {

		if ($completed) {
			//Check any repeated usernames
			$query = "SELECT username FROM users WHERE username='$username'";
			$rows = 0;
			if ($result = mysqli_query($dbc, $query))
				$rows = mysqli_num_rows($result);

			mysqli_close($dbc);
			if ($rows == 0) {//If the data are all valid, it will transfter all the fields by PHP session
				$_SESSION['username'] = $username;
				$_SESSION['forename'] = $forename;
				$_SESSION['surname'] = $surname;
				$_SESSION['password'] = $password;
				$_SESSION['email'] = $email;
				$_SESSION['gender'] = $gender;

				$_SESSION['day'] = $day;
				$_SESSION['month'] = $month;
				$_SESSION['year'] = $year;
				$_SESSION['address'] = $address;
				$_SESSION['postcode'] = $_POST['postcode'];

				$_SESSION['theForm'] = "completed";
				
				//Redirect page
				header('Location: handle_reg.php');
				exit ;
			} else {
				$usernameErr = "The username $username is alreday taken";
			}
		}

	}
}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
<div class="content">
<h1>Sign up to BuyCD</h1>
<p><span class="error">* required field.</span></p>
<!-- It will valid the page in its own page -->
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  	<input type="hidden" name="theForm" />
 
 <table>
    <tr>
       <td><span class="majorData">Email</span></td>
       <td><input type="text" name="email"></td>
       <td><span class="error">* <?php echo $emailErr; ?></span></td>
    </tr>
     <tr>
       <td><span class="majorData">Username</span></td>
       <td><input type="text" name="username"></td>
       <td><span class="error">* <?php echo $usernameErr; ?></span></td>
     </tr>
     <tr>
       <td><span class="majorData">Password</span></td>
       <td><input type="password" name="password" size="20" /></td>
       <td><span class="error">* <?php echo $passwordErr; ?></span></td>
     </tr>
     <tr>
       <td><span class="majorData">Confirm Password</span></td>
       <td><input type="password" name="confirm" size="20" /></td>
       <td></td>
     </tr>
      <tr>
       <td></td>
       <td></td>
       <td></td>
     </tr>
     <tr>
       <td>Forename</td>
       <td><input type="text" name="forename"></td>
       <td><span class="error">* <?php echo $fornameErr; ?></span></td>
     </tr>
     <tr>
       <td>Surname</td>
       <td><input type="text" name="surname"></td>
       <td><span class="error"> * <?php echo $surnameErr; ?></span></td>
     </tr>
     <tr>
       <td>Date of birth</td>
       <td><span class="error">

<select name="day">
<option value="">Day</option>
<?php
	// Print out 31 days:
	for ($i = 1; $i <= 31; $i++) {
		echo "<option value=\"$i\">$i</option>\n";
	}
						?>
</select>

<select name="month">
<option value="">Month</option>
<?php
//Print the months
$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
for ($i = 0; $i < count($months); $i++) {
	print '<option value="' . ($i + 1) . '">' . $months[$i] . "</option>\n";
}
	?>
</select>

<select name="year">
<option value="">Year</option>
<?php // Print out the years:
	for ($i = date("Y") - 18; $i >= 1900; $i--) {
		echo "<option value=\"$i\">$i</option>\n";
	}
						?>
</select>

       </span></td>
       <td><span class="error">* <?php echo $dobErr; ?></span></td>
     </tr>
     <tr>
       <td> Gender</td>
       <td><input type="radio" name="gender" value="F">Female
         <input type="radio" name="gender" value="M">Male</td>
       <td><span class="error">* <?php echo $genderErr; ?></span></td>
     </tr>
     <tr>
     	<td>Address</td>
     <td><textarea name="address" rows="3" cols="20"></textarea></td>
      <td><span class="error">* <?php echo $addressErr; ?></span></td>
	</tr>
	 <tr>
     	<td>Postcode</td>
     <td><input type="text" name="postcode"></td>
      <td></td>
	</tr>
     <tr>
       <td></td>
       <td><input type="submit" name="submit" value="Sign up!"></td>
       <td></td>
     </tr>
   </table>
   <br>
</form>
</div>
</body>
</html>