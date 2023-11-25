<?php  
	if(isset($_POST['submit']))
	{
		if(isset($_GET['email']))
		{
			$email=$_GET['email'];
		
			$upass=$_POST['password'];
			$cpass=$_POST['repassword'];
			if($upass==$cpass)
			{
				//sql statement
				$sql="UPDATE users SET password='$upass' WHERE email='".$email."'";

				//Database Connection
				include_once('includes/connection.php');

				$query=mysqli_query($conn, $sql) or die (mysqli_error($conn));

				if($query)
				{
					header("Location:index.php?msg=Your password is successfully updated");
				}
			}
		}
	}
?>
 
<!DOCTYPE html>
<html>
<head>
	<!--start title-->
	<?php include_once('includes/title.php'); ?>
	<!--end title-->
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="main-box">
		<form action="" method="POST" class="login-register">
			<div class="heading">
				<h2>Register Here</h2>
			</div>
			<div class="box">					
					<div class="inner-box">
						<label for="pass">Password</label>
						<input type="password" name="password" id="pass"/>
						<div></div>
					</div>
					<br/>
					<div class="inner-box">
						<label for="cpass">Confirm Password</label>
						<input type="password" name="repassword" id="cpass"/>
						<div></div>
					</div>					
					<br/>
					<div class="inner-box">
						<input type="submit" name="submit" value="Update Password"/>
					</div>
			</div>
		</form>
	</div>
</body>
</html>
