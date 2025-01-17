<?php

    require_once("../require/connection.php");
    require_once("../require/my_function.php");
    session_maintainance(1);

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT user_id, user_name, user_email, feedback, created_at FROM user_feedback";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    require_once("header.php");
?>

<div class="row">
    <?php require_once("admin_sidbar.php"); ?>
    
    <div class="col-sm-1"></div>
    <div class="col-sm-8">
        <h3 class="text-center bg-light shadow-lg mt-2 mb-4">User Feedback</h3>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="card text-center mb-3">
                    <div class="card-header">
                        Feedback from 
                        <a href="user_profile.php?id=<?php echo $row['user_id']; ?>"><?php echo htmlspecialchars($row['user_name']); ?></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['user_email']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['feedback']); ?></p>
                    </div>
                    <div class="card-footer text-body-secondary">
                        Posted on: <?php echo htmlspecialchars($row['created_at']); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">No feedback available.</div>
        <?php endif; ?>

    </div>
</div>

<?php require_once("footer.php"); ?>