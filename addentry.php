<?php
require("config.php");

// $db = mysqli_connect($dbhost, $dbuser, $dbpassword);
// mysqli_select_db($db, $dbdatabase);

if(isset($_SESSION["username"]) == FALSE){
    header("Location: " . $config_basedir);
}

$category = $_POST["category"];
$subject = $_POST["subject"];
$postbody = $_POST["body"];

if(isset($_POST["submit"])){
    $sql = "INSERT INTO entries(cat_id, dateposted, subject, body)
        VALUES(?, ?, ?, ?);";
        if($stmt = mysqli_prepare($db, $sql)){
            mysqli_stmt_bind_param($stmt, "isss", $param_cat_id, $param_dateposted, $param_subject, $param_body);
            $param_cat_id = $category;
            $param_dateposted = date;
            $param_subject = $subject;
            $param_body = $postbody;
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
            }
            
        }
        

    
    mysqli_stmt_store_result($stmt);
    header("Location: " .$config_basedir);
}
else{
    require("header.php");
?>
}

<h1>Add new entry</h1>
<form action="<?php echo $SCRIPT_NAME ?>" method="POST">
<table>
    <tr>
        <td>Category</td>
        <td>
            <select name="cat" id="">
                <?php
                $catsql = "SELECT * FROM categories;";
                // while($catres = mysqli_query($db, $catres)){
                //     echo "<option value='" . $catrow['id'] . "'>" . $catrow['cat'] . "</option>";
                    
                // }
                ?>
            </select>
        </td>
    </tr>

    <tr>
        <td>Subject</td>
        <td><input type="text" name="subject"></td>
    </tr>
    <tr>
        <td>Body</td>
        <td><textarea name="body" id="catbody" cols="50" rows="10"></textarea></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="Add Entry" name="submit"></td>
    </tr>
</table>
</form>

<?php 
}
require("footer.php");
?>