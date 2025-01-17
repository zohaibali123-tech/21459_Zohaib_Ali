
<?php

	require_once("../require/my_function.php");
	require_once("../require/connection.php");
	session_maintainance(1);


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
		$cat_title = mysqli_real_escape_string($connection, $_POST['title']);
		$cat_desc = mysqli_real_escape_string($connection, $_POST['description']);
		$cat_status = mysqli_real_escape_string($connection, $_POST['category']);

		$check_query = "SELECT * FROM category WHERE category_title = '$cat_title'";
		$check_result = mysqli_query($connection, $check_query);

		if (mysqli_num_rows($check_result) > 0) {

		} else {

			$query = "INSERT INTO category (category_title, category_description, category_status, created_at, updated_at) VALUES ('$cat_title', '$cat_desc', '$cat_status', NOW(), NOW())";

			if (mysqli_query($connection, $query)) {
				header("location: category.php");
			} else {
				echo "<p style='color: red; font-weight: bolder; text-align: center;'>Error: <br>" . mysqli_error($connection) . "</p>";
			}
		}
	}

	require_once("header.php");
?>

<div class="row">

	<?php

	require_once("admin_sidbar.php");

	?>
	
	<div class="col-sm-1"></div>

	<div class="col-sm-8">

	<h3 class="text-center bg-light shadow-lg mt-2 mb-4">Add New Category</h3>

	<form action="" method="post" >
		<table border="0" cellspacing="10px" cellpadding="10px">
			<tr>
				<td>	
    				<label for="exampleFormControlInput1" class="form-label">Category Title </label>
    			</td>
    			<td>
    				<input type="text" name="title" maxlength="100" required placeholder="Category Title..." class="form-control" id="exampleFormControlInput1" required>
				</td>
			</tr>
			<tr>
				<td>	
    				<label for="exampleFormControlInput1" class="form-label">Category Description </label>
    			</td>
    			<td>
    				<input type="text" name="description" maxlength="100" required placeholder="Category Description..." class="form-control" id="exampleFormControlInput1" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="exampleFormControlInput1" class="form-label">Category Status </label>
				</td>
				<td>
					<select name="category" class="form-control" id="exampleFormControlInput1" required>
        				<option value="" selected disabled>-- select status --</option>
        				<option value="active">Active</option>
        				<option value="inactive">InActive</option>
        			</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Add Category" name="publish" class="btn btn-primary w-100 mb-4">
				</td>
			</tr>
    		</table>
		</form>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php

	require_once("footer.php");

?>