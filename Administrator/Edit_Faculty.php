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
        <?php include_once('../includes/Admin-navbar.php'); ?>
         <!-- navbar end-->
	<!-- navbar end -->

    <div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Faculty</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	<div class="faculty">
				<h2>Update Faculty</h2>
				</br>
				<?php
				if(isset($_GET['fid']))
				{
					$fid=$_GET['fid'];  
					$sql="SELECT * FROM faculty WHERE fid='$fid'";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					while($row=mysqli_fetch_array($qry))
					{
						echo"
							<form method='post' action='' name=''>
								<div>
									<label for='fid'>FacultyID</label>
									<input type='text' name='fid' id='fid' value='".$row['fid']."'>
						        </div>
						        <div> 
									<label for='fname'>Faculty Name</label>
									<input type='text' name='fname' id='fname' value='".$row['fname']."'>
						        </div>  
						       
								<input type='submit' name='submit' value='UPDATE'/>
								<input type='reset' name='reset' value='CLEAR'/>
							</form>";
					}
				}
				?>
			</div>

			<div class="display">
            <?php 
					$sql="SELECT * FROM faculty";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0' class='admin'>";
						echo "<tr>
								<th>S.N.</th>
								<th>Faculty ID</th>
								<th>Name</th>
								<th>Loads</th>									
								<th colspan=2>Action</th>
							</tr>";
							$i=0;
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".++$i."</td>
										<td>".$row['fid']."</td>
										<td>".$row['fname']."</td>
										<td>".$row['loads']."</td>
										<td>
											<a href=Edit_Faculty.php?fid=".$row['fid']."><button class='edit'>EDIT</button></a>
										</td>
										<td>
											<a href=Delete_Faculty.php?fid=".$row['fid']."><button class='delete'>DELETE</button></a>
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

<?php
if(isset($_POST['submit']))
{
	$faculty_id=$_POST['fid'];
	$name=$_POST['fname'];
	$sql="UPDATE faculty SET fid='$faculty_id', fname='$name' WHERE fid='$fid'";
	$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	if($query)
	{
		echo "<script> alert('".$fid." succesfully updated')</script>";
		header("Location:Faculty.php?msg=Data Updated Successfully");
 	}
 	else
	{
	  header("Location:Faculty.php");
	}
}