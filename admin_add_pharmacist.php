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
		if(isset($_POST['submit']))
		{
			$pharmacist_id=$_POST['id'];
			$fname=$_POST['first_name'];
			$lname=$_POST['last_name'];
			$username=$_POST['username'];
			$password=$_POST['password'];
			$cpass=$_POST['cpass'];
		 	$address=$_POST['address'];
			$mobile=$_POST['mobile'];
			$email=$_POST['email_id'];

			if($password!=$cpass)
			{
				echo '<script type="text/javascript">
							alert("Passwords did not Match! \nPlease Try Again..."); 
							window.location.href = "admin_add_pharmacist.php";
						   </script>';
			}
			else
			{	
				// Checking if username already exists 
				$sql1=mysqli_query($con,"SELECT * FROM pharmacist WHERE username='$username'")or die(mysqli_error());
	 			$result1=mysqli_fetch_array($sql1);
	 			if($result1>0)
	 			{
					echo '<script type="text/javascript">
							var u;        
					 		u = "'.$username.'";
							alert("Sorry, the Username Entered \""+u+"\" Already Exists! \nPlease Try Again with some other Username...");
							window.location.href = "admin_add_pharmacist.php";
						   </script>';
	 			}
	 			else
	 			{
					$sql="INSERT INTO pharmacist (pharmacist_id, username, password, first_name, last_name, address, phone, email_id, date) VALUES ('$pharmacist_id', '$username', '$password', '$fname', '$lname', '$address', '$mobile', '$email', NOW())";

					if(mysqli_query($con,$sql)) 
					{
						echo '<script type="text/javascript">
								var f;        
						 		f = "'.$fname.'";
						 		var l;
						 		l = "'.$lname.'";
								alert("New Pharmacist : \""+f+" "+l+"\" has been added Successfully!");
								window.location.href = "admin_pharmacist.php";
							   </script>';
					}
					else
					{
						$error=mysqli_error($con);
						echo '<script type="text/javascript">
							      var e;        
							      e = "'.$error.'";
							      alert("Inserting Pharmacist Failed, Try Again! \nERROR : "+e);
							      window.location.href = "admin_add_pharmacist.php";
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
	<title> ADMIN ADD PHARMACIST PAGE </title>
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
			// Validation  for Pharmacist ID
			if(a == "Pharmacist ID")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Pharmacist\'s ID');
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
					textbox.setCustomValidity('Please Enter Pharmacist\'s First name');
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
					textbox.setCustomValidity('Please Enter Pharmacist\'s Last name');
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
					textbox.setCustomValidity('Please Enter Pharmacist\'s Username');
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
			// Validation  for Password
			if(a == "Password")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Pharmacist\'s Password');
				}
				else if(n.length<8)
				{
					textbox.setCustomValidity('Password Length must be atleast 8 Characters');
				}
				else if(n.length>15)
				{
					textbox.setCustomValidity('Password Length must not exceed 15 Characters');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for Confirm Password
			if(a == "Confirm Password")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Re-enter Pharmacist\'s Password');
				}
				else if(n.length<8)
				{
					textbox.setCustomValidity('Password Length must be atleast 8 Characters');
				}
				else if(n.length>15)
				{
					textbox.setCustomValidity('Password Length must not exceed 15 Characters');
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
					textbox.setCustomValidity('Please Enter Pharmacist\'s Address');
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
					textbox.setCustomValidity('Please Enter Pharmacist\'s Mobile Number');
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
					textbox.setCustomValidity('Please Enter Pharmacist\'s Email ID');
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
						 <a href="admin_profile.php"><img src="images/admin.png" height="80px" align="center" style="border:3px solid black;border-radius:20px;margin-bottom:3px;">
						 	<br><?php echo 'Welcome, '.$first_name.' '.$last_name ?>
						 </a>
						</center>
						 <a href="admin.php"><img src="images/dashboard.png" height="20px" align="center">&nbsp;&nbsp;Dashboard</a>
						 <a href="admin_manager.php"><img src="images/manager.png" height="20px" align="center">&nbsp;&nbsp;Manage Manager</a>
						 <a href="admin_pharmacist.php" class="active"><img src="images/pharmacist.png" height="20px" align="center">&nbsp;&nbsp;Manage Pharmacist</a>
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
					<h4> ADMIN - ADD NEW PHARMACIST </h4>
				<form name="add_pharmacist" id="add_pharmacist" action="admin_add_pharmacist.php" method="post" autocomplete="OFF">
					<table>
        				<tr> 
        					<th>Pharmacist ID</th> 
        					<td> <input type="text" name="id" placeholder="Pharmacist ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>
        					<th>First name </th> 
        					<td> <input type="text" name="first_name" placeholder="First name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Last name </th> 
        					<td> <input type="text" name="last_name" placeholder="Last name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Username </th> 
        					<td> <input type="text" name="username" placeholder="Username" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>   
        					<th>Password </th> 
        					<td> <input type="password" name="password" placeholder="Password" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Confirm Password </th> 
        					<td> <input type="password" name="cpass" placeholder="Confirm Password" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>  
        				<tr>   
        					<th>Address </th> 
        					<td><textarea name="address" rows="3" form="add_pharmacist" placeholder="Address" wrap="soft" oninvalid="validate(this);" oninput="validate(this);" required=""></textarea> </td>
        				</tr>
        				<tr>   
        					<th>Mobile No.</th> 
        					<td> <input type="text" name="mobile" placeholder="Mobile Number" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>   
        					<th>Email ID </th> 
        					<td> <input type="email" name="email_id" placeholder="Email ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        			</table>
					<a href="admin_pharmacist.php" class="button">GO BACK</a>
        			<input type="submit" class="button" name="submit" value="ADD PHARMACIST"> <br> &nbsp;
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>