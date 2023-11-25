<?php 
define("HOST","localhost");
define("USER","root");
define("PASSWORD","");
define("DATABASE","bca");

$conn=mysqli_connect(HOST, USER, PASSWORD, DATABASE) or die ("Database Connection ERROR!");
?>  