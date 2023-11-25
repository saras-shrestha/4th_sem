<?php require_once('../Session/sessioncheck.php'); ?>
<?php  
include('../includes/connection.php');
if(isset($_POST['submit']))
{
	$code=$_POST['courseCode']; 
	$course_name=$_POST['courseName'];
	$sem=$_POST['sem'];
	if(isset($_POST['course-status']))
	{
		$status=$_POST['course-status'];
	}
	else 
	{
		$status=0;
	}
	$sql="INSERT INTO courses(`code`,`course_name`, `semester_id`, `status`) VALUES('$code','$course_name', $sem, $status)";
	$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	if($query)
	{
		echo "<script> alert('".$code." succesfully added')</script>";
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
</head>
<body> 
	<!-- navbar start -->
        <?php include_once('../includes/Admin-navbar.php'); ?>
         <!-- navbar end-->
 
    <div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Course</h3>
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
					$sql="SELECT * FROM courses";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0'>";
						echo "<tr>
								<th>S.N.</th>
								<th>Code</th>
								<th>Course</th>	
								<th>Semester</th>	
								<th>Status</th>			
							</tr>";
							$i=0;
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".++$i."</td>
										<td>".$row['code']."</td>
										<td>".$row['course_name']."</td>
										<td>";
											$sql="SELECT sem_name FROM semesters WHERE sem_id=".$row['semester_id'];
											$query=mysqli_query($conn,$sql) or die (mysqli_error($conn));
											$result=mysqli_fetch_array($query);
											echo $result['sem_name'];
								echo "</td>
										<td>";
										if($row['status']==1){
											echo "Active";
										}
										else{
											echo "Inactive";
										}
										echo "</td>
												
									</tr>";
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