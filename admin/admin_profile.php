<?php
require_once("header.php");
require_once("../require/connection.php");
require_once("../require/my_function.php");
session_maintainance(1);

// Fetch user data for the specific user_id and role_id = 2
$user_id = $_GET['user_id'] ?? null; // Default to null if not set
if (!$user_id) {
    die("Invalid User ID.");
}

$query = "SELECT u.first_name, u.last_name, u.role_id, u.email, u.gender, u.date_of_birth, u.user_image, u.address, u.is_approved, u.is_active, u.created_at, r.role_type 
          FROM user u 
          JOIN role r ON u.role_id = r.role_id 
          WHERE u.user_id = $user_id AND u.role_id = 1";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found or does not have role_id = 2.");
}
?>


<div class="row">
    <?php require_once("admin_sidbar.php"); ?>

    <div class="col-sm-1" style="width: 5rem;"></div>

    <div class="col-sm-8 mt-4">
        <h3 class="text-center bg-light shadow-lg mt-2 mb-4">User Profile</h3>

        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4 text-center">
                    <img src="<?= "../images/" . $user['user_image'] ?>" class="img-fluid rounded-start" alt="User Image">
                    <small><strong>Last Updated:</strong> <?php echo date("F j, Y, g:i a", strtotime($user['created_at'])); ?></small>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h5>
                        <p class="card-text"><strong>Role:</strong> <?= htmlspecialchars($user['role_type']) ?></p>
                        <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                        <p class="card-text"><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
                        <p class="card-text"><strong>Date of Birth:</strong> <?= htmlspecialchars($user['date_of_birth']) ?></p>
                        <p class="card-text"><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
                        <div class="d-flex justify-content-start mt-3">
                            <?php if ($user['is_approved'] == 'Approved') { ?>
                                <button style="margin-right: 3%" class="btn btn-success post-link" onclick="changeApprovedStatus(<?php echo $user_id; ?>, 'Pending')">Approve</button>
                            <?php } elseif ($user['is_approved'] == 'Pending') { ?>
                                <button style="margin-right: 3%" class="btn btn-warning post-link" onclick="changeApprovedStatus(<?php echo $user_id; ?>, 'Rejected')">Pending</button>
                            <?php } else { ?>
                                <button style="margin-right: 3%" class="btn btn-danger post-link" onclick="changeApprovedStatus(<?php echo $user_id; ?>, 'Approved')">Rejected</button>
                            <?php } ?>

                            <?php if ($user['is_active'] == 'Active') { ?>
                                <button style="margin-right: 3%" class="btn btn-success post-link" onclick="changeUserStatus(<?php echo $user_id; ?>, 'InActive')">Active</button>
                            <?php } else { ?>
                                <button style="margin-right: 3%" class="btn btn-warning post-link" onclick="changeUserStatus(<?php echo $user_id;  ?>, 'Active')">InActive</button>
                            <?php } ?>
                            <a href="update_user.php?user_id=<?= $user_id ?>" class="btn btn-primary post-link">Edit User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-1"></div>
</div>

<?php require_once("footer.php"); ?>

<script>

    function changeUserStatus(userId, status) {
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
        ajax_request.open("GET", `ajax_process.php?action=change_user_status&user_id=${userId}&status=${status}`, true);
        ajax_request.send();
    }

    function changeApprovedStatus(userId, appstatus) {
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
        ajax_request.open("GET", `ajax_process.php?action=change_appuser_status&user_id=${userId}&appstatus=${appstatus}`, true);
        ajax_request.send();
    }


</script>
