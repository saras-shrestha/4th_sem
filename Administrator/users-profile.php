<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
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
		.profile ul li{
			margin: 25px;
			list-style-type: none;
			font-size: 18px;
			font-weight: bold;
		}
		ul{
			margin-left: 20px;
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
		div.profile{
			margin:auto;
			width :50%;
		}
		h3{
			text-align: center;
			padding:20px;
		}
		div button{
			margin-left: 40px;
		}
	</style>
	<link href="../css/admin.css" rel="stylesheet" type="text/css">	
</head>
<body style='background:lightgrey'> 
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
		<h3>Users Profile</h3>
		<ul>
		<?php 
		if(isset($_GET['uid']))
		{
			$uid=$_GET['uid'];  
			$sql_stat="SELECT * FROM users WHERE uid=$uid";
			$query=mysqli_query($conn,$sql_stat) or die (mysqli_error($conn));
			$count=mysqli_num_rows($query);
			if($count==1)
			{
				$row=mysqli_fetch_array($query);
				if($row['role']==1)
				{
					$sql="SELECT aid, aname, profile_image, email, phone FROM users JOIN admins ON users.uid=admins.user_id WHERE user_id=$uid";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));	
					$count=mysqli_num_rows($qry);
					if($count==1)
					{
						$row=mysqli_fetch_array($qry);
						echo "<div>
									<div class='image'>
										<img src='".$row['profile_image']."'/>
									</div>
							  </div>";
						echo "<ul>
								<li><label>Name : ".$row['aname']."</label></li>
							 	 <li><label>Email : ".$row['email']."</label></li>
							  	<li><label>Phone : ".$row['phone']."</label></li>
							  	</ul>
							";
					}
					else
					{
						echo "Records Not Found";
					}
				}
				else if($row['role']==2)
				{
					$sql="SELECT fid, fname, profile_image, email, phone FROM users JOIN faculty ON users.uid=faculty.user_id WHERE user_id=$uid";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));	
					$count=mysqli_num_rows($qry);
					if($count==1)
					{
						$row=mysqli_fetch_array($qry);
						echo "<div>
									<div class='image'>
										<img src='".$row['profile_image']."'/>
									</div>
							  </div>";
						echo "<ul>
								<li><label>ID : ".$row['fid']."</label></li>
							  	<li><label>Name : ".$row['fname']."</label></li>
							  	<li><label>Email : ".$row['email']."</label></li>
							  	<li><label>Phone : ".$row['phone']."</label></li>
							  </ul>
							";
					}
					else
					{
						echo "Records Not Found";
					}
				}
				else
				{
					$sql="SELECT stu_name, semester_id, profile_image, email, phone FROM users JOIN students ON users.uid=students.user_id WHERE user_id=$uid";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));	
					$count=mysqli_num_rows($qry);
					if($count==1)
					{
						$row=mysqli_fetch_array($qry);
						echo "<div>
									<div class='image'>
										<img src='".$row['profile_image']."'/>
									</div>
								</div>";
						echo "<ul>
								<li><label>Name : ".$row['stu_name']."</label></li>
								<li><label>Semester : ";
								  $sql1="SELECT sem_name FROM semesters WHERE sem_id=".$row['semester_id'];
								  $qry1=mysqli_query($conn,$sql1) or die (mysqli_error($conn));	
								  $count=mysqli_num_rows($qry1);
								  if($count==1)
								  {
								   	$result=mysqli_fetch_array($qry1);
									echo $result['sem_name']; 
								  }
								  echo "</label></li>
								  <li><label>Email : ".$row['email']."</label></li>
								  <li><label>Phone : ".$row['phone']."</label></li>
								</ul>
							";
					}
					else
					{
						echo "Records Not Found";
					}

				}
			}
			echo "<div><button><a href='users.php'>Back</a></button></div>";
		}
			
		?>
		</ul>
	    </div>
	</div>
</div>
	
</body>
</html>
 