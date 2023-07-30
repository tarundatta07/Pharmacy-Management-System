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
			$s_invoice_id=$_POST['invoice_id'];
			$s_invoice_no=$_POST['invoice_no'];
			$s_cust_name=$_POST['cust_name'];
			$s_pay_status=$_POST['pay_status'];
			$s_pay_type=$_POST['pay_type'];

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
					 	i = "'.$s_invoice_no.'";
					 	alert("Invoice ID Entered : \""+d+"\" Already Exists with Invoice Number \""+n+"\" of Customer \""+c+"\"\nPlease Try Again with some other Invoice ID... "); 
						window.location.href = "cashier_payment_invoice.php?invoice_no="+i;
					</script>';
	 		}
	 		else
	 		{
	 			$sql20=mysqli_query($con,"SELECT pres_id FROM prescription WHERE invoice_no='$s_invoice_no'")or die(mysqli_error());
						$row20 = mysqli_fetch_array($sql20);
						$a_pres_id = $row20['pres_id'];

				$sql11=mysqli_query($con,"SELECT medicine_name, quantity FROM prescription_details WHERE pres_id='$a_pres_id'")or die(mysqli_error());

				$counting=0;

				while($row = mysqli_fetch_array($sql11)) 
				{        
				    $med=$row['medicine_name'];
				    $qty=$row['quantity'];

				    $sql22=mysqli_query($con,"SELECT quantity FROM medicine WHERE medicine_name='$med'")or die(mysqli_error());
					$row22 = mysqli_fetch_array($sql22);
					$old_qty = $row22['quantity'];

					if($qty>$old_qty)
	 				{
	 					$counting=1;
	 					echo '<script type="text/javascript">
						var p;        
						p = "'.$a_pres_id.'";
						var m;
						m = "'.$med.'";
						var s;
						s = "'.$old_qty.'";
						var q;
						q = "'.$qty.'";
						alert("Quantity \'"+q+"\' prescribed for Medicine \""+m+"\" exceeds currently available Stock...\nThe currently available Stock for Medicine \""+m+"\" is \'"+s+"\'\nPlease Contact Pharmacist to update Quantity of Medicine...");
					   </script>';
	 				}
				}
				if($counting==1)
				{
					echo '<script type="text/javascript">
					window.location.href = "cashier_process_payment.php";
					</script>';
				}
				else
				{
				$sql="INSERT INTO invoice (invoice_id, invoice_no, customer_name, payment_status, payment_type, date) VALUES ('$s_invoice_id', '$s_invoice_no', '$s_cust_name', '$s_pay_status', '$s_pay_type', NOW())";
				if(mysqli_query($con,$sql))
				{
					if($s_pay_status=='Paid')
					{
						$sql10=mysqli_query($con,"SELECT pres_id FROM prescription WHERE invoice_no='$s_invoice_no'")or die(mysqli_error());
						$row10 = mysqli_fetch_array($sql10);
						$pres_id = $row10['pres_id'];

						$sql11=mysqli_query($con,"SELECT medicine_name, quantity FROM prescription_details WHERE pres_id='$pres_id'")or die(mysqli_error());

				        while($row = mysqli_fetch_array($sql11)) 
				        {        
				            $medicine_name=$row['medicine_name'];
				            $quantity=$row['quantity'];

				            $sql12=mysqli_query($con,"SELECT quantity, medicine_status FROM medicine WHERE medicine_name='$medicine_name'")or die(mysqli_error());
							$row12 = mysqli_fetch_array($sql12);
							$old_quantity = $row12['quantity'];
							$medicine_status = $row12['medicine_status'];

							$new_quantity=$old_quantity-$quantity;

							if($new_quantity<=0)
							{
								$medicine_status='Not Available';
							}

							$sql15=mysqli_query($con,"UPDATE medicine SET quantity='$new_quantity', medicine_status='$medicine_status' WHERE medicine_name='$medicine_name'") or die(mysqli_error());
						}
					}

					echo '<script type="text/javascript">
							var c;        
					 		c = "'.$s_cust_name.'";
					 		var n;        
					 		n = "'.$s_invoice_no.'";
					 		var s;
					 		s = "'.$s_pay_status.'";
							alert("Invoice Details of Customer \""+c+"\" with Invoice Number \""+n+"\" has been added Successfully!"); 
							if(s=="Paid")
							{
								var confirm = window.confirm("Do you want to Print Invoice/ Bill of Customer \""+c+"\" with Invoice Number \""+n+"\ ?");
								if (confirm == true)
								{
									window.location.href = "cashier_print_invoice.php?invoice_no="+n;
								} 
								else 
								{
									window.location.href = "cashier_process_payment.php";
								}
							}
							else
							{
								window.location.href = "cashier_process_payment.php";
						   	}
						   </script>';
				}
				else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
						      var e;        
						      e = "'.$error.'";
						      var i;        
					 		  i = "'.$s_invoice_no.'";
						      alert("Inserting Invoice Details Failed, Try Again! \nERROR : "+e);
						      window.location.href = "cashier_payment_invoice.php?invoice_no="+i;
						 </script>';
				}
				}
			}
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> CASHIER PAYMENT INVOICE PAGE </title>
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
						 <a href="cashier_process_payment.php" class="active"><img src="images/payment.png" height="20px" align="center">&nbsp;&nbsp;Process Payment</a>
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
					<h4> CASHIER - PAYMENT INVOICE <br>	</h4>
					<?php
						// GET INVOICE ID FROM URl
						if(isset($_GET['invoice_no']))
						{
							$invoice_no=$_GET['invoice_no'];

							// GET DETAILS OF INVOICE TO BE UPDATED
							$result = mysqli_query($con,"SELECT customer_name,pres_id FROM prescription WHERE invoice_no='$invoice_no'")or die(mysqli_error());
							$row = mysqli_fetch_array($result);
							$customer_name=$row['customer_name'];
							$pres_id=$row['pres_id'];

							$result1 = mysqli_query($con,"SELECT sum(cost) as cost FROM prescription_details WHERE pres_id='$pres_id'")or die(mysqli_error());
							$row1 = mysqli_fetch_array($result1);
							$cost=$row1['cost'];
						}
					?>
				<form name="add_invoice" action="cashier_payment_invoice.php" method="post" autocomplete="OFF">	
					<b> &nbsp;-- Total Cost of Customer "<?php echo $customer_name; ?>" &nbsp;: &nbsp;Tk. <?php echo $cost; ?> --&nbsp;</b>
					<table>
        				<tr> 
        					<th>Invoice ID</th> 
        					<td> <input type="text" name="invoice_id" placeholder="Invoice ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>
        					<th>Invoice No.</th> 
        					<td> <input type="text" name="invoice_no" value="<?php echo "$invoice_no" ?>" placeholder="Invoice Number" readonly=""> 
        					</td> 
        				</tr>
        				<tr>   
        					<th>Customer Name</th> 
        					<td> <input type="text" name="cust_name" value="<?php echo "$customer_name" ?>" placeholder="Customer Name" readonly=""> </td> 
        				</tr>
        				<tr>   
        					<th>Payment Status</th> 
        					<td> 
        					<select name="pay_status" oninvalid="this.setCustomValidity('Please Select Payment Status')" oninput="setCustomValidity('')" required="">
								<option value="">Select Status</option>
								<option value="Paid">Paid</option>
								<option value="Not Paid">Not Paid</option>
							</select>
							</td>
						</tr> 
						<tr>   
        					<th>Payment Type</th> 
        					<td> 
        					<select name="pay_type" oninvalid="this.setCustomValidity('Please Select Payment Type')" oninput="setCustomValidity('')" required="">
								<option value="">Select Type</option>
								<option value="Cash">Cash</option>
								<option value="Credit Card">Credit Card</option>
								<option value="Debit Card">Debit Card</option>
								<option value="NA">NA</option>
							</select>
							</td>
						</tr>
        			</table>
					<a href="cashier_process_payment.php" class="button">GO BACK</a>
        			<input type="submit" class="button" name="submit" value="ADD INVOICE"> 
        			<br> &nbsp;
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>