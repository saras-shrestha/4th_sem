<?php 
include('../includes/connection.php');
if (isset($_GET['code']))
{
$code=$_GET['code'];
$sql="DELETE FROM courses WHERE code='$code'";
$qry=mysqli_query($conn,$sql) OR die("Unable to delete record");//(mysqli_err($conn));
if($qry)
{
	header("Location:Courses.php?msg=$code deleted successfully");
} 
}
else
{
  header("Location:Courses.php");
}

?> 