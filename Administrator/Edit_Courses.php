<?php require_once('../Session/sessioncheck.php'); 
include('../includes/connection.php');
?>
<?php 
if(isset($_POST['submit']))
{
	$course_code=$_POST['courseCode'];
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
	$sql="UPDATE courses SET code='$course_code', course_name='$course_name', semester_id=$sem, status=$status WHERE code='$course_code'";
	$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	if($query)
	{
		echo "<script> alert('".$code." succesfully updated')</script>";
		header("Location:Courses.php?msg=Data Updated Successfully");
 	}
 	else
	{
	  header("Location:Courses.php");
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
          	<div class="course">
				<h2>Update Course</h2>
				</br>
				<?php
				if(isset($_GET['code']))
				{
					$code=$_GET['code'];  
					$sql="SELECT * FROM courses WHERE code='$code'";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					while($row=mysqli_fetch_array($qry))
					{
						echo "<form method='post' action='' name=''>
								<div>
									<label>Course Code</label>
									<input type='text' name='courseCode' value='".$row['code']."'>
						        </div>
						        <div>      
									<label>Course Name</label>
									<input type='text' name='courseName' value='".$row['course_name']."'>
						        </div>
						        <div>
						        	<label>Semester</label>
									<select name='sem'>";
									$sql1="SELECT * FROM semesters";
									$qry1=mysqli_query($conn, $sql1) or die (mysqli_error($conn));
									$count1=mysqli_num_rows($qry1);
									if($count1>=1)
									{
										 $mystring = '<option selected disabled>Select Semester</option>';
										while($row1=mysqli_fetch_array($qry1))
										{
											if($row['semester_id']==$row1['sem_id'])
											{
												$mystring .= "<option size='30px ' value='". $row1['sem_id'] ."' selected>" . $row1['sem_name']."</option>";
											}
											else
											{
												$mystring .= "<option size='30px ' value='". $row1['sem_id'] ."'>" . $row1['sem_name']."</option>";
											}
										}
										echo $mystring;
									}
									echo "</select>
						        </div>";
								if($row['status']==1)
								{
									echo "<div>
											<label for='course-stat'>Course Status</label>
											<input type='checkbox' name='course-status' id='course-stat' value='1' checked>						
										</div>";
								}
								else
								{
									echo "<div>
											<label for='course-stat'>Course Status</label>
											<input type='checkbox' name='course-status' id='course-stat' value='1'>						
										</div>";
								}
								echo"								
								<input type='submit' name='submit' value='UPDATE'/>
								<input type='reset' name='reset' value='CLEAR'/>
								</form>";		
					} 
				}
				else
				{
					header("Location:Courses.php");
				}
				?>
			</div>
			<div class="display">
                <?php 
					$sql="SELECT * FROM courses";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0' class='admin'>";
						echo "<tr>
								<th>Code</th>
								<th>Course</th>	
								<th>Status</th>			
								<th colspan=2>Action</th>
							</tr>";
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".$row['code']."</td>
										<td>".$row['course_name']."</td>
										<td>";
										if($row['status']==1){
											echo "Active";
										}
										else{
											echo "Deactive";
										}
									echo "</td>
										<td>
											<a href=Edit_Courses.php?code=".$row['code']."><button class='edit'>EDIT</button></a>
										</td>
										<td>
											<a href=Delete_Courses.php?code=".$row['code']."><button class='delete'>DELETE</button></a>
										</td>				
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
