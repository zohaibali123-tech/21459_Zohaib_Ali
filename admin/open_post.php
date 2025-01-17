<?php
    require_once("header.php");
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
            post.post_status,
            post.featured_image,
            post.updated_at,
            category.category_title,
            blog.blog_title
        FROM post
        LEFT JOIN post_category ON post.post_id = post_category.post_id
        LEFT JOIN category ON post_category.category_id = category.category_id
        LEFT JOIN blog ON post.blog_id = blog.blog_id
        WHERE post.post_id = $postId";

    $postResult = mysqli_query($connection, $postQuery);
    $postRow = mysqli_fetch_assoc($postResult);

    if (!$postRow) {
        die("Post not found.");
    }

    $commentsPerPage = 5;
    $totalCommentsQuery = "SELECT COUNT(*) AS total FROM post_comment WHERE post_id = $postId";
    $totalCommentsResult = mysqli_query($connection, $totalCommentsQuery);
    $totalComments = mysqli_fetch_assoc($totalCommentsResult)['total'];
    $totalPages = ceil($totalComments / $commentsPerPage);

    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($currentPage - 1) * $commentsPerPage;

    $commentQuery = "
        SELECT 
            post_comment.comment, 
            post_comment.created_at, 
            user.first_name, 
            user.last_name 
        FROM post_comment 
        LEFT JOIN user ON post_comment.user_id = user.user_id 
        WHERE post_comment.post_id = $postId 
        ORDER BY post_comment.created_at DESC 
        LIMIT $commentsPerPage OFFSET $offset";

    $commentResult = mysqli_query($connection, $commentQuery);

    $attachmentQuery = "SELECT * FROM post_atachment WHERE post_id = $postId";
    $attachmentResult = mysqli_query($connection, $attachmentQuery);
    $attachments = [];

    while ($attachmentRow = mysqli_fetch_assoc($attachmentResult)) {
        $attachments[] = $attachmentRow['post_attachment_path'];
    }
?>

<div class="row">
    
    <?php require_once("admin_sidbar.php"); ?>

    <div class="col-md-1" style="width: 5rem;"></div>

    <div class="col-md-4 mt-4">
        <div class="card" style="width: 33rem;">
            <div>
                <img src="<?php echo "uploads/" . $postRow['featured_image']; ?>" class="card-img-top" alt="Post Image">
            </div>
        <div class="card-body">
            <h5 class="card-title"><strong>Title:</strong> <?php echo htmlspecialchars($postRow['post_title']); ?></h5>
            <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($postRow['category_title'] ?? 'Uncategorized'); ?></p>
            <p class="card-text"><strong>Blog:</strong> <?php echo htmlspecialchars($postRow['blog_title'] ?? 'No Blog'); ?></p>
            <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($postRow['post_description']); ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Summary:</strong> <?php echo htmlspecialchars($postRow['post_summary']); ?></li>
        <?php if (!empty($attachments)) { ?>
            <li class="list-group-item"><strong>Attachments:</strong>
                <ul>
            <?php foreach ($attachments as $attachment) { ?>
                    <li><a style="text-decoration: none;" href="<?php echo $attachment; ?>" target="_blank">View Attachment</a></li>
            <?php } ?>
                </ul>
            </li>
        <?php } ?>
        </ul>
        <div class="card-body">
            <p class="card-text"><strong>Last Updated:</strong> <?php echo date("F j, Y, g:i a", strtotime($postRow['updated_at'])); ?></p>
            <a href="see_post.php" class="card-link btn btn-primary btn-sm post-link custom-button">Back to Posts</a>
        </div>
    </div>
</div>
    <div class="col-md-1"></div>

    <div class="col-md-4 mt-4">        
        <div class="card mb-3" style="width: 25rem;">
            <div class="card-header">
                <h3>Comments</h3>
            </div>
            <?php if (mysqli_num_rows($commentResult) > 0) { ?>
                <?php while ($commentRow = mysqli_fetch_assoc($commentResult)) { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><h4>Name: <?php echo htmlspecialchars($commentRow['first_name'] . " " . $commentRow['last_name']); ?></h4></li>
                        <li class="list-group-item"><?php echo htmlspecialchars($commentRow['comment']); ?></li>
                        <li class="list-group-item"><small><strong>Posted on:</strong> <?php echo date("F j, Y, g:i a", strtotime($commentRow['created_at'])); ?></small></li>
                    </ul>
                </div>
                <?php } ?>

            <nav aria-label="Comments Pagination">
                <ul class="pagination">
                    <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?post_id=<?php echo $postId; ?>&page=<?php echo $currentPage - 1; ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                            <a class="page-link" href="?post_id=<?php echo $postId; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?post_id=<?php echo $postId; ?>&page=<?php echo $currentPage + 1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php } else { ?>
            <p>No comments yet.</p>
        <?php } ?>
    </div>
</div>

<?php require_once("footer.php"); ?>
