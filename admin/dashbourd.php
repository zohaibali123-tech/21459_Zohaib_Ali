<?php

	require_once("header.php");
	require_once("../require/connection.php");
	require_once("../require/my_function.php");
	session_maintainance(1);

?>

<div class="row">

	<?php

	require_once("admin_sidbar.php");

	?>	

	<div class="col-sm-1">
		
	</div>

	<div class="col-sm-3 mt-5">
		<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
			<div class="card-header text-center">Welcome!</div>
			<div class="card-body">
				<h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Admin</h4>
				<a href="admin_profile.php" class="btn btn-primary w-100 post-link">Update Profile</a>
			</div>
		</div>

		<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
		<?php
			$query = "SELECT COUNT(*) AS total_posts FROM post";
			$result = mysqli_query($connection, $query);
			$count = 0;

			if ($result) {
				$data = mysqli_fetch_assoc($result);
				$count = $data['total_posts'];
			}
		?>
			<div class="card-header text-center"><?= $count ?></div>
			<div class="card-body">
				<h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Add Post</h4>
				<a href="add_post.php" class="btn btn-primary w-100 post-link">Add New Post</a>
			</div>
		</div>

		<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
		<?php
			$query = "SELECT COUNT(*) AS total_user FROM user";
			$result = mysqli_query($connection, $query);
			$count = 0;

			if ($result) {
				$data = mysqli_fetch_assoc($result);
				$count = $data['total_user'];
			}
		?>
			<div class="card-header text-center"><?= $count ?></div>
			<div class="card-body">
				<h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Users Accounts</h4>
				<a href="users.php" class="btn btn-primary w-100 post-link">See Users</a>
			</div>
		</div>
	</div>

	<div class="col-sm-3 mt-5">
		<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
		<?php
			$query = "SELECT COUNT(*) AS total_blog FROM blog";
			$result = mysqli_query($connection, $query);
			$count = 0;

			if ($result) {
				$data = mysqli_fetch_assoc($result);
				$count = $data['total_blog'];
			}
		?>
			<div class="card-header text-center"><?= $count ?></div>
			<div class="card-body">
				<h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Add Blog</h4>
				<a href="add_blog.php" class="btn btn-primary w-100 post-link">Add New Blog</a>
			</div>
		</div>

		<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
		<?php
			$query = "SELECT COUNT(*) AS total_posts FROM post";
			$result = mysqli_query($connection, $query);
			$count = 0;

			if ($result) {
				$data = mysqli_fetch_assoc($result);
				$count = $data['total_posts'];
			}
		?>
			<div class="card-header text-center"><?= $count ?></div>
			<div class="card-body">
				<h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Post</h4>
				<a href="see_post.php" class="btn btn-primary w-100 post-link">See All Post</a>
			</div>
		</div>

		<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
		<?php
			$query = "SELECT COUNT(*) AS total_admin FROM user WHERE role_id = 1";
			$result = mysqli_query($connection, $query);
			$count = 0;

			if ($result) {
				$data = mysqli_fetch_assoc($result);
				$count = $data['total_admin'];
			}
		?>
			<div class="card-header text-center"><?= $count ?></div>
			<div class="card-body">
				<h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Admins Account</h4>
				<a href="see_admins.php" class="btn btn-primary w-100 post-link">See Admins</a>
			</div>
		</div>
	</div>

	<div class="col-sm-3 mt-5">
		<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
		<?php
			$query = "SELECT COUNT(*) AS total_category FROM category";
			$result = mysqli_query($connection, $query);
			$count = 0;

			if ($result) {
				$data = mysqli_fetch_assoc($result);
				$count = $data['total_category'];
			}
		?>
			<div class="card-header text-center"><?= $count ?></div>
			<div class="card-body">
				<h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Add Category</h4>
				<a href="add_category.php" class="btn btn-primary w-100 post-link">Add New Category</a>
			</div>
		</div>

		<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
        <?php
            $query = "SELECT COUNT(*) AS total_comment FROM post_comment";
            $result = mysqli_query($connection, $query);
            $count = 0;

            if ($result) {
                $data = mysqli_fetch_assoc($result);
                $count = $data['total_comment'];
            }
        ?>
            <div class="card-header text-center"><?= $count ?></div>
            <div class="card-body">
                <h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Comments</h4>
                <a href="see_comment.php" class="btn btn-primary w-100 post-link">See Comments</a>
            </div>
        </div>

        <div class="card text-bg-dark mb-3" style="max-width: 18rem;">
        <?php
            $query = "SELECT COUNT(*) AS total_category FROM category";
            $result = mysqli_query($connection, $query);
            $count = 0;

            if ($result) {
                $data = mysqli_fetch_assoc($result);
                $count = $data['total_category'];
            }
        ?>
            <div class="card-header text-center"><?= $count ?></div>
            <div class="card-body">
                <h4 class="card-title text-center border mb-3 p-2" style="background-color: palevioletred;">Category</h4>
                <a href="category.php" class="btn btn-primary w-100 post-link">See Category</a>
            </div>
        </div>
	</div>
</div>


<?php


	require_once("footer.php");

?>