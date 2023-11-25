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
	            <h3>Users</h3>
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
	            if($_GET['status']==1)
	            {
	            	$sql="SELECT * FROM users WHERE status=1";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0' id='myTable' class='users'>";
						echo "<tr>
								<th>S.N.</th>
								<th>Username</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Role</th>
								<th>Status</th>										
								<th>Action</th>
							</tr>";
						$i=0;
						while($row=mysqli_fetch_array($qry))
						{
							echo "<tr>
									<td>".++$i."</td>
									<td>".$row['username']."</td>
									<td>".$row['email']."</td>
									<td>".$row['phone']."</td>
									<td>";
										if($row['role']==1){
											echo "Administrator";
										}
										else if($row['role']==2){
											echo "Faculty";
										}
										else
										{
											echo "Student";
										}
									echo "</td><td>";
										if($row['status']==1){
											echo "Active";
										}
										else{
											echo "Inactive";
										}
									echo "</td>";
									?>
									<td>
										<a href="Approve.php?uid=<?php echo $row['uid']?>">
										<input type='button' name='approve' class='approve' value='APPROVE' onclick='return confirm("User will be approved!!!")'/>	
										</a>	
									
										<a href="Reject.php?uid=<?php echo $row['uid']?>">
										<input type='button' name='reject' class='reject' value='REJECT' onclick='return confirm("User will be rejected!!!")'/>
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
	            if($_GET['status']==0)
	            {
	            	$sql="SELECT * FROM users WHERE status=0";
					$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
					$count=mysqli_num_rows($qry);
					if($count>=1)
					{
						echo "<table border='1' cellspacing='0' id='myTable' class='users'>";
						echo "<tr>
								<th>S.N.</th>
								<th>Username</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Role</th>
								<th>Status</th>					
								<th>Action</th>
							</tr>";
						$i=0;
						while($row=mysqli_fetch_array($qry))
						{
							echo "<tr>
									<td>".++$i."</td>
									<td>".$row['username']."</td>
									<td>".$row['email']."</td>
									<td>".$row['phone']."</td>
									<td>";
										if($row['role']==1){
											echo "Administrator";
										}
										else if($row['role']==2){
											echo "Faculty";
										}
										else
										{
											echo "Student";
										}
									echo "</td><td>";
										if($row['status']==1){
											echo "Active";
										}
										else{
											echo "Inactive";
										}
									echo "</td>";
									?>
									<td>
										<a href="Approve.php?uid=<?php echo $row['uid']?>">
										<input type='button' name='approve' class='approve' value='APPROVE' onclick='return confirm("User will be approved!!!")'/>	
										</a>	
									
										<a href="Reject.php?uid=<?php echo $row['uid']?>">
										<input type='button' name='reject' class='reject' value='REJECT' onclick='return confirm("User will be rejected!!!")'/>
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
	        }
	        else
	        {
	           	$sql="SELECT * FROM users ORDER BY uid DESC";
				$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
				$count=mysqli_num_rows($qry);
				if($count>=1)
				{
					echo "<table border='1' cellspacing='0' id='myTable' class='users'>";
					echo "<tr>
							<th>S.N.</th>
							<th>Username</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Role</th>
							<th>Status</th>										
							<th>Action</th>
						</tr>";
					$i=0;
					while($row=mysqli_fetch_array($qry))
					{
						echo "<tr>
								<td>".++$i."</td>
								<td>".$row['username']."</td>
								<td>".$row['email']."</td>
								<td>".$row['phone']."</td>
								<td>";
									if($row['role']==1){
										echo "Administrator";
									}
									else if($row['role']==2){
										echo "Faculty";
									}
									else
									{
										echo "Student";
									}
								echo "</td><td>";
									if($row['status']==1){
										echo "Active";
									}
									else{
										echo "Inactive";
									}
									echo "</td>";
								?>
								<td>
									<a href="Approve.php?uid=<?php echo $row['uid']?>">
									<input type='button' name='approve' class='approve' value='APPROVE' onclick='return confirm("User will be approved!!!")'/>	
									</a>	
									
									<a href="Reject.php?uid=<?php echo $row['uid']?>">
										<input type='button' name='reject' class='reject' value='REJECT' onclick='return confirm("User will be rejected!!!")'/>
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
