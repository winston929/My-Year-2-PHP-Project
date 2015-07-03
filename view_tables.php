<?php

if (!isset($useTable)) {
	$useTable = 0;
	if ($useTable != 1) {
		exit ;
	}
}
//Target page for the links in pagination
if ($useTable == 1)
	$targetpage = "list_cd.php";
else if ($useTable == 2)
	$targetpage = "search_results.php";
else if ($useTable == 3)
	$targetpage = "basket.php";
else if ($useTable == 4)
	$targetpage = "process_items.php";

$_SESSION['processDone'] = false;
?>

<?php
//If shopping basket is selected
if (!isset($basket))
	echo "<form action=\"move_basket.php\" method=\"POST\">";
else//The rest the the pages are selected
	echo "<form id=\"form1\" action=\"process_items.php\" method=\"POST\">";

$_SESSION['moveBacketDone'] = false;

//Referenced from http://www.a2zwebhelp.com/php-mysql-pagination

if (!isset($search)) {//If not the search query
	$query = "SELECT * FROM cds c, owners ow  WHERE c.owner = ow.userid";
} else {//If it is the search query
	$query = "SELECT * FROM cds c, owners ow WHERE (" . implode(' OR ', $matches) . ") AND c.owner = ow.userid";
}

if (isset($basket)) {//Basket page
	$query = "SELECT * FROM cds c, orders o, users u, owners ow WHERE 
	u.id = o.userID AND 
	ow.userID=c.owner AND
	c.id = o.cdID AND 
	u.id = $userID AND
	isPaid = 0";
}

if ($result = mysqli_query($dbc, $query)) {
	// Return the number of rows in result set
	$total = mysqli_num_rows($result);
} else {
	//header('Location: index.php');
	//exit ;
	echo "Error 1 " . $query;
}

//how many items to show per page
$limit = 10;

if ($page) {
	//first item to display on this page
	$start = ($page - 1) * $limit;
} else {
	$start = 0;
}
?>
<table class="nav">
<tr>

<?php
//It will display Sort by and selection in which order(ascending/descending)
if (!isset($paying)) {
	echo '<td class="leftCell"> Sort by:<select onchange="goToPage(value)">';
	for ($i = 0; $i < count($element); $i++) {
		if (!isset($search)) {
			if ($key[$i] != $field) {
				echo '<option value="' . $targetpage . '?page=1&field=' . $key[$i] . '&sortin=' . $sortin . '">' . $element[$i] . '</option>';
			} else {
				echo '<option selected="yes" value="' . $targetpage . '?page=1&field=' . $key[$i] . '&sortin=' . $sortin . '">' . $element[$i] . '</option>';
			}
		} else {
			if ($key[$i] != $field) {
				echo '<option value="' . $targetpage . '?keyword=' . $keyword . '&page=1&field=' . $key[$i] . '&sortin=' . $sortin . '">' . $element[$i] . '</option>';
			} else {
				echo '<option selected="yes" value="' . $targetpage . '?keyword=' . $keyword . '&page=1&field=' . $key[$i] . '&sortin=' . $sortin . '">' . $element[$i] . '</option>';
			}
		}
	}

	echo '</select></td><td class="rightCell"> Order:<select onchange="goToPage(value)">';

	if (!isset($search)) {
		if ($sortin == "asc") {
			echo '<option selected="yes" value="' . $targetpage . '?page=1&field=' . $field . '&sortin=asc">Ascending</option>';
			echo '<option value="' . $targetpage . '?page=1&field=' . $field . '&sortin=desc">Descending</option>';
		} elseif ($sortin == "desc") {
			echo '<option value="' . $targetpage . '?page=1&field=' . $field . '&sortin=asc">Ascending</option>';
			echo '<option selected="yes" value="' . $targetpage . '?page=1&field=' . $field . '&sortin=desc">Descending</option>';
		}
	} else {
		if ($sortin == "asc") {
			echo '<option selected="yes" value="' . $targetpage . '?keyword=' . $keyword . '&page=1&field=' . $field . '&sortin=asc">Ascending</option>';
			echo '<option value="' . $targetpage . '?keyword=' . $keyword . '&page=1&field=' . $field . '&sortin=desc">Descending</option>';
		} elseif ($sortin == "desc") {
			echo '<option value="' . $targetpage . '?keyword=' . $keyword . '&page=1&field=' . $field . '&sortin=asc">Ascending</option>';
			echo '<option selected="yes" value="' . $targetpage . '?keyword=' . $keyword . '&page=1&field=' . $field . '&sortin=desc">Descending</option>';
		}
	}

	echo "</select></td></table>";
}
?>
<br />

