<?php 
// Connection and session maintenance
require_once("../require/connection.php");
require_once("../require/my_function.php");
session_maintainance(1);

require_once("header.php");

// Search query
$query = isset($_GET['query']) ? mysqli_real_escape_string($connection, $_GET['query']) : '';

// Default empty query
if (empty($query)) {
    $query = '';
}

// Pagination setup
$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Main search query
$sql = "
    SELECT 
        u.user_id,
        u.first_name,
        u.last_name,
        u.gender,
        u.address,
        b.blog_title,
        (SELECT COUNT(p.post_id) FROM post p WHERE p.blog_id = b.blog_id) AS post_count,
        c.category_title,
        (SELECT COUNT(pcg.post_id) FROM post_category pcg WHERE pcg.category_id = c.category_id) AS category_post_count,
        p.post_id,
        p.post_title,
        p.post_description,
        p.post_summary,
        (SELECT COUNT(pc.post_comment_id) FROM post_comment pc WHERE pc.post_id = p.post_id) AS comment_count
    FROM user u
    LEFT JOIN blog b ON u.user_id = b.user_id
    LEFT JOIN post p ON b.blog_id = p.blog_id
    LEFT JOIN post_category pcg ON p.post_id = pcg.post_id
    LEFT JOIN category c ON pcg.category_id = c.category_id
    WHERE u.first_name LIKE '%$query%' 
       OR u.last_name LIKE '%$query%'
       OR u.gender LIKE '%$query%'
       OR u.address LIKE '%$query%'
       OR b.blog_title LIKE '%$query%'
       OR c.category_title LIKE '%$query%'
       OR p.post_title LIKE '%$query%'
       OR p.post_description LIKE '%$query%'
    GROUP BY p.post_id
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($connection, $sql);

// Count total records for pagination
$count_sql = "
    SELECT COUNT(DISTINCT p.post_id) AS total_records
    FROM user u
    LEFT JOIN blog b ON u.user_id = b.user_id
    LEFT JOIN post p ON b.blog_id = p.blog_id
    LEFT JOIN post_category pcg ON p.post_id = pcg.post_id
    LEFT JOIN category c ON pcg.category_id = c.category_id
    WHERE u.first_name LIKE '%$query%' 
       OR u.last_name LIKE '%$query%'
       OR u.gender LIKE '%$query%'
       OR u.address LIKE '%$query%'
       OR b.blog_title LIKE '%$query%'
       OR c.category_title LIKE '%$query%'
       OR p.post_title LIKE '%$query%'
       OR p.post_description LIKE '%$query%'
";
$count_result = mysqli_query($connection, $count_sql);
$total_records = mysqli_fetch_assoc($count_result)['total_records'];
$total_pages = ceil($total_records / $limit);

?>

<div class="row">

    <?php require_once("admin_sidbar.php"); ?>

    <div class="col-sm-1" style="width: 5rem;"></div>

    <div class="col-sm-8 mt-4">
        <h3 class="text-center bg-light shadow-lg mt-2 mb-4">
            <?php echo !empty($query) ? "Results for: " . htmlspecialchars($query) : "Search Results"; ?>
        </h3>

        <ol class="list-group list-group-numbered">
    <?php if ($result && mysqli_num_rows($result) > 0) { ?>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <!-- Post Title with a tag -->
                    <div class="fw-bold">
                        <a style="text-decoration: none;" href="open_post.php?post_id=<?php echo urlencode($row['post_id']); ?>">
                            <?php echo htmlspecialchars($row['post_title']); ?>
                        </a>
                    </div>
                    <?php echo htmlspecialchars($row['post_description']); ?>
                    <p>
                        <!-- User with first_name and last_name links -->
                        <strong>User:</strong> 
                        <a style="text-decoration: none;" href="user_profile.php?user_id=<?php echo urlencode($row["user_id"]); ?>">
                            <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>
                        </a> 
                        (<?php echo htmlspecialchars($row['gender']); ?>)<br>

                        <!-- Address -->
                        <strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?><br>

                        <!-- Blog Title with a tag -->
                        <strong>Blog:</strong> 
                        <a style="text-decoration: none;" href="blog.php?blog=<?php echo urlencode($row['blog_title']); ?>">
                            <?php echo htmlspecialchars($row['blog_title']); ?>
                        </a>
                        <span class="badge bg-info rounded-pill"><?php echo $row['post_count']; ?> Posts</span><br>

                        <!-- Category Title with a tag -->
                        <strong>Category:</strong> 
                        <a style="text-decoration: none;" href="category.php?category=<?php echo urlencode($row['category_title']); ?>">
                            <?php echo htmlspecialchars($row['category_title']); ?>
                        </a>
                        <span class="badge bg-success rounded-pill"><?php echo $row['category_post_count']; ?> Posts</span><br>

                        <!-- Post Summary -->
                        <strong>Post Summary:</strong> <?php echo htmlspecialchars($row['post_summary']); ?>
                    </p>
                </div>
                <!-- Comments Count with a tag -->
                <span class="badge bg-primary rounded-pill">
                    <a href="see_comment.php?post_id=<?php echo urlencode($row['post_title']); ?>" style="color: white; text-decoration: none;">
                        <?php echo $row['comment_count']; ?> Comments
                    </a>
                </span>
            </li>
        <?php } ?>
    <?php } else { ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">No results found</div>
                Please try a different search term.
            </div>
        </li>
    <?php } ?>
</ol>


        <!-- Pagination -->
<?php if ($total_pages > 1) { ?>
    <nav aria-label="Page navigation example" class="mt-4">
        <ul class="pagination justify-content-center">
            <!-- Previous Button -->
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($page > 1) ? '?query=' . urlencode($query) . '&page=' . ($page - 1) : '#'; ?>">
                    Previous
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>" aria-current="page">
                    <a class="page-link" href="?query=<?php echo urlencode($query); ?>&page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php } ?>

            <!-- Next Button -->
            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($page < $total_pages) ? '?query=' . urlencode($query) . '&page=' . ($page + 1) : '#'; ?>">
                    Next
                </a>
            </li>
        </ul>
    </nav>
<?php } ?>

    </div>
</div>

<?php require_once("footer.php"); ?>
