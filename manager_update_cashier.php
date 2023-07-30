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
		// GET CASHIER ID FROM URl
		if(isset($_GET['cashier_id']))
		{
			$cid=$_GET['cashier_id'];

			// GET DETAILS OF CASHIER TO BE UPDATED
			$result = mysqli_query($con,"SELECT username, first_name, last_name, address, phone, email_id FROM cashier where cashier_id='$cid'")or die(mysqli_error());
			$row = mysqli_fetch_array($result);
						
			$username=$row['username'];
			$fname=$row['first_name'];
			$lname=$row['last_name'];
			$address=$row['address'];
			$mobile=$row['phone'];
			$email=$row['email_id'];
		}

		if(isset($_POST['submit']))
		{
			$s_cid123=$_POST['cid11'];

			$s_cashier_id=$_POST['id'];
			$s_username=$_POST['username'];
			$s_fname=$_POST['first_name'];
			$s_lname=$_POST['last_name'];
			$s_address=$_POST['address'];
			$s_mobile=$_POST['mobile'];
			$s_email=$_POST['email_id'];


			$sql2 = mysqli_query($con,"SELECT username FROM cashier where cashier_id='$s_cid123'")or die(mysqli_error());
			$row = mysqli_fetch_array($sql2);
			$p=$row['username'];

			if($s_username!=$p)
			{
				// Checking if username already exists 
				$sql1=mysqli_query($con,"SELECT username FROM cashier WHERE username='$s_username'")or die(mysqli_error());
	 			$result1=mysqli_fetch_array($sql1);
	 			if($result1>0)
	 			{
					echo '<script type="text/javascript">
							var u;        
					 		u = "'.$s_username.'";
					 		var u1;        
					 		u1 = "'.$s_cid123.'";
							alert("Sorry, the Username Entered \""+u+"\" Already Exists! \nPlease Try Again with some other Username..."); 
							window.location.href = "manager_update_cashier.php?cashier_id="+u1;
						   </script>';
	 			}
 			}

				$sql="UPDATE cashier SET cashier_id='$s_cashier_id', username='$s_username', first_name='$s_fname', last_name='$s_lname', address='$s_address', phone='$s_mobile', email_id='$s_email' WHERE cashier_id='$s_cid123'";
				if(mysqli_query($con,$sql))
				{
					echo '<script type="text/javascript">
							var f;        
					 		f = "'.$s_fname.'";
					 		var l;
					 		l = "'.$s_lname.'";
							alert("Details of cashier \""+f+" "+l+"\" has been Updated Successfully!"); 
							window.location.href = "manager_cashier.php";
						   </script>';
				}
				else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
						      var e;        
						      e = "'.$error.'";
						      var u1;        
					 		  u1 = "'.$s_cid123.'";
						      alert("Update Failed, Try Again! \nERROR : "+e);
						      window.location.href = "manager_update_cashier.php?cashier_id="+u1;
						 </script>';
				}
		}
?>


			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> MANAGER UPDATE CASHIER PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/homepagestyle.css">
	<link rel="stylesheet" type="text/css" href="styles/profile.css">
	<script type="text/javascript">
		window.onload=on_load;
		// FUNCTION FOR ON LOAD
		function on_load()
		{
			var add= '<?php echo $address ?>';
			update_cashier.address.value =add;
		
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
			// Validation  for Cashier ID
			if(a == "Cashier ID")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Cashier\'s ID');
				}
				else if(isNaN(n))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if ((n - Math.floor(n)) != 0)
				{
					textbox.setCustomValidity('ID Cannot be a Decimal Number');
				}
				else if(n.includes("."))
				{
					textbox.setCustomValidity('Please Enter Digits Only');
				}
				else if(n == 0)
				{
					textbox.setCustomValidity('ID Cannot be Zero');
				}
				else if(n < 0)
				{
					textbox.setCustomValidity('ID Cannot be Negative Number');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for First name
			if(a == "First name")
			{
				var letters = /^[A-Za-z]+$/;
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Cashier\'s First name');
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
			// Validation  for Last name
			if(a == "Last name")
			{
				var letters = /^[A-Za-z]+$/;
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Cashier\'s Last name');
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
			// Validation  for 	Username
			if(a == "Username")
			{
				var letters1 = /^[A-Za-z0-9]+$/;
				var letters2 = /^[A-Za-z]\w*$/;
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Cashier\'s Username');
				}
				else if(!n.match(letters1)) 
				{
   					textbox.setCustomValidity('Special Characters are not allowed');
				}
				else if(!n.match(letters2))
				{
					textbox.setCustomValidity('Username Cannot Start with a Number');
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
					textbox.setCustomValidity('Please Enter Cashier\'s Address');
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
					textbox.setCustomValidity('Please Enter Cashier\'s Mobile Number');
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
			// Validation  for Email ID
			if(a == "Email ID")
			{
				// email id must contain the @ and . character
				// There must be at least one character before and after the @.
				// There must be at least two characters after . (dot).
				var atpos=n.indexOf('@');  
				var dotpos=n.lastIndexOf('.'); 
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Cashier\'s Email ID');
				}
				else if(atpos<1 || dotpos<atpos+2 || dotpos+2>=n.length)
				{  
  					textbox.setCustomValidity('Please Enter Valid E-mail Address');
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
						 <a href="manager_cashier.php" class="active"><img src="images/cashier.png" height="20px" align="center">&nbsp;&nbsp;Manage Cashier</a>
						 <a href="manager_stocks.php"><img src="images/stocks.png" height="20px" align="center">&nbsp;&nbsp;Stocks</a>
						 <a href="manager_update_stocks.php"><img src="images/updatestocks.png" height="20px" align="center">&nbsp;&nbsp;Update Stocks</a>
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
					<h4> MANAGER - UPDATE CASHIER <br>
						<span>-- Only modify details that you want to update --</span>
					</h4>
				<form name="update_cashier" id="update_cashier" action="manager_update_cashier.php" method="post" autocomplete="OFF">

					<input type='hidden' name='cid11' value='<?php echo "$cid"; ?>'> 

					<table>
        				<tr> 
        					<th>Cashier ID</th> 
        					<td> <input type="text" name="id" value="<?php echo "$cid" ?>" placeholder="Cashier ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>   
        					<th>Username </th> 
        					<td> <input type="text" name="username" value="<?php echo $username ?>" placeholder="Username" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>
        					<th>First name </th> 
        					<td> <input type="text" name="first_name" value="<?php echo $fname ?>" placeholder="First name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Last name </th> 
        					<td> <input type="text" name="last_name" value="<?php echo $lname ?>" placeholder="Last name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Address </th> 
        					<td> <textarea name="address" rows="3" form="update_cashier" placeholder="Address" wrap="soft" oninvalid="validate(this);" oninput="validate(this);" required=""></textarea> </td> 
        				</tr>
        				<tr>   
        					<th>Mobile No. </th> 
        					<td> <input type="text" name="mobile" value="<?php echo $mobile ?>" placeholder="Mobile Number" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>   
        				<tr>   
        					<th>Email ID </th> 
        					<td> <input type="email" name="email_id" value="<?php echo $email ?>" placeholder="Email ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        			</table>
					<a href="manager_cashier.php" class="button">GO BACK</a>
        			<input type="submit" class="button" name="submit" value="UPDATE DETAILS"> <br> &nbsp;
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>