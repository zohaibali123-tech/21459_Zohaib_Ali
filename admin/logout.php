<?php

	session_start();
	
	session_destroy();
	
	unset($_SESSION["user"]);
	
	header("location: ../login.php?message=Your Account Has Been Logged Out Succesfully!...&color=lightgreen");

?>