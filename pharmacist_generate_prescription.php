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
				$pres_id=$_POST['pres_id'];
				$invoice_no=$_POST['invoice_no'];
				$cust_name=$_POST['cust_name'];
				$address=$_POST['address'];
				$mobile_no=$_POST['mobile_no'];
				
				// Checking if Prescription ID already exists 
				$sql1=mysqli_query($con,"SELECT * FROM prescription WHERE pres_id='$pres_id'")or die(mysqli_error());
	 			$result1=mysqli_fetch_array($sql1);
	 			if($result1>0)
	 			{
					echo '<script type="text/javascript">
							var i;        
					 		i = "'.$pres_id.'";
							alert("Prescription ID Entered \""+i+"\" Already Exists! \nPlease Try Again with other Prescription ID...");
							window.location.href = "pharmacist_generate_prescription.php";
						   </script>';
	 			}
				else
				{	
					$sql="INSERT INTO prescription (pres_id, invoice_no, customer_name, address, phone, date) VALUES ('$pres_id', '$invoice_no', '$cust_name', '$address', '$mobile_no', NOW())";

					if(mysqli_query($con,$sql)) 
					{
						echo '<script type="text/javascript">
								var i;        
						 		i = "'.$pres_id.'";
								alert("Prescription has been created Successfully with ID : \""+i+"\"\nPlease Add Prescription Details...");
								window.location.href = "pharmacist_add_pres_details.php?pres_id="+i;
							   </script>';
					}
					else
					{
						$error=mysqli_error($con);
						echo '<script type="text/javascript">
							      var e;        
							      e = "'.$error.'";
							      alert("Generating Prescription Failed, Try Again! \nERROR : "+e);
							      window.location.href = "pharmacist_generate_prescription.php";
							 </script>';
					}
				}
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> PHARMACIST GENERATE PRESCRIPTION PAGE </title>
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
		function validate(textbox)
		{
			var a = textbox.placeholder;
			var v = textbox.value;
			var n = v.trim();
			// Validation  for Prescription ID
			if(a == "Prescription ID")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Prescription ID');
				}
				else if(isNaN(n))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if ((n - Math.floor(n)) != 0)
				{
					textbox.setCustomValidity('Prescription ID Cannot be a Decimal Number');
				}
				else if(n.includes("."))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if(n == 0)
				{
					textbox.setCustomValidity('Prescription ID Cannot be Zero');
				}
				else if(n < 0)
				{
					textbox.setCustomValidity('Prescription ID Cannot be Negative Number');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
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
						 <a href="pharmacist_generate_prescription.php" class="active"><img src="images/prescription.png" height="20px" align="center">&nbsp;&nbsp;Generate Prescription</a>
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
					<h4> PHARMACIST - GENERATE PRESCRIPTION </h4>
					
				<form name="gen_pres" id="gen_pres" action="pharmacist_generate_prescription.php" method="post" autocomplete="OFF">
					<table>
        				<tr> 
        					<th>Prescription ID</th> 
        					<td> <input type="text" name="pres_id" placeholder="Prescription ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>
        					<th>Invoice No.</th> 
        					<td> <input type="text" name="invoice_no" placeholder="Invoice Number" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>   
        					<th>Customer Name</th> 
        					<td> <input type="text" name="cust_name" placeholder="Customer Name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Address</th> 
        					<td> <textarea name="address" rows="3" form="gen_pres" placeholder="Address" wrap="soft" oninvalid="validate(this);" oninput="validate(this);" required=""></textarea> </td> 
        				</tr>
        				<tr>   
        					<th>Mobile Number</th> 
        					<td> <input type="text" name="mobile_no" placeholder="Mobile Number" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr> 
        			</table>
        			<input type="submit" class="button" name="submit" value="GENERATE PRESCRIPTION">
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>