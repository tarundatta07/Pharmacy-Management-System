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
?>


			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> MANAGER VIEW PHARMACIST PAGE </title>
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
						 <a href="manager_profile.php"><img src="images/manager1.png" height="80px" align="center" style="border:3px solid black;border-radius:20px;margin-bottom:3px;">
						 	<br><?php echo 'Welcome, '.$first_name.' '.$last_name ?>
						 </a>
						</center>
						 <a href="manager.php"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="manager_pharmacist.php" class="active"><img src="images/pharmacist.png" height="20px" align="center">&nbsp;&nbsp;Manage Pharmacist</a>
						 <a href="manager_cashier.php"><img src="images/cashier.png" height="20px" align="center">&nbsp;&nbsp;Manage Cashier</a>
						 <a href="manager_stocks.php"><img src="images/stocks.png" height="20px" align="center">&nbsp;&nbsp;Stocks</a>
						 <a href="manager_update_stocks.php"><img src="images/updatestocks.png" height="20px" align="center">&nbsp;&nbsp;Update Stocks</a>
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
					<h4> MANAGER - MANAGE PHARMACIST </h4>
					
					 <?php
					 	$result = mysqli_query($con,"SELECT * FROM pharmacist") or die(mysqli_error());
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<table>";
				        echo "<tr> 
				        		<th>ID</th>
				        		<th>Username </th>
				        		<th>First name </th> 
				        		<th>Last name </th>
				        		<th>Mobile No. </th>
				        		<th>Email ID </th>
				        		<th>Update/ Delete</th>
				        	   </tr>";

				        $result = mysqli_query($con,"SELECT * FROM pharmacist") or die(mysqli_error());	   
				        // loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['pharmacist_id'] . '</td>';
				                echo '<td>' . $row['username'] . '</td>';
				                echo '<td>' . $row['first_name'] . '</td>';
								echo '<td>' . $row['last_name'] . '</td>';
								echo '<td>' . $row['phone'] . '</td>';
								echo '<td>' . $row['email_id'] . '</td>';
								?>
								<td>&nbsp;&nbsp;
									<a href="manager_update_pharmacist.php?pharmacist_id=<?php echo $row['pharmacist_id']?>"><img src="images/update-icon.png" width="35" height="35"/></a> 
									&nbsp;&nbsp;
									<a onclick="return confirm('Are you sure you want to delete Pharmacist : \'<?php echo $row['first_name'] ?> <?php echo $row['last_name']?>\' ?')" href="manager_delete_pharmacist.php?pharmacist_id=<?php echo $row['pharmacist_id']?>"><img src="images/delete-icon.png" width="35px" height="35px"/></a>
								</td>
								</tr>
								<?php
						 } 
				        // close table>
				        echo "</table>";
				    	}
				    	else
				    	{
				    		echo"<br><br> <b id='nodataphar'> \"NO PHARMACIST'S\" </b><br><br><br>";
						}
				?>
				<a href="manager_add_pharmacist.php" class="button">ADD NEW PHARMACIST</a> <br>&nbsp;
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>