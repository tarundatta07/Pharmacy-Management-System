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
	<title> PHARMACIST HOME PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/homepagestyle.css">
	<link rel="stylesheet" type="text/css" href="styles/dashboard.css">
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
						 <a href="pharmacist.php" class="active"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="pharmacist_stocks.php"><img src="images/stocks.png" height="20px" align="center">&nbsp;&nbsp;Stocks</a>
						 <a href="pharmacist_update_stocks.php"><img src="images/updatestocks.png" height="20px" align="center">&nbsp;&nbsp;Update Stocks</a>
						 <a href="pharmacist_search_medicines.php"><img src="images/search.png" height="20px" align="center">&nbsp;&nbsp;Search Medicines</a>
						 <a href="pharmacist_generate_prescription.php"><img src="images/prescription.png" height="20px" align="center">&nbsp;&nbsp;Generate Prescription</a>
						 <a href="pharmacist_manage_prescription.php"><img src="images/manage_pres.png" height="20px" align="center">&nbsp;&nbsp;Manage Prescription</a>
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
		<h4> PHARMACIST - DASHBOARD </h4>

		<div class="container">
		<!-- STOCKS (Medicines) -->
			<div class="box" onclick="window.location.href = 'pharmacist_stocks.php';">
				<div class="icon">
					<img src="images/medicine1.png">
					<div class="title" align="center">
						Medicine's
					</div>
				</div>
				<div class="content">
					<h3>Total Medicine's</h3>
					<?php 
						$sql="SELECT medicine_id FROM medicine";
						$rowcount1="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount1=mysqli_num_rows($result);
	  						mysqli_free_result($result);
						}
					?>
					<span><?php echo $rowcount1 ?></span>
				</div>
		 	</div>
		 		
		 	<!-- PRESCRIPTIONS -->
			<div class="box" onclick="window.location.href = 'pharmacist_manage_prescription.php';">
				<div class="icon">
					<img src="images/prescription4.png">
					<div class="title" align="center">
						Prescription's
					</div>
				</div>
				<div class="content">
					<h3>Total Prescription's</h3>
					<?php 
						$sql="SELECT pres_id FROM prescription";
						$rowcount2="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount2=mysqli_num_rows($result);
	  						mysqli_free_result($result);
						}
					?>
					<span><?php echo $rowcount2 ?></span>
				</div>
		 	</div>
		 		
		 	<!-- PRESCRIPTION THIS YEAR -->
			<div class="box" onclick="window.location.href = 'pharmacist_manage_prescription.php';">
				<div class="icon">
					<img src="images/prescription2.png">
					<div class="title" align="center">
						<small> Prescription's This Year </small>
					</div>
				</div>
				<div class="content">
					<h3><small> Prescription's This Year </small></h3>
					<?php 
						$sql="SELECT pres_id FROM prescription WHERE YEAR(date)=YEAR(CURRENT_DATE)";
							$rowcount3="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount3=mysqli_num_rows($result);
	  						mysqli_free_result($result);
	  					}
					?>
					<span><?php echo $rowcount3 ?></span>
				</div>
		 	</div>
		 		
		 	<!-- PRESCRIPTIONS TODAY -->
			<div class="box" onclick="window.location.href = 'pharmacist_manage_prescription.php';">
				<div class="icon">
					<img src="images/today.png">
					<div class="title" align="center">
						<small> Prescription's Today </small>
					</div>
				</div>
				<div class="content">
					<h3><small> Prescription's Today </small></h3>
					<?php 
						$sql="SELECT pres_id FROM prescription WHERE DATE(date)=CURDATE()";
						$rowcount4="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount4=mysqli_num_rows($result);
	 						mysqli_free_result($result);
  						}
					?>
					<span><?php echo $rowcount4 ?></span>
				</div>
		 	</div>
		 		
		 	<!-- PRESCRIPTION THIS MONTH -->
			<div class="box" onclick="window.location.href = 'pharmacist_manage_prescription.php';">
				<div class="icon">
					<img src="images/month.png">
					<div class="title" align="center">
						<small> Prescription's This Month </small>
					</div>
				</div>
				<div class="content">
					<h3><small> Prescriptions This Month </small></h3>
					<?php 
						$sql="SELECT pres_id FROM prescription WHERE MONTH(date)=MONTH(CURRENT_DATE) AND YEAR(date)=YEAR(CURRENT_DATE)";
						$rowcount5="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount5=mysqli_num_rows($result);
	  						mysqli_free_result($result);
						}
					?>
					<span><?php echo $rowcount5 ?></span>
				</div>
		 	</div>
		 		
		 	<!-- PRESCRIPTIONS LAST MONTH -->
			<div class="box" onclick="window.location.href = 'pharmacist_manage_prescription.php';">
				<div class="icon">
					<img src="images/invoice_month1.png">
					<div class="title" align="center">
						<small> Prescription's Last Month </small>
					</div>
				</div>
				<div class="content">
					<h3><small> Prescriptions Last Month </small></h3>
					<?php 
						$sql="SELECT pres_id FROM prescription WHERE MONTH(date)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(date)=YEAR(CURRENT_DATE)";
						$rowcount6="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount6=mysqli_num_rows($result);
  							mysqli_free_result($result);
						}
					?>
					<span><?php echo $rowcount6 ?></span>
				</div>
		 	</div>
		 		
		 	<!-- OUT OF STOCK -->
			<div class="box" onclick="window.location.href = 'pharmacist_outofstock.php';">
				<div class="icon">
					<img src="images/outofstock1.png">
					<div class="title" align="center">
						Out of Stock
					</div>
				</div>
				<div class="content">
					<h3><small> Out of Stock Medicine's </small></h3>
					<?php 
						$sql="SELECT medicine_id FROM medicine where quantity=0";
						$rowcount7="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
							$rowcount7=mysqli_num_rows($result);
	  						mysqli_free_result($result);
	  					}
					?>
					<span><?php echo $rowcount7 ?></span>
				</div>
		 	</div>
		 		
		 	<!-- EXPIRE SOON -->
			<div class="box" onclick="window.location.href = 'pharmacist_expire.php';">
				<div class="icon">
					<img src="images/expire1.png">
					<div class="title" align="center">
						Expire Soon
					</div>
				</div>
				<div class="content">
					<h3><small> Expire Soon Medicine's </small></h3>
					<?php 
						$sql="SELECT medicine_id FROM medicine WHERE expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)";
						$rowcount8="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount8=mysqli_num_rows($result);
	  						mysqli_free_result($result);
  						}
					?>
					<span><?php echo $rowcount8 ?></span>
				</div>
		 	</div>
		 		
		 	<!-- EXPIRED -->
			<div class="box" onclick="window.location.href = 'pharmacist_expire.php#expired';">
				<div class="icon">
					<img src="images/expire2.png">
					<div class="title" align="center">
						Expired Medicine's
					</div>
				</div>
				<div class="content">
					<h3>Expired Medicine's</h3>
					<?php 
						$sql="SELECT medicine_id FROM medicine WHERE expiry_date < CURDATE()";
						$rowcount9="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount9=mysqli_num_rows($result);
	  						mysqli_free_result($result);
  						}
					?>
					<span><?php echo $rowcount9 ?></span>
				</div>
		 	</div>
		</div>
		<br>&nbsp;<br>&nbsp;
		
		</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php') ?>
	</div>
</body>
</html>