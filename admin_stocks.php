		<!-- PHP CODE STARTS FROM HERE -->
<?php
		session_start();
		include_once('connect_db.php');
		if(isset($_SESSION['admin_id']))
		{
			$id=$_SESSION['admin_id'];
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
	<title> ADMIN VIEW STOCKS PAGE </title>
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
						 <a href="admin_profile.php"><img src="images/admin.png" height="80px" align="center" style="border:3px solid black;border-radius:20px;margin-bottom:3px;">
						 	<br><?php echo 'Welcome, '.$first_name.' '.$last_name ?>
						 </a>
						</center>
						 <a href="admin.php"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="admin_manager.php"><img src="images/manager.png" height="20px" align="center">&nbsp;&nbsp;Manage Manager</a>
						 <a href="admin_pharmacist.php"><img src="images/pharmacist.png" height="20px" align="center">&nbsp;&nbsp;Manage Pharmacist</a>
						 <a href="admin_cashier.php"><img src="images/cashier.png" height="20px" align="center">&nbsp;&nbsp;Manage Cashier</a>
						 <a href="admin_stocks.php" class="active"><img src="images/stocks.png" height="20px" align="center">&nbsp;&nbsp;Stocks</a>
						 <a href="admin_outofstock.php"><img src="images/outofstock.png" height="20px" align="center">&nbsp;&nbsp;Out of Stock</a>
						 <a href="admin_expire.php"><img src="images/expire.png" height="20px" align="center">&nbsp;&nbsp;Expire Soon</a>
						 <a href="admin_salesreport.php"><img src="images/salesreport.png" height="20px" align="center">&nbsp;&nbsp;Sales Report</a>
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
					<a href="admin_profile.php"><img src="images/userprofile.png" height="20px" align="center">&nbsp;&nbsp;User Profile</a>
					<a href="admin_changepass.php"><img src="images/password.png" height="20px" align="center">&nbsp;&nbsp;Change Password</a>
					<a onclick="return confirm('Are you sure you want to log out?')" href="logout.php"><img src="images/logout.png" height="20px" align="center">&nbsp;&nbsp;Logout</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<!-- THIS IS ADMIN MAIN CONTENT -->
				<div id="mainbox" align="center">
					<h4> ADMIN - MANAGE STOCKS </h4>
					
					 <?php
					 	$result = mysqli_query($con,"SELECT medicine_id, medicine_name, quantity, unit_price, DATE_FORMAT(expiry_date, '%d-%m-%Y') as expiry_date, medicine_status FROM medicine") or die(mysqli_error());
						$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<table>";
				        echo "<tr> 
				        		<th>ID</th>
				        		<th>Medicine name </th>
				        		<th>Quantity </th> 
				        		<th>Unit price </th>
				        		<th>Expiry date </th>
				        		<th>Medicine status </th>
				        		<th>Update/ Delete</th>
				        	   </tr>";

				        $result = mysqli_query($con,"SELECT medicine_id, medicine_name, quantity, unit_price, DATE_FORMAT(expiry_date, '%d-%m-%Y') as expiry_date, medicine_status FROM medicine") or die(mysqli_error());
				        // loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['medicine_id'] . '</td>';
				                echo '<td>' . $row['medicine_name'] . '</td>';
				                echo '<td>' . $row['quantity'] . '</td>';
								echo '<td>' . $row['unit_price'] . '</td>';
								echo '<td>' . $row['expiry_date'] . '</td>';
								echo '<td>' . $row['medicine_status'] . '</td>';
								?>
								<td>&nbsp;&nbsp;
									<a href="admin_update_medicine.php?medicine_id=<?php echo $row['medicine_id']?>"><img src="images/update-icon.png" width="35" height="35"/></a> 
									&nbsp;&nbsp;
									<a onclick="return confirm('Are you sure you want to delete Medicine : \'<?php echo $row['medicine_name'] ?>\' ?')" href="admin_delete_medicine.php?medicine_id=<?php echo $row['medicine_id']?>"><img src="images/delete-icon.png" width="35" height="35"/></a>
								</td>
								</tr>
								<?php
						 } 
				        // close table>
				        echo "</table>";
				        }
				    	else
				    	{
				    		echo"<br><br> <b id='nodatastocks'> \"NO STOCKS OF MEDICINES\" </b><br><br><br>";
						}
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="admin_add_medicine.php" class="button">ADD NEW MEDICINE</a>

				<a href="admin_add_medicines.php" class="button">ADD MEDICINES THROUGH CSV FILE</a>

				<br>&nbsp;
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>