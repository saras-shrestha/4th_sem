<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
$semErr = "";
$sem = "";
if(isset($_POST['submit']))
{
	//validation
	if (empty($_POST['sem']))
	{
	    $semErr = "*Semester name is required";
	} 
	else if(!preg_match("/^[A-Za-z0-9\s]+$/", $_POST['sem']))
	{
	    $semErr="*letters and numbers are only allowed";    
	}
	else
	{
		$sem=$_POST['sem'];
	}
	if($sem)
	{
		$created_at=date('Y-m-d');
		$created_by=$_SESSION['admin_id'];
		if(isset($_POST['sem-status']))
		{
			$status=$_POST['sem-status'];
		}
		else 
		{
			$status=0;
		}
		$sql="INSERT INTO semesters(`sem_name`,`status`,`created_at`,`created_by`) VALUES('$sem','$status','$created_at',$created_by)";
		$query=mysqli_query($conn,$sql) or die(mysqli_error($conn));
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
	            <h3>Semester </h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	<div class="semester">
				<h3>Add New Semester</h3>
				</br>
				<form action="" method="POST">
					<div>
						<label for="sem">Semester</label>
						<input type="text" name="sem" id="sem">
						<br/>
						<span class='Err'><?php echo $semErr ?></span>
					</div>
					<div>
						<label for="sem-stat">Semester Status</label>
						<input type="checkbox" name="sem-status" id="sem-stat" value="1">						
					</div>
					<input type="submit" name="submit" value="ADD"/>
					<input type='reset' name='reset' value='CLEAR'/>
				</form>
			</div>
			<div class="display">
                <?php 
               		if(isset($_GET['msg']))
					{
						echo $_GET['msg'];
					}
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
								<th colspan=2 width:20%>Action</th>
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
											<a href=Edit_Semesters.php?sem_id=".$row['sem_id']."><button class='edit'>EDIT</button></a>
										</td>
										<td>
											<a href=Delete_Semesters.php?sem_id=".$row['sem_id']."><button class='delete'>DELETE</button></a>
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
