<form action="<?php echo $SCRIPT_NAME ?>" method="post">
<table>
    <tr>
        <td>Username</td>
        <td><input type="text" name="username"></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><input type="password" name="password" id=""></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="Login!" name="submit"></td>
    </tr>
</table>
</form>

<?php 
// session_start();

require("config.php");

$db = mysqli_connect($dbhost, $dbuser, $dbpassword);
mysqli_select_db($db, $dbdatabase);


// $error = 0;
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    // var_dump($_POST);
    $password = $_POST['password'];

    $sql = "SELECT * FROM logins WHERE username = $username 
        AND password = $password;";


    $result = mysqli_query($db, $sql);
    $numrows = mysqli_num_rows($result);

    if($numrows == 1){
        $row = mysqli_fetch_assoc($result);
        // session_register("USERNAME");
        // session_register("USERID");

        $_SESSION['USERNAME'] = $row['username'];
        $_SESSION['USERID'] = $row['id'];
        header("Location: " . $config_basedir);
    }
    else{
        header("Location: " . $config_basedir . "/login.php?error=1");
    }
}
else{
    require("header.php");

    if($_GET['error']){
        echo "Incorrect login, please try again!";
    }
}
require("footer.php");
?>