<?php

session_start();

require("config.php");

if(isset($_SESSION['USERNAME']) == FALSE){
    header("Location: " . $config_basedir);
}

$db = mysqli_connect($dbhost, $dbuser, $dbpassword);
mysqli_select_db($db, $dbdatabse);
$error = 0;
$validentry = 0;
if(isset($_GET['id]']) == TRUE){
    if(is_numeric($id) == FALSE){
        $error = 1;
    }

    if($error == 1) {
        header("Location: " . $config_basedir);
    }
    else{
        $validentry = $_GET['id'];
    }
}
else{
    $validentry = 0;
}
$category = $_POST['category'];
$subject = $_POST['subject'];
$catbody = $_POST['body'];

if($_POST['submit']){
    $sql = "UPDATE entries SET cat_id = $category, subject = $subject
        , body = $catbody WHERE id = $validentry;";

mysqli_query($db, $sql);

header("Location: " . $config_basedir . "/viewentry.php?id=" . $validentry);
}
else{

    require("header.php");

    $fillsql = "SELECT * FROM entries WHERE id = $validentry ;";
    $fillres = mysqli_query($db, $fillsql);
    $fillrow = mysqli_fetch_assoc($fillres);
    ?>
    <h1>Update Entry</h1>

    <form action="<?php echo $SCRIPT_NAME . "?id="
    . $validentry; ?>" method="POST">
    <table>
        <tr>
            <td>Category</td>
            <td>
                <select name="cat">
                <?php
                $catsql = "SELECT * FROM categories;";
                $catres = mysqli_query($db, $catsql);
                while($catrow=mysqli_fetch_assoc($catres)){
                    echo "<option value='" . $catrow['id'] . "'";

                    if($catrow['id'] == $fillrow['cat_id']){
                        echo " selected";
                    }

                    echo ">" . $catrow['category'] . "</option>";
                }
                ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Subject</td>
            <td><input type="text" name="subject" value="<?php echo $fillrow['subject']; ?>">
        </td>
        </tr>
        <tr>
            <td>Body</td>
            <td><textarea name="body" id="" cols="50" rows="10"><?php echo $fillrow['body']; ?></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Update Entry!" name="submit"></td>
        </tr>
    </table>
    </form>
    <?php
}
require("footer.php");
?>