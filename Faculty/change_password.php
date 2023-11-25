<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
 ?>
  <?php 
 //update process
 	$opassErr=$npassErr = $cpassErr = "";
	$old_pass = $new_pass = $confirm_pass = ""; 
	if(isset($_POST['submit']))
	{
		//old password
		if (empty($_POST["old_pass"])) 
		{
		    $opassErr = "*Old Password is required";
		} 
		else
		{
			$old_pass=$_POST['old_pass'];
		}
		//new password
		if (empty($_POST["new_pass"])) 
		{
		    $npassErr = "*New Password is required";
		} 
		else if(!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%\*\$\-]{8,24}$/", $_POST['new_pass']))
		{
		    $npassErr="*atleast one uppercase, <br/>*atleast one lowercase, <br/>*atleast one digits <br/>*may include special character _ # @ % * $ -<br/>*minimum 8 charactes<br/> *maximum 25 characters";    
		}
		else
		{
			$new_pass=$_POST['new_pass'];
		}
		//confirm password
		if (empty($_POST["con_pass"])) 
		{
		    $cpassErr = "*Confirm your password";
		} 
		else if($new_pass!=$_POST['con_pass'])
		{
			$cpassErr = "*password did not match";
		}
		else
		{
			$confirm_pass=$_POST['con_pass'];
		}
		/*$old_pass=$_POST['old_pass'];
		$new_pass=$_POST['new_pass'];
		$confirm_pass=$_POST['con_pass'];*/

		/*if(!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass))*/
		if($old_pass && $new_pass && $confirm_pass)
		{
			$sql_stat="SELECT password FROM users WHERE username='".$_SESSION['username']."'";
			$query=mysqli_query($conn,$sql_stat) or die (mysqli_error($conn));
			$row=mysqli_fetch_array($query);
			$count=mysqli_num_rows($query);
			if($count==1)
			{
				if($old_pass==$row['password'])
				{
					if($new_pass==$confirm_pass)
					{
						$sql="UPDATE users SET password='$new_pass' WHERE username='".$_SESSION['username']."'";
						$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));	
						if($qry)
						{
							header("Location:profile.php?msg=Your password is changed.");
						}
					}
					else
					{
						echo "<script>document.getElementById('conErr').innerHTML='**Password did not match**';</script>";
					}				
				}
				else
				{
					echo "<script>document.getElementById('oldErr').innerHTML='**Your old password is incorrect**';</script>";
				}
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
	<style>
		.profile h3{
			text-align: center;
			margin-bottom: 25px;
		}
		table{ 
			margin-left: 40px;
		}
	</style>
</head>
<body>  
	<!-- navbar start -->
        <?php include_once('../includes/Faculty-navbar.php'); ?>
    <!-- navbar end -->

    <div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Profile</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

	    	<div class="main-content">
	    		<div class="profile">
		    		<form method="post" action="">
		    			<table class='change-pass'>
		    				<?php 
		    				$sql="SELECT * FROM users WHERE username='".$_SESSION['username']."'";
							$qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
							$count=mysqli_num_rows($qry);
							$row=mysqli_fetch_array($qry);
							if($count==1)
							{
								echo "<h3>Change Password</h3>";
								echo "<tr>
									<th>Old Password</th>
			    					<td><b>:</b> <input type='password' name='old_pass'/> <br/> <span class='Err' id='oldErr'>$opassErr</span>
			    					<span id='oldErr'></span></td>
									</tr>";
								echo "<tr>
									<th>New Password</th>
			    					<td><b>:</b> <input type='password' name='new_pass'/><br/><span class='Err'>$npassErr</span></td>
									</tr>";
								echo "<tr>
									<th>Confirm Password</th>
			    					<td><b>:</b> <input type='password' name='con_pass'/> <br/> <span class='Err' id='conErr'>$cpassErr</span></td>
									</tr>";
							}
							?>	
							 				
		    				<tr>
		    					<td colspan="2"><input type="submit" name="submit" value="Change"/>
		    					<input type='reset' name='reset' value='CLEAR'/>
		    				</td>
		    				</tr>

		    			</table>	    			
		    		</form>
	    		</div>
	    	</div>
	    </div>
    </div>

</body>
</html>
