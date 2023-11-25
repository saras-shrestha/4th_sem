<?php require_once('../Session/sessioncheck.php'); ?>
<?php 
include('../includes/connection.php');
 ?>
<!DOCTYPE html>
<html>
<head> 
	<!--start title-->
	   <?php include_once('../includes/title.php'); ?>
	<!--end title-->
	<link href="../css/admin.css" rel="stylesheet" type="text/css">	
</head>
<body>  

	<!-- navbar start -->
    <?php include_once('../includes/Faculty-navbar.php'); ?>
    <!-- navbar end-->

	<div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Dashboard</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
        
        	<div class="dash-cards">
                <!-- loads -->
                <div class="dash-single">
                    <div class="card-body">
                        <div>
                            <div><h3>Load</h3></div>
                            <div>
                                <h3>
                                <?php 
                                    $sql="SELECT loads FROM faculty WHERE fid='".$_SESSION['fid']."'";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $result=mysqli_fetch_array($qry);
                                    echo $result['loads'];
                                ?>
                                </h3>
                            </div> 
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="faculty_loads.php">View All</a> 
                    </div>
                </div>
                <!-- end loads -->
                <!-- new preferences -->
                 <div class="dash-single">
                    <div class="card-body">
                        <div>
                            <div><h3>New Preferences</h3></div>
                            <div>
                                <h3>
                                <?php 
                                    $sql="SELECT schedules.semester_id FROM schedules WHERE faculty_id='".$_SESSION['fid']."' EXCEPT SELECT preferences.semester_id FROM preferences WHERE faculty_id='".$_SESSION['fid']."'";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $count=mysqli_num_rows($qry);
                                    echo $count;
                                ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="preferences.php">View All</a> 
                    </div>
                </div>
                 <!-- end new preferences -->
            </div>
     
        </div>
    </div>	
</body>
</html>
