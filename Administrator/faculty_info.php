<?php 
	require_once('../Session/sessioncheck.php'); 
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
        <?php include_once('../includes/Admin-navbar.php'); ?>
         <!-- navbar end-->
 
    <div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Faculty</h 3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          
			<div class="display">
				<?php
				    if(isset($_GET['fid']) && isset($_GET['name']))
				    {
				    	$sql_stat="SELECT * FROM schedules WHERE faculty_id ='".$_GET['fid']."'";
						$query=mysqli_query($conn,$sql_stat) or die (mysqli_error($conn));
						$count=mysqli_num_rows($query);
				        if($count>=1)
				        {
				        	echo "<strong>Faculty : ".$_GET['name']."</strong><br/><br/>";
                       		echo "<table>
                        		<tr><th>S.N.</th><th>Course</th><th>Course Code</th><th>Semester</th><th>Time</th></tr>";

	                       	$i=0;
	                       	while($row=mysqli_fetch_array($query))
							{
								echo "<tr>
									<td>".++$i."</td>";
									$sql="SELECT course_name FROM courses WHERE code ='".$row['course_code']."'";
									$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
									$count=mysqli_num_rows($qry);
			                        if($count==1)
			                        {
			                        	$result=mysqli_fetch_array($qry);
				                        	echo "<td>".$result['course_name']."</td>";
				                        	echo "<td>".$row['course_code']."</td>";
			                        }

			                        $sql="SELECT sem_name FROM semesters WHERE sem_id ='".$row['semester_id']."'";
									$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
									$count=mysqli_num_rows($qry);
				                    if($count==1)
				                    {
				                       	$result=mysqli_fetch_array($qry);
				                       	echo "<td>".$result['sem_name']."</td>";
				                    }
								echo "<td>".date('h:i a', strtotime($row['start_time']))." - ".date('h:i a', strtotime($row['end_time']))."</td></tr>";
							}
							echo "</table>";
				        }
				    }
				    else{
				    	echo"ooo";
				    }						
				?>					
				</div>
			</div>
		</div>
	</div>
</body>
</html>
