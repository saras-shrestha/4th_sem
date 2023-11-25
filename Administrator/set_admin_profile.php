 <?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
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
 			<label for='image'>Uplode Profile Picture</label><br/>
 			<input type='file' name='profile' id='image'/>
 		</div>
 		<div>
 			<label for='aname'>Name</label><br/>
 			<input type='text' name='name' id='name' placeholder="Enter Your Name"/>
 		</div>
 		
 		<input type='submit' name='submit' value='SET'/> 
 		<input type='reset' name='reset' value='CLEAR'/> 		
 	</form>
 </div>
 			
</body>
</html>
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

	$ad_name=$_POST['name'];
	/*if(empty($_POST['profile']))
	{
		echo "ghhfdsasgdhgjf";
	}
    else
    {
    	echo "A";
    }*/
	//profile start
    if(!empty($_FILES['profile']['name']))
    {
		//$files = $_FILES['profile'];
		
		$name=$_FILES['profile']['name'];
		$size=$_FILES['profile']['size']; 
		$type=$_FILES['profile']['type'];
		$tmpname = $_FILES['profile']['tmp_name'];
		$ulocation="../Upload/".$name;
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

	$sql_stat="INSERT INTO administrators(`aname`,`profile_image`, `user_id`) VALUES('$ad_name', '$ulocation', '$uid')";
	$query=mysqli_query($conn,$sql_stat) or die(mysqli_error($conn));
	if($query)
	{ 
		header("Location: dashboard.php"); 
	}
	else
	{
		echo "Unable to set your profile";
	}
}
 ?> 
