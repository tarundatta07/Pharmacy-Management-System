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
	<title> CASHIER PROFILE PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/homepagestyle.css">
	<link rel="stylesheet" type="text/css" href="styles/profile.css">
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
						 <a href="cashier.php"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
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
					<a href="cashier_profile.php" class="active"><img src="images/userprofile.png" height="20px" align="center">&nbsp;&nbsp;User Profile</a>
					<a href="cashier_changepass.php"><img src="images/password.png" height="20px" align="center">&nbsp;&nbsp;Change Password</a>
					<a onclick="return confirm('Are you sure you want to log out?')" href="logout.php"><img src="images/logout.png" height="20px" align="center">&nbsp;&nbsp;Logout</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<!-- THIS IS CASHIER MAIN CONTENT -->
				<div id="mainbox" align="center">
					<h4> CASHIER - USER PROFILE </h4>
					<?php 
						$result = mysqli_query($con,"SELECT cashier_id, username, first_name, last_name, address, phone, email_id FROM cashier where cashier_id=$id")or die(mysqli_error());
						$row = mysqli_fetch_array($result);
						$a=$row['cashier_id'];
						$b=$row['username'];
						$c=$row['first_name'];
						$d=$row['last_name'];
						$e=$row['address'];
						$f=$row['phone'];
						$g=$row['email_id'];
					?>
					<table>
        				<tr> 
        					<th>Cashier ID </th> 
        					<td> <?php echo $a ?> </td>	
        				</tr>
        				<tr>   
        					<th>Username </th> 
        					<td> <?php echo $b ?> </td>
        				</tr>
        				<tr>
        					<th>First name </th> 
        					<td> <?php echo $c ?> </td> 
        				</tr>
        				<tr>   
        					<th>Last name </th> 
        					<td> <?php echo $d ?> </td> 
        				</tr>   
        				<tr>   
        					<th>Address </th> 
        					<td> <?php echo $e ?> </td>
        				</tr>
        				<tr>   
        					<th>Mobile No.</th> 
        					<td> <?php echo $f ?> </td>
        				</tr>
        				<tr>   
        					<th>Email ID </th> 
        					<td> <?php echo $g ?> </td>
        				</tr>
        			</table>
        			<br>&nbsp;
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>