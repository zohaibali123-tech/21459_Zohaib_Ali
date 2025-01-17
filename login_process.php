<?php

    session_start();
    require_once("require/my_function.php");
    require_once("require/connection.php");

    if (isset($_POST["login"]) && $_POST["login"]) {
        $email = $_POST["email"];
        $password = sha1($_POST["password"]);

        $query = "
                SELECT u.user_id, u.email, u.role_id, r.role_type, u.is_approved, u.is_active, r.is_active AS role_active 
                FROM user u 
                INNER JOIN role r ON u.role_id = r.role_id 
                WHERE u.email = '$email' AND u.password = '$password'";

        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);

            if ($data["is_approved"] === 'Pending') {
                header("Location: login.php?message=Your Account Is Pending. You Cannot Log in at This Time!...&color=red");
            } elseif ($data["is_approved"] === 'Rejected') {
                header("Location: login.php?message=Your Account Is Rejected. You Cannot Log in at This Time!...&color=red");
            } elseif ($data["is_active"] !== 'Active' || $data["role_active"] !== 'Active') {
                header("Location: login.php?message=Your Account Is InActive. Please Wait!...&color=red");
            } else {

            $_SESSION["user"] = [
                "user_id" => $data["user_id"],
                "email" => $data["email"],
                "role_id" => $data["role_id"],
                "role_type" => $data["role_type"]
            ];

                if ($_SESSION["user"]["role_id"] == 1) {
                    header("location: admin/dashbourd.php");
                } elseif ($_SESSION["user"]["role_id"] == 2) {
                    header("location: home.php");
                }
            }
        } else {
            header("location: login.php?message=Login Fail !... Invalid Email/Password&color=red");
        }
    }

?>
