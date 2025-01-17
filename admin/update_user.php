<?php

	require_once("header.php");
	require_once("../require/connection.php");
	require_once("../require/my_function.php");
	session_maintainance(1);

?>

<div class="row">

	<?php

	require_once("admin_sidbar.php");

	$user_id = $_GET['user_id'];

	$query = "SELECT * FROM user WHERE user_id = $user_id";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_num_rows($result) > 0) {
    	$user = mysqli_fetch_assoc($result);
	} else {
    	echo "User not found.";
    	exit();
	}

	mysqli_close($connection);
?>

	<div class="col-sm-1"></div>

	<div class="col-sm-8">

	<h3 class="text-center bg-light shadow-lg mt-2 mb-4">Update Here</h3>

	<?php if (isset($_GET["message"])) { ?>
			<p style="font-family: cursive;text-align: center;"><?php echo $_GET['message']; ?></p>
	<?php } ?>

		<form action="u_process.php" method="POST" enctype="multipart/form-data">
				<table border="0" cellspacing="10px" cellpadding="10px">
					<tr>
						<td>
							<input type="hidden"  name="user_id" value="<?= $user['user_id']; ?>">
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">First Name: </label></td>
						<td>
							<input type="text"  name="first_name" value="<?= $user['first_name']; ?>" class="form-control"  placeholder="Zohaib">
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Last Name: </label></td>
						<td>
							<input type="text" name="last_name" value="<?= $user['last_name']; ?>" class="form-control"  placeholder="Ali">
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Email: </label></td>
						<td>
							<input type="email" name="email" value="<?= $user['email']; ?>" class="form-control"  placeholder="name@example.com">
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Password: </label></td>
						<td>
							<input type="password" name="password" value="<?= $user['password']; ?>" class="form-control" >
						</td>
					</tr>
					<tr>
						<td>
							<label class="form-check-label" id="flexRadioDefault1">Gender: </label>
						</td>
						<td>
							<input class="form-check-input" type="radio" name="gender" value="Male" <?= ($user['gender'] == 'Male') ? 'checked' : ''; ?>> Male <br>
							<input class="form-check-input" type="radio" name="gender" value="Female" <?= ($user['gender'] == 'Female') ? 'checked' : ''; ?>> Female <br>
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput" class="form-check-label">Date Of Birth: </label></td>
						<td>
							<input class="form-control"  type="date" name="date_of_birth" value="<?= $user['date_of_birth']; ?>">
						</td>
					</tr>
					<tr>
						<td><label id="formFile" class="form-label">Profile Image: </label></td>
						<td>
						<?php if (!empty($user['user_image'])): ?>
							<img src="../images/<?= $user['user_image']; ?>" alt="Profile Image" style="max-width: 100px; max-height: 100px;">
						<?php endif; ?>
							<input class="form-control" type="file" name="file">
							<input type="hidden" name="existing_image" value="<?= $user['user_image']; ?>">
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput">Home Town: </label></td>
  						<td>
  							<textarea class="form-control" placeholder="Home Town"  name="home_town"><?= $user['address']; ?></textarea>
  						</td>
					</tr>
					<tr>
						<td align="center">
							<input class="btn btn-primary w-100" type="submit" name="submit" value="Update">
						</td>
					</tr>
				</table>		
			</form>
	</div>

	<div class="col-sm-1">
	</div>
</div>

<?php

	require_once("footer.php");

?>