<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Page</title>

	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

	<style type="text/css">

		body{
			background-color: lavender;
		}

		/*ul li:hover{
			background-color: pink;
			color: blue;
			height: auto;
		}*/
		

	</style>

</head>
<body>
	<div class="container-fluid">

		<div class="row">
			<div class="col-sm">

				<!-- NAVBAR -->

				<nav class="navbar navbar-expand-lg bg-info">
				  <a class="navbar-brand" href="home.php"><h1>BLOG.</h1></a>
    			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      			<span class="navbar-toggler-icon"></span>
    			</button>
    			<div class="collapse navbar-collapse" id="navbarScroll">
      			<ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll d-flex" style="--bs-scroll-height: 100px;">
        			<li class="nav-item">
          			<a class="nav-link active" aria-current="page" href="home.php"><h5 class="ml-5">Home</h5></a>
        			</li>
        			<li class="nav-item">
          			<a class="nav-link" href="post.php"><h5 style="margin-left: 10px;">Blog</h5></a>
        			</li>
        			<li class="nav-item dropdown">
          			<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            		<h5 style="margin-left: 10px;">Catagory</h5>
          			</a>
          			<ul class="dropdown-menu" style="background-color: lavender;">
            			<li><a class="dropdown-item" href="sports.php"><h5>Sports</h5></a></li>
            			<li><a class="dropdown-item" href="entertainment.php"><h5>Entertainment</h5></a></li>
            			<li><a class="dropdown-item" href="politics.php"><h5>Politics</h5></a></li>
            			<li><a class="dropdown-item" href="education.php"><h5>Education</h5></a></li>
            			<li><a class="dropdown-item" href="weather.php"><h5>Weather</h5></a></li>
            			<li><hr class="dropdown-divider"></li>
            			<li><a class="dropdown-item" href=""><h5>More</h5></a></li>
          			</ul>
        			</li>
        			<li class="nav-item">
          			<a class="nav-link" href="aboutus.php"><h4 style="margin-left: 10px;">About Us</h4></a>
        			</li>
        			<li class="nav-item">
          			<a class="nav-link" href="feedback.php"><h4 style="margin-left: 10px;">Feedback</h4></a>
        			</li>
      			</ul>
      			<form class="d-flex" role="search">
        			<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        			<button class="btn btn-primary" type="submit">Search</button>
      			</form>
      			<div class="d-grid d-md-block p-3">
  					<a class="btn btn-primary" type="button" href="login.php">LOG IN</a>
 					<a class="btn btn-primary" type="button" href="signup.php">SIGN UP</a>
					</div>
    			</div>
				</nav>
				
			</div>
		</div>
