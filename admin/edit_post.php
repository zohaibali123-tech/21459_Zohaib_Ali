<?php
    require_once("../require/connection.php");
    require_once("../require/my_function.php");
    session_maintainance(1);

    if (!isset($_GET['post_id'])) {
        die("Invalid post ID.");
    }

    $postId = intval($_GET['post_id']);

    $postQuery = "
        SELECT 
            post.post_id,
            post.post_title,
            post.post_summary,
            post.post_description,
            post.featured_image,
            post.is_comment_allowed,
            post.blog_id,
            category.category_id
        FROM post
        LEFT JOIN post_category ON post.post_id = post_category.post_id
        LEFT JOIN category ON post_category.category_id = category.category_id
        WHERE post.post_id = $postId";
    $postResult = mysqli_query($connection, $postQuery);
    $postRow = mysqli_fetch_assoc($postResult);

    if (!$postRow) {
        die("Post not found.");
    }

    $blogsQuery = "SELECT blog_id, blog_title FROM blog WHERE blog_status = 'Active'";
    $blogsResult = mysqli_query($connection, $blogsQuery);

    $categoriesQuery = "SELECT category_id, category_title FROM category WHERE category_status = 'Active'";
    $categoriesResult = mysqli_query($connection, $categoriesQuery);

    $attachmentQuery = "SELECT * FROM post_atachment";
    $attachmentResult = mysqli_query($connection, $attachmentQuery);
    if (!$attachmentResult) {
        die("Error in Attachment Query: " . mysqli_error($connection));
    }

    $attachments = [];
    while ($attachmentRow = mysqli_fetch_assoc($attachmentResult)) {
        $attachments[$attachmentRow['post_id']][] = $attachmentRow['post_attachment_path'];
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postTitle = mysqli_real_escape_string($connection, $_POST['post_title']);
        $postSummary = mysqli_real_escape_string($connection, $_POST['post_summary']);
        $postDescription = mysqli_real_escape_string($connection, $_POST['post_description']);
        $isCommentAllowed = isset($_POST['is_comment_allowed']) ? 1 : 0;
        $blogId = intval($_POST['blog_id']);
        $categoryId = intval($_POST['category_id']);

        if (isset($_FILES['new_featured_image']['tmp_name']) && !empty($_FILES['new_featured_image']['tmp_name'])) {

            $newImageName = basename($_FILES['new_featured_image']['name']);
            $uploadPath = 'uploads/' . $newImageName;

            if (move_uploaded_file($_FILES['new_featured_image']['tmp_name'], $uploadPath)) {
                $featuredImage = $newImageName; // Use the new image name
            } else {
                die("Error uploading the new featured image.");
            }
        } else {
            $featuredImage = mysqli_real_escape_string($connection, $_POST['current_featured_image']);
        }

        $updatePostQuery = "
            UPDATE post
            SET 
                post_title = '$postTitle',
                post_summary = '$postSummary',
                post_description = '$postDescription',
                featured_image = '$featuredImage',
                is_comment_allowed = $isCommentAllowed,
                blog_id = $blogId,
                updated_at = CURRENT_TIMESTAMP
                WHERE post_id = $postId";
        mysqli_query($connection, $updatePostQuery);

        $updateCategoryQuery = "
            UPDATE post_category
            SET category_id = $categoryId,
                updated_at = CURRENT_TIMESTAMP
            WHERE post_id = $postId";
        mysqli_query($connection, $updateCategoryQuery);

        if (!empty($_FILES['attachments']['tmp_name'][0])) {
            $deleteAttachmentsQuery = "DELETE FROM post_atachment WHERE post_id = $postId";
            mysqli_query($connection, $deleteAttachmentsQuery);

            foreach ($_FILES['attachments']['tmp_name'] as $key => $tmpName) {
                if (!empty($tmpName)) {
                    $attachmentTitle = !empty($_POST['attachment_titles'][$key]) 
                        ? mysqli_real_escape_string($connection, $_POST['attachment_titles'][$key])
                        : "Untitled";

                    $attachmentName = time() . '_' . basename($_FILES['attachments']['name'][$key]);
                    $attachmentPath = 'post_attachment/' . $attachmentName;

                    if (move_uploaded_file($tmpName, $attachmentPath)) {
                        $insertAttachmentQuery = "
                            INSERT INTO post_atachment (post_id, post_attachment_title, post_attachment_path, is_active, updated_at)
                            VALUES ($postId, '$attachmentTitle', '$attachmentPath', 'Active', NOW())";

                        if (!mysqli_query($connection, $insertAttachmentQuery)) {
                            echo "Error inserting attachment: " . mysqli_error($connection);
                        }
                    } else {
                        echo "Error uploading attachment: " . htmlspecialchars($_FILES['attachments']['name'][$key]);
                    }
                }
            }
        }
        header("Location: open_post.php?post_id=$postId");
        exit();
    }

    require_once("header.php");
