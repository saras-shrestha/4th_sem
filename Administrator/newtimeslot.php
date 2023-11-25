<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
if(isset($_POST['submit']))
{
	$time=$_POST['timeslot'];
	$status=0;
	$sql="INSERT INTO timeslot(`timeslot`,`status`) VALUES('$time','$status')";
	$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	if($query)
	{
		echo "<script> alert('".$time." succesfully added')</script>";
	}
}
?> 
<!DOCTYPE html>
<html>
	<!--start title-->
     <?php 	include_once('../includes/title.html'); ?>
	<!--end title-->

<body> 
	<!---->
	<!--Start header-->
	<?php include_once('../includes/header.php'); ?>
	<!--End header-->
	 
    <div class="wrapper">
    	<div class="row">
    		<!--Start side menu-->
	    	<?php include_once('../includes/Admin-navbar.php'); ?>
	    	<!--End side menu-->

	    	<div class="main-content">
	    		<div class="timeslot">
					<h2>Add New Timeslot</h2>
					</br>
					<form method="post" action="" name="addtime">
						<div>
							<label>Semester</label>
							<select name="sem">
								<?php
									$sql="SELECT * FROM semester";
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
									$count=mysqli_num_rows($qry);
									if($count>=1)
									{
										 $mystring = '<option selected disabled>Select Semester</option>';
										while($row=mysqli_fetch_array($qry))
										{
											$mystring .= "<option size='30px ' value='". $row['sem_id'] ."'>" . $row['sem_name']."</option>";
										}
										echo $mystring;
									}
					 			?>			
							</select>

				         </div>
						<div>
							<label>Start time</label>
							<input type="text" name="start">
				         </div>
				         <div>
							<label>Endt time</label>
							<input type="text" name="end">
				         </div>
				         <div>
							<label>No. of periods</label>
							<input type="text" name="periods">
				         </div>
				         <div>
							<label>Period Interval</label>
							<input type="text" name="interval">
				         </div>
				         <div>
							<input type="submit" name="submit" value="ADD">
						</div>
					</form>
				</div>

				<div class="display">
                 <!--  //php retrive-->
                 <?php 
					$sql="SELECT * FROM timeslot";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0'>";
						echo "<tr>
								<th>timeslot</th>
								<th>Status</th>									
								<th colspan=2>Action</th>
							</tr>";
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".$row['timeslot']."</td>
										<td>".$row['status']."</td>
										<td>
											<a href=EditSem.php?code=".$row['tid'].">Edit</a>
										</td>
										<td>
											<a href=DeleteSem.php?code=".$row['tid'].">Delete</a>
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
    </div>

	<!--Start footer-->
	<?php include_once('../includes/footer.php'); ?>
	<!--End footer-->
</body>
</html>