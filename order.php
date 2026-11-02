<?php
/*
File:    order.php
Author:  Kevin Viren
Date:    12/14/2024
*/
$page_title = 'Order';
include('includes/header.html');


// FUNCTION DEFINITIONS

function create_select_item($value, $name, $selected_value) {
	$selected = ($value == $selected_value) ? ' selected="selected"' : '';
	return "<option value=\"" . $value . "\"$selected>" . $name . "</option>";
}

function create_select_list() {
	require_once('../../../final_project_mysqli_connect.php');
	$selected_val = isset($_POST['menu_item']) ? $_POST['menu_item'] : '';

	$q = "SELECT m.item_id, m.name, c.name AS category FROM menu_items AS m INNER JOIN categories as c USING (category_id) ORDER BY category_id; ";
	$r = @mysqli_query($dbc, $q);

	if($r) {
		$item_ids = [];
		$item_names = [];
		$category_names = [];

		while($row = mysqli_fetch_assoc($r)) {
			$item_ids[] = $row['item_id'];
			$item_names[] = $row['name'];
			$category_names[] = $row['category'];
		}

		$select_items = '';

		for($i = 0; $i < count($item_ids); $i++) {
			$select_items .= create_select_item($item_ids[$i], $item_names[$i] . " ($category_names[$i])", $selected_val);
		}

		return $select_items;
	} else {
		return '<option value="query_failure">query failure</option>';
	}
}


// FORM HANDLING

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = []; // Initialize an error array

	// Check for a quantity:
	if(empty($_POST['qty']) || $_POST['qty'] < 1) {
		$errors[] = 'You entered an invalid quantity.';
	}

	// Check for a name:
	if(empty($_POST['name'])) {
		$errors[] = 'You forgot to enter your name.';
	}

	// Check for a phone number:
	if(empty($_POST['phone'])) {
		$errors[] = 'You forgot to enter a phone number.';
	}


	if($_POST['pickup'] == "yes" && !empty($_POST['address'])) {
		$errors[] = 'You chose pickup but also entered a delivery address. Utterly ludicrous. What do you want from us?';
	}

	if($_POST['pickup'] != "yes" && empty($_POST['address'])) {
		$errors[] = 'You forgot to enter a delivery address.';
	}


	if(empty($errors)) { // If everything's OK

		echo '<h2>Order submitted successfully</h2>';

		// Include the footer and quit the script:
		include('includes/footer.html');
		exit();

	} else { // Report the errors

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach($errors as $msg) { // Print each error
			echo " - $msg<br>\n";
		}
		echo 'Please Try Again</p><p><br></p>';
	}
}



// DISPLAY FORM

echo '
<h1>Online Order</h1>
<form action="order.php" method="POST">
	<p>Dish:
	<select name="menu_item">'
		. create_select_list() .
	'</select></p>
	<p>Quantity: <input type="number" name="qty" min="1" value="' . (isset($_POST['qty']) ? $_POST['qty'] : 1) . '"></p>
	<p>Contact Name: <input type="text" name="name" value="' . (isset($_POST['name']) ? $_POST['name'] : '') . '"></p>
	<p>Phone #: <input type="tel" name="phone" placeholder="(555) 555-5555" value="' . (isset($_POST['phone']) ? $_POST['phone'] : '') . '"></p>
	<p>Pickup:  <input type="checkbox" name="pickup" value="yes"' . (isset($_POST['pickup']) && $_POST['pickup'] == "yes" ? ' checked="checked"' : '') . '></p>
	<p>Delivery Address: <input type="text" name="address" size="40" placeholder="If ordering pickup, do not fill out." value="' . (isset($_POST['address']) ? $_POST['address'] : '') . '"></p>
	<p>Comments:</p>
	<p><textarea name="comments" rows = "4" cols="40">' . (isset($_POST['comments']) ? $_POST['comments'] : '') . '</textarea></p>
	<p><input type="submit" name="submit" value="Submit!"></p>
</form>';

mysqli_close($dbc);
include('includes/footer.html');
?>