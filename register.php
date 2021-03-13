<?php 
// session_start();

require("config.php");

$username = $password = "";
$username_err = $password_err = "";
// $error = 0;
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST['username']))){
        $username_err = "Please enter your Username";
    }
    else{
        $sql = "SELECT id FROM logins WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POSt["username"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                }
                else{
                    $username = trim($POST["username"]);
                }
            }
            else{
                echo "OOps! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }


    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    }
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    }
    else{
        $password = trim($POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($db, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_passwrod);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            }
            else{
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
require("header.php");
?>

