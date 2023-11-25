<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
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
	<!-- navbar start -->
        <?php include_once('../includes/Faculty-navbar.php'); ?>
         <!-- navbar end-->
	<!-- navbar end -->

    <div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Loads</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	<div class="display">
            <?php 
			$sql_st="SELECT * FROM schedules WHERE faculty_id='".$_SESSION['fid']."'";
			$query=mysqli_query($conn,$sql_st) or die (mysqli_error($conn));
			$count=mysqli_num_rows($query);
			if($count>=1)
			{
				echo "<table border='1' cellspacing='0'>";
				echo "<tr>
						<th>S.N.</th>
						<th>Semester</th>
						<th>Course</th>
						<th>Time</th>								
					</tr>";
				$i=0;
				while($rows=mysqli_fetch_array($query))
				{
					echo "<tr>
							<td>".++$i."</td>
							<td>";
								$sql="SELECT * FROM semesters WHERE sem_id='".$rows['semester_id']."'";
								$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
								$result=mysqli_fetch_array($qry);
								echo $result['sem_name'].
					  	   "</td>
							<td>";
								$sql="SELECT * FROM courses WHERE code='".$rows['course_code']."'";
								$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
								$result=mysqli_fetch_array($qry);
								echo $result['course_name']."[".$result['code']."]";
					  echo "</td>";
					  		
					  		if($rows['end_time']=='00:00:00' && $rows['start_time']=='00:00:00')
					  			{
					  				echo "<td>- - -</td>";
					  			}
					  			else
					  			{
					  				echo "<td>".date('h:i a', strtotime($rows['start_time']))." - ".date('h:i a', strtotime($rows['end_time']))."</td>";
					  			}
					  		
					  	echo "</tr>";
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