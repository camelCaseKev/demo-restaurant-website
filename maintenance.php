<?php
/*
File:    maintenance.php
Author:  Kevin Viren
Date:    12/12/2024 (modified: 12/14/2024)
*/

$page_title = 'Maintenance';
include('includes/header.html');
require('../../../final_project_mysqli_connect.php');



// EDIT A MENU ITEM


if( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
	$id = $_GET['id'];
	
	$q = "SELECT item_id, image_location, name, description, category_id, price, calories, gluten_free, vegetarian FROM menu_items WHERE item_id = $id LIMIT 1";
	$r = @mysqli_query($dbc, $q);
	
	if($r) {
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC); // Used to fill in the edit form below. 
	}
}

if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['submit2'] == 'EDIT') {
	
	$errors = []; // Initialize an error array
	
	// Check for an item id:
	if(empty($_GET['item_id'])) {
		$errors[] = 'You forgot to enter an item id.';
	} else {
		$item_id = mysqli_real_escape_string($dbc, trim($_GET['item_id']));
	}
	
	// Check for a image URL:
	if(empty($_GET['image_location'])) {
		$errors[] = 'You forgot to enter an image URL.';
	} else {
		$image_location = mysqli_real_escape_string($dbc, trim($_GET['image_location']));
	}
	
	// Check for a name:
	if(empty($_GET['name'])) {
		$errors[] = 'You forgot to enter an item name.';
	} else {
		$name = mysqli_real_escape_string($dbc, trim($_GET['name']));
	}
	
	// Check for a description:
	if(empty($_GET['description'])) {
		$errors[] = 'You forgot to enter a description.';
	} else {
		$description = mysqli_real_escape_string($dbc, trim($_GET['description']));
	}
	
	// Check for a category_id:
	if(empty($_GET['category_id'])) {
		$errors[] = 'You forgot to select a category.';
	} else {
		$category_id = mysqli_real_escape_string($dbc, trim($_GET['category_id']));
	}
	
	// Check for a price:
	if(empty($_GET['price'])) {
		$errors[] = 'You forgot to enter a price.';
	} else {
		$price = mysqli_real_escape_string($dbc, trim($_GET['price']));
	}
	
	// Check for a calorie count:
	if(empty($_GET['calories'])) {
		$errors[] = 'You forgot to enter a calorie count';
	} else {
		$calories = mysqli_real_escape_string($dbc, trim($_GET['calories']));
	}
	
	// Check for gluten free status:
	if(empty($_GET['gluten_free'])) {
		$errors[] = 'You forgot to select whether item is gluten free or not.';
	} else {
		$gluten_free = mysqli_real_escape_string($dbc, trim($_GET['gluten_free']));
	}
	
	// Check for vegetarian status:
	if(empty($_GET['vegetarian'])) {
		$errors[] = 'You forgot to select whether item is vegetarian or not.';
	} else {
		$vegetarian = mysqli_real_escape_string($dbc, trim($_GET['vegetarian']));
	}
	
	if(empty($errors)) { // If everything's OK
		
		
		// Make the query:
		$q = "UPDATE menu_items SET image_location = '$image_location', name = '$name', description = '$description', category_id = $category_id, price = $price, calories = $calories, gluten_free = '$gluten_free', vegetarian = '$vegetarian' WHERE item_id=$item_id LIMIT 1";
		$r = @mysqli_query($dbc, $q); // Run the query
		
		if(mysqli_affected_rows($dbc) == 1) { // If it ran OK
			
			echo '<h1>SUCCESS</h1>';
			
		} else { // If it did not run OK
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Item could not be edited due to a system error.</p>';
			
		}
		
		mysqli_close($dbc); // Close the database connection
		
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


// ADD A MENU ITEM

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit'] == 'ADD') {
	
	$errors = []; // Initialize an error array
	
	// Check for a image URL:
	if(empty($_POST['image_location'])) {
		$errors[] = 'You forgot to enter an image URL.';
	} else {
		$image_location = mysqli_real_escape_string($dbc, trim($_POST['image_location']));
	}
	
	// Check for a name:
	if(empty($_POST['name'])) {
		$errors[] = 'You forgot to enter an item name.';
	} else {
		$name = mysqli_real_escape_string($dbc, trim($_POST['name']));
	}
	
	// Check for a description:
	if(empty($_POST['description'])) {
		$errors[] = 'You forgot to enter a description.';
	} else {
		$description = mysqli_real_escape_string($dbc, trim($_POST['description']));
	}
	
	// Check for a category_id:
	if(empty($_POST['category_id'])) {
		$errors[] = 'You forgot to select a category.';
	} else {
		$category_id = mysqli_real_escape_string($dbc, trim($_POST['category_id']));
	}
	
	// Check for a price:
	if(empty($_POST['price'])) {
		$errors[] = 'You forgot to enter a price.';
	} else {
		$price = mysqli_real_escape_string($dbc, trim($_POST['price']));
	}
	
	// Check for a calorie count:
	if(empty($_POST['calories'])) {
		$errors[] = 'You forgot to enter a calorie count';
	} else {
		$calories = mysqli_real_escape_string($dbc, trim($_POST['calories']));
	}
	
	// Check for gluten free status:
	if(empty($_POST['gluten_free'])) {
		$errors[] = 'You forgot to select whether item is gluten free or not.';
	} else {
		$gluten_free = mysqli_real_escape_string($dbc, trim($_POST['gluten_free']));
	}
	
	// Check for vegetarian status:
	if(empty($_POST['vegetarian'])) {
		$errors[] = 'You forgot to select whether item is vegetarian or not.';
	} else {
		$vegetarian = mysqli_real_escape_string($dbc, trim($_POST['vegetarian']));
	}
	
	if(empty($errors)) { // If everything's OK
		
		// Make the query:
		$q = "INSERT INTO menu_items (image_location, name, description, category_id, price, calories, gluten_free, vegetarian) VALUES ('$image_location', '$name', '$description', $category_id, $price, $calories, '$gluten_free', '$vegetarian')";
		$r = @mysqli_query($dbc, $q); // Run the query
		
		if(mysqli_affected_rows($dbc) == 1) { // If it ran OK
			
			echo '<h1>SUCCESS</h1>';
			
		} else { // If it did not run OK
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Item could not be added due to a system error.</p>';
			
		}
		
		mysqli_close($dbc); // Close the database connection
		
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

$cat_selected_option = isset($_POST['category_id']) ? $_POST['category_id'] : '1';
$glu_selected_option = isset($_POST['gluten_free']) ? $_POST['gluten_free'] : 'No';
$veg_selected_option = isset($_POST['vegetarian']) ? $_POST['vegetarian'] : 'No';

?>

<!-- CREATE REGISTER/EDIT FORMS -->
<div class="row">
	<div class="col">
		<h1>Add Menu Item</h1>
		<form action="maintenance.php" method="POST">
			<p><strong>Image URL: </strong><input type="text" name="image_location" size="40" maxlength="255" placeholder="assets/images/example.jpg" value="<?php if(isset($_POST['image_location'])) echo $_POST['image_location']; ?>"></p>
			<p><strong>Name: </strong><input type="text" name="name" size="25" maxlength="50" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>"></p>
			<p><strong>Description: </strong></p>
			<p><textarea name="description" rows = "4" cols="40"><?php if(isset($_POST['description'])) echo $_POST['description']; ?></textarea></p>
			<p><strong>Category: </strong></p>
			<p><input type="radio" name="category_id" value="1" <?php if($cat_selected_option === '1') echo 'checked'; ?>>Burgers
			<input type="radio" name="category_id" value="2" <?php if($cat_selected_option === '2') echo 'checked'; ?>>Sandwiches
			<input type="radio" name="category_id" value="3"<?php if($cat_selected_option === '3') echo 'checked'; ?>>Pizza
			<input type="radio" name="category_id" value="4" <?php if($cat_selected_option === '4') echo 'checked'; ?>>Seafood</p>
			<p><strong>Price: $</strong><input type="number" name="price" min="0" step="0.01" placeholder="0.00"value="<?php if(isset($_POST['price'])) echo $_POST['price']; ?>"></p>
			<p><strong>Calories: </strong><input type="number" name="calories" min="0" step="1" value="<?php if(isset($_POST['calories'])) echo $_POST['calories']; ?>"></p>
			<p><strong>Gluten Free:</strong></p>
			<p><input type="radio" name="gluten_free" value="Yes" <?php if($glu_selected_option === 'Yes') echo 'checked'; ?>>Yes
			<input type="radio" name="gluten_free" value="No" <?php if($glu_selected_option === 'No') echo 'checked'; ?>>No</p>
			<p><strong>Vegetarian:</strong></p>
			<p><input type="radio" name="vegetarian" value="Yes" <?php if($veg_selected_option === 'Yes') echo 'checked'; ?>>Yes
			<input type="radio" name="vegetarian" value="No" <?php if($veg_selected_option === 'No') echo 'checked'; ?>>No</p>
			<p><input type="submit" name="submit" value="ADD">
		</form>
	</div>
	<div class="col"> 
		<h1>Edit Menu Item</h1>
		<form action="maintenance.php" method="GET">
			<p><strong>Item Id: </strong><input type="number" name="item_id" min="1" step="1" value="<?php echo $row['item_id']; ?>"></p>
			<p><strong>Image URL: </strong><input type="text" name="image_location" size="40" maxlength="255" placeholder="assets/images/example.jpg" value="<?php echo $row['image_location']; ?>"</p>
			<p><strong>Name: </strong><input type="text" name="name" size="25" maxlength="50" value="<?php echo $row['name']; ?>"></p>
			<p><strong>Description: </strong></p>
			<p><textarea name="description" rows = "4" cols="40"><?php echo $row['description']; ?></textarea></p>
			<p><strong>Category: </strong></p>
			<p><input type="radio" name="category_id" value="1" <?php if($row['category_id']==1) echo 'checked';?>>Burgers
			<input type="radio" name="category_id" value="2" <?php if($row['category_id']==2) echo 'checked';?>>Sandwiches
			<input type="radio" name="category_id" value="3" <?php if($row['category_id']==3) echo 'checked';?>>Pizza
			<input type="radio" name="category_id" value="4" <?php if($row['category_id']==4) echo 'checked';?>>Seafood</p>
			<p><strong>Price: $</strong><input type="number" name="price" min="0" step="0.01" placeholder="0.00" value="<?php echo $row['price']; ?>"></p>
			<p><strong>Calories: </strong><input type="number" name="calories" min="0" step="1" value="<?php echo $row['calories']; ?>"></p>
			<p><strong>Gluten Free:</strong></p>
			<p><input type="radio" name="gluten_free" value="Yes" <?php if($row['gluten_free']=="Yes") echo 'checked';?>>Yes
			<input type="radio" name="gluten_free" value="No" <?php if($row['gluten_free']=="No") echo 'checked';?>>No</p>
			<p><strong>Vegetarian:</strong></p>
			<p><input type="radio" name="vegetarian" value="Yes" <?php if($row['vegetarian']=="Yes") echo 'checked';?>>Yes
			<input type="radio" name="vegetarian" value="No" <?php if($row['vegetarian']=="No") echo 'checked';?>>No</p>
			<p><input type="submit" name="submit2" value="EDIT">
		</form>
	</div>
</div>


<?php // DISPLAY MENU ITEMS
$q = "SELECT * FROM categories";
$r = @mysqli_query($dbc, $q);

if($r) {
	$num1 = mysqli_num_rows($r);
	mysqli_free_result($r);
	
	$i = 1;
	while($i <= $num1) {
		
		$q = "SELECT item_id, image_location, name, description, price, calories, gluten_free, vegetarian FROM menu_items WHERE category_id = $i";
		$r = @mysqli_query($dbc, $q);


		if($r) { 
			$num2 = mysqli_num_rows($r);

			if($num2 > 0) { // If query ran okay
				$q2 = "SELECT name FROM categories WHERE category_id = $i";
				$r2 = @mysqli_query($dbc, $q2);
				
				if($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
					echo "<h2>". $row2['name'] . "</h2>";
				}
				
				echo "<table class='table'>
				<thead>
				<tr>
					<th></th>
					<th></th>
					<th>#</th>
					<th>Image</th>
					<th>Dish</th>
					<th>Description</th>
					<th>Calories</th>
					<th>Gluten Free</th>
					<th>Vegetarian</th>
					<th>Price</th>
				</thead>
				<tbody>";
		
				// Fetch and print records
				while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<tr><td><a href="maintenance.php?id=' . $row['item_id'] . '">Edit</a></td><td><a href="delete_item.php?id=' . $row['item_id'] . '">Delete</a></td><td>' . $row['item_id'] . '</td><td><img src="' . $row['image_location'] . '" alt="Image of food" class="menuImg"></td><td align="left"><strong>' . $row['name'] . '</strong></td><td align="left">' . $row['description'] . '</td><td>' . $row['calories'] . '</td><td>' . $row['gluten_free'] . '</td><td>' . $row['vegetarian'] . '</td><td>$' . $row['price'] . '<br/><br/><br/></td></tr>';
				}
				echo '</tbody></table>'; 
				$i += 1;
		
			} else { // If query did not run okay
		
				echo '<p class="error">An unexpected query error occurred.</p>';
				$i += 1;
			}
		} else {
			echo '<p class="error">Could not retrieve data due to an error.</p>';
			$i += 1;
		}
	}
}

mysqli_close($dbc);
include('includes/footer.html');
?>