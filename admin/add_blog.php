<?php
	require_once("../require/connection.php");
	require_once("../require/my_function.php");
	session_maintainance(1);


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
		$blog_title = mysqli_real_escape_string($connection, $_POST['blog_title']);
		$post_per_page = mysqli_real_escape_string($connection, $_POST['post_page']);
		$blog_status = mysqli_real_escape_string($connection, $_POST['blog_status']);

		$imagePath = null;
		$file_name = null;

		if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

			$tmp_name = $_FILES['file']['tmp_name'];
			$name = $_FILES['file']['name'];
			$file_name = time() . "_" . $name;
			$path = "../Blog_bg_images/" . $file_name;

			if (move_uploaded_file($tmp_name, $path)) {
				$imagePath = $path;
			} else {
				die("File not uploaded.");
			}
		}

		$check_query = "SELECT * FROM blog WHERE blog_title = '$blog_title'";
		$check_result = mysqli_query($connection, $check_query);

		if (mysqli_num_rows($check_result) > 0) {

		} else {

			$query = "INSERT INTO blog (user_id, blog_title, post_per_page, blog_background_image, blog_status, created_at, updated_at) VALUES ('1', '$blog_title', '$post_per_page', '$file_name', '$blog_status', NOW(), NOW())";

			if (mysqli_query($connection, $query)) {
				header("Location: blog.php");
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

	<h3 class="text-center bg-light shadow-lg mt-2 mb-4">Add New Blog</h3>

	<form action="" method="post" enctype="multipart/form-data">
		<table border="0" cellspacing="10px" cellpadding="10px">
			<tr>
				<td>	
    				<label for="exampleFormControlInput1" class="form-label">Blog Title </label>
    			</td>
    			<td>
    				<input type="text" name="blog_title" maxlength="100" required placeholder="Add Blog Title..." class="form-control" id="exampleFormControlInput1">
				</td>
			</tr>
			<tr>
				<td>
    				<label for="exampleFormControlInput1" class="form-label">Post Per Page </label>
				</td>
				<td>
    				<input type="number" name="post_page" required placeholder="Post Per Pages..." class="form-control" id="exampleFormControlInput1">
				</td>
			</tr>
			<tr>
				<td><label id="formFile" class="form-label">Blog Background Image: </label></td>
				<td>
					<input class="form-control"  type="file" name="file" value="" required>
				</td>
			</tr>
			<tr>
				<td>
    				<label for="exampleFormControlInput1" class="form-label">Blog Status </label>
				</td>
				<td>	
    				<select name="blog_status" class="form-control" id="exampleFormControlInput1" required>
        				<option value="" selected disabled>-- select status --</option>
        				<option value="active">Active</option>
        				<option value="inactive">InActive</option>
      				</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Add Blog" name="blog" class="btn btn-primary w-100 mb-4">
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