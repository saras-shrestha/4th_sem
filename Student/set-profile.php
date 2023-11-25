<?php require_once('../Session/sessioncheck.php');
	  include('../includes/connection.php');
?>
<?php
if(isset($_GET['msg']))
{
	echo "<script>alert ('".$_GET['msg']."');</script>";
} 
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
 			<label for='sname'>Name</label><br/>
 			<input type='text' name='sname' id='sname' placeholder="Enter Your Name"/>
 		</div>
 		<div>
			<label for='sem_id'>Semester</label>
			<select name="sem" id='sem_id'>
				<?php
					$sql="SELECT * FROM semesters";
					$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						$mystring = '<option selected disabled>Select Semester</option>';
						while($row=mysqli_fetch_array($qry))
						{
							$mystring .= "<option size='30px ' value='". $row['sem_id'] ."'>" . $row['sem_name']."</option>";
						}
						echo $mystring;
					}
				?>			
			</select>
	    </div> 
	    <br/>
 		<input type='submit' name='submit' value='SET'/> 
 		<input type='reset' name='reset' value='CLEAR'/> 		
 	</form>
 </div>
 <?php
if(isset($_POST['submit']))
{
	//for uid
	$sql_stat="SELECT uid FROM users WHERE username='".$_SESSION['username']."'";
	$myqry=mysqli_query($conn,$sql_stat) or die(mysqli_error($conn));
	$count=mysqli_num_rows($myqry);
	if($count==1)
	{
		while($row=mysqli_fetch_array($myqry))
		{
			$uid=$row['uid'];
		}
	}
	
	$sem_id=$_POST['sem']; 
	$sname=$_POST['sname'];

	//profile start
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

	$sql_stat="INSERT INTO students(`stu_name`, `semester_id`, `profile_image`, `user_id`) VALUES('$sname', $sem_id, '$ulocation', $uid)";
	$query=mysqli_query($conn, $sql_stat) or die(mysqli_error($conn));
	if($query)
	{
		$_SESSION['sem_id']=$_POST['sem'];
	 	header("Location: dashboard.php"); 
	 }
	else
	{
		echo "Unable to set your profile";
	}
}
?>				
</body>
</html>