<?php 
include('../includes/connection.php');
if (isset($_GET['sid']))
{
$sid=$_GET['sid'];
$sql="DELETE FROM schedules WHERE sid='$sid'";
$qry=mysqli_query($conn,$sql) OR die("Unable to delete record");//(mysqli_err($conn));
if($qry)
{
	header("Location:AssignFaculty.php?msg=Faculty unassigned successfully");
} 
}
else
{
  header("Location:AssignFaculty.php");
}

?> 