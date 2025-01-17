<?php
	require_once("../require/connection.php");
	require_once("../require/my_function.php");
	session_maintainance(1);

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $first_name         = $_POST['first_name'];
        $last_name          = $_POST['last_name'];
        $email              = $_POST['email'];
        $password           = $_POST['password'];
        $confirm_password   = $_POST['confirm_password'];
        $gender             = $_POST['gender'];
        $date_of_birth      = $_POST['date_of_birth'];
        $home_town          = $_POST['home_town'];
        $is_approved		= $_POST['is_approved'];
        $is_active			= $_POST['is_active'];
    
    
        $imagePath = null;

        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

            $tmp_name    = $_FILES['file']['tmp_name'];
            $name        = $_FILES['file']['name'];
            $file_name   = time()."_".$_FILES['file']['name'];
            $path        = "../images/".$file_name;

            if (move_uploaded_file($tmp_name, $path)) {

            $imagePath = $path;
            } else {
                die("file not uploaded.");
            }
        }

        $hashed_password = sha1($password);
        $role = 2;
    
        $query = "INSERT INTO user (role_id, first_name, last_name, email, password, gender, date_of_birth, user_image, address, is_approved, is_active, updated_at)
            VALUES ('$role', '$first_name', '$last_name', '$email', '$hashed_password', '$gender', '$date_of_birth', '$file_name', '$home_town', '$is_approved', '$is_active', CURRENT_TIMESTAMP)";

    
        if ($connection->query($query) === TRUE) {

            header("location: users.php?");
        } else {
            
            echo "New User Account Is Not Regester. Try Again Latter!...&color=red";
        }

    
        $connection->close();
    }

    require_once("header.php");
?>

<div class="row">

	<?php

	require_once("admin_sidbar.php");

	?>

	<div class="col-sm-1"></div>

	<div class="col-sm-8">
		
		<h3 class="text-center bg-light shadow-lg mt-2 mb-4">Add New User</h3>
		<form action="" method="POST" enctype="multipart/form-data">
				<table border="0" cellspacing="10px" cellpadding="10px">
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">First Name: </label></td>
						<td>
							<input type="text"  name="first_name" value="<?= $first_name??""; ?>" class="form-control"  placeholder="Zohaib">
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Last Name: </label></td>
						<td>
							<input type="text" name="last_name" value="<?= $last_name??""; ?>" class="form-control"  placeholder="Ali">
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Email: </label></td>
						<td>
							<input type="email" name="email" value="<?= $email??""; ?>" class="form-control"  placeholder="name@example.com">
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Password: </label></td>
						<td>
							<input type="password" name="password" value="<?= $password??""; ?>" class="form-control" >
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput1" class="form-label">Confirm Password: </label></td>
						<td>
							<input type="password" name="confirm_password" value="<?= $confirm_password??""; ?>" class="form-control" >
						</td>
					</tr>
					<tr>
						<td>
							<label class="form-check-label" id="flexRadioDefault1">Gender: </label>
						</td>
						<td>
							<input class="form-check-input"  type="radio" name="gender" value="Male" <?= (isset($gender) && $gender == "Male")?'checked':''; ?> /> Male <br>

							<input class="form-check-input"  type="radio" name="gender" value="Female" <?= (isset($gender) && $gender == "Female")?'checked':'';  ?> /> Female <br>
							
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput" class="form-check-label">Date Of Birth: </label></td>
						<td>
							<input class="form-control"  type="date" name="date_of_birth" value="<?= $date_of_birth??""; ?>">
						</td>
					</tr>
					<tr>
						<td><label id="formFile" class="form-label">Profile Image: </label></td>
						<td>
							<input class="form-control"  type="file" name="file" value="" >
						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput">Home Town: </label></td>
  						<td>
  							<textarea class="form-control" placeholder="Home Town"  name="home_town"  ></textarea>
  						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput">User Status: </label></td>
  						<td>
  							<select name="is_approved" class="form-control" id="exampleFormControlInput1" required>
        						<option value="" selected disabled>-- select status --</option>
        						<option value="approved">Approved</option>
        						<option value="Pending">Pending</option>
        						<option value="rejected">Rejected</option>
        					</select>
  						</td>
					</tr>
					<tr>
						<td><label id="exampleFormControlInput">Active/In Status: </label></td>
  						<td>
  							<select name="is_active" class="form-control" id="exampleFormControlInput1" required>
        						<option value="" selected disabled>-- select active/in status --</option>
        						<option value="active">Active</option>
        						<option value="inactive">InActive</option>
        					</select>
  						</td>
					</tr>
					<tr>
						<td align="center">
							<input class="btn btn-primary w-100" type="submit" name="submit" value="ADD">
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