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
			padding:20px;
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
	    		<h3>Profile</h3>
	    		<ul>
	    			<?php
		    			$sql1="SELECT aname, profile_image, username, email, phone FROM users JOIN administrators ON users.uid=administrators.user_id WHERE username='".$_SESSION['username']."'";
						$qry1=mysqli_query($conn,$sql1) or die (mysqli_error($conn));	
						$row1=mysqli_fetch_array($qry1);
						$count1=mysqli_num_rows($qry1);
						if($count1==1)
						{
							echo "<div class='image'>
									<div>
										<img src='".$row1['profile_image']."'/>
									</div>
									<span><a href='update-picture.php'>Update Picture</a></span>
								</div>";
							echo "<li><label>Name : ".$row1['aname']."</label></li>
								  <li><label>User Name : ".$row1['username']."</label></li>
								  <li><label>Email : ".$row1['email']."</label></li>
								  <li><label>Phone : ".$row1['phone']."</label></li>
							";
						}
	    			?>
	    			<button><a href="update-profile.php">Update Profile</a></button>
	    			<button class="change"><a href="change-password.php">Change Password</a></button>
	    		</ul>
	    	</div>
	    </div>
	</div> 
</body>
</html>
