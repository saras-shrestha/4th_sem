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
	<div class="sidebar">
        <div class="sidebar-header">
        <h2>Class Schedule</h2>
        </div>
        <div class="sidebar-menu">
        <?php include_once('../includes/Student-navbar.php'); ?>
        </div>
    </div>
	<!-- navbar end -->
	<div class="container"> 
    	<!--Start header-->
        <div class="header">
	        <div class="welcome-note">
	            <h3>Student Dashboard</h3>
	        </div>

	        <div class="logout">
	            <a href="../logout.php">LogOut</a>
	        </div>
		</div>
	    <!--End header-->

        <div class="main-content">
          	<div class="dash-cards">
                <!-- card1 start-->
                <div class="dash-single">

                    <div class="card-body">
                        <div>
                            <div><h3>Course</h3></div>

                            <div>
                                <h3>
                                <?php 
                                    $sql="SELECT count(*) AS count FROM courses WHERE semester_id IN (SELECT sem_id FROM semesters WHERE sem_id IN (SELECT semester_id FROM students WHERE user_id IN (SELECT uid FROM users WHERE username='".$_SESSION['username']."')))";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $result=mysqli_fetch_array($qry);
                                    echo $result['count'];
                                ?>
                                </h3>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="student-courses-list.php">View All</a> 
                    </div>
                </div>
                <!-- card1 end -->
                <!-- card2 start -->
                 <div class="dash-single">

                    <div class="card-body">
                        <div>
                            <div><h3>Faculty</h3></div>

                            <div>
                                <h3>
                                <?php 
                                    $sql="SELECT count(*) AS count FROM schedules WHERE status=1 && semester_id IN (SELECT semester_id FROM students WHERE user_id IN (SELECT uid FROM users WHERE username='".$_SESSION['username']."'))";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $result=mysqli_fetch_array($qry);
                                    echo $result['count'];
                                ?>
                                </h3>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="sem_faculty.php">View All</a> 
                    </div>
                </div>
                <!-- card2 end -->               

            </div>
	    </div>
    </div>	
</body>
</html>
