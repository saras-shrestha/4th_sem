<!DOCTYPE html>
<html>
	<!--start title-->
     <?php 	include_once('includes/title.html'); ?>
	<!--end title-->

<body> 
	<!---->
	<!--Start header-->
	<?php include_once('includes/header.php'); ?>
	<!--End header-->
	 
    <div class="wrapper">
    	<div class="row">
    		<!--Start side menu-->
	    	<?php include_once('includes/nav.php'); ?>
	    	<!--End side menu-->

	    	<div class="main-content">
	    		<div class="assignFaculty">
					<h2>Assign Faculty</h2><br/>
					<form method="post" action="" name="">	
						<div>	
							<label>Faculty</label>
							<select name="fid">
								<option>Select Faculty</option>
								<?php
									include('includes/connection.php');
									$sql="SELECT * FROM faculty";
									//DB CONNECTION
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
									$count=mysqli_num_rows($qry);
									if($count>=1)
									{
										 $mystring = '<option selected disabled>Select Faculty</option>';
										while($row=mysqli_fetch_array($qry))
										{
											$mystring .= "<option size='30px ' value='". $row['fid'] ."'>" . $row['name'] ." [". $row['fid'] ."] </option>";
										}
										echo $mystring;
									}
					 			?>			
							</select>
				        </div> 
				        <div>
							<label>Course</label>
							<select name="course">
								<?php
									include('connection.php');
									$sql="SELECT * FROM course";
									//DB CONNECTION
									$qry=mysqli_query($conn, $sql) or die (mysqli_error($conn));
									$count=mysqli_num_rows($qry);
									if($count>=1)
									{
										 $mystring = '<option selected disabled>Select Course</option>';
										while($row=mysqli_fetch_array($qry))
										{
											$mystring .= "<option size='30px' value='".$row['fid']."'>".$row['name']."[".$row['fid']."] </option>";
										}
										echo $mystring;
									}
					 			?>	
					 			</select>		
				        </div>  
				        <div>    
							<input type="submit" name="assign" value="Assign">
						</div>
					</form>
				</div>

				<div class="display">
                 <!--  //php retrive-->
				</div>
	    	</div>
	    </div>
    </div>

	<!--Start footer-->
	<?php include_once('includes/footer.php'); ?>
	<!--End footer-->
</body>
</html>