
<?php

	require_once('header.php');
	require_once('require/my_function.php');	
	require_once('require/connection.php');

?>
	
	<div class="row mt-5" align="center">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<h1 class="text-center bg-light shadow-lg mt-5">LOG IN</h1>
		</div>
		<div class="col-sm-4"></div>
		<div class="col-sm mt-5">
			<form action="login_process.php" method="POST">
				<table border="0" cellspacing="10px" cellpadding="10px">
					<tr>
						<td><label for="exampleFormControlInput1" class="form-label">Email</label></td>
						<td><input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" style="width: 300px;"></td>
					</tr>
					<tr>
						<td><label for="exampleFormControlInput1" class="form-label">Password</label></td>
						<td><input type="password" name="password" class="form-control" id="exampleFormControlInput1" style="width: 300px;"></td>
					</tr>
					<tr>
						<td>
							<input class="btn btn-primary w-100" type="submit" name="login" value="Log In">
							<td>
								<span style="color: red;">You Have Not A Account Please</span>
								<a href="signup.php" style="text-decoration: none;">Sign Up</a>
							</td>
						</td>
					</tr>
					<?php if (isset($_GET["message"])) { ?>
							<p style="font-family: cursive; background-color: <?php echo $_GET["color"]; ?>; 
								text-align: center; 
								font: bold; 
								padding: 5px; 
								margin: 10px auto; 
								width: fit-content; 
								border-radius: 5px;">
								<?php echo $_GET['message']; ?>
							</p>
					<?php } ?>
				</table>		
			</form>
		</div>
	</div>


<?php

	require_once('footer.php');

?>