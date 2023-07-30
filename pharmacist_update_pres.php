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
		if(isset($_POST['submit']))
		{
			$s_pid123=$_POST['pid11'];

			$s_invoice_no=$_POST['invoice_no'];
			$s_cust_name=$_POST['cust_name'];
			$s_address=$_POST['address'];
			$s_mobile_no=$_POST['mobile_no'];


	 		// Excluding Current Invoice Number
			$sql2 = mysqli_query($con,"SELECT invoice_no FROM prescription where pres_id='$s_pid123'")or die(mysqli_error());
			$row = mysqli_fetch_array($sql2);
			$p=$row['invoice_no'];

			if($s_invoice_no!=$p)
			{
				// Checking if Invoice Number already exists 
				$sql1=mysqli_query($con,"SELECT invoice_no FROM prescription WHERE invoice_no='$s_invoice_no'")or die(mysqli_error());
	 			$result1=mysqli_fetch_array($sql1);
	 			if($result1>0)
	 			{
					echo '<script type="text/javascript">
							var u;        
					 		u = "'.$s_invoice_no.'";
					 		var u1;        
					 		u1 = "'.$s_pid123.'";
							alert("The Invoice Number Entered \""+u+"\" Already Exists! \nPlease Try Again with other Invoice Number..."); 
							window.location.href = "pharmacist_update_pres.php?pres_id="+u1;
						   </script>';
	 			}
 			}

				$sql="UPDATE prescription SET invoice_no='$s_invoice_no', customer_name='$s_cust_name', address='$s_address', phone='$s_mobile_no' WHERE pres_id='$s_pid123'";
				if(mysqli_query($con,$sql))
				{
					echo '<script type="text/javascript">
							var p;        
					 		p = "'.$s_pid123.'";
					 		var c;
					 		c = "'.$s_cust_name.'";
							alert("Prescription Details of Customer \""+c+"\" with ID : \""+p+"\" has been Updated Successfully!"); 
							window.location.href = "pharmacist_manage_prescription.php";
						   </script>';
				}
				else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
						      var e;        
						      e = "'.$error.'";
						      var u1;        
					 		  u1 = "'.$s_pid123.'";
						      alert("Updating Prescription Failed, Try Again! \nERROR : "+e);
						      window.location.href = "pharmacist_update_pres.php?pres_id="+u1;;
						 </script>';
				}
		}

		// GET PRESCRIPTION ID FROM URl
		if(isset($_GET['pres_id']))
		{
			$pid=$_GET['pres_id'];

			// GET DETAILS OF PRESCRIPTION TO BE UPDATED
			$result = mysqli_query($con,"SELECT invoice_no, customer_name, address, phone FROM prescription where pres_id='$pid'")or die(mysqli_error());
			$row = mysqli_fetch_array($result);

			$invoice_no=$row['invoice_no'];
			$cust_name=$row['customer_name'];
			$address=$row['address'];
			$mobile_no=$row['phone'];
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> PHARMACIST UPDATE PRESCRIPTION PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/homepagestyle.css">
	<link rel="stylesheet" type="text/css" href="styles/profile.css">
	<script type="text/javascript">
		window.onload=on_load;
		// FUNCTION FOR ON LOAD
		function on_load()
		{
			var add= '<?php echo $address ?>';
			update_pres.address.value =add;
		
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
			var a = textbox.placeholder;
			var v = textbox.value;
			var n = v.trim();
			// Validation  for Invoice Number
			if(a == "Invoice Number")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Invoice Number');
				}
				else if(isNaN(n))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if ((n - Math.floor(n)) != 0)
				{
					textbox.setCustomValidity('Invoice Number Cannot be a Decimal Number');
				}
				else if(n.includes("."))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if(n == 0)
				{
					textbox.setCustomValidity('Invoice Number Cannot be Zero');
				}
				else if(n < 0)
				{
					textbox.setCustomValidity('Invoice Number Cannot be Negative Number');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for Customer Name
			if(a == "Customer Name")
			{
				var letters = /^[A-Za-z ]+$/;
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Customer\'s Name');
				}
				else if(!n.match(letters))
				{
					textbox.setCustomValidity('Please Enter Alphabets Only');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for Address
			if(a == "Address")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Customer\'s Address');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for Mobile Number
			if(a == "Mobile Number")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Customer\'s Mobile Number');
				}
				else if(isNaN(n))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if ((n - Math.floor(n)) != 0)
				{
					textbox.setCustomValidity('Mobile Number Cannot be a Decimal Number');
				}
				else if(n.includes("."))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if(n == 0)
				{
					textbox.setCustomValidity('Mobile Number Cannot be Zero');
				}
				else if(n < 0)
				{
					textbox.setCustomValidity('Mobile Number Cannot be Negative Number');
				}
				else if(!isNaN(n))
				{
					if(n.length<10 || n.length>10)
					{
						textbox.setCustomValidity('Please Enter 10 Digit Mobile Number Only');
					}
					else
					{
						textbox.setCustomValidity('');
					}
				}
				else
				{
					textbox.setCustomValidity('');
				}
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
					<h4> PHARMACIST - UPDATE PRESCRIPTION <br>
						<span>-- Only modify details that you want to update --</span>
					</h4>
				<form name="update_pres" id="update_pres" action="pharmacist_update_pres.php" method="post" autocomplete="OFF">

					<input type='hidden' name='pid11' value='<?php echo "$pid"; ?>'> 
					<table>
        				<tr> 
        					<th>Prescription ID</th> 
        					<td> <input type="text" name="pres_id" value="<?php echo "$pid" ?>" placeholder="Prescription ID" readonly=""> </td>
        				</tr>
        				<tr>
        					<th>Invoice No.</th> 
        					<td> <input type="text" name="invoice_no" value="<?php echo "$invoice_no" ?>" placeholder="Invoice Number" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>   
        					<th>Customer Name</th> 
        					<td> <input type="text" name="cust_name" value="<?php echo "$cust_name" ?>" placeholder="Customer Name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Address</th> 
        					<td> <textarea id="address" name="address" rows="3" form="update_pres" placeholder="Address" wrap="soft" oninvalid="validate(this);" oninput="validate(this);" required=""></textarea> </td>
        				</tr>
        				<tr>   
        					<th>Mobile Number</th> 
        					<td> <input type="text" name="mobile_no" value="<?php echo "$mobile_no" ?>" placeholder="Mobile Number" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr> 
        			</table>
        			<a href="pharmacist_manage_prescription.php" class="button">GO BACK</a>
        			<input type="submit" class="button" name="submit" value="UPDATE DETAILS"> <br>
        		
        			<b id="msg11">UPDATE DETAILS :-</b><span id="left11"><a href="pharmacist_update_prescription_details.php?pres_id=<?php echo $pid ?>" class="button">UPDATE PRESCRIPTION DETAILS OF ID <?php echo $pid ?></a>
        		</span>
        			<br>&nbsp;<br>&nbsp;
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>