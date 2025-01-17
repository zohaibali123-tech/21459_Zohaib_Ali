<?php

	session_start();

	function session_maintainance($role_id) {

		if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
			header("location: ../login.php?message=Please Login Into Your Account First!...&color=lightpink");
			exit();
		}

		if ($_SESSION["user"]["role_id"] != $role_id) {

			$_SESSION = [];
			session_destroy();
			header("location: ../login.php?message=Invalid Access! Please Log In Again!...&color=lightpink");
			exit();
		}
	}

?>
