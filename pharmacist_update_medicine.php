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
			$s_mid123=$_POST['mid11'];

			$s_med_id=$_POST['med_id'];
			$s_med_name=$_POST['med_name'];
			$s_quantity=$_POST['quantity'];
			$s_unit_price=$_POST['unit_price'];
			$s_expiry_date=$_POST['expiry_date'];
			$s_med_status=$_POST['med_status'];


			$sql2 = mysqli_query($con,"SELECT medicine_name FROM medicine where medicine_id='$s_mid123'")or die(mysqli_error());
			$row = mysqli_fetch_array($sql2);
			$p=$row['medicine_name'];

			if($s_med_name!=$p)
			{
				// Checking if Medicine name already exists 
				$sql1=mysqli_query($con,"SELECT medicine_id, medicine_name FROM medicine where medicine_name='$s_med_name'")or die(mysqli_error());
	 			$result1=mysqli_fetch_array($sql1);
	 			$mid_old = $result1['medicine_id'];
	 			$med_name_old = $result1['medicine_name'];
	 			if($result1>0)
	 			{
					echo '<script type="text/javascript">
							var u;        
					 		u = "'.$med_name_old.'";
					 		var u1;        
					 		u1 = "'.$mid_old.'";
					 		var u2;
					 		u2 = "'.$s_mid123.'";
					 		var confirm = confirm("The Medicine Name Entered \""+u+"\" Already Exists! \nDo you want to Update that Medicine Instead...");
					 		if(confirm == true)
	         				{ 
	             				window.location.href="pharmacist_update_medicine.php?medicine_id="+u1;
	           				}
	           				else
	           				{
	           					alert("The Medicine Name Entered \""+u+"\" Already Exists! \nPlease Try Again with other Medicine name");
	           					window.location.href="pharmacist_update_medicine.php?medicine_id="+u2;
	           				}
						   </script>';

	 			}
 			}

				$sql="UPDATE medicine SET medicine_id='$s_med_id', medicine_name='$s_med_name', quantity='$s_quantity', unit_price='$s_unit_price', expiry_date='$s_expiry_date', medicine_status='$s_med_status' WHERE medicine_id='$s_mid123'";
				if(mysqli_query($con,$sql))
				{
					echo '<script type="text/javascript">
							var m;        
					 		m = "'.$s_med_name.'";
							alert("Details of Medicine \""+m+"\" has been Updated Successfully!"); 
							window.location.href = "pharmacist_update_stocks.php";
						   </script>';
				}
				else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
						      var e;        
						      e = "'.$error.'";
						      var u1;        
					 		  u1 = "'.$s_mid123.'";
						      alert("Update Failed, Try Again! \nERROR : "+e);
						      window.location.href = "pharmacist_update_medicine.php?medicine_id="+u1;
						 </script>';
				}
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> PHARMACIST UPDATE MEDICINE PAGE </title>
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
			var a = textbox.placeholder;
			var v = textbox.value;
			var n = v.trim();
			// Validation  for Medicine ID
			if(a == "Medicine ID")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Medicine ID');
				}
				else if(isNaN(n))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if ((n - Math.floor(n)) != 0)
				{
					textbox.setCustomValidity('Medicine ID Cannot be a Decimal Number');
				}
				else if(n.includes("."))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if(n == 0)
				{
					textbox.setCustomValidity('Medicine ID Cannot be Zero');
				}
				else if(n < 0)
				{
					textbox.setCustomValidity('Medicine ID Cannot be Negative Number');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for Medicine name
			if(a == "Medicine name")
			{
				var letters = /^[A-Za-z ]+$/;
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Medicine Name');
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
			// Validation  for Quantity
			if(a == "Quantity")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Quantity of Medicines');
				}
				else if(isNaN(n))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if ((n - Math.floor(n)) != 0)
				{
					textbox.setCustomValidity('Quantity Cannot be a Decimal Number');
				}
				else if(n.includes("."))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if(n == 0)
				{
					textbox.setCustomValidity('Quantity of Medicine Cannot be Zero');
				}
				else if(n < 0)
				{
					textbox.setCustomValidity('Quantity of Medicine Cannot be Negative Number');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for Unit price
			if(a == "Unit price")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Unit Price of Medicine');
				}
				else if(isNaN(n))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if(n.length - (n.indexOf(".")+1) > 2)  
				{
					textbox.setCustomValidity('Please Enter Only Two Digits after Decimal');	
				}
				else if(n.length - (n.indexOf(".")+1) == 0)
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if(n == 0)
				{
					textbox.setCustomValidity('Unit Price Cannot be Zero');
				}
				else if(n < 0)
				{
					textbox.setCustomValidity('Unit Price Cannot be Negative Number');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for Expiry Date
			if(a == "Expiry Date")
			{
				var today = new Date();
     		 	var input = new Date(textbox.value);
     		 	
     		 	var todayYear = today.getFullYear();// Get the year as a four digit number (yyyy)
     		 	var todayMonth = today.getMonth()+1; // Get the month as a number (0-11)
     		 	var todayDate = today.getDate();  // Get the day as a number (1-31)

     		 	var inputYear = input.getFullYear();
     		 	var inputMonth = input.getMonth()+1;
     		 	var inputDate = input.getDate();

				if(n=="")
				{
					textbox.setCustomValidity('Please Select Expiry Date of Medicine');
				}
				else if(inputYear < todayYear || (inputYear <= todayYear && inputMonth < todayMonth) || (inputYear <= todayYear && inputMonth <= todayMonth && inputDate < todayDate))
				{
					textbox.setCustomValidity('The expiry date is before today\'s date. Please select a valid expiry date');
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
						 <a href="pharmacist_update_stocks.php" class="active"><img src="images/updatestocks.png" height="20px" align="center">&nbsp;&nbsp;Update Stocks</a>
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
					<h4> PHARMACIST - UPDATE MEDICINE <br>
						<span>-- Only modify details that you want to update --</span>
					</h4>
					<?php
						// GET MEDICINE ID FROM URl
						if(isset($_GET['medicine_id']))
						{
							$mid=$_GET['medicine_id'];

							// GET DETAILS OF MEDICINE TO BE UPDATED
							$result = mysqli_query($con,"SELECT medicine_name, quantity, unit_price, expiry_date, medicine_status FROM medicine where medicine_id='$mid'")or die(mysqli_error());
							$row = mysqli_fetch_array($result);
							
							$med_name=$row['medicine_name'];
							$quantity=$row['quantity'];
							$unit_price=$row['unit_price'];
							$expiry_date=$row['expiry_date'];
							$med_status=$row['medicine_status'];
						}
					?>
				<form name="update_medicine" action="pharmacist_update_medicine.php" method="post" autocomplete="OFF">

					<input type='hidden' name='mid11' value='<?php echo "$mid"; ?>'> 

					<table>
        				<tr> 
        					<th>Medicine ID</th> 
        					<td> <input type="text" name="med_id" value="<?php echo "$mid" ?>" placeholder="Medicine ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>
        					<th>Medicine name</th> 
        					<td> <input type="text" name="med_name" value="<?php echo "$med_name" ?>" placeholder="Medicine name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Quantity</th> 
        					<td> <input type="text" name="quantity" value="<?php echo "$quantity" ?>" placeholder="Quantity" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Unit price</th> 
        					<td> <input type="text" name="unit_price" value="<?php echo "$unit_price" ?>" placeholder="Unit price" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>   
        					<th>Expiry Date</th> 
        					<td> <input type="date" name="expiry_date" value="<?php echo "$expiry_date" ?>" placeholder="Expiry Date" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Medicine Status</th> 
        					<td> 
        					<select name="med_status" oninvalid="this.setCustomValidity('Please Select Medicine Status')" oninput="setCustomValidity('')" required="">
        					<?php 
        						if($med_status=="Available")
        						{
        					?>
								<option value="">Select Status</option>
								<option value="Available" selected>Available</option>
								<option value="Not Available">Not Available</option>
							<?php
								}
							?>
							<?php 
        						if($med_status=="Not Available")
        						{
        					?>
								<option value="">Select Status</option>
								<option value="Available">Available</option>
								<option value="Not Available" selected>Not Available</option>
							<?php
								}
							?>
							</select>
							</td>
        				</tr>  
        			</table>
					<a href="pharmacist_update_stocks.php" class="button">GO BACK</a>
        			<input type="submit" class="button" name="submit" value="UPDATE DETAILS"> <br> &nbsp;
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>