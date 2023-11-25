<?php require_once('../Session/sessioncheck.php');  
include('../includes/connection.php');
?>
<?php 
//update process
 if(isset($_POST['submit']))
 {
 	$sem_id=$_POST['sem_id'];
 	$sem_name=$_POST['sem'];
 	if(isset($_POST['sem-status']))
 	{
  		$sem_status=$_POST['sem-status'];
  	}
  	else
  	{
  		$sem_status=0;
  	}

  	$sql="UPDATE semesters SET sem_name='$sem_name', status=$sem_status WHERE sem_id=$sem_id";
	$qry=mysqli_query($conn,$sql) or die(mysqli_error($conn));
 	if($qry)
 	{
 		header("Location:Semesters.php?msg=Data Updated Successfully");
 	}
 	else
	{
	  header("Location:Semesters.php");
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
	            <h3>Semester</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
            <!-- <h2 class="dash-title">Semester</h2> -->
			<div class="semester">
				<h3>Update Semester</h3>
				</br>
				<?php
				if(isset($_GET['sem_id']))
				{
					$sem_id=$_GET['sem_id'];  
					$sql="SELECT * FROM semesters WHERE sem_id=$sem_id";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					while($row=mysqli_fetch_array($qry))
					{
						echo"<form action='' method='POST'>
								<input type='hidden' name='sem_id' value='".$row['sem_id']."'>
									
								<div>
									<label for='sem'>Semester</label>
									<input type='text' name='sem' id='sem' value='".$row['sem_name']."'>
									<br/>
									<span></span>
								</div>";
								if($row['status']==1)
								{
									echo "<div>
									<label for='sem-stat'>Semester Status</label>
									<input type='checkbox' name='sem-status' id='sem-stat' value='1' checked>						
								</div>";
								}
								else{
									echo "<div>
									<label for='sem-stat'>Semester Status</label>
									<input type='checkbox' name='sem-status' id='sem-stat' value='1'>						
								</div>";
								}
								echo"
								
								<input type='submit' name='submit' value='UPDATE'/>
								<input type='reset' name='reset' value='CLEAR'/>
								</form>";						
					} 
				}
				else
				{
					header("Location:Semesters.php");
				}
				?>
			</div>
			<div class="display">
                <?php 
					$sql="SELECT * FROM semesters";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table class='admin'>";
						echo "<tr >
								<th>S.N.</th>
								<th>Semester</th>
								<th>Status</th>				
								<th colspan=2>Action</th>
							</tr>";
							$i=0;
							while($row=mysqli_fetch_array($qry))
							{
								echo "<tr>
										<td>".++$i."</td>
										<td>".$row['sem_name']."</td>
										<td>";
										if($row['status']==1){
											echo "Active";
										}
										else{
											echo "Deactive";
										}
									echo "</td>
										<td>
											<a href='Edit_Semesters.php?sem_id=".$row['sem_id']."'><button class='edit'>EDIT</button></a>
										</td>
										<td>
											<a href='Delete_Semesters.php?sem_id=".$row['sem_id']."'><button class='delete'>DELETE</button></a>
										</td>					
									</tr>";
							}
							echo "</table>";
					}
					else
					{
						echo "No records";
					}
					?>
			</div>
	    </div>
   	</div>	
</body>
</html>
