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
	<link href="../css/admin.css" rel="stylesheet" type="text/css">	
	<style>
		.profile h3{
			text-align: center;
			margin-bottom: 25px;
		}
		table{
			margin-left: 40px;
		}
	</style>
</head>
<body> 
	<!-- navbar start -->
        <?php include_once('../includes/Admin-navbar.php'); ?>
    <!-- navbar end -->

    <div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h2>Profile</h2>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

	    	<div class="main-content">
	    		<div class="profile">
		    		<form method="post" action="" enctype='multipart/form-data'>
		    			<table class='update-profile'>
		    				<h3>Update Profile Picture</h3>
		    				<tr>
								<th>Profile Picture</th>
								<td><b>:</b><input type='file' name='profile'/></td>
							</tr>
							<tr>
			    				<td colspan="2">
			    					<input type="submit" name="submit" value="Update"/>
			    					<input type='reset' name='reset' value='CLEAR'/>
		    					</td>
		    				</tr>
		    			</table>	    			
		    		</form>
	    		</div>
	    	</div>
	    </div>
</body>
</html>
 <?php 
 //update process
	if(isset($_POST['submit']))
	{
		/*Profile picture*/
		$files = $_FILES['profile'];
		$pname=$_FILES['profile']['name'];
		$size=$_FILES['profile']['size']; 
		$type=$_FILES['profile']['type'];
		$tmpname = $_FILES['profile']['tmp_name'];
		$ulocation="../Upload/".$pname;
		print_r($files);

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
		/*profile-picture*/
		
		//$sql="UPDATE administrators SET profile_image='$ulocation' where aid=".$_SESSION['admin_id'];
		$sql="UPDATE administrators SET profile_image='$ulocation' WHERE user_id IN (SELECT uid FROM users WHERE username='".$_SESSION['username']."')" ;
		$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
		if($qry)
		{
			header("Location:Admin_Profile.php"); 
		}		    			
	}
	
?>