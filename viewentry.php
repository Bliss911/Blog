<?php
require("config.php");
$error = 0;
if(isset($_GET['id']) == TRUE){

    if(is_numeric($_GET['id']) == FALSE){
        $error = 1;
    }

    if($error == 1){
        header("Location: " . $config_basedir);
    }
    else{
        $validentry = (int) $_GET['id'];
    }
}
else{
    $validentry = 0;
}

if(isset($_POST['submit']) != NULL){
    $db = mysqli_connect($dbhost, $dbuser, $dbpassword);
    mysqli_select_db($dbdatabase, $db);

    $sql = "INSERT INTO comments(blog_id, dateposted, name, comment) VALUES("
        . $validentry . ", NOW(), '" . $_POST['name'] 
        . "', " 
        .$_PoST['comment'] . "');";
    mysqli_query($db, $sql);
    header("Location: http://" . $HTTP_HOST
        .$SCRIPT_NAME . "?id=" . $validentry);
}
else{
    //code will go here
}
require("header.php");


$sql = "";
if($validentry == 0) {
    $sql = "SELECT entries.*, categories.category FROM entries, categories  
     WHERE entries.cat_id = categories.id 
     ORDER BY dateposted DESC  
     LIMIT 1;";
}
else{
    $sql = "SELECT entries.*, categories.category FROM entries, categories 
        WHERE entries.cat_id = categories.id
        AND entries.id = 1 ORDER BY dateposted DESC 
        LIMIT 1;";
}
$result = mysqli_query($db, $sql);
// var_dump($sql);

$row = mysqli_fetch_assoc($result);
// var_dump($row);
echo "<h2>" . $row['subject'] 
    ."</h2><br>";
echo "<i>In <a href='viewcat.php?id=" 
    . $row['cat_id'] 
    . "'>" 
    . $row['category'] . "</a> - Posted on " 
    . date("D jS F Y g.iA", strtotime($row['dateposted'])) 
    ."</i>";

if(isset($_SESSION['USERNAME']) == TRUE){
    echo "[<a href='updateentry.php?id=" . $row['id'] . "'>edit</a>]";
}

echo "<p>";
echo nl2br($row['body']);
echo "</p>";

$commsql = "SELECT * FROM comment WHERE blog_id = $validentry ORDER BY dateposted DESC;";

$commresult = mysqli_query($db, $commsql);

$numrows_comm = mysqli_num_rows($commresult);
// var_dump($commresult);

if($numrows_comm == 0){
    echo "<p>No comments. </p>";
}
else{
    $i = 1;

    while($commrow = mysqli_fetch_assoc($commresult)){
        echo "<a name='comment" 
            . $i 
            . "'>";
        echo "<h3>Comment by " 
            . $commrow['name'] 
            . " on " 
            . date("D jS F Y g.iA",
            strtotime($commrow['dateposted'])) 
            . "</h3>";
        echo $commrow['comment'];
        $i++;
    }
}
?>

<h3>Leave a comment</h3>

<form action="<?php echo $SCRIPT_NAME . "?id=" . $validentry; ?>" method="post">
    <table>
        <tr>
            <td>Your name</td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td>Comment</td>
            <td><textarea name="comment" rows="10" cols="50"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Add comment" name="submit"></td>
        </tr>
    </table>
    

</form>

<?php

require("footer.php");
?>