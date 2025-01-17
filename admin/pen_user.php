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

		<div class="col-sm-10">

			<h3 class="text-center bg-light shadow-lg mt-2 mb-4">Pending User</h3>

			<?php
				$rows_per_page = 5;

				$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				if ($current_page < 1) {
					$current_page = 1;
				}

				$offset = ($current_page - 1) * $rows_per_page;

				$total_query = "SELECT COUNT(*) AS total FROM user WHERE role_id = 2";
				$total_result = mysqli_query($connection, $total_query);
				$total_row = mysqli_fetch_assoc($total_result);
				$total_rows = $total_row['total'];

				$total_pages = ceil($total_rows / $rows_per_page);

				$query = "SELECT user.*, role.role_type
					  FROM user
					  JOIN role ON user.role_id = role.role_id
					  WHERE role.role_type = 'user'
					  AND user.is_approved = 'Pending'
					  ORDER BY user.user_id DESC
					  LIMIT $offset, $rows_per_page";

				$result = mysqli_query($connection, $query);

				if ($result->num_rows) {
			?>
			<div class="table-responsive" style="margin-left: 40px;">
				<table class="table table-success table-striped table-hover table-respon">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Role</th>
							<th scope="col">Full Name</th>
							<th scope="col">Email</th>
							<th scope="col">Password</th>
							<th scope="col">Gender</th>
							<th scope="col">Date Of Birth</th>
							<th scope="col">Profile Image</th>
							<th scope="col">Address</th>
							<th scope="col">Status</th>
							<th scope="col">A/InA Status</th>
							<th scope="col">Update</th>
						</tr>
					</thead>
					<tbody>
					<?php
						while ($data = mysqli_fetch_assoc($result)) {
					?>
						<tr>
							<td scope="row"><?= $data["user_id"] ?></td>
							<td><?= $data["role_type"] ?></td>
							<td><?= $data["first_name"] . " " . $data["last_name"] ?></td>
							<td><?= $data["email"] ?></td>
							<td><?= $data["password"] ?></td>
							<td><?= $data["gender"] ?></td>
							<td><?= $data["date_of_birth"] ?></td>
							<td><img src="../images/<?= $data['user_image'] ?>" style="height: 50px; border-radius: 50px;"></td>
							<td><?= $data["address"] ?></td>
							<td><?= $data["is_approved"] ?></td>
							<td><?= $data["is_active"] ?></td>
							<td><a href="user_profile.php?user_id=<?= $data["user_id"] ?>" class="btn btn-primary post-link">Profile</a></td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</div>
		<?php } ?>
		
		<br/>

		<nav aria-label="Page navigation example">
			<ul class="pagination justify-content-center">
				<li class="page-item <?php if ($current_page == 1) echo 'disabled'; ?>">
					<a class="page-link" href="?page=<?php echo $current_page - 1; ?>">Previous</a>
				</li>
				<?php for ($i = max(1, $current_page - 2); $i <= min($current_page + 2, $total_pages); $i++) { ?>
				<li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
					<a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a>
				</li>
				<?php } ?>
				<li class="page-item <?php if ($current_page == $total_pages) echo 'disabled'; ?>">
					<a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Next</a>
				</li>
			</ul>
		</nav>

	</div>
</div>


<?php

	require_once("footer.php");

?>