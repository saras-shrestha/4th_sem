<?php 
include('../includes/connection.php');
$sem= $_GET['sem_id'];
$sql="SELECT * FROM courses WHERE semester_id=$sem AND status=1";
$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
$count=mysqli_num_rows($qry);
$mystring = '<option selected disabled>Select Course</option>';
if($count>=1)
{
	while($row=mysqli_fetch_array($qry))
	{
		$mystring .= "<option size='30px ' value='". $row['code'] ."'>" . $row['course_name'] ." [". $row['code'] ."] </option>";
	}
}
echo $mystring;
?>
