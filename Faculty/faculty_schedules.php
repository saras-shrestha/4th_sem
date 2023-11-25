<?php require_once('../Session/sessioncheck.php'); 

//http://localhost/ClassScheduleManagementSystem/Faculty/scheduletable.php
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
        <?php include_once('../includes/Faculty-navbar.php'); ?>
         <!-- navbar end-->
 
    <div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Schedule</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          		<div class="display">
				<?php
						
						$days=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
						echo "<table id='schedule' border='1' cellspacing='0'>
									<tr>
									<th>Day</th>";
									for($i=0;$i<count($days);$i++)
									{
										echo "<td>$days[$i]</td>";
									}							

						$sql="SELECT * FROM timeslots";
						$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
						$count=mysqli_num_rows($qry);
						if($count>=1)
						{
							//$p=0;
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr><th>";
										  echo date('h:i a', strtotime($row['start_time']));
										  echo " - ";
										  echo date('h:i a', strtotime($row['end_time']));
							 	  echo "</th>";
								
								$sql1="SELECT * FROM schedules where (start_time='".$row['start_time']."' AND end_time='".$row['end_time']."') AND faculty_id IN (SELECT fid FROM faculty WHERE user_id IN (SELECT uid FROM users WHERE username='".$_SESSION['username']."'))";
								$qry1=mysqli_query($conn,$sql1) or die (mysqli_error($conn));
								$count=mysqli_num_rows($qry1);
								if($count==1)
								{
									while($rows=mysqli_fetch_array($qry1))
									{
									    for($j=0;$j<count($days);$j++)
										{
                                        	echo "<td>";
                                        	$s="SELECT sem_name FROM semesters WHERE sem_id =".$rows['semester_id'];
											$q=mysqli_query($conn, $s);
											$r=mysqli_fetch_array($q);
											echo "<b>".$r['sem_name']."</b><br/>";

                                            $sql_query="SELECT course_name FROM courses WHERE code='".$rows['course_code']."'";
											$query=mysqli_query($conn,$sql_query);
											$result=mysqli_fetch_array($query);
											echo $result['course_name']." [".$rows['course_code']."]</td>";
                                      	}
									}
								}						
							
								else
								{
									for($j=0;$j<count($days);$j++)
									{
                                   		echo "<td>---</td>";
                                  	}
								}
								 "</tr>";
							}							
							
						}
						echo "</table>";
				?>					
				</div>
			</div>
		</div>
	</div>
</body>
</html>