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
				<h2>Update Timeslot</h2>
				</br>
				<?php
				if(isset($_GET['tid']))
				{
					$tid=$_GET['tid'];  
					$sql="SELECT * FROM timeslots WHERE tid='$tid'";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					while($row=mysqli_fetch_array($qry))
					{
						echo"<form method='POST' action=''>
							<div>
								<label for='start-time'>Start Time</label>
								<input type='time' name='start-time' id='start-time' value='".$row['start_time']."'>

								<label for='end-time'>End Time</label>
								<input type='time' name='end-time' id='end-time' value='".$row['end_time']."'>
					        </div>";
					        if($row['status']==1)
							{
								echo "<div>
									<label for='time-stat'>Timeslot Status</label>
									<input type='checkbox' name='time-status' id='time-stat' value='1' checked>
									</div>";
							}
							else
							{
								echo "<div>
										<label for='time-stat'>TimeSlot Status</label>
										<input type='checkbox' name='time-status' id='time-stat' value='1'>						
										</div>";
							}
							echo"								
							<input type='submit' name='submit' value='UPDATE'/>
							<input type='reset' name='reset' value='CLEAR'/>
							</form>";		
					}
				}
				?>
			</div>
			<?php
if(isset($_POST['submit']))
{
	//getting data from form
	$start_time=$_POST['start-time'];
	$end_time=$_POST['end-time'];

	if(isset($_POST['time-status']))
	{
		$status=$_POST['time-status'];
	}
	else 
	{
		$status=0;
	}

	//sql statement
	$sql="UPDATE timeslots SET start_time='$start_time', end_time='$end_time', status='$status' WHERE tid=$tid";

	$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	
	if($query)
	{
		header("Location:Timeslots.php?msg=Timeslot Updated Successfully");
 	}
 	else
	{

	  header("Location:Timeslots.php");
	}
}
?> 
			<div class="display">
                <?php 
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
										<td>".date('h:i a', strtotime($row['start_time']))."</td>
										<td>".date('h:i a', strtotime($row['end_time']))."</td>
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
