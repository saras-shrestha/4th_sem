<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
if(isset($_POST['submit']))
{
	$fid=$_POST['faculty'];
	$code=$_POST['course'];
	$sem_id=$_POST['sem'];
	
	$sql="UPDATE schedules SET faculty_id='$fid', semester_id=$sem_id, course_code='$code'";
	$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	if($query)
	{
		echo "<script> alert('$fid assigned to $code')</script>";
		header("Location:AssignFaculty.php?msg=Data Updated Successfully");
 	}
 	else
	{
	  header("Location:AssignFaculty.php");
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
	            <h3>Assign Faculty</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	<div class="assignFaculty">
				<h2>Assign Faculty</h2>
				<br/>
				<?php
				if(isset($_GET['sid']))
				{
					$sid=$_GET['sid'];  
					$sql="SELECT * FROM schedules WHERE sid='$sid'";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					while($rows=mysqli_fetch_array($qry))
					{
						echo"<form method='POST' action='' name=''>
							<div>
								<label>Faculty</label>
								<select name='faculty'>";									
								$sql="SELECT * FROM faculty";
								$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
								$count=mysqli_num_rows($qry);
								if($count>=1)
								{
								    $mystring = '<option disabled>Select Faculty</option>';
									while($row=mysqli_fetch_array($qry))
									{
										if($row['fid']==$rows['faculty_id'])
										{
										    $mystring .= "<option size='30px ' value='". $row['fid'] ."'selected>" . $row['fname'] ." [". $row['fid'] ."]</option>";
										}
										else
										{
											$mystring .= "<option size='30px ' value='". $row['fid'] ."'>" . $row['fname'] ." [". $row['fid'] ."] </option>";
										}
									}
									echo $mystring;
								}
							echo"</select>
						    </div> 
							<div>
								<label>Course</label>
								<select name='course'>";
								$sql='SELECT * FROM courses';
								$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
								$count=mysqli_num_rows($qry);
								if($count>=1)
								{
			   					    $mystring = '<option disabled >Select Course</option>';
									while($row=mysqli_fetch_array($qry))
									{
										if($row['code']==$rows['course_code'])
										{
										   $mystring .= "<option size='30px ' value='". $row['code'] ."' selected>" . $row['course_name'] ." [". $row['code'] ."] </option>";
										}
										else
										{
											$mystring .= "<option size='30px ' value='". $row['code'] ."'>" . $row['course_name'] ." [". $row['code'] ."] </option>";
										}
									}
									echo $mystring;
								}
							echo "</select>		
							</div>  
							<div>
								<label>Semester</label>
								<select name='sem'>";
								$sql="SELECT * FROM semesters";
								$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
								$count=mysqli_num_rows($qry);
								if($count>=1)
								{
									$mystring = '<option disabled>Select Semester</option>';
									while($row=mysqli_fetch_array($qry))
									{
										if($row['sem_id']==$rows['semester_id'])
										{
											$mystring .= "<option size='30px ' value='". $row['sem_id'] ."' selected>" . $row['sem_name']."</option>";
										}
										else
										{
											$mystring .= "<option size='30px ' value='". $row['sem_id'] ."'>" . $row['sem_name']."</option>";
										}
									}
									echo $mystring;
								}
							 echo "</select>
							    </div> 
							        <div>    
										<input type='submit' name='submit' value='UPDATE'>
										<input type='reset' name='reset' value='CLEAR'/>
									</div>
							</form>";
					}
				}
				?>
			</div>
		<div class="display">
                <?php 
                	$sql="SELECT sid, fid, fname, course_name, sem_name FROM faculty join schedules ON faculty.fid=schedules.faculty_id join courses ON schedules.course_code=courses.code join semesters ON schedules.semester_id=semesters.sem_id";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0' class='admin'>";
						echo "<tr>
								<th>S.N.</th>	
								<th>ID</th>		
								<th>Name</th>
								<th>Course</th>		
								<th>Semester</th>								
								<th colspan=2>Action</th>
							</tr>";
							$i=0;
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".++$i."</td>
										<td>".$row['fid']."</td>
										<td>".$row['fname']."</td>
										<td>".$row['course_name']."</td>
										<td>".$row['sem_name']."</td>
										<td>
											<a href=Edit_Assign.php?sid=".$row['sid']."><button class='edit'>EDIT</button></a>
										</td>
										<td>
											<a href=Delete_Assign.php?sid=".$row['sid']."><button class='delete'>DELETE</button></a>
										</td>					
									</tr>";
							}
							echo "</table>";
					}
					else
					{
					echo "Faculty not assign to any course";
					}
				?>
			</div>
	    </div>
   	</div>		
</body>
</html>