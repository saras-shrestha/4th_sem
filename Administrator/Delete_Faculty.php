<?php 
include('../includes/connection.php');
if (isset($_GET['fid']))
{
$fid=$_GET['fid'];
$sql="DELETE FROM faculty WHERE fid='$fid'";
$qry=mysqli_query($conn,$sql) OR die("Unable to delete record");//(mysqli_err($conn));
if($qry)
{
	header("Location:Faculty.php?msg=$fid deleted successfully");
} 
}
else
{
  header("Location:Faculty.php");
}

?>