<?php
	$driver = new mysqli_driver();
	$driver->report_mode = MYSQLI_REPORT_OFF;
	
	$host_name	=	"localhost";
	$user_name	=	"root";
	$password	=	"";
	$database 	=	"21459_zohaib";
	
	$connection = mysqli_connect($host_name, $user_name, $password, $database);

	if(mysqli_connect_errno())
	{
		echo "<p style='color: red; font-weight: bold'>Database Connection Problem!...</p>";
		echo "<p><b style='color: red; font-weight:bold'>Error No: </b>".mysqli_connect_errno()."</p>";
		echo "<p><b style='color: red; font-weight:bold'>Error Message: </b>".mysqli_connect_error()."</p>";
	}
?>