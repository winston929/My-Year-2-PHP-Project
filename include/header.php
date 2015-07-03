<?php
include 'database.php';
if (!isset($include)) {
	$include = 0;
	if ($include != 1) {
		exit ;
	}
}
?>
<table width="1050">
	<tr>
		<!--Logo for the website-->
		<td class="leftCell"><img class="headerImg" src="img/cd.png" width="100" height="100"><h1 class="header">BuyCD online!</h1></td>
		<td class="rightCell">
		<?php
		
		
		$menuNotLoggedIn = '<ul id="main_menu">
			<li>
				<a href="/buycd">Home</a>
			</li>
			<li>
				<a href="page-1-field-dvd_title-sortin-asc">CD/DVD List</a>
			</li>
			<li>
				<a href="register">Sign Up</a>
			</li>
			<li>
				<a href="login">Login</a>
			</li>';

		
		$menuLoggedIn = '<ul id="main_menu">
			<li>
				<a href="/buycd">Home</a>
			</li>
			<li>
				<a href="page-1-field-dvd_title-sortin-asc">CD/DVD List</a>
			</li>
			<li>
				<a href="basket">Shopping Basket</a>
			</li>
			<li>
				<a href="logout">Log Out</a>
			</li>
			';
	
		$adminMenu = '<ul id="main_menu">
			<li>
				<a href="/buycd">Home</a>
			</li>
			<li>
				<a href="page-1-field-dvd_title-sortin-asc">CD/DVD List</a>
			</li>
			<li>
				<a href="basket">Shopping Basket</a>
			</li>
			<li>
				<a href="add_cds">Add CD</a>
			</li>
			<li>
				<a href="logout">Log Out</a>
			</li>';

		session_start();
				if (isset($_SESSION['isLoggedIn'])) {

			if ($_SESSION['isLoggedIn'] && $_SESSION['isAdmin']) {
				echo $adminMenu;
			} elseif ($_SESSION['isLoggedIn'] && !$_SESSION['isAdmin']) {
				echo $menuLoggedIn;
			} else {
				echo $menuNotLoggedIn;
			}
			} else {
			echo $menuNotLoggedIn;
		}
		?></td>
	</tr>
</table>

