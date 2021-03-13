<?php 
require("header.php");
// session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: " . $config_basedir);
    exit;
}

require("config.php");

$username = $password = "";
$username_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"])) && empty(trim($_POST["password"]))){
        $username_err = "Please enter username.";
        $password_err = "Please enter password.";
    }
    else{
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM logins WHERE username = ?";

        if($stmt = mysqli_prepare($db, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        header("Location: viewentry.php");
                    }
                }
            }
            else{
                $username_err = "No account found with that username.";
            }
        
        }
        else{
            echo "OOps! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
}


mysqli_close($db);

?>



    <div class="w-50 mx-auto" id="wrapper">
    <div class="">
        <h1 class="display-3">Login</h1>
        <p class="lead">Enter your Login details</p>
        <hr class="my-2">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo(!empty($username_err)) ? 'has-error' : ''; ?>">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo(!empty($password_err)) ? 'has-error' : ''; ?>">
                <label for="password">Password</label>    
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group mt-2">
                <input type="submit" value="Login" class="btn btn-primary">
            </div>
            <p>
                Don't have an account? <a href="register.php">Register</a>
            </p>
        </form>
        
    </div>
</div>

