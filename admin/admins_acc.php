
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

	<div class="col-sm-1"></div>

	<div class="col-sm-8 mt-5">

	<h3 class="text-center bg-light shadow-lg mt-5 mb-5">Admin Profile</h3>
		
		<?php

			$query = "SELECT * FROM user,role
					  WHERE user.user_id= 1 AND role.role_id = 1";

			$result = mysqli_query($connection, $query);

			if ($result->num_rows) {
				?>
					<div class="table-responsive">
					<table class="table table-success table-striped table-hover">
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
								<th scope="col">View Profile</th>
							</tr>
						</thead>
						<tbody>
						<?php
							while ($data = mysqli_fetch_assoc($result)) {
						?>
							<tr>
								<td scope="row"><?= $data["user_id"] ?></td>
								<td><?= $data["role_type"] ?></td>
								<td><?= $data["first_name"]." ".$data["last_name"] ?></td>
								<td><?= $data["email"] ?></td>
								<td><?= $data["password"] ?></td>
								<td><?= $data["gender"] ?></td>
								<td><?= $data["date_of_birth"] ?></td>
								<td><img src="../images/<?= $data["user_image"] ?>" style="height: 50px;"></td>
								<td><?= $data["address"] ?></td>
								<td><a href="user_profile.php?user_id=<?= $data["user_id"] ?>" class="btn btn-primary post-link">Profile</a></td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
					</div>
			<?php
			}
			?>					
	</div>

	<div class="col-sm-1"></div>
</div>


<?php

	require_once("footer.php");

?>