<?php

	require_once("../require/connection.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id        = $_POST['user_id'];
    $first_name     = $_POST['first_name'];
    $last_name      = $_POST['last_name'];
    $email          = $_POST['email'];
    $password       = $_POST['password'];
    $gender         = $_POST['gender'];
    $date_of_birth  = $_POST['date_of_birth'];
    $home_town      = $_POST['home_town'];
    $file_name      = $_POST['existing_image']; // Default purani image
    
    // Agar nayi image upload hui to usko replace karein
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $tmp_name   = $_FILES['file']['tmp_name'];
        $file_name  = time() . "_" . $_FILES['file']['name'];
        $path       = "../images/" . $file_name;

        if (!move_uploaded_file($tmp_name, $path)) {
            die("File not uploaded.");
        }
    }

    // Password change ka check karein
    $hashed_password = $user['password']; // Default purana password
    if (!empty($password)) {
        $hashed_password = sha1($password);
    }

    // Update query
    $query = "UPDATE user 
              SET first_name = '$first_name', last_name = '$last_name', email = '$email', 
                  password = '$hashed_password', gender = '$gender', date_of_birth = '$date_of_birth', 
                  user_image = '$file_name', address = '$home_town', updated_at = CURRENT_TIMESTAMP
              WHERE user_id = $user_id";

    // Query execute aur response handle karein
    if ($connection->query($query) === TRUE) {
        header("Location: user_profile.php?user_id=$user_id");
    } else {
        header("Location: update_user.php?message=User Account Not Updated. Try Again Later!&color=red");
    }
    exit();
}
?>