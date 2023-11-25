<?php session_start();?>
<?php
if(isset($_GET['msg']))
{
	echo "<script>alert ('".$_GET['msg']."');</script>";
} 
?>

<?php 
	$unameErr = $passErr = $roleErr = "";//for validation
	$uname = $upass = $role = "";
    if(isset($_POST['submit']))
	{
	   	//retriving the data from login form
	   	/*$uname=$_POST['username'];
	   	$upass=$_POST['password'];
	   	$role=$_POST['role'];*/

	   	//validation
	   	
	   	//validating username
		if (empty($_POST['username']))
		{
		    $unameErr = "*Username is required";
		} 
		/*else if(strlen($_POST['username'])<8)
		{
			$unameErr= "*Username must be greater than or equal to 8 characters";
		}
		else if(!preg_match("/^[A-Za-z]+[A-Za-z0-9]*$/", $_POST['username']))
		{
		    $unameErr="*Only Letters and numbers are allowed";    
		}*/
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
		/*else if(!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%\*\$\-]{8,24}$/", $_POST['password']))
		{
		    $passErr="*atleast one uppercase, <br/>*atleast one lowercase, <br/>*atleast one digits <br/>*may include special character _ # @ % * $ -<br/>*minimum 8 charactes<br/> *maximum 25 characters";    
		}*/
		else
		{
			$upass=$_POST['password'];
		}
		//role validation
		if (empty($_POST["role"])) 
		{
			$roleErr = "**Role is required**";
		}
		else
		{
			$role=$_POST['role'];
		}

		//if not error
		if($uname && $upass && $role)
		{
			//setting cookies
		   	if(!empty($_POST['remember']))
		    {	
		   	   setcookie('uname',$uname, time()+3600*24*7,"/");
		   	   setcookie('upass',$_POST['password'], time()+3600*24*7,"/");		
		    }

		    //sql statement
		   	$sql="SELECT * FROM users WHERE username='$uname' && password='$upass'";

		   	include_once('includes/connection.php');

		   	$qry=mysqli_query($conn, $sql) or die(mysqli_error($conn));

		   	$count = mysqli_num_rows($qry);
	      	if($count==1)
		   	{
		   		$row=mysqli_fetch_array($qry);

		   		//validating role
		   		if($role==$row['role'])
		   		{
		   			$_SESSION['username']=$uname;
		   			//validating status
		   			if($row['status']==1)
		   			{
		   				//role==1 for administrator
			           	if($role==1)
				   		{
				   			//sql statement to retrive data from administrators table if  user_id is set 
				   			$sql="SELECT * FROM administrators WHERE user_id=".$row['uid'];

				   			$query=mysqli_query($conn, $sql) or die(mysqli_error($conn));

				   			$count = mysqli_num_rows($query);
						    if($count==1)
							{
								while($row=mysqli_fetch_array($query))
							   	{
							   		$_SESSION['admin_id']=$row['aid'];
							   	}
							   	header("Location: Administrator/dashboard.php");
							}

							//if user_id is not set in administrators table 
					   		else
					   		{
					   			header("Location: Administrator/set_admin_profile.php");
					   		}			   		
				   		}

				   		//role==2 for teacher
				   		else if($role==2)
				   		{
				   			//sql statement to retrive data from faculty table if  user_id is set 
				   			$sql="SELECT * FROM faculty WHERE user_id=".$row['uid'];

				   			$query=mysqli_query($conn, $sql) or die(mysqli_error($conn));

				   			$result = mysqli_fetch_array($query);
				   			if($result['fname']=="" && $result['loads']==0)//if faculty has not set profile 
				   			{
				   				header("Location:Faculty/set-profile.php?fid=".$result['fid']);
				   			}
						    else
							{
								$_SESSION['fid']=$result['fid'];
								header("Location: Faculty/dashboard.php");
							}					   					
				   		}

				   		//for student
				   		else
				   		{
				   			//sql statement to retrive data from student table if  user_id is set 
				   			$sql="SELECT * FROM students WHERE user_id=".$row['uid'];

				   			$query=mysqli_query($conn, $sql) or die(mysqli_error($conn));

				   			$count = mysqli_num_rows($query);
						    if($count==1)
							{
								$row=mysqli_fetch_array($query);

								$_SESSION['sem_id']=$row['semester_id'];
								$_SESSION['stu_id']=$row['stu_id'];

								header("Location: Student/dashboard.php");
							}

							//if user_id is not set in student table 
					   		else
					   		{
					   			header("Location:Student/set-profile.php");
					   		}	   	
				   		}
				   	}
				   	else
				   	{
				   		echo "<script>alert('You are not approved by administrator');</script>";
				   	}
		   		}
		   		else
		   		{
		   			echo "<script>alert('Please choose correct user type!');</script>";
		   		}
		   	}
		   	else 
		   	{
		   		echo "<script>alert('Credentials does not match!');</script>";
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
				<h2>Login Here</h2>
			</div> 		
			<div class="box">
				<div class="inner-box">
					<label for="uname" >Username</label><br/>
					<input type="text" name="username" id="uname" value="<?php
					if(isset($_COOKIE['uname']))
					echo $_COOKIE['uname'];?>"/>
					<div class='Err'><?php echo $unameErr; ?></div>	
				</div>
				<br/>
				<div class="inner-box">
					<label for ="pass">Password</label><br/>
					<input type="password" name="password" id="pass" value="<?php if(isset($_COOKIE['upass']))
					echo $_COOKIE['upass']; ?>"/>
					<div class='Err'><?php echo $passErr; ?></div>
				</div>
				<br/>
				<div class="inner-box">
					<label for="utype" >User Type</label><br/>
					<select name="role" id="utype">
						<option value="" selected disabled>Select User Type</option>
						<option value="1">Administrator</option>
						<option value="2">Faculty</option>
						<option value="3">Student</option>
					</select>
					<div class='Err'><?php echo $roleErr; ?></div>
				</div>
				<br/>
				<div class="inner-box" style="font-size:12px;">
					<input type="checkbox" name="remember" value="1" id="rem-me"/>
					<label for="rem-me">Remember Me</label>						
				</div>
				<br/>
				<div class="inner-box" class="submitbtn">
					<input type="submit" name="submit" value="Log in"/>			
				</div>
				<br/>
				<div>
					<span class="forgot"> <a href="send_mail.php"> Forgotten password? </a></span>
					<span style="text-align: center;" > Not a member? <a href="register.php"> Register</a> </span>
				</div>
			</div>
		</form>		
	</div>	
</body>		
</html>

