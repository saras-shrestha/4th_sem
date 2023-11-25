<?php session_start();?>
<?php 
	//for validation
	$unameErr = $passErr = $emailErr = $cpassErr = $phnErr = $roleErr = "";
	$uname = $upass = $cpass = $uemail = $uphone = $urole = ""; 
	if(isset($_POST['submit']))
	{
		//retriving the data from register form
		/*$uname=$_POST['username'];
		$upass=($_POST['password']);
		$cpass=($_POST['repassword']);
		$uemail=$_POST['email'];
		$uphone=($_POST['phone']);
		$urole=$_POST['role'];*/
		$ustatus=0;

		//validation
	   	
	   	//validating username
		if (empty($_POST['username']))
		{
		    $unameErr = "*Username is required";
		} 
		else if(strlen($_POST['username'])<8)
		{
			$unameErr= "*Username must be greater than or equal to 8 characters";
		}
		else if(!preg_match("/^[A-Za-z]+[A-Za-z0-9]*$/", $_POST['username']))
		{
		    $unameErr="*Only Letters and numbers are allowed";    
		}
		else
		{
			$uname=$_POST['username'];
		}
		//validating password
		/*
			Requirements of password validation
			->not empty
			->atleast 8 characters
			->atleast one uppercase,
			->atleast one lowercase, 
			->atleast one digits or 
			->mat include special characters such as @ $ # - * % _ 
		*/ 
		if (empty($_POST["password"])) 
		{
		    $passErr = "*Password is required";
		} 
		else if(!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%\*\$\-]{8,24}$/", $_POST['password']))
		{
		    $passErr="*at least one uppercase, <br/>*at least one lowercase, <br/>*at least one digits <br/>*may include special character _ # @ % * $ -<br/>*minimum 8 charactres<br/> *maximum 25 characters";    
		}
		else
		{
			$upass=$_POST['password'];
		}
		//confirm password
		if (empty($_POST["repassword"])) 
		{
		    $cpassErr = "*Confirm your password";
		} 
		else if($upass!=$_POST['repassword'])
		{
			$cpassErr = "*password did not match";
		}
		else
		{
			$cpass=$_POST['repassword'];
		}

		//email validation
		if(empty($_POST['email'])) 
		{
	    	$emailErr = "*Email is required";
	  	}

		else if(!preg_match("/[A-Za-z0-9_]+[@][a-z]+[\.][a-z]+/",$_POST["email"]))
		{
			$emailErr= "*Please enter a valid email address";
		}
		else 
		{
		    $uemail=$_POST['email'];
		}
		//phone validation
		if(empty($_POST['phone'])) 
		{
	    	$phnErr = "*Phone no  is required";
	  	}

		/*else if(!preg_match("/[9][0-9]{9}+/",$_POST["phone"]))*/
		else if(!preg_match("/^[9]\d{9}$/",$_POST['phone']))
		{
			$phnErr= "*Please enter a valid 10 digit mobile number";
		}
		else 
		{
		    $uphone=$_POST['phone'];
		}
		//role validation
		if (empty($_POST["role"])) 
		{
			$roleErr = "**Role is required**";
		}
		else
		{
			$urole=$_POST['role'];
		}

		//if not error
		if($uname && $upass && $cpass && $uemail && $uphone && $urole)
		{
			$created_at=date('Y-m-d H:i:s');		
			//sql statement 
			$sql="INSERT INTO users(`username`,`password`,`email`,`phone`,`role`,`status`,`created_at`) VALUES('$uname','$upass','$uemail','$uphone','$urole', '$ustatus','$created_at')";

			//Database Connection
			include_once('includes/connection.php');

			$query=mysqli_query($conn, $sql) or die (mysqli_error($conn));

			if($query)
			{
				$_SESSION['username']=$uname;
				$sql_stat="SELECT * FROM users WHERE username='".$uname."'";

				$qry=mysqli_query($conn, $sql_stat) or die(mysqli_error($conn));

				$count = mysqli_num_rows($qry);
				if($count==1)
				{
					$row=mysqli_fetch_array($qry);
					echo $row['role'];
					if($row['role']==1)
					{
						header("Location:index.php?msg=$uname is registered successfully");
					}
					else if($row['role']==2)
					{
						header("Location:index.php?msg=$uname is registered successfully");
					}
					else
					{
						header("Location:index.php?msg=$uname is registered successfully");
					}
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
						<label for="uname">User Name</label>
						<input type="text" name="username" id="uname"/>
						<div class='Err'><?php echo $unameErr;?></div>
					</div>
					<br/>

					<div class="inner-box">
						<label for="pass">Password</label>
						<input type="password" name="password" id="pass"/>
						<div class='Err'><?php echo $passErr;?></div>
					</div>
					<br/>

					<div class="inner-box"> 
						<label for="cpass">Confirm Password</label>
						<input type="password" name="repassword" id="cpass"/>
						<div class='Err'><?php echo $cpassErr;?></div>
					</div>
					<br/>

					<div class="inner-box">
						<label for="email">Email</label>
						<input type="Email" name="email" id="email"/>
						<div class='Err'><?php echo $emailErr;?></div>
					</div>
					<br/>

					<div class="inner-box">
						<label for="phone-no">Phone Number</label>
						<input type="text" name="phone" id="phone-no"/>
						<div class='Err'><?php echo $phnErr;?></div>
					</div>
					<br/>

					<div class="inner-box">
						<label for="utype">User Type</label>
						<select name="role" id="utype">
							<option value="" selected disabled>Select User Type</option>
							<option value="1">Administrator</option>
							<option value="2">Faculty</option>
							<option value="3">Student</option>
						</select>
						<div class='Err'><?php echo $roleErr;?></div>
					</div>
					<br/>

					<div class="inner-box">
						<input type="submit" name="submit" value="Register"/><br>
					</div>
					<br/>
					<div>
						<span>Already a member? <a href="index.php">Login</a></span>
					</div>
			</div>
		</form>
	</div>
</body>
</html>
