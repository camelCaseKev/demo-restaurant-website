<?php
/*
File:    delete_item.php
Author:  Kevin Viren
Date:    12/13/2024
*/

// Check for a valid item ID, through GET or POST
if( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From maintenance.php
	$id = $_GET['id'];
} elseif( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { 
	$id = $_POST['id'];
} else { // If no valid ID, kill script
	include('includes/header.html');
	echo '<p class="error">This page has been accessed in error.</p>';
	include('includes/footer.html');
	exit();
}

require('../../../final_project_mysqli_connect.php');

// Check if the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if($_POST['sure'] == 'Yes') { // Delete the record
		
		// QUERY
		$q = "DELETE FROM menu_items WHERE item_id=$id LIMIT 1";
		$r = @mysqli_query($dbc, $q);
		if(mysqli_affected_rows($dbc) == 1) { // If query ran OK
			include('includes/header.html');
			echo '<p>The menu item has been deleted.</p>';
		} else { // If the query did not run OK
			echo '<p class="error">The menu item could not be deleted due to a system error.</p>';
		}
		
	} else { // No confirmation of deletion
		include('includes/header.html');
		echo '<p>The item has not been deleted!</p>';
	}
	
} else { // Show the form

	$q = "SELECT name, description FROM menu_items WHERE item_id=$id";
	$r = @mysqli_query($dbc, $q);
	
	if(mysqli_num_rows($r) == 1) {
		
		$row = mysqli_fetch_array($r, MYSQLI_NUM);

		$page_title = "Delete Item: $row[0]";
		include('includes/header.html');
		echo '<h1>Delete a Menu Item</h1>';
		
		// Display the record being deleted
		echo "<h3>Name: $row[0]</h3>
		Are you sure you want to delete this item?";
		
		echo '
		<form action="delete_item.php" method="POST">
			<input type="radio" name="sure" value="Yes">Yes
			<input type="radio" name="sure" value="No" checked="checked">No
			<input type="submit" name="submit" value="Submit">
			<input type="hidden" name="id" value="' . $id . '">
		</form>';
	} else { 
		echo '<p class="error">This page has been accessed in error.</p>';
	}
}

mysqli_close($dbc);
include('includes/footer.html');
?>