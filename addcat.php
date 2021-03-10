<?php
session_start();
require("config.php");

$db = mysqli_connect($dbhost, $dbuser, $dbpassword);
mysqli_select_db($db, $dbdatabase);

if(isset($_SESSION['USERNAME']) == FALSE){
    header("Location: " . $config_basedir);
}

if($POST['submit']){
    $sql = "INSERT INTO categories(category) VALUES('" . $POST['cat'] . "');";
    mysqli_query($db, $sql);
    header("Location: ". $config_basedir . "viewcat.php");
}
else{
    require("header.php");
?>
<?php
}
    require("footer.php");
?>

?>
<form action="<?php echo $SCRIPT_NAME ?>" method="POST">
<table>
    <tr>
        <td>Category</td>
        <td><input type="text" name="cat" id=""></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="Add Entry!"></td>
    </tr>
</table>
</form>