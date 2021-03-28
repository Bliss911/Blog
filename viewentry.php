<?php
require("config.php");
require("header.php");
// if(isset($_SESSION["username"]) && "[<a href='login.php'>login</a>]"){
//     echo "[<a href='logout.php'>logout</a>]";
// }
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

$commsql = "SELECT * FROM comments WHERE blog_id = $validentry ORDER BY dateposted DESC;";

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
        echo "<p><strong>Comment by " 
            . $commrow['name'] 
            . " on " 
            . date("D jS F Y g.iA",
            strtotime($commrow['dateposted'])) 
            . "</strong></p>";
        echo $commrow['comment'];
        $i++;
    }
}

?>

<h3>Leave a comment</h3>

<form action="<?php echo $SCRIPT_NAME . "?id=" . $validentry; ?>" method="post" class="w-25 mx-auto">
    

    
  <div class="mb-3 d-flex justify-content-between">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" cols="35" rows="10" style="width: 275px;">
    
  </div>
  <div class="mb-3 d-flex justify-content-between">
    <label for="commentbox" class="form-label text-top">comment</label>
    <textarea name="commentbox" id="commentbox" cols="35" rows="10"></textarea>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>

    

</form>

<?php

require("footer.php");
?>