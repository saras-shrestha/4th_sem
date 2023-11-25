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
	            <h3>Preferences</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	

			<div class="display">
            <?php   
            if(isset($_GET['status']))
            {      
				$sql="SELECT * FROM preferences WHERE status='1'";
				$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
				$count=mysqli_num_rows($qry);
				if($count>=1)
				{
					echo "<table border='1' cellspacing='0' class='approve'>";
					echo "<tr>
							<th>S.N.</th>
							<th>Faculty ID</th>
							<th>Name</th>
							<th>Semester</th>
							<th>Time</th>
							<th>Status</th>			
						</tr>";
					$i=0;
					while($row=mysqli_fetch_array($qry))
					{
						echo "<tr>
								<td>".++$i."</td>
								<td>".$row['faculty_id']."</td>
								<td>";
									$sql_query="SELECT fname FROM faculty WHERE fid='".$row['faculty_id']."'";
									$query=mysqli_query($conn,$sql_query);
									$result=mysqli_fetch_array($query);
									echo $result['fname'];
						        echo "</td>
								<td>";
									$sql_query="SELECT sem_name FROM semesters WHERE sem_id=".$row['semester_id'];
									$query=mysqli_query($conn,$sql_query);
									$result=mysqli_fetch_array($query);
									echo $result['sem_name'];
						        echo "</td>
								<td>";
									$sql_query="SELECT start_time, end_time FROM timeslots WHERE tid='".$row['time_id']."'";
									$query=mysqli_query($conn,$sql_query);
									$result=mysqli_fetch_array($query);
									echo date('h:i a', strtotime($result['start_time']));
									echo " - ";
									echo date('h:i a', strtotime($result['end_time']));
						        echo "</td>
								<td>";
									if($row['status']==1){
										echo "Approved";
									}
									else{
										echo "Pending";
									}
								echo "</td></tr>";
					}
					echo "</table>";
				}
				else
				{
					echo "Record Not Found";
				}
			}
			else
			{
				$sql="SELECT * FROM preferences WHERE status='0'";
				$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
				$count=mysqli_num_rows($qry);
				if($count>=1)
				{
					echo "<table border='1' cellspacing='0' class='admin'>";
					echo "<tr>
							<th>S.N.</th>
							<th>Faculty ID</th>
							<th>Name</th>
							<th>Semester</th>
							<th>Time</th>
							<th>Status</th>										
							<th colspan=2>Action</th>
						</tr>";
					$i=0;
					while($row=mysqli_fetch_array($qry))
					{
						echo "<tr>
								<td>".++$i."</td>
								<td>".$row['faculty_id']."</td>
								<td>";
									$sql_query="SELECT fname FROM faculty WHERE fid='".$row['faculty_id']."'";
									$query=mysqli_query($conn,$sql_query);
									$result=mysqli_fetch_array($query);
									echo $result['fname'];
						        echo "</td>
								<td>";
									$sql_query="SELECT sem_name FROM semesters WHERE sem_id=".$row['semester_id'];
									$query=mysqli_query($conn,$sql_query);
									$result=mysqli_fetch_array($query);
									echo $result['sem_name'];
						        echo "</td>
								<td>";
									$sql_query="SELECT start_time, end_time FROM timeslots WHERE tid='".$row['time_id']."'";
									$query=mysqli_query($conn,$sql_query);
									$result=mysqli_fetch_array($query);
									echo date('h:i a', strtotime($result['start_time']));
									echo " - ";
									echo date('h:i a', strtotime($result['end_time']));
						        echo "</td>
								<td>";
									if($row['status']==1){
										echo "Approved";
									}
									else{
										echo "Pending";
									}
								echo "</td>
								<td>
									<a href=Approve.php?pid=".$row['pid']."&sem_id=".$row['semester_id']."&fid=".$row['faculty_id'].">";
								?>
										<input type='button' name='approve' class='approve' onclick='return confirm("Preferred time will be approved!!!")' value='APPROVE'/>	
									</a>	
								</td>		
							</tr>
							<?php
					}
					echo "</table>";
				}
				else
				{
					echo "Record Not Found";
				}
			}
			?>
	    	</div>
	    </div>
    </div>

</body>
</html>
