<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
$facultyErr = $courseErr = $semErr = "";
$fid = $code = $sem_id = "";
if(isset($_POST['submit']))
{
	//validate faculty
	if (empty($_POST['faculty'])) 
	{
	    $facultyErr = "*Select Faculty";
	} 
	else 
	{
		$fid=$_POST['faculty'];
	}
	//validate semester
	if (empty($_POST['sem'])) 
	{
	    $semErr = "*Select Semester";
	} 
	else 
	{
		$sem_id=$_POST['sem'];
	}
	//validate course
	if (empty($_POST['course'])) 
	{
	    $courseErr = "*Select Course";
	} 
	else 
	{
		$code=$_POST['course'];
	}

	if($fid && $sem_id && $code)
	{

		// sql statement to count how many times faculty is assign for same semester
		$sql="SELECT count(*) AS count FROM schedules WHERE (faculty_id='$fid' AND  semester_id=$sem_id)";
		$qry=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$row=mysqli_fetch_array($qry);

		if($row['count']==0)
		{

		    // restrict faculty to assign for same subject
			$sql="SELECT count(*) AS count FROM schedules WHERE course_code='$code'";
			$qry=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$row=mysqli_fetch_array($qry);
		
			if($row['count']==0)
			{
				$sql="INSERT INTO schedules(`faculty_id`,`semester_id`,`course_code`,`status`) VALUES('$fid',$sem_id,'$code',0)";
				$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				if($query)
				{
					echo "<script> alert('$fid assigned to $code')</script>";
				}		
			}
			else
			{
				echo "<script>alert('The course is already assigned');</script>";
			}		
		}
		else
		{
			echo "<script>alert('The faculty is already assigned in this semester');</script>";
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
	            <h3>Assign Faculty</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	<div class="assignFaculty">
					<h2>Assign Faculty</h2><br/>
					<form method='POST' action='' name=''>
						<div>
							<label for='faculty'>Faculty</label>
							<select name="faculty" id='faculty'>
								<?php
									$sql="SELECT * FROM faculty join users ON faculty.user_id=users.uid WHERE status=1";
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
									$count=mysqli_num_rows($qry);
									$mystring ="<option selected disabled>Select Faculty</option>";
									if($count>=1)
									{
										while($row=mysqli_fetch_array($qry))
										{
											$mystring .= "<option size='30px ' value='". $row['fid'] ."'>" . $row['fname'] ." [". $row['fid'] ."] </option>";
										}										
									}
									echo $mystring;
					 			?>			
							</select>
							<span class='Err'><?php echo $facultyErr; ?></span>
				        </div> 

				         <div>
							<label for='semester'>Semester</label>
							<select id='semester' name="sem" onchange="loadData(this.value)">
								<?php
									$sql="SELECT * FROM semesters WHERE status=1";
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
									$count=mysqli_num_rows($qry);
									$mystring = '<option selected disabled>Select Semester</option>';
									if($count>=1)
									{
										while($row=mysqli_fetch_array($qry))
										{
											$mystring .= "<option size='30px ' value='". $row['sem_id'] ."'>" . $row['sem_name']."</option>";
										}										
									}
									echo $mystring;
					 			?>			
							</select>
							<span class='Err'><?php echo $semErr; ?></span>
				        </div> 

				        <div>
							<label for='course'>Course</label>
							<select name="course" id='course'>
								<option selected disabled>Select Course</option>	
				 			</select>	
				 			<span class='Err'><?php echo $courseErr; ?></span>	
				        </div>  
				        <script type="text/javascript">
				        	function loadData(data){
				        		var obj=new XMLHttpRequest();
				        		obj.open('GET', 'load_course.php?sem_id=' + data, true);
				        		obj.send();
				        		obj.onreadystatechange = function(){
				        			if(obj.readyState == 4 && obj.status == 200){
				        				document.getElementById('course').innerHTML=obj.responseText;
				        			}
				        		};
				        	} 
				        </script>
				        
				        <div>
				        	<span id='assign_Err'></span>
				        </div>
				       
				        <div>    
							<input type="submit" name="submit" value="Assign">
							<input type='reset' name='reset' value='CLEAR'/>
						</div>
					</form>
				</div>
			<div class="display">
                <?php 
                	if(isset($_GET['msg']))
					{
						echo"<script>alert ('".$_GET['msg']."');</script>";
					}
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