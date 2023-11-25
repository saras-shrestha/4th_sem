<?php 
	require_once('../Session/sessioncheck.php');
    include('../includes/connection.php');
?>
<?php 
if(isset($_GET['uid']))
{
	$uid=$_GET['uid'];
	$sql="UPDATE users SET status=1 WHERE uid=$uid";
	$query=mysqli_query($conn,$sql);
	if($query)
	{
		$s="SELECT role FROM users WHERE uid=$uid";
		$q=mysqli_query($conn,$s);
		$result=mysqli_fetch_array($q);
		if($result['role']==2)
		{
			$s1="SELECT * FROM faculty WHERE user_id=$uid";
			$q1=mysqli_query($conn,$s1);
			$c=mysqli_num_rows($q1);
			if($c==1)
			{
				header('Location:users.php?');
			}			
			else
			{
				$fid="F".$uid;
				$s2="INSERT INTO faculty (fid,user_id) VALUES ('$fid', $uid)";
				$q2=mysqli_query($conn,$s2);
				if($q2)	
				header('Location:users.php?');
			}
		}
		else
		{
			header('Location:users.php');
		}
	}
	else
	{
		echo "<script>alert('Fail to approve');</script>";
	}
} 
if(isset($_GET['pid']) && isset($_GET['sem_id']) && isset($_GET['fid']))
//if(isset($_GET['pid'], $GET['sem_id'], $GET['fid']))
{ 
	$pid=$_GET['pid'];
	$sem_id=$_GET['sem_id'];
	$fid=$_GET['fid'];

	$sql="UPDATE preferences SET status=1 WHERE pid=$pid";
	$query=mysqli_query($conn,$sql);
	if($query)
	{
		$sql1="SELECT start_time, end_time FROM timeslots WHERE tid IN (SELECT time_id FROM preferences WHERE pid=$pid)";
		$query1=mysqli_query($conn, $sql1);
		$count=mysqli_num_rows($query1);
		if($count==1)
		{
			$row=mysqli_fetch_array($query1);
			//print_r($row);
			$sql2="UPDATE schedules SET status=1, start_time='".$row['start_time']."', end_time= '".$row['end_time']."' WHERE faculty_id='$fid' && semester_id=$sem_id";
			$query2=mysqli_query($conn,$sql2);
			if($query2)
			{
				header('Location:Preferences.php?status=1');
				//echo "<script>alert('time is scheduled');</script>";
			}
		}
	}
	else
	{
		echo "<script>alert('Fail to approve');</script>";
	}	
}
?>