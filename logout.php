<?php 
require_once('Session/sessioncheck.php');
session_destroy();

header("Location: index.php");
?>  