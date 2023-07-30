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
	<title> ADMIN HOME PAGE </title>
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
						 <a href="admin_profile.php"><img src="images/admin.png" height="80px" align="center" style="border:3px solid black;border-radius:20px;margin-bottom:3px;">
						 	<br><?php echo 'Welcome, '.$first_name.' '.$last_name ?>
						 </a>
						</center>
						 <a href="admin.php" class="active"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="admin_manager.php"><img src="images/manager.png" height="20px" align="center">&nbsp;&nbsp;Manage Manager</a>
						 <a href="admin_pharmacist.php"><img src="images/pharmacist.png" height="20px" align="center">&nbsp;&nbsp;Manage Pharmacist</a>
						 <a href="admin_cashier.php"><img src="images/cashier.png" height="20px" align="center">&nbsp;&nbsp;Manage Cashier</a>
						 <a href="admin_stocks.php"><img src="images/stocks.png" height="20px" align="center">&nbsp;&nbsp;Stocks</a>
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
		<h4> ADMIN - DASHBOARD </h4>
		
		<div class="container">
		<!-- MANAGERS -->
			<div class="box" onclick="window.location.href = 'admin_manager.php';">
				<div class="icon">
					<img src="images/manager1.png">
					<div class="title" align="center">
						Manager's
					</div>
				</div>
				<div class="content">
					<h3>Total Manager's</h3>
					<?php
						$sql="SELECT manager_id FROM manager";
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

		<!-- PHARMACIST -->
			<div class="box" onclick="window.location.href = 'admin_pharmacist.php';">
				<div class="icon">
					<img src="images/pharmacist1.png">
					<div class="title" align="center">
						Pharmacist's
					</div>
				</div>
				<div class="content">
					<h3>Total Pharmacist's</h3>
					<?php 
						$sql="SELECT pharmacist_id FROM pharmacist";
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

		<!-- CASHIER -->
		 	<div class="box" onclick="window.location.href = 'admin_cashier.php';">
				<div class="icon">
					<img src="images/cashier1.png">
					<div class="title" align="center">
						Cashier's
					</div>
				</div>
				<div class="content">
					<h3>Total Cashier's</h3>
					<?php 
						$sql="SELECT cashier_id FROM cashier";
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

	 	<!-- STOCKS (Medicines) -->
		 	<div class="box" onclick="window.location.href = 'admin_stocks.php';">
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
		 	
		<!-- OUT OF STOCK -->
		 	<div class="box" onclick="window.location.href = 'admin_outofstock.php';">
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

		<!-- EXPIRE SOON -->
		 	<div class="box" onclick="window.location.href = 'admin_expire.php';">
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
			
		<!-- EXPIRED -->
		 	<div class="box" onclick="window.location.href = 'admin_expire.php#expired';">
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

		<!-- SALES REPORT -->
		 	<div class="box" onclick="window.location.href = 'admin_salesreport.php';">
				<div class="icon">
					<img src="images/salesreport.png">
					<div class="title" align="center">
						Total Sales 
					</div>
				</div>
				<div class="content">
					<h3>Total Sales</h3>
					<?php 
						$sql="SELECT a.pres_id, b.cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no from invoice WHERE payment_status='Paid') GROUP BY a.pres_id";
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

		<!-- SALES THIS MONTH -->
		 	<div class="box" onclick="window.location.href = 'admin_salesreport.php';">
				<div class="icon">
					<img src="images/sales1.png">
					<div class="title" align="center">
						Sales This Month
					</div>
				</div>
				<div class="content">
					<h3>Sales This Month</h3>
					<?php 
						$sql="SELECT a.pres_id, b.cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no from invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY a.pres_id";
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