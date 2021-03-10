<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbdatabase = "blogtastic";

$config_blogname = "Funny old world";

$config_author = "Cious Online";

$config_basedir = "http://127.0.0.1/PHPCodes/Blog/";

$db = mysqli_connect($dbhost, $dbuser, $dbpassword);
mysqli_select_db($db, $dbdatabase);
?>