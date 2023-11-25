<?php 
require_once('../Session/sessioncheck.php');
include('../includes/connection.php');
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <!--start title-->
    <?php   include_once('../includes/title.php'); ?>
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
                <h3>Dashboard</h3>
            </div>

            <div class="logout">
                <a href="../logout.php">LogOut</a>
            </div>
        </div>
	    <!--End header-->

        <div class="main-content">

            <h2 class="dash-title">Overview</h2>

            <div class="dash-cards">

            <!-- for faculty -->
                <div class="dash-single">
                    <div class="card-body">
                        <div>
                            <div><h3>Faculty</h3></div>
                            <div>
                                <h3>
                                <?php 
                                    $sql="SELECT * FROM faculty";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $count=mysqli_num_rows($qry);
                                    echo $count;
                                ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="Faculty.php">View All</a> 
                    </div>
                </div>
                <!-- for students -->
                <div class="dash-single">
                    <div class="card-body">
                        <div>
                            <div><h3>Student</h3></div>
                            <div>
                            <h3>
                                <?php 
                                    $sql="SELECT * FROM students";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $count=mysqli_num_rows($qry);
                                    echo $count;
                                ?>
                            </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="Students.php">View All</a>
                    </div>
                </div>

                <!-- for courses -->
                <div class="dash-single">
                    <div class="card-body">
                        <div>
                            <div><h3>Course</h3></div>
                            <div>
                            <h3>
                                <?php 
                                    $sql="SELECT * FROM courses";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $count=mysqli_num_rows($qry);
                                    echo $count;
                                ?>
                            </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="courses-list.php">View All</a>
                    </div>
                </div>
                <!-- for new preferences -->
                <div class="dash-single">
                    <div class="card-body">
                        <div>
                            <div><h3>New Preferences</h3></div>
                            <div>
                            <h3>
                                <?php 
                                    $sql="SELECT * FROM preferences WHERE status='0'";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $count=mysqli_num_rows($qry);
                                    echo $count;
                                ?>
                            </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="Preferences.php">View All</a>
                    </div>
                </div>

                <!-- for new users -->
                <div class="dash-single">
                    <div class="card-body">
                        <div>
                            <div><h3>Inactive User</h3></div>
                            <div>
                            <h3>
                                <?php 
                                    $sql="SELECT * FROM users WHERE status='0'";
                                    $qry=mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                    $count=mysqli_num_rows($qry);
                                    echo $count;
                                ?>
                            </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="users.php?status=0">View All</a>
                    </div>
                </div>

        </div>

    </div>
</body>
</html>