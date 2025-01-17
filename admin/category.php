<?php
    
    require_once("../require/connection.php");
    require_once("../require/my_function.php");
    session_maintainance(1);

    if (!isset($_GET['category_id'])) {
        die("Invalid category ID.");
    }

    $postId = intval($_GET['post_id']);

    $category_per_page = 1;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $category_per_page;

    $category_query = "SELECT * FROM category LIMIT $category_per_page OFFSET $offset";
    $category_result = mysqli_query($connection, $category_query);
    $total_category_query = "SELECT COUNT(*) AS total FROM category";
    $total_category_result = mysqli_fetch_assoc(mysqli_query($connection, $total_category_query));
    $total_category = $total_category_result['total'];
    $total_category = ceil($total_category / $category_per_page);

    require_once("header.php");
?>

<div class="row">
    <?php require_once("admin_sidbar.php"); ?>

    <div class="col-md-1" style="width: 5rem;"></div>

    <div class="col-md-8 mt-4">
        <h3 class="text-center bg-light shadow-lg mb-3">Categories</h3>

        <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
            <div class="card mb-2">               
                <div class="card-body">
                    <h5 class="card-title">Title: <?php echo $category['category_title']; ?></h5>
                    <p class="card-title"><strong>Description:</strong> <?php echo $category['category_description']; ?></p>

                    <?php
                        $posts_in_category = 4;
                        $post_page = isset($_GET['post_page']) ? (int)$_GET['post_page'] : 1;
                        $post_offset = ($post_page - 1) * $posts_in_category;

                        $posts_query = "
                            SELECT post.post_id, post.post_title, post.featured_image 
                            FROM post_category 
                            INNER JOIN post ON post_category.post_id = post.post_id 
                            WHERE post_category.category_id = {$category['category_id']}
                            ORDER BY post.post_id DESC
                            LIMIT $posts_in_category OFFSET $post_offset";

                        $posts_result = mysqli_query($connection, $posts_query);

                        $total_posts_query = "
                            SELECT COUNT(*) AS total 
                            FROM post_category
                            WHERE category_id = {$category['category_id']}";

                        $total_posts_result = mysqli_fetch_assoc(mysqli_query($connection, $total_posts_query));
                        $total_posts = $total_posts_result['total'];
                        $total_post_pages = ceil($total_posts / $posts_in_category);
                    ?>

                    <div class="row">
                        <p class="mb-4"><strong>Posts In Category:</strong> <?php echo $total_posts; ?></p>

                    <?php while ($post = mysqli_fetch_assoc($posts_result)) { ?>
                            <div class="col-3 mb-4">
                                <a href="open_post.php?post_id=<?php echo $post['post_id']; ?>" class="post-link">
                                <div class="card mb-1">
                                    <img src="<?php echo "uploads/" . $post['featured_image']; ?>" class="card-img-top" alt="Post Image">
                                    <div class="card-body p-2">
                                        <h6 class="card-title">Title: <?php echo $post['post_title']; ?></h6>
                                    </div>
                                </div>
                                </a>
                            </div>
                    <?php } ?>
                    </div>

                    <nav aria-label="Post Pagination" class="mb-4">
                        <ul class="pagination pagination-sm justify-content-center">
                            <li class="page-item <?php if ($post_page == 1) echo 'disabled'; ?>">
                                <a class="page-link" href="?post_page=<?php echo max($post_page - 1, 1); ?>&page=<?php echo $page; ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_post_pages; $i++) { ?>
                                <li class="page-item <?php if ($i == $post_page) echo 'active'; ?>">
                                    <a class="page-link" href="?post_page=<?php echo $i; ?>&page=<?php echo $page; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                            <li class="page-item <?php if ($post_page == $total_post_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="?post_page=<?php echo min($post_page + 1, $total_post_pages); ?>&page=<?php echo $page; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>

                    <button style="margin-right: 1%" class="btn btn-primary post-link custom-button" onclick="editCategory(<?php echo $category['category_id']; ?>)">Edit</button>
                    <button style="margin-right: 1%" class="btn btn-danger post-link custom-button" onclick="deleteCategory(<?php echo $category['category_id']; ?>)">Delete</button>

                    <?php if ($category['category_status'] == 'Active') { ?>
                        <button class="btn btn-success post-link custom-button" onclick="changeCategoryStatus(<?php echo $category['category_id']; ?>, 'InActive')">Active</button>
                    <?php } else { ?>
                        <button class="btn btn-warning post-link custom-button" onclick="changeCategoryStatus(<?php echo $category['category_id']; ?>, 'active')">InActive</button>
                    <?php } ?>
                    <small style="margin-left: 15%;"><strong>Last Updated:</strong> <?php echo date("F j, Y - h:i A", strtotime($category['updated_at'])); ?></small>
                </div>
            </div>
        <?php } ?>

        <nav aria-label="category Pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo max($page - 1, 1); ?>">Previous</a>
                </li>
                <?php for ($i = max(1, $page - 2); $i <= min($page + 2, $total_category); $i++) { ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if ($page == $total_category) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo min($page + 1, $total_category); ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    
    <div class="col-md-1"></div>
</div>

<script type="text/javascript">
    function editCategory(categoryId) {
        window.location.href = `edit_category.php?category_id=${categoryId}`;
    }

    function deleteCategory(categoryId) {
        if (confirm("Are you sure you want to delete this category?")) {
            var ajax_request = new XMLHttpRequest();
            ajax_request.onreadystatechange = function () {
                if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                    if (ajax_request.responseText.trim() === "success") {
                        location.reload();
                    } else {
                        alert(ajax_request.responseText);
                    }
                }
            };
            ajax_request.open("GET", `ajax_process.php?action=delete_category&category_id=${categoryId}`, true);
            ajax_request.send();
        }
    }

    function changeCategoryStatus(categoryId, status) {
        var ajax_request = new XMLHttpRequest();
        ajax_request.onreadystatechange = function () {
            if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                if (ajax_request.responseText.trim() === "success") {
                    location.reload();
                } else {
                    alert(ajax_request.responseText);
                }
            }
        };
        ajax_request.open("GET", `ajax_process.php?action=change_category_status&category_id=${categoryId}&status=${status}`, true);
        ajax_request.send();
    }
</script>

<?php require_once("footer.php"); ?>