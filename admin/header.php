<?php 
	require_once("../require/my_function.php"); 
	require_once("../require/connection.php");
    session_maintainance(1);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Page</title>

	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

	<style type="text/css">

		body{
			background-color: lavender;
		}

		.dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: lavender;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            min-width: 200px;
            border-radius: 5px;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .dropdown-menu a {
            color: #333;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }
        .dropdown-menu a:hover {
            background-color: pink;
        }

        .post-link {
            display: inline-block;
            text-decoration: none;
            transform: scale(1);
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        }
        .post-link .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-out, background-color 0.3s ease-out;
        }
        .post-link:hover {
            transform: scale(1.05);
        }
        .post-link:hover .card {
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            background-color: #f9f9f9;
        }

        .button {
            display: inline-block;
            width: 200px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
            padding: 10px;
            text-align: center;
            overflow: hidden;
        }
        .button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .nav-item {
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease-out;
            gap: 10px;
        }
        .button:hover .nav-item {
            transform: translateX(10px);
        }
        .button:hover {
            transform: translateX(10px);
        }

        .custom-button {
            display: inline-block;
            padding: 10px 40px;
            font-size: 16px;
            text-align: center;
        }


	</style>

</head>
<body>
	<div class="container-fluid">

		<div class="row">
			<div class="col-sm">

				<!-- NAVBAR -->

				<nav class="navbar navbar-expand-lg bg-info">
                    <a class="navbar-brand" href="dashbourd.php"><h1>BLOG.</h1></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../home.php"><h4 class="ml-5">Home</h4></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="blog.php"><h4 style="margin-left: 10px;">Blog</h4></a>
                            </li>
                        <?php
                            $query = "SELECT category_title FROM category WHERE category_status = 'Active'";
                            $result = mysqli_query($connection, $query);
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <h4 style="margin-left: 10px;" class="dropdown-toggle">Category</h4>
                                </a>
                                <ul class="dropdown-menu" style="background-color: lavender;">
                            <?php
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<li><a class="dropdown-item" href="#"><h5>' . htmlspecialchars($row['category_title']) . '</h5></a></li>';
                                    }
                                } else {
                                    echo '<li><a class="dropdown-item" href="#"><h5>No categories found</h5></a></li>';
                                }
                            ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"><h5>More</h5></a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../aboutus.php"><h4 style="margin-left: 10px;">About Us</h4></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="user_fback.php"><h4 style="margin-left: 10px;">Feedback</h4></a>
                            </li>
                        </ul>
                        <form method="GET" action="search.php" class="d-flex" role="search">
                            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" required>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                        <div class="d-grid gap-2 d-md-block p-3">
                <?php if (isset($_SESSION['user'])) { ?>
                            <a class="btn btn-primary" type="button" href="user_profile.php?user_id=<?php echo htmlspecialchars($_SESSION['user']['user_id']); ?>">PROFILE</a>
                            <a class="btn btn-primary" type="button" href="logout.php">LOGOUT</a>
                <?php } else { ?>
                            <a class="btn btn-primary" type="button" href="login.php">LOG IN</a>
                            <a class="btn btn-primary" type="button" href="signup.php">SIGN UP</a>
                    <?php } ?>
                        </div>
                    </div>
				</nav>
				
			</div>
		</div>