<?php
	require_once("../require/connection.php");
	require_once("../require/my_function.php");
	session_maintainance(1);

	if (isset($_GET['toggle_status']) && isset($_GET['post_id'])) {
		$postId = intval($_GET['post_id']);
		$toggleStatus = ($_GET['toggle_status'] === 'Active') ? 'InActive' : 'Active';

		$statusQuery = "UPDATE post SET post_status = '$toggleStatus' WHERE post_id = $postId";
		if (mysqli_query($connection, $statusQuery)) {
        	header("Location: ".$_SERVER['PHP_SELF']."?page=".$_GET['page']);
			exit;
		} else {
			die("Error toggling post status: " . mysqli_error($connection));
		}
	}

	$postsPerPage = 3;
	$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
	$offset = ($page - 1) * $postsPerPage;

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
		ORDER BY post.updated_at DESC
		LIMIT $postsPerPage OFFSET $offset";
	$postResult = mysqli_query($connection, $postQuery);
	if (!$postResult) {
		die("Error in Post Query: " . mysqli_error($connection));
	}

	$totalPostsQuery = "SELECT COUNT(*) AS total FROM post";
	$totalPostsResult = mysqli_query($connection, $totalPostsQuery);
	$totalPostsRow = mysqli_fetch_assoc($totalPostsResult);
	$totalPosts = $totalPostsRow['total'];
	$totalPages = ceil($totalPosts / $postsPerPage);

	$attachmentQuery = "SELECT * FROM post_atachment";
	$attachmentResult = mysqli_query($connection, $attachmentQuery);
	if (!$attachmentResult) {
		die("Error in Attachment Query: " . mysqli_error($connection));
	}

	$attachments = [];
	while ($attachmentRow = mysqli_fetch_assoc($attachmentResult)) {
		$attachments[$attachmentRow['post_id']][] = $attachmentRow['post_attachment_path'];
	}

	require_once("header.php");
?>

<div class="row">
	<?php require_once("admin_sidbar.php"); ?>

	<div class="col-sm-1"></div>
	<div class="col-sm-8">
		<h3 class="text-center bg-light shadow-lg mt-2 mb-4">All Posts</h3>

		<div class="row row-cols-1 row-cols-md-3 g-4">
			<?php while ($postRow = mysqli_fetch_assoc($postResult)) { ?>
			<div class="col post-link">
				<div class="card h-100 ">
					<div>
					<img src="<?php echo "uploads/" . $postRow['featured_image']; ?>" class="card-img-top" alt="Post Image">
					</div>
                        
				<div class="card-body">
					<h5 class="card-title"><strong>Title:</strong> <?php echo htmlspecialchars($postRow['post_title']); ?></h5>
					<p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($postRow['post_description']); ?></p>
					<p class="card-text"><strong>Summary:</strong> <?php echo htmlspecialchars($postRow['post_summary']); ?></p>
					<p><strong>Category:</strong> <?php echo htmlspecialchars($postRow['category_title'] ?? 'Uncategorized'); ?></p>
					<p><strong>Blog:</strong> <?php echo htmlspecialchars($postRow['blog_title'] ?? 'No Blog'); ?></p>
				</div>

				<div class="card-footer">
					<p class="text-muted"><strong>Last Updated:</strong> <?php echo date("F j, Y, g:i a", strtotime($postRow['updated_at'])); ?></p>
					<button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#attachments-<?php echo $postRow['post_id']; ?>" aria-expanded="false" aria-controls="attachments-<?php echo $postRow['post_id']; ?>">
						View Attachments
					</button>
					<a href="open_post.php?post_id=<?php echo $postRow['post_id']; ?>" class="btn btn-primary btn-sm post-link">Open Post</a>
					<a href="?toggle_status=<?php echo $postRow['post_status']; ?>&post_id=<?php echo $postRow['post_id']; ?>&page=<?php echo $page; ?>" class="btn btn-warning btn-sm mt-2 post-link">
						<?php echo $postRow['post_status'] === 'Active' ? 'Deactivate' : 'Activate'; ?>
					</a>
					<a href="edit_post.php?post_id=<?php echo $postRow['post_id']; ?>" class="card-link btn btn-primary btn-sm mt-2 post-link">Edit Post</a>
					<button class="btn btn-danger btn-sm mt-2 post-link" onclick="deletePost(<?php echo $postRow['post_id']; ?>)">Delete</button>
				</div>

				<div class="collapse" id="attachments-<?php echo $postRow['post_id']; ?>">
					<div class="card card-body">
						<?php if (!empty($attachments[$postRow['post_id']])) { ?>
						<ul>
							<?php foreach ($attachments[$postRow['post_id']] as $attachment) { ?>
							<li><a style="text-decoration: none;" href="<?php echo $attachment; ?>" target="_blank">View Attachment</a></li>
							<?php } ?>
						</ul>
						<?php } else { ?>
							<p>No attachments found.</p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>

	<br/>

	<nav aria-label="...">
		<ul class="pagination justify-content-center">
            <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Previous</a>
            </li>
        <?php for ($i = max(1, $page - 2); $i <= min($page + 2, $totalPages); $i++) { ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>
            <li class="page-item <?php if ($page == $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
            </li>
        </ul>
	</nav>
</div>
</div>

<script type="text/javascript">
	
	function deletePost(postId) {
        if (confirm("Are You Sure You Want To Delete This Post?")) {
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
            ajax_request.open("GET", `ajax_process.php?action=delete_post&post_id=${postId}`, true);
            ajax_request.send();
        }
    }

</script>

<?php require_once("footer.php"); ?>
