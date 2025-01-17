<?php
require_once("../require/connection.php");

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Delete blog
    if ($action == 'delete_blog' && isset($_GET['blog_id'])) {
        $blog_id = (int)$_GET['blog_id'];
        $query = "DELETE FROM blog WHERE blog_id = $blog_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error deleting blog: " . mysqli_error($connection);
        }
        exit;
    }

    // Change blog status
    if ($action == 'change_blog_status' && isset($_GET['blog_id'], $_GET['status'])) {
        $blog_id = (int)$_GET['blog_id'];
        $status = $_GET['status'];
        $query = "UPDATE blog SET blog_status = '$status' WHERE blog_id = $blog_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error updating status: " . mysqli_error($connection);
        }
        exit;
    }

    // Delete category
    if ($action == 'delete_category' && isset($_GET['category_id'])) {
        $category_id = (int)$_GET['category_id'];
        $query = "DELETE FROM category WHERE category_id = $category_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error deleting category: " . mysqli_error($connection);
        }
        exit;
    }

    // Change category status
    if ($action == 'change_category_status' && isset($_GET['category_id'], $_GET['status'])) {
        $category_id = (int)$_GET['category_id'];
        $status = $_GET['status'];
        $query = "UPDATE category SET category_status = '$status' WHERE category_id = $category_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error updating status: " . mysqli_error($connection);
        }
        exit;
    }

    // Delete post
    if ($action == 'delete_post' && isset($_GET['post_id'])) {
        $post_id = (int)$_GET['post_id'];
        $query = "DELETE FROM post WHERE post_id = $post_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error deleting post: " . mysqli_error($connection);
        }
        exit;
    }

    // Delete Comment
    if ($action == 'delete_comment' && isset($_GET['comment_id'])) {
        $comment_id = (int)$_GET['comment_id'];
        $query = "DELETE FROM post_comment WHERE post_comment_id = $comment_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error deleting comment: " . mysqli_error($connection);
        }
        exit;
    }

    // Change Comment Status
    if ($action == 'change_comment_status' && isset($_GET['comment_id'], $_GET['status'])) {
        $comment_id = (int)$_GET['comment_id'];
        $status = $_GET['status'];
        $query = "UPDATE post_comment SET is_active = '$status' WHERE post_comment_id = $comment_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error updating status: " . mysqli_error($connection);
        }
        exit;
    }

    // Update Comment (New Action)
    if ($action == 'update_comment' && isset($_POST['comment_id'], $_POST['comment_text'])) {
        $comment_id = (int)$_POST['comment_id'];
        $comment_text = mysqli_real_escape_string($connection, $_POST['comment_text']);
        $query = "UPDATE post_comment SET comment = '$comment_text' WHERE post_comment_id = $comment_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error updating comment: " . mysqli_error($connection);
        }
        exit;
    }

    if ($action == 'change_user_status' && isset($_GET['user_id'], $_GET['status'])) {
        $user_id = (int)$_GET['user_id'];
        $status = $_GET['status'];
        $query = "UPDATE user SET is_active = '$status' WHERE user_id = $user_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error updating status: " . mysqli_error($connection);
        }
        exit;
    }

    if ($action == 'change_appuser_status' && isset($_GET['user_id'], $_GET['appstatus'])) {
        $user_id = (int)$_GET['user_id'];
        $status = $_GET['appstatus'];
        $query = "UPDATE user SET is_approved = '$status' WHERE user_id = $user_id";

        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "Error updating status: " . mysqli_error($connection);
        }
        exit;
    }
}

?>
