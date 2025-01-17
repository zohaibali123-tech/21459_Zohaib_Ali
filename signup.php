<?php

	require_once('require/my_function.php');
	require_once('require/connection.php');
	require_once('header.php');
	require_once('form_validation.php');

?>

	<script type="text/javascript" src="js/validation.js"></script>

<style type="text/css">
	td > span{
		color: red;
	}
</style>

	<div class="row mt-5" align="center">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<h1 class="text-center bg-light shadow-lg mt-5">SIGN UP</h1>
		</div>
		<div class="col-sm-4"></div>
		<div class="col-sm mt-5">
			<h3 class="text-danger mb-4">Note: Required Fields (*)</h3>
			<form action="signup_process.php" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
				<table border="0" cellspacing="10px" cellpadding="10px">
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">First Name: </label><span>*</span></td>
						<td>
							<input type="text" id="first_name" name="first_name" value="<?= $first_name??""; ?>" class="form-control"  placeholder="Zohaib">
							<span id="first_name_msg"><?= $first_name_msg??"";  ?></span>
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Last Name: </label><span>*</span></td>
						<td>
							<input type="text" id="last_name" name="last_name" value="<?= $last_name??""; ?>" class="form-control"  placeholder="Ali">
							<span id="last_name_msg"><?=  $last_name_msg??"";  ?></span>
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Email: </label><span>*</span></td>
						<td>
							<input type="email" id="email" name="email" value="<?= $email??""; ?>" class="form-control"  placeholder="name@example.com">
							<span id="email_msg"><?=  $email_msg??"";  ?></span>
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Password: </label><span>*</span></td>
						<td>
							<input type="password" id="password" name="password" value="<?= $password??""; ?>" class="form-control" >
							<span id="password_msg"><?=  $password_msg??"";  ?></span>
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Confirm Password: </label><span>*</span></td>
						<td>
							<input type="password" id="confirm_password" name="confirm_password" value="<?= $confirm_password??""; ?>" class="form-control" >
							<span id="confirm_password_msg"><?=  $confirm_password_msg??"";  ?></span>
						</td>
					</tr>
					<tr>
						<td>
							<label class="form-check-label" id="flexRadioDefault1">Gender: </label>
							<span>*</span>
						</td>
						<td>
							<input class="form-check-input"  type="radio" name="gender" value="Male" <?= (isset($gender) && $gender == "Male")?'checked':''; ?> /> Male <br>

							<input class="form-check-input"  type="radio" name="gender" value="Female" <?= (isset($gender) && $gender == "Female")?'checked':'';  ?> /> Female <br>
							
							<span id="gender_msg"><?=  $gender_msg??"";  ?></span>
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput" class="form-check-label">Date Of Birth: </label><span>*</span></td>
						<td>
							<input class="form-control" id="date_of_birth"  type="date" name="date_of_birth" value="<?= $date_of_birth??""; ?>">
							<span id="date_msg"><?=  $dob_msg??"";  ?></span>
						</td>
					</tr>
					<tr>
						<td><label id="formFile" class="form-label">Profile Image: </label><span>*</span></td>
						<td>
							<input class="form-control"  type="file" name="file" id="file" value="" >
							<span id="file_msg"><?=  $file_msg??"";  ?></span>
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput">Home Town: </label><span>*</span></td>
  						<td>
  							<textarea class="form-control" id="home_town" placeholder="Home Town"  name="home_town"  ></textarea>
  							<span id="home_town_msg"><?=  $home_town_msg??"";  ?></span>
  						</td>
					</tr>
					<tr>
						<td align="center">
							<input class="btn btn-primary w-100" type="submit" name="submit" value="Sign up">
							<td>
								<span>You Have A Account Please</span>
								<a href="login.php" style="text-decoration: none;">Log In</a>
							</td>
						</td>
					</tr>
				</table>		
			</form>
		</div>
	</div>

	


<?php

	require_once('footer.php');

?>