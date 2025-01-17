<?php
    
    require_once("../require/connection.php");
    require_once("../require/my_function.php");
    session_maintainance(1);

    if (!isset($_GET['blog_id'])) {
        die("Blog ID is required.");
    }

    $blog_id = (int)$_GET['blog_id'];

    $blog_query = "SELECT blog_title, post_per_page, blog_background_image, blog_status, updated_at FROM blog WHERE blog_id = $blog_id";
    $blog_result = mysqli_query($connection, $blog_query);

    if (!$blog_result || mysqli_num_rows($blog_result) == 0) {
        die("Blog not found.");
    }

    $blog = mysqli_fetch_assoc($blog_result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $blog_title = mysqli_real_escape_string($connection, $_POST['blog_title']);
        $post_per_page = (int)$_POST['post_per_page'];
        $blog_status = mysqli_real_escape_string($connection, $_POST['blog_status']);
        $updated_at = date("Y-m-d H:i:s");

        $blog_background_image = $blog['blog_background_image'];

        if (isset($_FILES['blog_background_image']['name']) && $_FILES['blog_background_image']['name'] != '') {
            $target_dir = "../Blog_bg_images/";
            $target_file = $target_dir . basename($_FILES["blog_background_image"]["name"]);
            $upload_ok = true;

            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["blog_background_image"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $upload_ok = false;
            }

            if ($upload_ok && move_uploaded_file($_FILES["blog_background_image"]["tmp_name"], $target_file)) {
                $blog_background_image = basename($_FILES["blog_background_image"]["name"]);
            } else {
                echo "Failed to upload image.";
            }
        }

        $update_query = "UPDATE blog SET 
                        blog_title = '$blog_title', 
                        post_per_page = $post_per_page, 
                        blog_background_image = '$blog_background_image', 
                        blog_status = '$blog_status', 
                        updated_at = '$updated_at' 
                     WHERE blog_id = $blog_id";

        if (mysqli_query($connection, $update_query)) {
            header("Location: blog.php");
        } else {
            echo "Error updating blog: " . mysqli_error($connection);
        }
    }

    require_once("header.php");
?>

<div class="row">

    <?php require_once("admin_sidbar.php"); ?>
    
    <div class="col-sm-1"></div>

    <div class="col-sm-8">

        <h3 class="text-center bg-light shadow-lg mt-2 mb-4">Edit Blog</h3>

        <form action="" method="POST" enctype="multipart/form-data">
            <table border="0" cellspacing="10px" cellpadding="10px">
                <tr>
                    <td><label for="blog_title" class="form-label">Blog Title</label></td>
                    <td>
                        <input type="text" class="form-control" id="blog_title" name="blog_title" value="<?php echo htmlspecialchars($blog['blog_title']); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="post_per_page" class="form-label">Posts Per Page</label>
                    </td>
                    <td>
                        <input type="number" class="form-control" id="post_per_page" name="post_per_page" value="<?php echo $blog['post_per_page']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="blog_background_image" class="form-label">Blog Background Image</label>
                    </td>
                    <td>
                        <div>
                            <img src="<?php echo "../Blog_bg_images/" . $blog['blog_background_image']; ?>" alt="Featured Image" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <input type="file" class="form-control" id="blog_background_image" name="blog_background_image">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="blog_status" class="form-label">Blog Status</label>
                    </td>
                    <td>
                        <select class="form-control" id="blog_status" name="blog_status" required>
                            <option value="Active" <?php if ($blog['blog_status'] == 'Active') echo 'selected'; ?>>Active</option>
                            <option value="InActive" <?php if ($blog['blog_status'] == 'InActive') echo 'selected'; ?>>InActive</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="btn btn-primary">Update Blog</button>
                        <a href="blog.php" class="btn btn-secondary">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php require_once("footer.php"); ?>
