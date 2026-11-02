<?php
/*
File:    menu.php
Author:  Kevin Viren
Date:    12/11/2024
*/
$page_title = 'Menu';
include('includes/header.html');
require_once('../../../final_project_mysqli_connect.php');

$q = "SELECT * FROM categories";
$r = @mysqli_query($dbc, $q);

if($r) {
	$num1 = mysqli_num_rows($r);
	mysqli_free_result($r);
	
	$i = 1;
	while($i <= $num1) {
		
		$q = "SELECT image_location, name, description, price, calories, gluten_free, vegetarian FROM menu_items WHERE category_id = $i";
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
					echo '<tr><td><img src="' . $row['image_location'] . '" alt="Image of food" class="menuImg"></td><td align="left"><strong>' . $row['name'] . '</strong></td><td align="left">' . $row['description'] . '</td><td>' . $row['calories'] . '</td><td>' . $row['gluten_free'] . '</td><td>' . $row['vegetarian'] . '</td><td>$' . $row['price'] . '<br/><br/><br/></td></tr>';
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