<?php
//The values are come from the array above called $key, which will be separated with comma;
//and join the $query string for SQL command
if (isset($paying)) {
	//Payment!
	$query = "SELECT " . implode(', ', $key) . " FROM cds c, orders o, owners ow, users u
			WHERE o.cdid = c.id
			AND c.owner = ow.userid
			AND o.userid = u.id
			AND ispaid=0
			AND o.userid =" . $_SESSION['userID'] . "
			AND (" . implode(" OR ", $idsList).")";
} elseif (isset($basket)) {
	//The basket
	$query = "SELECT " . implode(', ', $key) . " FROM cds c, orders o, users u, owners ow WHERE 
				u.id = o.userID AND 
				ow.userID=c.owner AND
				c.id = o.cdID AND 
				u.id = $userID AND
				isPaid = 0
				ORDER BY $field $sortin
				LIMIT $start , $limit";

} else if (!isset($search)) {
	//If it is not search query
	$query = "SELECT " . implode(', ', $key) . " FROM cds c, owners ow  WHERE c.owner = ow.userid ORDER BY " . $field . " $sortin LIMIT $start, $limit";
} else {
	//Search query!
	$query = "SELECT " . implode(', ', $key) . " FROM cds c, owners ow  WHERE ( " . implode(' OR ', $matches) . ") AND c.owner = ow.userid ORDER BY $field $sortin LIMIT $start, $limit";
}
/* Setup page vars for display. */
//if no page var is given, default to 1.
if ($page == 0)
	$page = 1;
