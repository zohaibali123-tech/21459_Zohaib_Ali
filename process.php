<?php

	$connection = mysqli_connect('localhost','root','','user_regestration');

	if(isset($_POST['submit'])){
		/*echo "<pre>";
		print_r($_POST);
		//print_r($_FILES);
		echo "<pre/>";*/
			$first_name	 = $_POST['first_Name'];
			$last_name	 = $_POST['LastName'];
			$email 		 = $_POST['email'];
			$password	 = $_POST['password'];

			echo "<h3>First Name : $first_name</h3>";
			echo "<h3>Last Name  : $last_name</h3>";
			echo "<h3>Email      : $email</h3>";
			echo "<h3>Password   : $password</h3>";
		$count = 0;
		foreach ($_FILES['files']['name'] as $key => $value) {
			
			$tmp_name 	 = $_FILES['files']['tmp_name'][$key];
			$name 		 = $_FILES['files']['name'][$key];
			$file_name   = time()."_".$_FILES['files']['name'][$key];
			$path 		 = "images/".$file_name;

			if(move_uploaded_file($tmp_name, $path)){
				$query = "INSERT INTO user VALUES(NULL,'".$first_name."','".$last_name."','".$email."','".$password."','".$file_name."','".$path."')";
					$flag = mysqli_query($connection,$query);
					if($flag){
						$count++;
					}
			}
		}

		if($count > 0){
			echo "<h2>$count Files Uploaded & Inserted Successfully<h2>";
		}
	}

	$query = "SELECT * FROM user";
	$result = mysqli_query($connection,$query);

	if($result->num_rows > 0){
		while($row = mysqli_fetch_assoc($result)){
			/*echo "<pre>";
			print_r($row);
			echo "<pre/>";*/
			?>
			<div style="float: left; padding:10px ;">
				<img src="<?= $row['p_img_path'];  ?>" height="200px" width="200px">
			</div>
			<?php
		}
	}else{
		echo "<h4>No Record Found</h4>";
	}

?>