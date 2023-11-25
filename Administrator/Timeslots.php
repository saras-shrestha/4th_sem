<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
$stimeErr = $etimeErr = "";
$start_time = $end_time = "";
include('../includes/connection.php');
if(isset($_POST['submit']))
{
	//validation start time
	if (empty($_POST['start-time']))
	{
	    $stimeErr = "*Enter start time";
	} 
	else 
	{
		$start_time=$_POST['start-time'];
	}
	//validation end time
	if (empty($_POST['end-time']))
	{
	    $etimeErr = "*Entr end time";
	} 
	else
	{
		$end_time=$_POST['end-time'];
	}
	
	if($end_time && $start_time)
	{		
		$created_by=$_SESSION['admin_id'];
		$created_at=date('Y-m-d');
		if(isset($_POST['time-status']))
		{
			$status=$_POST['time-status'];
		}
		else 
		{
			$status=0;
		}
		$sql="INSERT INTO timeslots(`start_time`, `end_time`, `status`, `created_at`, `created_by`) VALUES('$start_time', '$end_time', '$status', '$created_at', $created_by)";
		$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if($query)
		{
			echo "<script> alert('$start_time - $end_time succesfully added')</script>";
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
	            <h3>Timeslots</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	<div class="timeslot">
					<h2>Add New Timeslot</h2>
					</br>
					<form method='POST' action=''>
						<div>
							<label for='start-time'>Start Time</label>
							<input type='time' name='start-time' id='start-time'>
							<span class='Err'><?php echo $stimeErr ?></span>

							<label for='end-time'>End Time</label>
							<input type='time' name='end-time' id='end-time'>							
							<span class='Err'><?php echo $etimeErr ?></span>
				         </div>
						<div>
							<label for='time-stat'>Timeslot Status</label>
							<input type='checkbox' name='time-status' id='time-stat' value='1'>				
						</div>
						<input type='submit' name='submit' value='ADD'/>
						<input type='reset' name='reset' value='CLEAR'/>
					</form>
			</div>
			<div class="display">
                <?php 
                	if(isset($_GET['msg']))
					{
						echo "<script>alert('".$_GET['msg']."');</script>";
					}
					$sql="SELECT * FROM timeslots";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0' class='admin'>";
						echo "<tr>
								<th>S.N.</th>
								<th>Start Time</th>
								<th>End Time</th>
								<th>Status</th>									
								<th colspan=2>Action</th>
							</tr>";
							$i=0;
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".++$i."</td>
										<td>";
										  echo date('h:i a', strtotime($row['start_time']));
									echo "</td>
										 <td>";
										  echo date('h:i a', strtotime($row['end_time']));
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
											<a href=Edit_Timeslots.php?tid=".$row['tid']."><button class='edit'>EDIT</button></a>
										</td>
										<td>
											<a href=Delete_Timeslots.php?tid=".$row['tid']."><button class='delete'>DELETE</button></a>
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