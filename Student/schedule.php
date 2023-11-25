<?php require_once('../Session/sessioncheck.php'); 
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
						$mystring="";
						$sql="SELECT sem_name FROM semesters WHERE sem_id=".$_SESSION['sem_id'];
						$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
						$count=mysqli_num_rows($qry);
                        if($count==1)
                        {
                        	$row=mysqli_fetch_array($qry);
                        	echo "<h1>Class Schedule of ".$row['sem_name']."</h1>";
                        }
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
								$sql1="SELECT * FROM schedules where semester_id=".$_SESSION['sem_id']." AND start_time='".$row['start_time']."' AND end_time='".$row['end_time']."'";
								$qry1=mysqli_query($conn,$sql1) or die (mysqli_error($conn));
								$count=mysqli_num_rows($qry1);
								if($count==1)
								{
									while($row=mysqli_fetch_array($qry1))
									{
									    for($j=0;$j<count($days);$j++)
										{
                                        	echo "<td>";
                                            		$sql_query="SELECT code FROM courses WHERE code='".$row['course_code']."'";
													$query=mysqli_query($conn,$sql_query);
													$result=mysqli_fetch_array($query);
													echo $result['code']."<br/>";

													$sql_query="SELECT fid, fname FROM faculty WHERE fid='".$row['faculty_id']."'";
													$query=mysqli_query($conn,$sql_query);
													$result=mysqli_fetch_array($query);
													echo $result['fname']."</td>";
                                      	}
                                      	$sql_query2="SELECT fid,fname,phone,email FROM users JOIN faculty ON users.uid=faculty.user_id WHERE fid='".$row['faculty_id']."'";
										$query2=mysqli_query($conn,$sql_query2);
										$result2=mysqli_fetch_array($query2);
										$mystring.="<tr><td>".$result2['fname']."[".$result2['fid']."]</td><td>".$result2['phone']."</td><td>".$result2['email']."</td></tr>";
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
						echo "<table class='info'><tr><th>Faculty</th><th>Contact</th><th>Email</th></tr>".$mystring."</table>";
				?>					
				</div>
			</div>
		</div>
	</div>
</body>
</html>