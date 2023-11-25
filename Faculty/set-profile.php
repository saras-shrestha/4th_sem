<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
 ?>
 <?php
if(isset($_GET['fid']))
{
	echo "<script>alert ('Your Faculty ID is ".$_GET['fid']."');</script>"; 
?> 
<!DOCTYPE html>
<html>
<head>
	<!--start title-->
    <?php 	include_once('../includes/title.php'); ?>
	<!--end title-->
	<style type="text/css">
		.set-profile{
			width:40%;
			height:300px;
			box-shadow: 10px 10px 20px rgba(0,0,0,0.6);
			margin:auto;
			padding:10px;
			box-sizing: border-box;
		} 
		input[type='text'], input[type='file']{
			padding:5px;
			margin :0 0 15px 0;
			width:90%;
		}
		h3{
			text-align:center;
		}
	</style>
</head>
<body>
 <div class='set-profile'>
 	<h3>Set Your Profile</h3>
 	<form action='' method='POST' enctype='multipart/form-data'> 
 		<div>
 			<label for='fid'>Faculty ID</label><br/>
 			<input type='text' name='fid' id='fid' value='<?php echo $_GET['fid'];?>' disabled/>
 		</div>
 		<div>
 			<label for='fname'>Name</label><br/>
 			<input type='text' name='fname' id='fname' placeholder="Enter Your Name"/>
 		</div>
 		<div>
 			<label for='image'>Uplode Profile Picture</label><br/>
 			<input type='file' name='profile' id='image'/>
 		</div> 		
 		<input type='submit' name='submit' value='SET'/> 
 		<input type='reset' name='reset' value='CLEAR'/> 		
 	</form>
 </div>
 			
</body>
</html>
<?php 
}
?>
<?php
if(isset($_POST['submit']))
{
	//for uid
	$sql="SELECT uid FROM users WHERE username='".$_SESSION['username']."'";
	$qry=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	$count=mysqli_num_rows($qry);
	if($count==1)
	{
		while($row=mysqli_fetch_array($qry))
		{
			$uid=$row['uid'];
		}
	}
	$fname=$_POST['fname'];

	if(!empty($_FILES['profile']['name']))
    {
		//$files = $_FILES['profile'];
		
		$pname=$_FILES['profile']['name'];
		$size=$_FILES['profile']['size']; 
		$type=$_FILES['profile']['type'];
		$tmpname = $_FILES['profile']['tmp_name'];
		$ulocation="../Upload/".$pname;
		//print_r($files);

		if($type=="image/jpeg" || $type=="image/jpg" || $type=="image/png" || $type=="image/gif")
		{
			if(move_uploaded_file($tmpname, $ulocation))
			{
				echo "Upload success";
			}
			else
			{
				echo "Something Wrong While Uploading the File";
			}
		}
		else 
		{
			echo "Only Accept Images like JPEG, JPG, PNG, and GIF";
		}
	}
	else
	{
		$ulocation="../Upload/default.png";
	}
	//profile-end

	$sql_stat="UPDATE faculty SET fname='$fname', profile_image='$ulocation' WHERE fid='".$_GET['fid']."' AND user_id=$uid";
	$query=mysqli_query($conn,$sql_stat) or die(mysqli_error($conn));
	if($query)
	{ 
		$_SESSION['fid']=$_GET['fid'];
		header("Location: dashboard.php"); 
	}
	else
	{
		echo "Unable to set your profile";
	}
}
 ?> 
