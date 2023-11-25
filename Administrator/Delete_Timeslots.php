<?php 
include('../includes/connection.php');
if (isset($_GET['tid']))
{
$tid=$_GET['tid'];
$sql="DELETE FROM timeslots WHERE tid=$tid";
$qry=mysqli_query($conn,$sql) OR die("Unable to delete record");//(mysqli_err($conn));
if($qry)
{
	header("Location:Timeslots.php?msg=$tid deleted successfully");
} 
}
else
{
  header("Location:Timeslots.php");
}
?>