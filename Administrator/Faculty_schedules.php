<?php 
	require_once('../Session/sessioncheck.php'); 
	include('../includes/connection.php');
?>

<?php 
if(isset($_POST['search']))
{
	$str=$_POST['search_text'];
	$sql="SELECT * FROM schedules WHERE (start_time <> '00:00:00' OR end_time <> '00:00:00') AND faculty_id IN (SELECT fid FROM faculty WHERE fname='$str')";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	$count=mysqli_num_rows($qry);
}
else
{
	$sql="SELECT * FROM schedules WHERE start_time <>'00:00:00' OR end_time <> '00:00:00'";
	$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
	$count=mysqli_num_rows($qry);
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
	            <h3>Faculty Schedule</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	<div class="select_sem">
          		<h3>Search Faculty</h3>
          		<form method="POST" action="">
	    			<div class="search">
	    			 <input type="text" name="search_text" placeholder="Enter Name of Faculty">
	    			 <input type="submit" name="search" value="Search">			
					</div>
				</form>

				</div>
			<div class="display">
				<?php
						if($count>=1)
                        {
                        	echo "<table>
                        	<tr><th>S.N.</th><th>Faculty</th><th>Faculty ID</th><th>Course</th><th>Course Code</th><th>Semester</th><th>Time</th></tr>";
                        	$i=0;
                        	while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".++$i."</td>";
										$sql_stat="SELECT fname FROM faculty WHERE fid ='".$row['faculty_id']."'";
										$query=mysqli_query($conn,$sql_stat) or die (mysqli_error($conn));
										$count=mysqli_num_rows($query);
				                        if($count==1)
				                        {
				                        	$result=mysqli_fetch_array($query);
				                        	echo "<td><a href='faculty_info.php?name=".$result['fname']."&fid=".$row['faculty_id']."'/>".$result['fname']."</a></td>";
				                        }
				                echo "<td>".$row['faculty_id']."</td>";

								        $sql_stat="SELECT course_name FROM courses WHERE code ='".$row['course_code']."'";
										$query=mysqli_query($conn,$sql_stat) or die (mysqli_error($conn));
										$count=mysqli_num_rows($query);
				                        if($count==1)
				                        {
				                        	$result=mysqli_fetch_array($query);
				                        	echo "<td>".$result['course_name']."</td>";
				                        }
				                echo "<td>".$row['course_code']."</td>";

				                		$sql_stat="SELECT sem_name FROM semesters WHERE sem_id ='".$row['semester_id']."'";
										$query=mysqli_query($conn,$sql_stat) or die (mysqli_error($conn));
										$count=mysqli_num_rows($query);
				                        if($count==1)
				                        {
				                        	$result=mysqli_fetch_array($query);
				                        	echo "<td>".$result['sem_name']."</td>";
				                        }
								echo "<td>".date('h:i a', strtotime($row['start_time']))." - ".date('h:i a', strtotime($row['end_time']))."</td></tr>";

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
	</div>
</body>
</html>
