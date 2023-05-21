<?php 

$dbname = "mysql:host=localhost;dbname=atmsystem";
$dbuser = "root";
$dbpass = "";

$conn = new PDO($dbname, $dbuser, $dbpass);
echo"HELLO WORLD";
?>
