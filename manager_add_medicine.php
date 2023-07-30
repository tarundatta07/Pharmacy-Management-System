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
		if(isset($_POST['submit']))
		{
				$med_id=$_POST['med_id'];
				$med_name=$_POST['med_name'];
				$quantity=$_POST['quantity'];
				$unit_price=$_POST['unit_price'];
				$expiry_date=$_POST['expiry_date'];
				$med_status=$_POST['med_status'];

				// Checking if Medicine name already exists 
				$sql1=mysqli_query($con,"SELECT * FROM medicine WHERE medicine_name='$med_name'")or die(mysqli_error());
	 			$result1=mysqli_fetch_array($sql1);
	 			if($result1>0)
	 			{
					echo '<script type="text/javascript">
							var u;        
					 		u = "'.$med_name.'";
							alert("The Medicine Name Entered \""+u+"\" Already Exists! \nYou can Update the Medicine Instead...");
							window.location.href = "manager_update_stocks.php";
						   </script>';
	 			}
	 			else
	 			{
					$sql="INSERT INTO medicine (medicine_id, medicine_name, quantity, unit_price, expiry_date, medicine_status) VALUES ('$med_id', '$med_name', '$quantity', '$unit_price', '$expiry_date', '$med_status')";

					if(mysqli_query($con,$sql)) 
					{
						echo '<script type="text/javascript">
								var m;        
						 		m = "'.$med_name.'";
								alert("New Medicine : \""+m+"\" has been added Successfully!");
								window.location.href = "manager_update_stocks.php";
							   </script>';
					}
					else
					{
						$error=mysqli_error($con);
						echo '<script type="text/javascript">
							      var e;        
							      e = "'.$error.'";
							      alert("Inserting Medicine Failed, Try Again! \nERROR : "+e);
							      window.location.href = "manager_add_medicine.php";
							 </script>';
					}
			
				}
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> MANAGER ADD MEDICINE PAGE </title>
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
						 <a href="manager_profile.php"><img src="images/manager1.png" height="80px" align="center" style="border:3px solid black;border-radius:20px;margin-bottom:3px;">
						 	<br><?php echo 'Welcome, '.$first_name.' '.$last_name ?>
						 </a>
						</center>
						 <a href="manager.php"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="manager_pharmacist.php"><img src="images/pharmacist.png" height="20px" align="center">&nbsp;&nbsp;Manage Pharmacist</a>
						 <a href="manager_cashier.php"><img src="images/cashier.png" height="20px" align="center">&nbsp;&nbsp;Manage Cashier</a>
						 <a href="manager_stocks.php"><img src="images/stocks.png" height="20px" align="center">&nbsp;&nbsp;Stocks</a>
						 <a href="manager_update_stocks.php" class="active"><img src="images/updatestocks.png" height="20px" align="center">&nbsp;&nbsp;Update Stocks</a>
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
					<h4> MANAGER - ADD NEW MEDICINE </h4>
					
				<form name="add_medicine" action="manager_add_medicine.php" method="post" autocomplete="OFF">
					<table>
        				<tr> 
        					<th>Medicine ID</th> 
        					<td> <input type="text" name="med_id" placeholder="Medicine ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>
        					<th>Medicine name</th> 
        					<td> <input type="text" name="med_name" placeholder="Medicine name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Quantity</th> 
        					<td> <input type="text" name="quantity" placeholder="Quantity" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Unit price</th> 
        					<td> <input type="text" name="unit_price" placeholder="Unit price" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>   
        					<th>Expiry Date</th> 
        					<td> <input type="date" name="expiry_date" placeholder="Expiry Date" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Medicine Status</th> 
        					<td> 
        					<select name="med_status" oninvalid="this.setCustomValidity('Please Select Medicine Status')" oninput="setCustomValidity('')" required="">
								<option value="">Select Status</option>
								<option value="Available">Available</option>
								<option value="Not Available">Not Available</option>
							</select>
							</td>
        				</tr>  
        			</table>
					<a href="manager_update_stocks.php" class="button">GO BACK</a>
        			<input type="submit" class="button" name="submit" value="ADD MEDICINE"> <br> &nbsp;
        			
        			<a href="manager_add_medicines.php" class="button">ADD MEDICINES THROUGH CSV FILE</a><br> &nbsp;
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>