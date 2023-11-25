<?php 
	require_once('../Session/sessioncheck.php');
	include('../includes/connection.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<!--start title-->
	   <?php include_once('../includes/title.php'); ?>
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
	            <h3>Preferences</h3>
	        </div> 

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">

        	<div class="preferences">
					<?php
					//sql statement to count the no. of semester where a particular faculty is assigned
					/*as a faculty can be assign to a single course for a particular semester*/ 
					$sql="SELECT count(*) AS s_count FROM schedules WHERE faculty_id='".$_SESSION['fid']."'"; 
					$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
					$row=mysqli_fetch_array($qry);

					//sql statement to count the preferences of a particular faculty
					$sql="SELECT count(*) AS p_count FROM preferences WHERE faculty_id='".$_SESSION['fid']."'"; 
					$query=mysqli_query($conn, $sql) or die (mysqli_error($conn));
					$rows=mysqli_fetch_array($query);
					if($row['s_count']==$rows['p_count'])
					{
						echo "<b>No preferences to choose</b>";//No preferences to choose
					}

					else
					{
						echo "<b>Choose timeslots for your course in respective semester</b>";
						echo "<form action='' method='POST' name='choose-preference'>"; 
				        // echo $_SESSION['fid']."and".$_SESSION['username'];
				    	//to find the semester in which faculty is assigned

				    	/*$sql="SELECT schedules.semester_id FROM schedules JOIN faculty ON schedules.faculty_id=faculty.fid JOIN preferences ON faculty.fid=preferences.faculty_id WHERE schedules.faculty_id='".$_SESSION['fid']."' AND schedules.semester_id<>preferences.semester_id"; 
						*/
						$sql=" SELECT semester_id FROM schedules WHERE schedules.faculty_id='".$_SESSION['fid']."' EXCEPT SELECT semester_id FROM preferences WHERE preferences.faculty_id='".$_SESSION['fid']."'";
						$query=mysqli_query($conn, $sql) or die (mysqli_error($conn));
						$count=mysqli_num_rows($query);
						$check=0;
						$sem_array=[];
						if($count>=1)
						{
							while($row=mysqli_fetch_array($query))
							{								
								//storing semester in array
								$sem_array[$check]=$row['semester_id'];
                                //print_r($sem_array);

                                //sql statement to retrive preferrences of a faculty in a particular semesters
								$sql1="SELECT * FROM preferences WHERE semester_id=".$row['semester_id']." AND faculty_id='".$_SESSION['fid']."'";
								$qry1=mysqli_query($conn, $sql1) or die (mysqli_error($conn));
								$count=mysqli_num_rows($qry1);
								if($count==1)
								{
									echo "Successfully choosen for ".$row['semester_id'];
								}

								else
								{
								   	echo "<div style='display:inline-block; margin:10px;border:1px solid black'>";
						        	//Display the remaining timeslot of particular semester

						        	//sql statement to retrive a semester name of aparticular semester
						        	$sql="SELECT sem_name, course_name, course_code FROM semesters JOIN schedules ON semesters.sem_id=schedules.semester_id JOIN courses ON schedules.course_code=courses.code WHERE schedules.semester_id=".$row['semester_id']." AND schedules.faculty_id='".$_SESSION['fid']."'";
								    $qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
								    $rows=mysqli_fetch_array($qry);
									echo "<b>".$rows['sem_name']."<br/>".$rows['course_name']."[".$rows['course_code']."]"."</b>";//display the name of Semester									

									//to retrive the timeslots that are already assign in particular semester from preferences table
									$sql="SELECT time_id FROM preferences WHERE semester_id=".$row['semester_id'];
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
								    $count=mysqli_num_rows($qry);

								    $time_string="";
									if($count>=1)
									{					
										while($row=mysqli_fetch_array($qry))
										{
											//storing timeslot of that particular sem_id as a string
											$time_string.=$row['time_id'].",";
										}
									}
									//changing string to array which now contains the timeslot id
									$time_array=explode(',',$time_string);
									//print_r($time_array);

									//selecting those time slot which are not assign in particular sem
									$sql="SELECT * FROM timeslots WHERE tid<>'$time_array[0]'";
									for($i=1;$i<count($time_array)-1;$i++)
									{
										$sql.=" and tid<>'$time_array[$i]'";
									}	
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));	
									$count=mysqli_num_rows($qry);
								
									if($count>=1)
									{
										while($rows=mysqli_fetch_array($qry))
										{ 
											echo "<br/><input type='checkbox' name='checktime".$check."[]' onClick='return myfun()' value='".$rows['tid']."'/>".date('h:i a', strtotime($rows['start_time']))." - ".date('h:i a', strtotime($rows['end_time']));
										}
									}	
									echo "</div>";
								}
								$check++;
							}
							echo "<div><span id='limit-Err' style='color: red'></span></div>";
							echo "<div><span id='Err' style='color: red'></span></div>";
							echo "<br/><input type='submit' name='submit' value='Submit'>";	

						
						}
						else 
						{
							echo "You are not assign to any course";
						}	
						
					echo "</form>";
					}
					?>

				<script type="text/javascript">
					function myfun()
					{
						for(var i=0;i<=<?php echo $check; ?>;i++)
						{
							var temp="checktime"+i+"[]";
							var a=document.getElementsByName(temp);
							var newvar=0;
							for(var j=0;j<a.length;j++)
							{
								if(a[j].checked==true)
								{
									newvar=newvar+1;
								}
							}
							if(newvar>1)
							{
								document.getElementById('limit-Err').innerHTML="Please check only one slot from each semester";
								return false;
							}
						}
					}
				</script>
					
			</div>	

          	<div class="display">
          	<?php
          		$sql="SELECT * FROM preferences WHERE faculty_id='".$_SESSION['fid']."'";
				$query=mysqli_query($conn, $sql) or die (mysqli_error($conn));
                echo "<b>List of prefered timeslots</b>";
				echo "<table border='1' cellspacing='0'>";
						echo "<tr>
								<th>S.N.</th>
								<th>Semester</th>
								<th>Course</th>	
								<th>Course_Code</th>
								<th>Time</th>			
								<th>Status</th>
							</tr>";
				    $i=0;
					while($row=mysqli_fetch_array($query))
					{
						echo "<tr>
								<td>".++$i."</td>
								<td>";
									$sql="SELECT * FROM semesters WHERE sem_id='".$row['semester_id']."'";
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
									$result=mysqli_fetch_array($qry);
									echo $result['sem_name'].
							   "</td>
								<td>";
									$sql="SELECT sem_name, course_name, course_code FROM semesters JOIN schedules ON semesters.sem_id=schedules.semester_id JOIN courses ON schedules.course_code=courses.code WHERE schedules.semester_id=".$row['semester_id']." AND schedules.faculty_id='".$_SESSION['fid']."'";
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
									$result=mysqli_fetch_array($qry);
									echo $result['course_name'].
								"</td>
								<td>";
								   echo $result['course_code'].
								"</td>
								<td>";
									$sql="SELECT * FROM timeslots WHERE tid='".$row['time_id']."'";
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
									$result=mysqli_fetch_array($qry);
									echo date('h:i a', strtotime($result['start_time']))." - ".date('h:i a', strtotime($result['end_time']));
						   echo "</td>
						        <td>";
							   	    if($row['status']==1)
									{
										echo "Approved";
									}
									else
									{
										echo "Pending...";
									}
						echo "</td>
						</tr>";
					}
				echo "</table>";
          	?>
	    	</div>

	    </div>
    </div>	

