		<!-- PHP CODE STARTS FROM HERE -->
<?php
		session_start();
		include_once('connect_db.php');
		if(isset($_SESSION['pharmacist_id']))
		{
			$id=$_SESSION['pharmacist_id'];
			$first_name=$_SESSION['first_name'];
			$last_name=$_SESSION['last_name'];
		}
		else
		{
			header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
			exit();
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> PHARMACIST MANAGE PRESCRIPTION PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/homepagestyle.css">
	<link rel="stylesheet" type="text/css" href="styles/manage.css">
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
						 <a href="pharmacist_profile.php"><img src="images/pharmacist1.png" height="80px" align="center" style="border:3px solid black;border-radius:20px;margin-bottom:3px;">
						 	<br><?php echo 'Welcome, '.$first_name.' '.$last_name ?>
						 </a>
						</center>
						 <a href="pharmacist.php"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="pharmacist_stocks.php"><img src="images/stocks.png" height="20px" align="center">&nbsp;&nbsp;Stocks</a>
						 <a href="pharmacist_update_stocks.php"><img src="images/updatestocks.png" height="20px" align="center">&nbsp;&nbsp;Update Stocks</a>
						 <a href="pharmacist_search_medicines.php"><img src="images/search.png" height="20px" align="center">&nbsp;&nbsp;Search Medicines</a>
						 <a href="pharmacist_generate_prescription.php"><img src="images/prescription.png" height="20px" align="center">&nbsp;&nbsp;Generate Prescription</a>
						 <a href="pharmacist_manage_prescription.php" class="active"><img src="images/manage_pres.png" height="20px" align="center">&nbsp;&nbsp;Manage Prescription</a>
						 <a href="pharmacist_outofstock.php"><img src="images/outofstock.png" height="20px" align="center">&nbsp;&nbsp;Out of Stock</a>
						 <a href="pharmacist_expire.php"><img src="images/expire.png" height="20px" align="center">&nbsp;&nbsp;Expire Soon</a>
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
					<a href="pharmacist_profile.php"><img src="images/userprofile.png" height="20px" align="center">&nbsp;&nbsp;User Profile</a>
					<a href="pharmacist_changepass.php"><img src="images/password.png" height="20px" align="center">&nbsp;&nbsp;Change Password</a>
					<a onclick="return confirm('Are you sure you want to log out?')" href="logout.php"><img src="images/logout.png" height="20px" align="center">&nbsp;&nbsp;Logout</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<!-- THIS IS PHARMACIST MAIN CONTENT -->
				<div id="mainbox" align="center">
					<h4> PHARMACIST - MANAGE PRESCRIPTION </h4>
					
					 <?php
					 	$result = mysqli_query($con,"SELECT pres_id, invoice_no, customer_name, phone ,DATE_FORMAT(date, '%d-%m-%Y') as date FROM prescription") or die(mysqli_error());
						$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<table>";
				        echo "<tr> 
				        		<th>ID</th>
				        		<th>Invoice No.</th>
				        		<th>Customer Name</th>
				        		<th>Mobile No.</th>
				        		<th>Date</th>
				        		<th>Update/ Delete</th>
				        	   </tr>";

				       $result = mysqli_query($con,"SELECT pres_id, invoice_no, customer_name, phone ,DATE_FORMAT(date, '%d-%m-%Y') as date FROM prescription ORDER BY DATE(date) DESC") or die(mysqli_error());
				        // loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['pres_id'] . '</td>';
				                echo '<td>' . $row['invoice_no'] . '</td>';
				                echo '<td>' . $row['customer_name'] . '</td>';
								echo '<td>' . $row['phone'] . '</td>';
								echo '<td>' . $row['date'] . '</td>';
				        		?>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="pharmacist_update_pres.php?pres_id=<?php echo $row['pres_id']?>"><img src="images/update-icon.png" width="35" height="35"/></a> 
									&nbsp;&nbsp;
									<a onclick="return confirm('Are you sure you want to delete Prescription of \'<?php echo $row['customer_name'] ?>\' with ID : \'<?php echo $row['pres_id'] ?>\' ?')" href="pharmacist_delete_pres.php?pres_id=<?php echo $row['pres_id']?>"><img src="images/delete-icon.png" width="35px" height="35px"/></a>
								</td>
								</tr>
								<?php
						 }
				        // close table>
				        echo "</table>";
				    	}
				    	else
				    	{
				    		echo"<br><br> <b id='nodatastocks'> \"NO PRESCRIPTIONS GENERATED\" </b><br><br><br>";
						}
				?>
				<br>
				<a href="pharmacist_generate_prescription.php" class="button"> GENERATE NEW PRESCRIPTION</a>
				<br>&nbsp;<br>&nbsp;
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>