<?php 
	if (isset($_POST['submit'])) {
		extract($_POST);
		$flag = true;

		/*---------- Patterns Start-----------*/
		
		$alpha_pattern 		= "/^[A-Z]{1}[a-z]{2,}$/";
		$email_pattern 		= "/^[a-z]+\d*[@]{1}[a-z]+[.]{1}(com|net){1}$/";
		$password_pattern   = "/^[0-9]{8}$/";


		/*---------- ERROR Messages ----------*/

		$first_name_msg 		= "";
		$last_name_msg 			= "";
		$email_msg 				= "";
		$password_msg 			= "";
		$confirm_password_msg 	= "";
		$gender_msg 			= "";
		$dob_msg 				= "";
		$file_msg 				= "";
		$home_town_msg 			= "";

		/*---------- Validation Start ----------*/

		/*---------- First Name Start ----------*/

		if ($first_name === "") {
			$flag = false;
			$first_name_msg = "First Name Is Required.";
		} else {

			$first_name_msg = "";
			if (!(preg_match($alpha_pattern, $first_name))) {
				$flag = false;
				$first_name_msg = "First Alphabets Must Be Capital. ";
			}
		}
		
		/*---------- First Name END ----------*/

		/*---------- Last Name Start ----------*/

		if ($last_name !== "") {
			if (!(preg_match($alpha_pattern, $last_name))) {
				$flag = false;
				$last_name_msg = "First Alphabets Must Be Capital.";
			}

		} else {
			$last_name_msg = "";
		}

		/*---------- Last Name END ----------*/

		/*---------- Email Start ----------*/

		if ($email === "") {
			$flag = false;
			$email_msg = "Email Is Required.";

		} else {
			$email_msg = "";
			if (!(preg_match($email_pattern, $email))) {
				$flag = false;
				$email_msg = "Email Must Be name@example.com|net name12@example.com|net.";		
			}
		}

		/*----------  Email END ----------*/

		/*---------- Password Start ----------*/

		if ($password === "") {
			$flag = false;
			$password_msg = "Password Is Required.";

		} else {
			$password_msg = "";
			if (!(preg_match($password_pattern, $password))) {
				$flag = false;
				$password_msg = "Password Must Be Numeric And Up To 8 Digits.";
			}
		}

		/*---------- Password END ----------*/

		/*---------- Confirm Password Start ----------*/

		if ($confirm_password === "") {
			$flag = false;
			$confirm_password_msg = "Confirm Password Is Required.";

		} else {
			$confirm_password_msg = "";
			if ($confirm_password !== $password) {
				$flag = false;
				$confirm_password_msg = "Passwords Not Match.";
			}
		}

		/*---------- Confirm Password END ----------*/

		/*---------- Gender Start ----------*/

		if (!$gender) {
			$flag = false;
			$gender_msg = "Gender Required.";

		} else {
			$gender_msg = "";
		}

		/*---------- Gender END ----------*/

		/*---------- Date Of Birth Start ----------*/

		if ($date_of_birth === "") {
			$flag = false;
			$dob_msg = "Date Of Birth Is Required.";

		} else {
			$dob_msg = "";
		}
		
		/*---------- Date Of Birth END ----------*/

		/*---------- FILE Start ----------*/

		if ($_FILES['file']['name'] === "") {
    		$flag = false;
    		$file_msg = "File Is Required.";

		} else {
    		$file_msg = "";
    		if($_FILES['file']['size'] > 1024 * 1024){
        		$flag = false;
        		$file_msg = "File Size Must Be Less Than 1MB.";
    		}
		}

		/*---------- FILE END ----------*/

		/*---------- Home Town Start ----------*/

		if ($home_town === "") {
			$flag = false;
			$home_town_msg = "Home Town Is Required.";

		} else {
			$home_town_msg = "";
		}

		/*---------- Home Town END ----------*/

		if ($flag === true) {
			showData($_POST);
		}
	}

?>
