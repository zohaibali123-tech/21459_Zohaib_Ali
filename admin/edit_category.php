<?php

    require_once("../require/connection.php");
    require_once("../require/my_function.php");
    session_maintainance(1);

    if (!isset($_GET['category_id'])) {
        die("Category ID is required.");
    }

    $category_id = (int)$_GET['category_id'];
    $error_message = "";

    $category_query = "SELECT category_title, category_description, category_status, updated_at FROM category WHERE category_id = $category_id LIMIT 1";
    $category_result = mysqli_query($connection, $category_query);

    if (!$category_result || mysqli_num_rows($category_result) == 0) {
        die("Category not found.");
    }

    $category = mysqli_fetch_assoc($category_result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $category_title = mysqli_real_escape_string($connection, $_POST['category_title']);
        $category_description = mysqli_real_escape_string($connection, $_POST['category_description']);
        $category_status = mysqli_real_escape_string($connection, $_POST['category_status']);
        $updated_at = date("Y-m-d H:i:s");

        if (empty($category_title) || empty($category_description) || empty($category_status)) {
            $error_message = "All fields are required.";
        } else {
            $update_query = "
                UPDATE category 
                SET 
                    category_title = '$category_title',
                    category_description = '$category_description',
                    category_status = '$category_status',
                    updated_at = '$updated_at'
                WHERE category_id = $category_id";

            if (mysqli_query($connection, $update_query)) {
                header("Location: category.php");
                exit();
            } else {
                $error_message = "Failed to update category: " . mysqli_error($connection);
            }
        }
    }
?>

<?php require_once("header.php"); ?>

<div class="row">

    <?php require_once("admin_sidbar.php"); ?>
    
    <div class="col-sm-1"></div>

    <div class="col-sm-8">

    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

        <h3 class="text-center bg-light shadow-lg mt-2 mb-4">Edit Category</h3>

        <form action="" method="POST" enctype="multipart/form-data">
            <table border="0" cellspacing="10px" cellpadding="10px">
                <tr>
                    <td>
                        <label for="category_title" class="form-label">Category Title</label>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="category_title" name="category_title" value="<?php echo $category['category_title']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="category_description" class="form-label">Category Description</label>
                    </td>
                    <td>
                        <textarea class="form-control" id="category_description" name="category_description" rows="4" required><?php echo $category['category_description']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="category_status" class="form-label">Category Status</label>
                    </td>
                    <td>
                        <select class="form-control" id="category_status" name="category_status" required>
                            <option value="Active" <?php if ($category['category_status'] === 'Active') echo 'selected'; ?>>Active</option>
                            <option value="InActive" <?php if ($category['category_status'] === 'InActive') echo 'selected'; ?>>InActive</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="category.php" class="btn btn-secondary">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php require_once("footer.php"); ?>
