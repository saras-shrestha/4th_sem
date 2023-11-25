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
</head>
<body> 
	<!-- navbar start -->
        <?php include_once('../includes/Student-navbar.php'); ?>
         <!-- navbar end-->
 
    <div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Faculty</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
			<div class="display">
                <?php 
                	if(isset($_GET['msg']))
					{
						echo $_GET['msg'];
					}
					$sql="SELECT * FROM schedules WHERE status=1 && semester_id IN (SELECT sem_id FROM semesters WHERE sem_id IN (SELECT semester_id FROM students WHERE user_id IN (SELECT uid FROM users WHERE username='".$_SESSION['username']."')))";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0'>";
						echo "<tr>
								<th>S.N.</th>
								<th>Faculty ID</th>
								<th>Name</th>	
								<th>Course</th>	
								<th>Phone</th>
								<th>email</th>			
							</tr>";
							$i=0;
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".++$i."</td>
										<td>".$row['faculty_id']."</td>";

										$s="SELECT fname FROM faculty WHERE fid='".$row['faculty_id']."'";
										$q=mysqli_query($conn,$s) or die (mysqli_error($conn));
									    $count=mysqli_num_rows($q);
									    if($count==1)
									    {
									    	$result=mysqli_fetch_array($q);
									    	echo "<td>".$result['fname']."</td>";
									    }

									    $s="SELECT course_name FROM courses WHERE code='".$row['course_code']."'";
										$q=mysqli_query($conn,$s) or die (mysqli_error($conn));
									    $count=mysqli_num_rows($q);
									    if($count==1)
									    {
									    	$result=mysqli_fetch_array($q);
									    	echo "<td>".$result['course_name']."</td>";
									    }

									    $s="SELECT phone, email FROM users WHERE uid=(SELECT user_id FROM faculty WHERE fid ='".$row['faculty_id']."')";
										$q=mysqli_query($conn,$s) or die (mysqli_error($conn));
									    $count=mysqli_num_rows($q);
									    if($count==1)
									    {
									    	$result=mysqli_fetch_array($q);
									    	echo "<td>".$result['phone']."</td>";
									    	echo "<td>".$result['email']."</td>";
									    }								
								
										echo "</tr>";
							}
							echo "</table>";
					}
					else
					{
					echo "Record Not Found";
					}
				?>
			</div>
	    </div>
   	</div>	
</body>
</html>