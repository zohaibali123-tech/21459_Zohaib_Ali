
<?php

	require_once('header.php');
	

?>

	<div class="row mt-5" align="center">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<h1 class="text-center bg-light shadow-lg mb-4">FEEDBACK</h1>
			</div>
		<div class="col-sm-4"></div>
		<div class="col-sm">
			<form action="" method="POST">
				<table border="0" cellspacing="10px" cellpadding="10px">
					<tr>
						<td><label for="exampleFormControlInput1" class="form-label">First Name: </label></td>
						<td><input type="text" name="first_name" class="form-control" id="exampleFormControlInput1" placeholder="Zohaib"></td>
					</tr>
					<tr>
						<td><label for="exampleFormControlInput1" class="form-label">Last Name: </label></td>
						<td><input type="text" name="last_name" class="form-control" id="exampleFormControlInput1" placeholder="Ali"></td>
					</tr>
					<tr>
						<td><label for="exampleFormControlInput1" class="form-label">Email: </label></td>
						<td><input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com"></td>
					</tr>
					<tr>
						<td><label for="exampleFormControlInput">Feedback: </label></td>
  						<td><textarea class="form-control" placeholder="Feedback Here..." id="exampleFormControlInput1" name="feedback"></textarea></td>
					</tr>
					<tr>
						<td>
							<input class="btn btn-primary w-100" type="submit" value="Submit">
						</td>
					</tr>
				</table>		
			</form>
		</div>
	</div>


<?php

	require_once('footer.php');

?>