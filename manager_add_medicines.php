		<!-- PHP CODE STARTS FROM HERE -->
<?php
		session_start();
		include_once('connect_db.php');
		if(isset($_SESSION['manager_id']))
		{
			$id=$_SESSION['manager_id'];
			$first_name=$_SESSION['first_name'];
			$last_name=$_SESSION['last_name'];
		}
		else
		{
			header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
			exit();
		}
		if(isset($_POST['submit']))
		{
			if($_FILES['csvfile']['name'])
	 		{
	  			$filename = explode(".", $_FILES['csvfile']['name']);
	  			if(end($filename) == "csv")
	  			{
				   	$handle = fopen($_FILES['csvfile']['tmp_name'], "r");
				   	if(!$handle) 
				   	{
					    echo '<script type="text/javascript">
								alert("Cannot be able to read CSV File\nPlease Try Again...");
								window.location.href = "manager_add_medicines.php";
							   </script>';
					    exit();
					}
				   	$count = 0;
				   	$successMsg="";
    				$errorMsg="";
				   	while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				   	{
				   		$count++;
    					if ($count == 1) { continue; }
				    	$fileName = $_FILES["csvfile"]["tmp_name"];
				    	
			            $med_id = "";
			            if (isset($data[0])) 
			            {
			                $med_id = mysqli_real_escape_string($con, $data[0]);
			            }
			            $med_name = "";
			            if (isset($data[1])) 
			            {
			                $med_name = mysqli_real_escape_string($con, $data[1]);
			            }
			            $quantity = "";
			            if (isset($data[2])) 
			            {
			                $quantity = mysqli_real_escape_string($con, $data[2]);
			            }
			            $unit_price = "";
			            if (isset($data[3])) 
			            {
			                $unit_price = mysqli_real_escape_string($con, $data[3]);
			            }
			            $expiry_date = "";
			            if (isset($data[4])) 
			            {
			                $expiry_date = mysqli_real_escape_string($con, $data[4]);
			            }
			            $med_status = "";
			            if (isset($data[5])) 
			            {
			                $med_status = mysqli_real_escape_string($con, $data[5]);
			            }
			            
			            // Checking if Medicine name already exists 
						$sql12=mysqli_query($con,"SELECT * FROM medicine WHERE medicine_name='$med_name'")or die(mysqli_error());
			 			$result12=mysqli_fetch_array($sql12);
			 			if($result12>0)
			 			{
			 				$errorMsg = $errorMsg."\\nThe Medicine Name Entered \'".$med_name."\' Already Exists, You can Update the Medicine Instead...";
							$errorMsg = nl2br($errorMsg,false);
							continue;
			 			}
			            // $sql = "INSERT INTO medicine (medicine_id, medicine_name, quantity, unit_price, expiry_date, medicine_status) VALUES ('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]')";
			                
    					$sql="INSERT INTO medicine (medicine_id, medicine_name, quantity, unit_price, expiry_date, medicine_status) VALUES ('$med_id', '$med_name', '$quantity', '$unit_price',  DATE '$expiry_date', '$med_status')";
    				
    					
						if(mysqli_query($con,$sql)) 
						{
							$successMsg = $successMsg." '".$med_name."',";
						}
						else
						{
							$error=mysqli_error($con);
							$errorMsg = $errorMsg."\\nMedicine \'".$med_name."\' is not inserted - ERROR : ".$error;
							$errorMsg = nl2br($errorMsg,false);
						}
				   	}
				   	fclose($handle);
				   	if($successMsg!="" && $errorMsg!="")
				   	{
					   	echo '<script type="text/javascript">
								var m;        
								m = "'.$successMsg.'";
								var e;        
								e = "'.$errorMsg.'";
								alert("New Medicines :"+m+" have been Inserted Successfully ! \nERROR in Inserting Medicines :"+e);
								window.location.href = "manager_add_medicines.php";
							  </script>';
					}
					if($successMsg!="" && $errorMsg=="")
				   	{
					   	echo '<script type="text/javascript">
								var m;        
								m = "'.$successMsg.'";
								alert("New Medicines :"+m+" have been Inserted Successfully !");
								window.location.href = "manager_add_medicines.php";
							  </script>';
					}
					if($successMsg=="" && $errorMsg!="")
				   	{
					   	echo '<script type="text/javascript">
								var e;        
								e = "'.$errorMsg.'";
								alert("ERROR in Inserting Medicines :"+e);
								window.location.href = "manager_add_medicines.php";
							  </script>';
					}
				}
				else
			  	{
			   		$message = "PLEASE SELECT A FILE WITH CSV EXTENSION ONLY";
			  	}
			}
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> MANAGER ADD MEDICINES PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/homepagestyle.css">
	<link rel="stylesheet" type="text/css" href="styles/profile.css">
	<link rel="stylesheet" type="text/css" href="styles/uploadfile.css">
	<script type="text/javascript">
		window.onload= startTime;
		function startTime() 
		{
	  		var today = new Date();
	 	 	var h = today.getHours();
	  		var m = today.getMinutes();
	  		var s = today.getSeconds();
  			var ampm = h >= 12 ? 'PM' : 'AM';
		   	if (h > 12) 
		   	{
		        h -= 12;
		   	} 
		   	else if (h === 0) 
		   	{
		        h = 12;
		   	}
	 	 	h = checkTime(h);
	  		m = checkTime(m);
	  		s = checkTime(s);
	  		document.getElementById('txt').innerHTML =
	  		h + ":" + m + ":" + s+'&nbsp;&nbsp;'+ ampm;
	  		var t = setTimeout(startTime, 500);
	  	}
		function checkTime(i) 
		{
	  		if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	  		return i;
		}
	</script>
</head>
<body>
	<!-- THIS IS SESSION INACTIVE MODAL -->
		<?php include_once('session_inactive_modal.php'); ?>
		
	<!-- MAIN CONTENT -->
	<div id="homepage">
		<!-- THIS IS HEADER CONTENT -->
		<?php include_once('header.php'); ?>
		<!-- THIS IS MAIN AREA CONTENT -->
		<div id="mainarea">

				<!-- THIS IS SIDE BAR -->
				<div id="sidebar">
						<center>
						 <a href="manager_profile.php"><img src="images/manager1.png" height="80px" align="center" style="border:3px solid black;border-radius:20px;margin-bottom:3px;">
						 	<br><?php echo 'Welcome, '.$first_name.' '.$last_name ?>
						 </a>
						</center>
						 <a href="manager.php"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="manager_pharmacist.php"><img src="images/pharmacist.png" height="20px" align="center">&nbsp;&nbsp;Manage Pharmacist</a>
						 <a href="manager_cashier.php"><img src="images/cashier.png" height="20px" align="center">&nbsp;&nbsp;Manage Cashier</a>
						 <a href="manager_stocks.php"><img src="images/stocks.png" height="20px" align="center">&nbsp;&nbsp;Stocks</a>
						 <a href="manager_update_stocks.php" class="active"><img src="images/updatestocks.png" height="20px" align="center">&nbsp;&nbsp;Update Stocks</a>
						 <a href="manager_outofstock.php"><img src="images/outofstock.png" height="20px" align="center">&nbsp;&nbsp;Out of Stock</a>
						 <a href="manager_expire.php"><img src="images/expire.png" height="20px" align="center">&nbsp;&nbsp;Expire Soon</a>
						 <a href="manager_salesreport.php"><img src="images/salesreport.png" height="20px" align="center">&nbsp;&nbsp;Sales Report</a>
						 <a onclick="return confirm('Are you sure you want to log out?')" href="logout.php"><img src="images/logout.png" height="20px" align="center">&nbsp;&nbsp;Logout</a>
				</div>

				<!-- THIS IS NAV BAR -->
				<div id="navbar" align="right">
					<?php 
						$date = date('l, F d, Y', time());
					?>
					<div id='datenow'>
						<img src="images/datenow.png" height="20px" align="center">&nbsp;<?php echo $date; ?>&nbsp;
					</div>
					<div id='timenow'>
						<img src="images/timenow.png" height="20px" align="center">&nbsp;<div id="txt"></div>&nbsp;
					</div>
					<a href="manager_profile.php"><img src="images/userprofile.png" height="20px" align="center">&nbsp;&nbsp;User Profile</a>
					<a href="manager_changepass.php"><img src="images/password.png" height="20px" align="center">&nbsp;&nbsp;Change Password</a>
					<a onclick="return confirm('Are you sure you want to log out?')" href="logout.php"><img src="images/logout.png" height="20px" align="center">&nbsp;&nbsp;Logout</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<!-- THIS IS MANAGER MAIN CONTENT -->
				<div id="mainbox" align="center">
					<h4> MANAGER - ADD NEW MEDICINES </h4>
					
				<b id="title1">IMPORT/ ADD MEDICINES THROUGH A CSV FILE</b>
				<br>&nbsp;<br>&nbsp;<br>
				
            	<form name="add_medicines" action="manager_add_medicines.php" method="post" autocomplete="OFF" enctype="multipart/form-data">
                    <span>Select a CSV File : </span> &nbsp;
                    <input type="file" name="csvfile" id="csvfile" class="filebox" accept=".csv" oninvalid="this.setCustomValidity('Please Select a CSV File')" oninput="setCustomValidity('')" required="">&nbsp;&nbsp;&nbsp;
                    
                    <button type="reset" name="reset" class="resetbutton"> <img src="images/reset.png" height="21px" align="center"> </button> <br>&nbsp;<br>&nbsp;&nbsp;
                    <a href="manager_update_stocks.php" class="button">GO BACK</a>
                    <input type="submit" class="button" name="submit" value="ADD MEDICINES">
            	</form><br>

            	<?php 
            		if(isset($message))
            		{
						echo "<b id='nodatafile'>\"".$message."\"</b>";
						echo "<br>&nbsp;<br>";
               		}
               	?>

               	<b id='note'>NOTE :- </b><br>&nbsp;<br>
               	<span id="points">
               		1. File that you will Import/ Upload should be with csv extension.<br>
               		2. First Row of CSV file should consist of Column Names.<br>
               		3. Column Names should be in the following sequence :<br>
               		&nbsp;&nbsp;&nbsp;
               		a) Medicine Id, b) Medicine Name, c) Quantity, d) Unit Price, e) Expiry Date, f) Medicine Status<br>
               		4. Expiry Date Column should be in 'yyyy-mm-dd' format only.<br>
               	</span>
               		
				<br>&nbsp;<br>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>