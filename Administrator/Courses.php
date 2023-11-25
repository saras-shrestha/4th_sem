<?php require_once('../Session/sessioncheck.php'); ?>
<?php  
include('../includes/connection.php');
$semErr = $codeErr = $courseErr = "";
$sem =$code = $course_name = "";
if(isset($_POST['submit']))
{
	//validation of course code
	if (empty($_POST['courseCode']))
	{
	    $codeErr = "*Course code is required";
	} 
	else if(!preg_match("/^[A-Za-z0-9]+$/", $_POST['courseCode']))
	{
	    $codeErr="*letters and numbers are only allowed";    
	}
	else
	{
		$code=$_POST['courseCode'];
	}
	//validation of course name
	if (empty($_POST['courseName']))
	{
	    $courseErr = "*Course Name is required";
	} 
	else if(!preg_match("/^[A-Za-z_&\s]+$/", $_POST['courseName']))
	{
	    $courseErr="*letters and space are only allowed";    
	}
	else
	{
		$course_name=$_POST['courseName'];
	}
	//validation of semester
	if (empty($_POST['sem']))
	{
	    $semErr = "*Select Semester";
	} 
	else
	{
		$sem=$_POST['sem'];
	}
	
	if($sem && $code && $course_name)
	{		
		$created_by=$_SESSION['admin_id'];
		$created_at=date('Y-m-d');
		if(isset($_POST['course-status']))
		{
			$status=$_POST['course-status'];
		}
		else 
		{
			$status=0;
		}
		$sql="INSERT INTO courses(`code`,`course_name`, `semester_id`, `status`, `created_at`, `created_by`) VALUES('$code','$course_name', $sem, $status,'$created_at',$created_by)";
		$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if($query)
		{
			echo "<script> alert('".$code." succesfully added')</script>";
		}
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
					<h2>Add New Course</h2>
					</br>
					<form method="post" action="" name="">
						<div>
							<label>Course Code</label>
							<input type="text" name="courseCode">
							<span class='Err'><?php echo $codeErr ?></span>
				        </div>
				        <div>      
							<label>Course Name</label>
							<input type="text" name="courseName">
							<span class='Err'><?php echo $courseErr ?></span>
				        </div> 
				        <div>      
							<label>Semester</label>
							<select name="sem">
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
							<span class='Err'><?php echo $semErr ?></span>
				        </div> 
						<div>
							<label for="sem-stat">Course Status</label>
							<input type="checkbox" name="course-status" id="course-stat" value="1">					
						</div>
						<input type="submit" name="submit" value="ADD"/>
						<input type='reset' name='reset' value='CLEAR'/>
					</form>
			</div>
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
						echo "<table border='1' cellspacing='0' class='admin'>";
						echo "<tr>
								<th>S.N.</th>
								<th>Code</th>
								<th>Course</th>	
								<th>Semester</th>	
								<th>Status</th>			
								<th colspan=2>Action</th>
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