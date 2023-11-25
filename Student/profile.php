<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
 ?>
 <?php 
    $sql="SELECT * from users where username='".$_SESSION['username']."'";
    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
	$count=mysqli_num_rows($qry);
	if($count==1)
	{
		while($row=mysqli_fetch_array($qry))
		{
			$uid=$row['uid'];
			$uname=$row['username'];
			$email=$row['email'];  
			$phone=$row['phone'];
		}
	}
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
	<link href="../css/admin.css" rel="stylesheet" type="text/css">	
	<style type="text/css">
		.profile ul li{
			margin: 25px;
			list-style-type: none;
			font-size: 18px;
			font-weight: bold;
		}
		div.image {  
			width: 150px;
			height: 150px;  
			margin: auto;
			margin-bottom: 50px;
		}  
		img {  
			width: 150px;
			height: 150px; 
			border: 1px solid #000; 			
		}  
		.image span{
			margin-left: 25px;
		}
		div.profile{
			margin:auto;
			width :50%;
		}
		button{
			padding:5px;
		}
		button.change
		{
			float:right;
		}
		h3{
			text-align: center;
			padding:10px;
		}
	</style>
</head>
<body> 
	<!-- navbar start -->
        <?php include_once('../includes/Student-navbar.php'); ?>
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
	    		<h3>Profile</h3>
	    		<ul>
	    			<?php
		    			$sql="SELECT stu_name, profile_image, semester_id, username, email, phone FROM users JOIN students ON users.uid=students.user_id WHERE username='".$_SESSION['username']."'";
						$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));	
						$row=mysqli_fetch_array($qry);
						$count=mysqli_num_rows($qry);
						if($count==1)
						{
							echo "<div class='image'>
									<div>
										<img src='".$row['profile_image']."'/>
									</div>
									<span><a href='Update-picture.php'>Update Picture</a></span>
								</div>";
							echo "<li><label>Name : ".$row['stu_name']."</label></li>
								  <li>
								  <label>Semester : ";
								  	$sql1="SELECT sem_name FROM semesters WHERE sem_id=".$row['semester_id'];
									$qry1=mysqli_query($conn,$sql1) or die (mysqli_error($conn));	
									$row1=mysqli_fetch_array($qry1);
									$count=mysqli_num_rows($qry1);
									if($count==1)
									{
										echo $row1['sem_name'];
									}

							echo "</label></li>
								  <li><label>User Name : ".$row['username']."</label></li>
								  <li><label>Email : ".$row['email']."</label></li>
								  <li><label>Phone : ".$row['phone']."</label></li>
							";
						}
	    			?>
	    			<button><a href="Update-profile.php">Update Profile</a></button>
	    			<button class="change"><a href="change_password.php">Change Password</a></button>
	    		</ul>
	    	</div>
	    </div>
	</div> 
</body>
</html>
