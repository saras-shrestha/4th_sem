<?php  
	include('../includes/connection.php');

	//creating user table
	$sql = "CREATE TABLE IF NOT EXISTS users(
	uid int PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(55) NOT NULL UNIQUE,
	password VARCHAR(55) NOT NULL,
	email VARCHAR(55) NOT NULL UNIQUE,
	phone VARCHAR(10),
	role int(2) NOT NULL,
	created_at DATETIME,
	updated_at DATETIME,
	status tinyint(1) NOT NULL 
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "users table created successfully";
	}
	echo "<br/>";
	
	//creating semesters table
	$sql = "CREATE TABLE IF NOT EXISTS semesters(
	sem_id int PRIMARY KEY AUTO_INCREMENT,
	sem_name VARCHAR(55) NOT NULL UNIQUE,	
	created_at DATE,
	updated_at DATE,
	status tinyint(1) NOT NULL 
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "semesters table created successfully";
	}
	echo "<br/>";

	//creating administrators table
	$sql = "CREATE TABLE IF NOT EXISTS administrators(
	aid int PRIMARY KEY AUTO_INCREMENT,
	aname VARCHAR(55) NOT NULL,
	profile_image VARCHAR(55),
	user_id INT,
	FOREIGN KEY (user_id) REFERENCES users(uid)
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "administrators table created successfully";
	}
	echo "<br/>";

	//creating faculty table
	$sql = "CREATE TABLE IF NOT EXISTS faculty(
	fid VARCHAR(20) PRIMARY KEY,
	fname VARCHAR(55) NOT NULL,
	loads INT DEFAULT 0,
	profile_image VARCHAR(55),
	user_id INT,
	FOREIGN KEY (user_id) REFERENCES users(uid)
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "faculty table created successfully";
	}
	echo "<br/>";

	//creating students table
	$sql = "CREATE TABLE IF NOT EXISTS students(
	stu_id int PRIMARY KEY AUTO_INCREMENT,
	stu_name VARCHAR(55) NOT NULL,	
	semester_id int NOT NULL, 
	profile_image VARCHAR(55),
	user_id INT ,
	FOREIGN KEY (user_id) REFERENCES users(uid),
	FOREIGN KEY (semester_id) REFERENCES semesters(sem_id)
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "students table created successfully";
	}
	echo "<br/>";

	//creating courses table
	$sql = "CREATE TABLE IF NOT EXISTS courses(
	code VARCHAR(20) PRIMARY KEY,
	course_name VARCHAR(55) NOT NULL,
	semester_id INT NOT NULL,
	created_at DATE,
	updated_at DATE,	
	status tinyint(1) NOT NULL,
	FOREIGN KEY (semester_id) REFERENCES semesters(sem_id)
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "courses table created successfully";
	}
	echo "<br/>";

	//creating timeslots table
	$sql = "CREATE TABLE IF NOT EXISTS timeslots(
	tid int PRIMARY KEY AUTO_INCREMENT,
	start_time time NOT NULL UNIQUE,
	end_time time NOT NULL UNIQUE,	
	created_at DATE,
	updated_at DATE,
	status tinyint(1) NOT NULL 
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "timeslots table created successfully";
	}
	echo "<br/>";

	//creating preferences table
	$sql = "CREATE TABLE IF NOT EXISTS preferences(
	pid int PRIMARY KEY AUTO_INCREMENT,
	faculty_id VARCHAR(20) NOT NULL,
	semester_id int NOT NULL,
	time_id int NOT NULL,
	status tinyint(1) NOT NULL,
	FOREIGN KEY (faculty_id) REFERENCES faculty(fid),
	FOREIGN KEY (semester_id) REFERENCES semesters(sem_id), 
	FOREIGN KEY (time_id) REFERENCES timeslots(tid)	
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "preferences table created successfully";
	}
	echo "<br/>";

	//creating schedules table
	$sql = "CREATE TABLE IF NOT EXISTS schedules(
	sid int PRIMARY KEY AUTO_INCREMENT,
	faculty_id VARCHAR(20) NOT NULL,
	semester_id int NOT NULL,
	course_code VARCHAR(20) NOT NULL, 
	start_time time DEFAULT '00:00:00',
	end_time time DEFAULT '00:00:00',
	description TEXT,
	status tinyint(1),
	created_at DATE,
	updated_at DATE,
	FOREIGN KEY (faculty_id) REFERENCES faculty(fid),
	FOREIGN KEY (semester_id) REFERENCES semesters(sem_id), 
	FOREIGN KEY (course_code) REFERENCES courses(code)
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "schedules table created successfully";
	}

	//creating schedules table
	/*$sql = "CREATE TABLE IF NOT EXISTS schedules(
	sid int PRIMARY KEY AUTO_INCREMENT,
	faculty_id VARCHAR(20) NOT NULL,
	semester_id int NOT NULL,
	course_code VARCHAR(20) NOT NULL, 
	timeslot VARCHAR(55) DEFAULT '- - -',zz
	description TEXT,
	status tinyint(1),
	created_at DATE,
	updated_at DATE,
	FOREIGN KEY (faculty_id) REFERENCES faculty(fid),
	FOREIGN KEY (semester_id) REFERENCES semesters(sem_id), 
	FOREIGN KEY (course_code) REFERENCES courses(code)
	)";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "schedules table created successfully";
	}*/




	//trigger for loads in faculty
/*
	$sql="CREATE TRIGGER Faculty_Load_increase AFTER INSERT ON schedules 
	FOR EACH ROW
	UPDATE faculty
	SET loads=loads+1
	WHERE fid=new.faculty_id";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "trigger Faculty_Load_increase created successfully";
	}*/

	/*$sql="CREATE TRIGGER Faculty_Load_decrease After DELETE ON schedules
	FOR EACH ROW 
	UPDATE faculty SET loads=loads-1
	WHERE fid=old.faculty_id;";
	$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	if($qry)
	{
		echo "trigger Faculty_Load_decrease created successfully";
	}*/

	//trigger for preferences 
	/*"CREATE TRIGGER Faculty_Preference_DELETE AFTER DELETE ON schedules
	FOR EACH ROW 
	DELETE FROM preferences
	WHERE faculty_id=old.faculty_id AND semester_id=old.semester_id";*/
	

	mysqli_close($conn);
?>
