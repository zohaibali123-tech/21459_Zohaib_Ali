<?php

    require_once('require/connection.php');

    session_start();

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $first_name         = $_POST['first_name'];
        $last_name          = $_POST['last_name'];
        $email              = $_POST['email'];
        $password           = $_POST['password'];
        $confirm_password   = $_POST['confirm_password'];
        $gender             = $_POST['gender'];
        $date_of_birth      = $_POST['date_of_birth'];
        $home_town          = $_POST['home_town'];
    
    
        $imagePath = null;

        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

            /*$image          = $_FILES['file'];
            $target_dir     = "upload_images/";
            $target_file    = basename($image['name']);*/
            $tmp_name    = $_FILES['file']['tmp_name'];
            $name        = $_FILES['file']['name'];
            $file_name   = time()."_".$_FILES['file']['name'];
            $path        = "images/".$file_name;

            if (move_uploaded_file($tmp_name, $path)) {

            $imagePath = $path;
            } else {
                die("file not uploaded.");
            }
        }

        $hashed_password = sha1($password);
        $role = 2;
    
        $query = "INSERT INTO user (role_id, first_name, last_name, email, password, gender, date_of_birth, user_image, address, is_approved, is_active)
            VALUES ('$role', '$first_name', '$last_name', '$email', '$hashed_password', '$gender', '$date_of_birth', '$file_name', '$home_town', 'Pending', 'InActive')";

    
        if ($connection->query($query) === TRUE) {

            header("location: login.php?message=Your Registration Has Been Successfully.&color=lightgreen");
        } else {
            
            header("location: signup.php?message=Your Account Is Not Regester. Try Again Latter.&color=red");
        }

    
        $connection->close();
    }

?>
