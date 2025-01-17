
<?php
	require_once("../require/connection.php");
	require_once("../require/my_function.php");
	session_maintainance(1);



	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['publish'])) {
    
    // Get data from the form
		$blog_id = mysqli_real_escape_string($connection, $_POST['blog']);
		$post_title = mysqli_real_escape_string($connection, $_POST['title']);
		$post_summary = mysqli_real_escape_string($connection, $_POST['content']);
		$post_description = mysqli_real_escape_string($connection, $_POST['description']);
		$category_id = mysqli_real_escape_string($connection, $_POST['category']);
		$post_attachment_title = mysqli_real_escape_string($connection, $_POST['post_atechment_title']);
		$attachment_status = mysqli_real_escape_string($connection, $_POST['atachment_status']);
		$post_status = mysqli_real_escape_string($connection, $_POST['status']);
		$is_comment_allowed = 1;

    // Handle file upload
		if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {

            $newImageName = basename($_FILES['image']['name']);
            $uploadPath = 'uploads/' . $newImageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $featuredImage = $newImageName; // Use the new image name
            } else {
                die("Error uploading the new featured image.");
            }
        }

		$post_attachment_path = "";
		if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
			$upload_dir = "post_attachment/";

			if (!is_dir($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			$post_attachment_path = $upload_dir . basename($_FILES['document']['name']);
			if (!move_uploaded_file($_FILES['document']['tmp_name'], $post_attachment_path)) {
				echo "Failed to upload document.";
				exit;
			}
		}

		$check_query = "
        	SELECT * FROM post 
        	WHERE blog_id = '$blog_id' AND post_title = '$post_title'";

		$check_result = mysqli_query($connection, $check_query);

		if (mysqli_num_rows($check_result) > 0) {
			
		} else {
        
        	$query = "INSERT INTO post (blog_id, post_title, post_summary, post_description, featured_image, post_status, is_comment_allowed, created_at, updated_at) VALUES('$blog_id', '$post_title', '$post_summary', '$post_description', '$featuredImage', '$post_status', '$is_comment_allowed', NOW(), NOW())";

			if (mysqli_query($connection, $query)) {
            
				$post_id = mysqli_insert_id($connection);

				$category_query = "INSERT INTO post_category (post_id, category_id, created_at, updated_at) VALUES ('$post_id', '$category_id', NOW(), NOW())";

				mysqli_query($connection, $category_query);

				if (!empty($post_attachment_path)) {
					
					$attachment_query = "INSERT INTO post_atachment(post_id, post_attachment_title, post_attachment_path, is_active, created_at, updated_at) VALUES ('$post_id', '$post_attachment_title', '$post_attachment_path', '$attachment_status', NOW(), NOW())";

					mysqli_query($connection, $attachment_query);
				}

				header("Location: see_post.php");
			} else {
				echo "<p style='color: red; font-weight: bolder; text-align: center;'>Post Is Not Added. Try Again Later!...<br>Error: " . mysqli_error($connection) . "</p>";
			}
		}    
	}

	$blog_query = "SELECT blog_id, blog_title FROM blog";
	$blog_result = mysqli_query($connection, $blog_query);

	$category_query = "SELECT category_id, category_title FROM category";
	$category_result = mysqli_query($connection, $category_query);

	require_once("header.php");
?>

<div class="row">

	<?php

	require_once("admin_sidbar.php");

	?>
	
	<div class="col-sm-1"></div>

	<div class="col-sm-8">

	<h3 class="text-center bg-light shadow-lg mt-2 mb-4">Add New Post</h3>

	<form action="" method="POST" enctype="multipart/form-data">
		<table border="0" cellspacing="10px" cellpadding="10px">
			<tr>
				<td>
    				<label for="exampleFormControlInput1" class="form-label">Choose Blog </label>
				</td>
				<td>
					<select name="blog" class="form-control" id="blog" required>
						<option value="" selected disabled>-- Select Blog --</option>
                            <?php while ($blog = mysqli_fetch_assoc($blog_result)) { ?>
                                <option value="<?= $blog['blog_id']; ?>"><?= $blog['blog_title']; ?></option>
                            <?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>	
    				<label for="exampleFormControlInput1" class="form-label">Post Title </label>
    			</td>
    			<td>
    				<input type="text" name="title" maxlength="100" required placeholder="Add Post Title..." class="form-control" id="exampleFormControlInput1">
				</td>
			</tr>
			<tr>
				<td>
    				<label for="exampleFormControlInput1" class="form-label">Post Summary </label>
				</td>
				<td>
    				<textarea name="content" class="form-control" id="exampleFormControlInput1" required maxlength="10000" placeholder="Write Your Content..." cols="10" rows="3"></textarea>
				</td>
			</tr>
			<tr>
				<td>
    				<label for="exampleFormControlInput1" class="form-label">Post Description </label>
				</td>
				<td>
    				<textarea name="description" class="form-control" id="exampleFormControlInput1" required maxlength="10000" placeholder="Write Your Description..." cols="20" rows="5"></textarea>
				</td>
			</tr>
					
					<?php
						$query = "SELECT category_title FROM category";

						$result = mysqli_query($connection, $query);

						if ($result->num_rows) {
					?>
			
				
				<tr>
					<td>
    					<label for="exampleFormControlInput1" class="form-label">Post Category </label>
					</td>
					<td>
						<select name="category" class="form-control" id="exampleFormControlInput1" required>
        					<option value="" selected disabled>-- select category --</option>
						<?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
    				
        					<option value="<?= $category['category_id']; ?>"><?= $category['category_title']; ?></option>
        				<?php } ?>
      					</select>
					</td>
			</tr>
		<?php } ?>
			<tr>
				<td>
					<label for="exampleFormControlInput1" class="form-label">Image </label>
				</td>
				<td>
					<input type="file" name="image" class="form-control" id="formFile">
				</td>
			</tr>
			<tr>
				<td>	
    				<label for="exampleFormControlInput1" class="form-label">Post Attachment Title </label>
    			</td>
    			<td>
    				<input type="text" name="post_atechment_title" maxlength="100" required placeholder="Add Post Atechment Title..." class="form-control" id="exampleFormControlInput1">
				</td>
			</tr>
			<tr>
				<td>
					<label for="document" class="form-label">Post Attachment</label>
				</td>
				<td>
					<input type="file" name="document" id="document" class="form-control" accept=".pdf,.doc,.docx,.txt" required>
				</td>
			</tr>
			<tr>
				<td>
					<label class="form-check-label" id="flexRadioDefault1">Post Attachment Status: </label>
				</td>
				<td>
					<select name="atachment_status" class="form-control" id="exampleFormControlInput1" required>
        				<option value="" selected disabled>-- select post attachment status --</option>
        				<option value="active">Active</option>
        				<option value="inactive">Inactive</option>
      				</select>
				</td>
			</tr>
			<tr>
				<td>
					<label class="form-check-label" id="flexRadioDefault1">Status: </label>
				</td>
				<td>
					<select name="status" class="form-control" id="exampleFormControlInput1" required>
        				<option value="" selected disabled>-- select post status --</option>
        				<option value="active">Active</option>
        				<option value="inactive">Inactive</option>
      				</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Publish Post" name="publish" class="btn btn-primary w-100 mb-4">
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