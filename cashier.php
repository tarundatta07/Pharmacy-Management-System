		<!-- PHP CODE STARTS FROM HERE -->
<?php
		session_start();
		include_once('connect_db.php');
		if(isset($_SESSION['cashier_id']))
		{
			$id=$_SESSION['cashier_id'];
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
	<title> CASHIER HOME PAGE </title>
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
						 <a href="cashier_profile.php"><img src="images/cashier1.png" height="80px" align="center" style="border:3px solid black;border-radius:20px;padding:0px 4px 3px 3px;margin-bottom:3px;">
						 	<br><?php echo 'Welcome, '.$first_name.' '.$last_name ?>
						 </a>
						</center>
						 <a href="cashier.php" class="active"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="cashier_process_payment.php"><img src="images/payment.png" height="20px" align="center">&nbsp;&nbsp;Process Payment</a>
						 <a href="cashier_generate_bill.php"><img src="images/bill.png" height="20px" align="center">&nbsp;&nbsp;Generate Bill</a>
						 <a href="cashier_manage_invoices.php"><img src="images/invoice.png" height="20px" align="center">&nbsp;&nbsp;Manage Invoices</a>
						 <a href="cashier_notpaid_invoices.php"><img src="images/notpaid.png" height="20px" align="center">&nbsp;&nbsp;Invoices Not Paid</a>
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
					<a href="cashier_profile.php"><img src="images/userprofile.png" height="20px" align="center">&nbsp;&nbsp;User Profile</a>
					<a href="cashier_changepass.php"><img src="images/password.png" height="20px" align="center">&nbsp;&nbsp;Change Password</a>
					<a onclick="return confirm('Are you sure you want to log out?')" href="logout.php"><img src="images/logout.png" height="20px" align="center">&nbsp;&nbsp;Logout</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

		<!-- THIS IS CASHIER MAIN CONTENT -->
		<div id="mainbox" align="center">
		<h4> CASHIER - DASHBOARD </h4>
		
		<div class="container">
		<!-- PROCESS PAYMENT -->
			<div class="box" onclick="window.location.href = 'cashier_process_payment.php';">
				<div class="icon">
					<img src="images/payment1.png">
					<div class="title" align="center">
						Process Payment
					</div>
				</div>
				<div class="content">
					<h3>Process Payment</h3>
					<?php 
						$sql="SELECT a.invoice_no, sum(b.cost) as cost FROM prescription a join prescription_details b ON a.pres_id=b.pres_id WHERE a.invoice_no != ALL(SELECT invoice_no FROM invoice) GROUP BY a.pres_id";
						$rowcount0="NA";
						if ($result=mysqli_query($con,$sql))
	  					{
	  						$rowcount0=mysqli_num_rows($result);
	  						mysqli_free_result($result);
	  					}
					?>
					<span><?php echo $rowcount0 ?></span>
				</div>
		 	</div>

		<!-- INVOICES -->
			<div class="box" onclick="window.location.href = 'cashier_manage_invoices.php';">
				<div class="icon">
					<img src="images/invoice1.png">
					<div class="title" align="center">
						Invoices
					</div>
				</div>
				<div class="content">
					<h3>Total Invoices</h3>
					<?php 
						$sql="SELECT invoice_id FROM invoice";
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

		 	<!-- INVOICES PAID -->
			<div class="box" onclick="window.location.href = 'cashier_generate_bill.php';">
				<div class="icon">
					<img src="images/pay.png">
					<div class="title" align="center">
						Invoices Paid
					</div>
				</div>
				<div class="content">
					<h3>Invoices Paid</h3>
					<?php 
						$sql="SELECT invoice_id FROM invoice WHERE payment_status='Paid'";
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

		 	<!-- INVOICES NOT PAID -->
		 	<div class="box" onclick="window.location.href = 'cashier_notpaid_invoices.php';">
				<div class="icon">
					<img src="images/notpaid1.png">
					<div class="title" align="center">
						Invoices Not Paid
					</div>
				</div>
				<div class="content">
					<h3>Invoices Not Paid</h3>
					<?php 
						$sql="SELECT invoice_id FROM invoice WHERE payment_status='Not Paid'";
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

		 	<!-- INVOICES TODAY -->
			<div class="box" onclick="window.location.href = 'cashier_manage_invoices.php';">
				<div class="icon">
					<img src="images/today.png">
					<div class="title" align="center">
						Invoices Today
					</div>
				</div>
				<div class="content">
					<h3>Invoices Today</h3>
					<?php 
						$sql="SELECT invoice_id FROM invoice WHERE DATE(date)=CURDATE()";
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
		 	
		 	<!-- INVOICES THIS MONTH -->
			<div class="box" onclick="window.location.href = 'cashier_manage_invoices.php';">
				<div class="icon">
					<img src="images/month.png">
					<div class="title" align="center">
						Invoices This Month
					</div>
				</div>
				<div class="content">
					<h3>Invoices This Month</h3>
					<?php 
						$sql="SELECT invoice_id FROM invoice WHERE MONTH(date)=MONTH(CURRENT_DATE) AND YEAR(date)=YEAR(CURRENT_DATE)";
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
		 	
		 	<!-- INVOICES LAST MONTH -->
			<div class="box" onclick="window.location.href = 'cashier_manage_invoices.php';">
				<div class="icon">
					<img src="images/invoice_month1.png">
					<div class="title" align="center">
						Invoices Last Month
					</div>
				</div>
				<div class="content">
					<h3>Invoices Last Month</h3>
					<?php 
						$sql="SELECT invoice_id FROM invoice WHERE MONTH(date)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(date)=YEAR(CURRENT_DATE)";
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

		 	<!-- INVOICES THIS YEAR -->
			<div class="box" onclick="window.location.href = 'cashier_manage_invoices.php';">
				<div class="icon">
					<img src="images/thisyear.png">
					<div class="title" align="center">
						Invoices This Year
					</div>
				</div>
				<div class="content">
					<h3>Invoices This Year</h3>
					<?php 
						$sql="SELECT invoice_id FROM invoice WHERE YEAR(date)=YEAR(CURRENT_DATE)";
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

		 	<!-- INVOICES LAST YEAR -->
			<div class="box" onclick="window.location.href = 'cashier_manage_invoices.php';">
				<div class="icon">
					<img src="images/lastyear.png">
					<div class="title" align="center">
						Invoices Last Year
					</div>
				</div>
				<div class="content">
					<h3>Invoices Last Year</h3>
					<?php 
						$sql="SELECT invoice_id FROM invoice WHERE YEAR(date)=YEAR(CURRENT_DATE - INTERVAL 1 YEAR)";
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
		</div>
		<br>&nbsp;<br>&nbsp;
		
		</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php') ?>
	</div>
</body>
</html>