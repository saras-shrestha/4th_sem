 <?php  
	if(isset($_POST['submit']))
	{
		$selector = bin2hex(random_bytes(8));
		$token = random_bytes(32);
		$uemail=$_POST['email'];
		//sql statement
		$sql="SELECT * from users WHERE email='".$uemail."'";

		//Database Connection
		include_once('includes/connection.php');

		$query=mysqli_query($conn, $sql) or die (mysqli_error($conn));
		$count = mysqli_num_rows($query);
		if($count==1)
		{
			$row=mysqli_fetch_array($query);
			$username= $row['username'];
			$subject = "Reset Password";
			$body = "HI, $username.Click here to activate your account http://localhost/ClassScheduleManagementSystem/password_recover.php?email=$uemail";
			$sender_email = "From: shrestha.saraswoti995@gmail.com";
			if(mail($uemail, $subject, $body, $sender_email))
			{
				header('location:index.php?msg=check your mail to reset your password');
			}
			else
			{				
				echo "<script>alert('Email sending failed...')</script>";
			}
		}
		else
		{
			echo "<script>alert('No email found')</script>";
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
		<form action="" method="POST" class="send-mail">
			<div class="heading">
				<h2>Reset  your Password</h2>
			</div>
			<div class="box">					
					<div class="inner-box">
						<label for="email">Email</label>
						<input type="Email" name="email" id="email"/>
						<div></div>
					</div>
					<br/>
					<div class="inner-box">
						<input type="submit" name="submit" value="Send Mail"/>
					</div>
			</div>
		</form>
	</div>
</body>
</html>
