<?php 
include('../includes/connection.php');
if (isset($_GET['sem_id']))
{
$sem_id=$_GET['sem_id'];
$sql="DELETE FROM semesters WHERE sem_id=$sem_id";
$qry=mysqli_query($conn,$sql) OR die("Unable to delete record");//(mysqli_err($conn));
if($qry)
{
	header("Location: Semesters.php?msg=$sem_id deleted successfully");
} 
}
else
{
  header("Location:Semesters.php");
}

?>