</body>
</html>
<?php 
	if(isset($_GET['msg']))
	{
		echo "<script>alert ('".$_GET['msg']."');</script>";
	} 
?>


<?php 
if(isset($_POST['submit']))
{
	$temp=0;
	for($i=0;$i<count($sem_array);$i++)
	{
		if(!empty($_POST['checktime'.$i]))
		{
			$temp++;
		}
		else
		{
			echo "<script>document.getElementById('Err').innerHTML='***Please choose time for all semesters***'; </script>";
		}
	}

	if($temp==count($sem_array))
	{
		$j=0;
		for($i=0;$i<count($sem_array);$i++)
		{
			//print_r($sem_array);
			$sql="SELECT * FROM preferences WHERE semester_id=$sem_array[$i] AND faculty_id='".$_SESSION['fid']."'";
			$query=mysqli_query($conn, $sql) or die (mysqli_error($conn));
			$count=mysqli_num_rows($query);
			if($count==0)
			{
				$checktime=$_POST['checktime'.$i];
				//print_r($checktime);
				if(count($checktime)==1)
				{
					$sql="SELECT * FROM preferences WHERE time_id=$checktime[0] AND faculty_id='".$_SESSION['fid']."'";
					$qry=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count==1)
					{
						echo "<script>document.getElementById('Err').innerHTML='**Please choose different time for different semester**'; </script>";
					}
					else
					{
						$sql_stat="INSERT INTO preferences(faculty_id,semester_id,time_id) VALUES ('".$_SESSION['fid']."', $sem_array[$i], $checktime[0])";
						$sql_qry=mysqli_query($conn,$sql_stat) or die(mysqli_error($conn));
						if($sql_qry)
						{
							$j++;
						}
						else
						{
							echo "Data not inserted";	
						}
					}
				}
			}
			
		}	
		if($j==count($sem_array))
		{
			header("Location:preferences.php?msg=your choice is Successfully submitted");
		}
		else
		{
			echo "Something error";	
		}    
	}
	
}
?>