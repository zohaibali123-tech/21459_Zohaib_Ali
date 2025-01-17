<?php
    require_once("header.php");
    require_once("../require/connection.php");
    require_once("../require/my_function.php");
    session_maintainance(1);

    $blogs_per_page = 1;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $blogs_per_page;

    $blogs_query = "SELECT * FROM blog ORDER BY created_at DESC LIMIT $blogs_per_page OFFSET $offset";
    $blogs_result = mysqli_query($connection, $blogs_query);
    $total_blogs_query = "SELECT COUNT(*) AS total FROM blog";
    $total_blogs_result = mysqli_fetch_assoc(mysqli_query($connection, $total_blogs_query));
    $total_blogs = $total_blogs_result['total'];
    $total_pages = ceil($total_blogs / $blogs_per_page);

    $followers_per_page = 5;
    $follower_page = isset($_GET['follower_page']) ? (int)$_GET['follower_page'] : 1;
    $follower_offset = ($follower_page - 1) * $followers_per_page;

    $followers_query = "SELECT f.*, b.blog_title, b.blog_id, b.blog_status, u.first_name, u.last_name 
                    FROM following_blog f
                    JOIN blog b ON f.blog_following_id = b.blog_id
                    JOIN user u ON f.follower_id = u.user_id
                    ORDER BY f.created_at DESC
                    LIMIT $followers_per_page OFFSET $follower_offset";

    $followers_result = mysqli_query($connection, $followers_query);

    if (!$followers_result) {
        die("Error fetching followers: " . mysqli_error($connection));
    }

    $total_followers_query = "SELECT COUNT(DISTINCT f.blog_following_id) AS total FROM following_blog f";
    $total_followers_result = mysqli_fetch_assoc(mysqli_query($connection, $total_followers_query));
    $total_followers = $total_followers_result['total'];
    $total_follower_pages = ceil($total_followers / $followers_per_page);

?>

<div class="row">
    <?php require_once("admin_sidbar.php"); ?>

    <div class="col-md-1" style="width: 5rem;"></div>

    <div class="col-md-4 mt-2">
        <h3 class="text-center bg-light shadow-lg mb-3" style="width: 33rem;">Blogs</h3>

        <?php while ($blog = mysqli_fetch_assoc($blogs_result)) { ?>
            <div class="card mb-2" style="width: 33rem;">
                <img src="<?php echo "../Blog_bg_images/" . $blog['blog_background_image']; ?>" class="card-img-top" alt="Blog Image" >
                <div class="card-body">
                    <h5 class="card-title">Blog: <?php echo $blog['blog_title']; ?></h5>
                    <p>Posts Per Page: <?php echo $blog['post_per_page']; ?></p>

                <?php
                    $posts_per_page = (int)$blog['post_per_page'];
                    $post_page = isset($_GET['post_page']) ? (int)$_GET['post_page'] : 1;
                    $post_offset = ($post_page - 1) * $posts_per_page;

                    $posts_query = "SELECT * FROM post WHERE blog_id = {$blog['blog_id']} ORDER BY created_at DESC LIMIT $posts_per_page OFFSET $post_offset";
                    $posts_result = mysqli_query($connection, $posts_query);
                    $total_posts_query = "SELECT COUNT(*) AS total FROM post WHERE blog_id = {$blog['blog_id']}";
                    $total_posts_result = mysqli_fetch_assoc(mysqli_query($connection, $total_posts_query));
                    $total_posts = $total_posts_result['total'];
                    $total_post_pages = ceil($total_posts / $posts_per_page);
                ?>

                    <div class="row">
                        <?php while ($post = mysqli_fetch_assoc($posts_result)) { ?>
                            <div class="col-3">
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

                    <nav aria-label="Post Pagination" class="mt-2">
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

                    <button class="btn btn-primary post-link" onclick="editBlog(<?php echo $blog['blog_id']; ?>)">Edit</button>
                    <button class="btn btn-danger post-link" onclick="deleteBlog(<?php echo $blog['blog_id']; ?>)">Delete</button>

                    <?php if ($blog['blog_status'] == 'Active') { ?>
                        <button class="btn btn-success post-link" onclick="changeBlogStatus(<?php echo $blog['blog_id']; ?>, 'InActive')">Active</button>
                    <?php } else { ?>
                        <button class="btn btn-warning post-link" onclick="changeBlogStatus(<?php echo $blog['blog_id']; ?>, 'active')">Inactive</button>
                    <?php } ?>
                    <small style="margin-left: 10%;"><strong>Last Updated:</strong> <?php echo date("F j, Y", strtotime($blog['updated_at'])); ?></small>
                </div>
            </div>
        <?php } ?>

        <nav aria-label="Blog Pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo max($page - 1, 1); ?>">Previous</a>
                </li>
                <?php for ($i = max(1, $page - 2); $i <= min($page + 2, $total_pages); $i++) { ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if ($page == $total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo min($page + 1, $total_pages); ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    
    <div class="col-md-1"></div>

    <div class="col-md-4 mt-2" style="width: 25rem;">        
        
        <h3 class="text-center bg-light shadow-lg mb-3">Followers</h3>
        <ul class="list-group mb-2">
            <?php if (mysqli_num_rows($followers_result) > 0) {
                     while ($follower = mysqli_fetch_assoc($followers_result)) { ?>
                    <li class="list-group-item">
                        <strong>Blog:</strong> <?php echo $follower['blog_title']; ?> <br>
                        <strong>Follower:</strong> <?php echo $follower['first_name'] . ' ' . $follower['last_name']; ?>
                        <span class="badge bg-secondary float-end">Status: <?php echo $follower['blog_status']; ?></span>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <li class="list-group-item">No followed blogs available.</li>
            <?php } ?>
        </ul>

        <nav aria-label="Followers Pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($follower_page == 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?follower_page=<?php echo $follower_page - 1; ?>">Previous</a>
                </li>
                <?php for ($i = max(1, $follower_page - 2); $i <= min($follower_page + 2, $total_follower_pages); $i++) {
                ?>
                    <li class="page-item <?php if ($i == $follower_page) echo 'active'; ?>">
                        <a class="page-link" href="?follower_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if ($follower_page == $total_follower_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?follower_page=<?php echo $follower_page + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>


<script type="text/javascript">
    function editBlog(blogId) {
        window.location.href = `edit_blog.php?blog_id=${blogId}`;
    }

    function deleteBlog(blogId) {
        if (confirm("Are you sure you want to delete this blog?")) {
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
            ajax_request.open("GET", `ajax_process.php?action=delete_blog&blog_id=${blogId}`, true);
            ajax_request.send();
        }
    }

    function changeBlogStatus(blogId, status) {
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
        ajax_request.open("GET", `ajax_process.php?action=change_blog_status&blog_id=${blogId}&status=${status}`, true);
        ajax_request.send();
    }
</script>

<?php require_once("footer.php"); ?>
