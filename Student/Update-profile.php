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
		    		<form method="post" action="" enctype='multipart/form-data'>
		    			<table class='update-profile'>
		    				<?php 
		    				$sql="SELECT * FROM students INNER JOIN users ON students.user_id=users.uid WHERE username='".$_SESSION['username']."'";
							$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
							$count=mysqli_num_rows($qry);
							if($count==1)
							{
								$row=mysqli_fetch_array($qry);
								echo "<h3>Update Profile</h3>";
							
								echo "<tr>
										<th>Name</th>
			    						<td><b>:</b> <input type='text' name='name' value='".$row['stu_name']."'/></td>
									</tr>";
								echo "<tr>
										<th><label for='semester'>Semester</label></th>
			    						<td><b>:</b>			    						 
										<select id='semester' name='sem'>";										
											$sql="SELECT * FROM semesters";
											$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
											$count=mysqli_num_rows($qry);
											$mystring = '<option selected disabled>Select Semester</option>';
											if($count>=1)
											{
												while($rows=mysqli_fetch_array($qry))
												{
													if($_SESSION['sem_id']==$rows['sem_id'])
													{
														$mystring .= "<option size='30px' value='". $rows['sem_id'] ."' selected>" . $rows['sem_name']."</option>";
													}
													else
													{
													 	$mystring .= "<option size='30px ' value='". $rows['sem_id'] ."'>" . $rows['sem_name']."</option>";
													}
												}										
											}
											echo $mystring;
							 						
								    echo "</select>
				        				 </td></tr>";
								
							}
							?>		    				
		    				<tr>
		    					<th>User Name</th>
		    					<td><b>:</b> <input type="text" name="uname" value="<?php echo $uname; ?>" disabled/></td>
		    				</tr>
		    				<tr>
		    					<th>Email</th>
		    					<td><b>:</b> <input type="email" name="email" value="<?php echo $email; ?>"/></td>
		    				</tr>
		    				<tr>
		    					<th>Phone</th>
		    					<td><b>:</b> <input type="text" name="phone" value="<?php echo $phone; ?>"/></td>
		    				</tr>
		    				<tr>
		    					<td colspan="2"><input type="submit" name="submit" value="Update"/>
		    					<input type='reset' name='reset' value='CLEAR'/>
		    				</td>
		    				</tr>

		    			</table>	    			
		    		</form>
	    		</div>
	    	</div>
	    </div>
    </div>

</body>
</html>
 <?php 
 //update process
	if(isset($_POST['submit']))
	{
		$name=$_POST['name'];
		$sem=$_POST['sem'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];

		
		$sql1="UPDATE students SET stu_name='$name', semester_id=$sem WHERE stu_id=".$row['stu_id'];
		$qry1=mysqli_query($conn,$sql1) or die (mysqli_error($conn));
		
		$sql2="UPDATE users SET email='$email',phone='$phone' where username='".$_SESSION['username']."'";
		$qry2=mysqli_query($conn,$sql2) or die (mysqli_error($conn));	
		if($qry1&&$qry2)
		{
			header("Location:profile.php");
		}		    			
	}
	
?>