?>

<div class="row">
    <?php require_once("admin_sidbar.php"); ?>

    <div class="col-sm-1" style="width: 5rem;"></div>

    <div class="col-sm-8 mt-4">
        <h3 class="text-center bg-light shadow-lg mt-2 mb-4">Edit Post</h3>
        <form method="POST" enctype="multipart/form-data">
            <table border="0" cellspacing="10px" cellpadding="10px">
                <tr class="form-group">
                    <td>
                        <label for="exampleFormControlInput1" class="form-label">Title</label>
                    </td>
                    <td>
                        <input type="text" name="post_title" class="form-control" value="<?php echo htmlspecialchars($postRow['post_title']); ?>" required>
                    </td>
                </tr>
                <tr class="form-group">
                    <td>
                        <label for="post_summary">Summary</label>
                    </td>
                    <td>
                        <textarea name="post_summary" class="form-control" required><?php echo htmlspecialchars($postRow['post_summary']); ?></textarea>
                    </td>
                </tr>
                <tr class="form-group">
                    <td>
                        <label for="post_description">Description</label>
                    </td>
                    <td>
                        <textarea name="post_description" class="form-control" required><?php echo htmlspecialchars($postRow['post_description']); ?></textarea>
                    </td>
                </tr>
                <tr class="form-group">
                    <td>
                        <label for="featured_image">Featured Image</label>
                    </td>
                    <td>
                        <div>
                            <img src="<?php echo "uploads/" . $postRow['featured_image']; ?>" class="card-img-top" alt="Post Image" style="max-width: 100px; max-height: 100px;">
                        </div>

                        <input type="file" name="new_featured_image" class="form-control">

                        <input type="hidden" name="current_featured_image" value="<?php echo htmlspecialchars($postRow['featured_image']); ?>">
                    </td>
                </tr>
                <tr class="form-group">
                    <td>
                        <label for="blog_id">Blog</label>
                    </td>
                    <td>
                        <select name="blog_id" class="form-control">
                        <?php while ($blog = mysqli_fetch_assoc($blogsResult)) { ?>
                            <option value="<?php echo $blog['blog_id']; ?>" <?php echo $blog['blog_id'] == $postRow['blog_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($blog['blog_title']); ?>
                            </option>
                        <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr class="form-group">
                    <td>
                        <label for="category_id">Category</label>
                    </td>
                    <td>
                        <select name="category_id" class="form-control">
                        <?php while ($category = mysqli_fetch_assoc($categoriesResult)) { ?>
                            <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $postRow['category_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_title']); ?>
                            </option>
                        <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr class="form-group">
                    <td>
                        <label for="is_comment_allowed">Allow Comments</label>
                    </td>
                    <td>
                        <input type="checkbox" name="is_comment_allowed" <?php echo $postRow['is_comment_allowed'] ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr class="form-group">
                    <td>
                        <label for="exampleFormControlInput1" class="form-label">Current Attachment</label>
                    </td>
                    <td>
                    <?php if (!empty($attachments[$postRow['post_id']])) { ?>
                        <ul>
                        <?php foreach ($attachments[$postRow['post_id']] as $attachment) { ?>
                            <li><a style="text-decoration: none;" href="<?php echo $attachment; ?>" target="_blank">View Attachment</a></li>
                        <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p style="color: red;">No Attachments Found!...</p>
                    <?php } ?>
                    </td>
                </tr>
                <tr class="form-group">
                    <td>
                        <label for="attachments">Attachments</label>
                    </td>
                    <td>
                        <input type="file" name="attachments[]" class="form-control" multiple>

                        <input type="text" name="attachment_titles[]" class="form-control" placeholder="Attachment Title">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </td>
                <tr class="form-group">
            </table>
        </form>
    </div>
    <div class="col-sm-1"></div>
</div>

<?php require_once("footer.php"); ?>