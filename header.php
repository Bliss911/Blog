<?php
session_start();
require("config.php");

$db = mysqli_connect($dbhost, $dbuser, $dbpassword);
mysqli_select_db($db, $dbdatabase);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config_blogname; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="header">
        <h1><?php echo $config_blogname; ?></h1>
        [<a href="index.php">home</a>]
        [<a href="viewcat.php">categories</a>]

        <?php
        if(isset($_SESSION['USERNAME']) == TRUE){
            echo "[<a href='logout.php'>logout</a>]";
        }
        else{
            echo "[<a href='login.php'>login</a>]";
        }

        if(isset($_SESSION['USERNAME']) == TRUE){
            echo "-";
            echo "[<a href='addentry.php'>add entry</a>]";
            echo "[<a href='addcat.php'>add category</a>";
        }

        ?>
    </div>
    <div id="main">
   