//previous page is current page - 1
$prev = $page - 1;
//next page is current page + 1
$next = $page + 1;
//lastpage
$lastpage = ceil($total / $limit);
if ($result = mysqli_query($dbc, $query)) {

	// Run the query.
	// Retrieve and echo in a table:
	
	//If it isn't payment page is will appear tickboxes
	if (!isset($paying)) {
		echo "<table class=\"results\" id=\"tick\"><tr>";
		echo "<th><input type=\"checkbox\" onclick=\"tickAll()\" /></th>";
	}else{
			
			echo "<table class=\"results\"><tr>";
	}
	for ($i = 0; $i < count($element); $i++) {
		echo "<th>" . $element[$i] . "</th>";
	}
	echo "</tr>";

	while ($row = mysqli_fetch_array($result)) {
		//If it isn't payment page is will appear tickboxes
		if (!isset($paying)) {
			echo "<tr><td><input type=\"checkbox\" name=\"" . $row['id'] . "\" /></td>";
		}
		//Go through all the elements
		for ($i = 0; $i < count($element); $i++) {
			echo "<td>";
			//Displays the pound sign in "Price" before its value
			if ($element[$i] == "Price") {
				echo "£" . $row[$key[$i]];
				
			//Display the ordered date in proper British format
			} else if ($element[$i] == "Ordered Date") {
				echo date('d-m-Y H:m:s', strtotime($row[$key[$i]]));
			} else
				echo $row[$key[$i]];

			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table></div>";

} else {// Query didn't run.
	//header('Location: index.php');
	//exit ;
	echo "Error 2 " . $query;
}// End of query IF.

//If Basket is selected
if (isset($basket)) {
	//Calculating the price
	$totalPrice = 0.0;
	$query = "SELECT SUM(price) AS totalPrice
			FROM cds c, orders o, users u
			WHERE u.id = o.userID
			AND c.id = o.cdID
			AND o.isPaid = 0
			AND u.id =$userID";
	if ($result = mysqli_query($dbc, $query)) {
		while ($row = mysqli_fetch_array($result)) {
			$totalPrice = $row['totalPrice'];
		}
	} else {
		// header('Location: index.php');
		// exit ;
	}
	//If nothing is selected from the list
	if ($totalPrice != NULL) {
		echo "<p class=\"total\">Total Price: £$totalPrice</p>";
	} else {
		echo "<p class=\"total\">Total Price: £0</p>";
	}
}
//If Payment isn't selected
if(!isset($paying)){
?>
<br />
<table class="nav">
<tr>
<td class="footerLeftCell"> Select a page:
<select id="myList" onchange="goToPage(value)">
<?php
//Drop down list of all the pages, which are activated via JavaScript
if ($total == 0) {
	$lastpage = 1;
}
for ($i = 1; $i <= $lastpage; $i++) {
	if (!isset($search)) {
		if ($i != $page)
			echo '<option value="' . $targetpage . '?page=' . $i . '&field=' . $field . '&sortin=' . $sortin . '">Page ' . $i . ' of ' . $lastpage . '</option>';
		else {
			echo '<option selected="yes" value="' . $targetpage . '?page=' . $page . '&field=' . $field . '&sortin=' . $sortin . '">Page ' . $i . ' of ' . $lastpage . '</option>';
		}
	} else {
		if ($i != $page)
			echo '<option value="' . $targetpage . '?keyword=' . $keyword . '&page=' . $i . '&field=' . $field . '&sortin=' . $sortin . '">Page ' . $i . ' of ' . $lastpage . '</option>';
		else
			echo '<option selected="yes" value="' . $targetpage . '?keyword=' . $keyword . '&page=' . $i . '&field=' . $field . '&sortin=' . $sortin . '">Page ' . $i . ' of ' . $lastpage . '</option>';
	}
}
?>
</select>&nbsp;&nbsp;&nbsp;
<?php
if (isset($basket)) {
	if ($total != 0) {
		echo "<input type=\"submit\" name=\"purchase\" id=\"basket\" value=\"Purchase！\" />&nbsp;&nbsp;";
		echo "<input type=\"submit\" name=\"remove\" id=\"basket\"   value=\"Remove items\" />";
	} else {
		echo "<input type=\"submit\" name=\"purchase\" id=\"basket\" value=\"Purchase！\" disabled />&nbsp;&nbsp;";
		echo "<input type=\"submit\" name=\"remove\" id=\"basket\"   value=\"Remove items\" disabled />";
	}
} else {
	echo "<input type=\"submit\" name=\"submit\" value=\"Move to Basket！\" />";
}
}
?>
</td><td class="rightCell">
<div>
<?php
if (!isset($paying)) {
	/* Page navagation for different pages */
	$pagination = "";
	$counter = 0;
	if (!isset($search)) {
		if ($lastpage > 1) {
			if ((int)$page > $counter + 1) {
				$pagination .= "<a href=\"page-1-field-$field-sortin-$sortin\">First Page</a> | ";
				$pagination .= "<a href=\"page-$prev-field-$field-sortin-$sortin\">Previous</a> | ";
			} else {
				$pagination .= "First Page | Previous| ";
			}

			//next button
			if ($page < $lastpage) {
				$pagination .= "<a href=\"page-$next-field-$field-sortin-$sortin\">Next</a> | ";
				$pagination .= "<a href=\"page-$lastpage-field-$field-sortin-$sortin\">Last Page</a>";
			} else {
				$pagination .= "Next | Last Page";
			}
		}
	} else {
		if ($lastpage > 1) {
			if ((int)$page > $counter + 1) {
				$pagination .= "<a href=\"$targetpage?keyword=$keyword&page=1&field=$field&sortin=$sortin\">First Page</a> | ";
				$pagination .= "<a href=\"$targetpage?keyword=$keyword&page=$prev&field=$field&sortin=$sortin\">Previous</a> | ";
			} else {
				$pagination .= "First Page | Previous| ";
			}

			//next button
			if ($page < $lastpage) {
				$pagination .= "<a href=\"$targetpage?keyword=$keyword&page=$next&field=$field&sortin=$sortin\">Next</a> | ";
				$pagination .= "<a href=\"$targetpage?keyword=$keyword&page=$lastpage&field=$field&sortin=$sortin\">Last Page</a>";
			} else {
				$pagination .= "Next | Last Page";
			}
		}

	}
	$pagination .= "</div>\n";
	//Print the pagination
	echo $pagination;
}
?>
</form>
</td>
</tr>
</table>