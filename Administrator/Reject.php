<?php 
	require_once('../Session/sessioncheck.php');
    include('../includes/connection.php');
?>
<?php 
if(isset($_GET['uid']))
{
	$uid=$_GET['uid'];
	$sql="UPDATE users SET status=0 WHERE uid=$uid";
	$query=mysqli_query($conn,$sql);
	if($query)
	{
		header('Location:users.php');
	}
	else
	{
		echo "<script>alert('Fail to reject');</script>";
	}
}
/*if(isset($_GET['pid']))
{
	$pid=$_GET['pid'];
	$sql="UPDATE preferences SET status=0 WHERE pid=$pid";
	$query=mysqli_query($conn,$sql);
	if($query)
	{
		header('Location:preferences.php');
	}
	else
	{
		echo "<script>alert('Fail to reject');</script>";
	}	
}*/
?>