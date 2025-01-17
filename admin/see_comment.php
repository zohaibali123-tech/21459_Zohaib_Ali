<?php

    require_once("header.php");
    require_once("../require/connection.php");
    require_once("../require/my_function.php");
    session_maintainance(1);

?>

<div class="row">
    <?php require_once("admin_sidbar.php"); ?>

    <div class="col-sm-1" style="width: 5rem;"></div>

    <div class="col-sm-8 mt-4">
        <h3 class="text-center bg-light shadow-lg mt-2 mb-4">Users Comments</h3>
        <div id="comment-list" class="list-group">
            <?php
            $query = "
                   SELECT 
                        pc.post_comment_id AS comment_id,
                        pc.comment AS user_comment, 
                        pc.is_active AS is_active,
                        pc.created_at AS comment_date, 
                        p.post_title AS post_name, 
                        p.post_id AS post_id,
                        u.first_name AS user_name, 
                        u.last_name AS user_last_name 
                    FROM post_comment pc
                    JOIN post p ON pc.post_id = p.post_id
                    JOIN user u ON pc.user_id = u.user_id
                    ORDER BY pc.created_at DESC";

            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $comment_id = $row['comment_id'];
                    $user_full_name = $row['user_name'] . ' ' . $row['user_last_name'];
                    $user_comment = $row['user_comment'];
                    $comment_date = date("F j, Y, g:i a", strtotime($row['comment_date']));
                    $post_name = $row['post_name'];
                    $post_id = $row['post_id'];
            ?>
                    <div id="comment-<?= $comment_id; ?>" class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Post: <a href="open_post.php?post_id=<?php echo $post_id; ?>" class="post-link"><?= htmlspecialchars($post_name); ?></a></h5>
                            <small class="text-muted"><?= htmlspecialchars($comment_date); ?></small>
                        </div>
                        <p class="mb-1" id="comment-text-<?= $comment_id; ?>"><?= htmlspecialchars($user_comment); ?></p>
                        <small class="text-muted">Comment by: <?= htmlspecialchars($user_full_name); ?></small>
                        <div class="mt-3">
                            <button class="btn btn-primary post-link" onclick="editComment(<?php echo $comment_id; ?>)">Edit</button>
                            <button class="btn btn-danger post-link" onclick="deleteComment(<?php echo $comment_id; ?>)">Delete</button>

                        <?php if ($row['is_active'] == 'Active') { ?>
                            <button class="btn btn-success post-link" onclick="changeCommentStatus(<?php echo $comment_id; ?>, 'InActive')">Active</button>
                        <?php } else { ?>
                            <button class="btn btn-warning post-link" onclick="changeCommentStatus(<?php echo $comment_id; ?>, 'Active')">InActive</button>
                        <?php } ?>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="text-center text-muted">No comments found.</p>';
            }
            ?>
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>

<script>

    function editComment(commentId) {
        const commentTextElement = document.getElementById(`comment-text-${commentId}`);
        const currentComment = commentTextElement.innerText;

        commentTextElement.innerHTML = `<textarea id="edit-comment-input-${commentId}" class="form-control" rows="3">${currentComment}</textarea>`;

        const buttonContainer = commentTextElement.parentElement.querySelector('.mt-3');
        buttonContainer.innerHTML = `<button class="btn btn-primary" onclick="saveInlineComment(${commentId})">Save</button>
        <button class="btn btn-secondary" onclick="cancelEdit(${commentId}, '${currentComment}')">Cancel</button>`;
    }

    function cancelEdit(commentId, originalComment) {
        const commentTextElement = document.getElementById(`comment-text-${commentId}`);
        commentTextElement.innerText = originalComment;

        const buttonContainer = commentTextElement.parentElement.querySelector('.mt-3');
        buttonContainer.innerHTML = `<button class="btn btn-primary" onclick="editComment(${commentId})">Edit</button>
        <button class="btn btn-danger" onclick="deleteComment(${commentId})">Delete</button>
        <button class="btn btn-success" onclick="changeCommentStatus(${commentId}, 'InActive')">Active</button>`;
    }


    function saveInlineComment(commentId) {
        const updatedComment = document.getElementById(`edit-comment-input-${commentId}`).value;

        var ajax_request = new XMLHttpRequest();
        ajax_request.onreadystatechange = function () {
            if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                if (ajax_request.responseText.trim() === "success") {
                    alert("Comment updated successfully.");
                    location.reload();
                } else {
                alert(ajax_request.responseText);
                }
            }
        };
        ajax_request.open("POST", `ajax_process.php?action=update_comment`, true);
        const formData = new FormData();
        formData.append('comment_id', commentId);
        formData.append('comment_text', updatedComment);
        ajax_request.send(formData);
    }


    function deleteComment(commentId) {
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
            ajax_request.open("GET", `ajax_process.php?action=delete_comment&comment_id=${commentId}`, true);
            ajax_request.send();
        }
    }

    function changeCommentStatus(commentId, status) {
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
        ajax_request.open("GET", `ajax_process.php?action=change_comment_status&comment_id=${commentId}&status=${status}`, true);
        ajax_request.send();
    }

</script>

<?php require_once("footer.php"); ?>
