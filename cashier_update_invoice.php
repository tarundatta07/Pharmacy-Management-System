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
		if(isset($_POST['submit']))
		{
			$s_invoice_id123=$_POST['invoice_id11'];

			$s_invoice_id=$_POST['invoice_id'];
			$s_invoice_no=$_POST['invoice_no'];
			$s_cust_name=$_POST['cust_name'];
			$s_pay_status=$_POST['pay_status'];
			$s_pay_type=$_POST['pay_type'];

			if($s_invoice_id123!=$s_invoice_id)
			{
				// Checking if Invoice ID already exists 
				$sql1=mysqli_query($con,"SELECT invoice_no, customer_name FROM invoice WHERE invoice_id='$s_invoice_id'")or die(mysqli_error());
	 			$result1=mysqli_fetch_array($sql1);
	 			$no_old = $result1['invoice_no'];
	 			$name_old = $result1['customer_name'];
	 			if($result1>0)
	 			{
					echo '<script type="text/javascript">
							var c;        
					 		c = "'.$name_old.'";
					 		var n;        
					 		n = "'.$no_old.'";
					 		var d;
					 		d = "'.$s_invoice_id.'";
					 		var i;
					 		i = "'.$s_invoice_id123.'";
					 		alert("Invoice ID Entered : \""+d+"\" Already Exists with Invoice Number \""+n+"\" of Customer \""+c+"\"\nPlease Try Again with other Invoice ID... "); 
							window.location.href = "cashier_update_invoice.php?invoice_id="+i;
						   </script>';
	 			}
 			}

				$sql="UPDATE invoice SET invoice_id='$s_invoice_id', payment_status='$s_pay_status', payment_type='$s_pay_type' WHERE invoice_id='$s_invoice_id123'";
				if(mysqli_query($con,$sql))
				{
					echo '<script type="text/javascript">
							var c;        
					 		c = "'.$s_cust_name.'";
					 		var n;        
					 		n = "'.$s_invoice_no.'";
							alert("Invoice Details of Customer \""+c+"\" with Invoice Number \""+n+"\" has been Updated Successfully!"); 
							window.location.href = "cashier_manage_invoices.php";
						   </script>';
				}
				else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
						      var e;        
						      e = "'.$error.'";
						      var i;        
					 		  i = "'.$s_invoice_id123.'";
						      alert("Update Failed, Try Again! \nERROR : "+e);
						      window.location.href = "cashier_update_invoice.php?invoice_id="+i;
						 </script>';
				}
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> CASHIER UPDATE INVOICE PAGE </title>
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
		// FUNCTION TO VALIDATE INPUT DATA
		function validate(textbox)
		{
			var v = textbox.value;
			var n = v.trim();
			// Validation  for Invoice ID
			if(n == "")
			{
				textbox.setCustomValidity('Please Enter Invoice ID');
			}
			else if(isNaN(n))
			{
				textbox.setCustomValidity('Please Enter Digits Only');
			}
			else if ((n - Math.floor(n)) != 0)
			{
				textbox.setCustomValidity('Invoice ID Cannot be a Decimal Number');
			}
			else if(n.includes("."))
			{
				textbox.setCustomValidity('Please Enter Digits Only');
			}
			else if(n == 0)
			{
				textbox.setCustomValidity('Invoice ID Cannot be Zero');
			}
			else if(n < 0)
			{
				textbox.setCustomValidity('Invoice ID Cannot be Negative Number');
			}
			else
			{
					textbox.setCustomValidity('');
			}
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
						 <a href="cashier_manage_invoices.php" class="active"><img src="images/invoice.png" height="20px" align="center">&nbsp;&nbsp;Manage Invoices</a>
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
					<h4> CASHIER - UPDATE INVOICE <br>
						<span>-- Only modify details that you want to update --</span>
					</h4>
					<?php
						// GET INVOICE ID FROM URl
						if(isset($_GET['invoice_id']))
						{
							$invoice_id=$_GET['invoice_id'];

							// GET DETAILS OF INVOICE TO BE UPDATED
							$result = mysqli_query($con,"SELECT invoice_no, customer_name, payment_status, payment_type FROM invoice WHERE invoice_id='$invoice_id'")or die(mysqli_error());
							$row = mysqli_fetch_array($result);
							
							$invoice_no=$row['invoice_no'];
							$customer_name=$row['customer_name'];
							$payment_status=$row['payment_status'];
							$payment_type=$row['payment_type'];


							$result3 = mysqli_query($con,"SELECT pres_id FROM prescription WHERE invoice_no='$invoice_no'")or die(mysqli_error());
							$row3 = mysqli_fetch_array($result3);

							$pres_id=$row3['pres_id'];
							
							$result1 = mysqli_query($con,"SELECT sum(cost) as cost FROM prescription_details WHERE pres_id='$pres_id'")or die(mysqli_error());
							$row1 = mysqli_fetch_array($result1);
							$cost=$row1['cost'];
							if($cost=='' || empty($cost))
							{
								$cost='NA';
							}
						}
					?>
				<form name="update_invoice" action="cashier_update_invoice.php" method="post" autocomplete="OFF">
					<b> &nbsp;-- Total Cost of Customer "<?php echo $customer_name; ?>" &nbsp;: &nbsp;Rs. <?php echo $cost; ?> --&nbsp;</b> 

					<input type='hidden' name='invoice_id11' value='<?php echo "$invoice_id"; ?>'> 

					<table>
        				<tr> 
        					<th>Invoice ID</th> 
        					<td> <input type="text" name="invoice_id" value="<?php echo "$invoice_id" ?>" placeholder="Invoice ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>
        					<th>Invoice No.</th> 
        					<td> <input type="text" name="invoice_no" value="<?php echo "$invoice_no" ?>" placeholder="Invoice Number" readonly=""> </td> 
        				</tr>
        				<tr>   
        					<th>Customer Name</th> 
        					<td> <input type="text" name="cust_name" value="<?php echo "$customer_name" ?>" placeholder="Customer Name" readonly=""> </td> 
        				</tr>
        				<tr>   
        					<th>Payment Status</th> 
        					<td> 
        					<select name="pay_status" oninvalid="this.setCustomValidity('Please Select Payment Status')" oninput="setCustomValidity('')" required="">
        					<?php 
        						if($payment_status=="Paid")
        						{
        					?>
								<option value="">Select Status</option>
								<option value="Paid" selected>Paid</option>
								<option value="Not Paid">Not Paid</option>
							<?php
								}
							?>
							<?php 
        						if($payment_status=="Not Paid")
        						{
        					?>
								<option value="">Select Status</option>
								<option value="Paid">Paid</option>
								<option value="Not Paid" selected>Not Paid</option>
							<?php
								}
							?>
							</select>
							</td>
						</tr> 
						<tr>   
        					<th>Payment Type</th> 
        					<td> 
        					<select name="pay_type" oninvalid="this.setCustomValidity('Please Select Payment Type')" oninput="setCustomValidity('')" required="">
        					<?php 
        						if($payment_type=="Cash")
        						{
        					?>
								<option value="">Select Type</option>
								<option value="Cash" selected>Cash</option>
								<option value="Credit Card">Credit Card</option>
								<option value="Debit Card">Debit Card</option>
								<option value="NA">NA</option>
							<?php
								}
							?>
							<?php 
        						if($payment_type=="Credit Card")
        						{
        					?>
								<option value="">Select Type</option>
								<option value="Cash">Cash</option>
								<option value="Credit Card" selected>Credit Card</option>
								<option value="Debit Card">Debit Card</option>
								<option value="NA">NA</option>
							<?php
								}
							?>
							<?php 
        						if($payment_type=="Debit Card")
        						{
        					?>
								<option value="">Select Type</option>
								<option value="Cash">Cash</option>
								<option value="Credit Card">Credit Card</option>
								<option value="Debit Card" selected>Debit Card</option>
								<option value="NA">NA</option>
							<?php
								}
							?>
							<?php 
        						if($payment_type=="NA")
        						{
        					?>
								<option value="">Select Type</option>
								<option value="Cash">Cash</option>
								<option value="Credit Card">Credit Card</option>
								<option value="Debit Card">Debit Card</option>
								<option value="NA" selected>NA</option>
							<?php
								}
							?>
							</select>
							</td>
						</tr>
        			</table>
					<a href="cashier_manage_invoices.php" class="button">GO BACK</a>
        			<input type="submit" class="button" name="submit" value="UPDATE DETAILS"> <br> &nbsp;
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>