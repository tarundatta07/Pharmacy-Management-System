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
			$result1 = mysqli_query($con,"SELECT password FROM pharmacist where pharmacist_id=$id")or die(mysqli_error());
			$row1 = mysqli_fetch_array($result1);
			$password=$row1['password'];

			$current_pass=$_POST['current_pass'];
			
			if($current_pass!=$password)
			{
				echo '<script type="text/javascript">
							alert("Current Password is not Correct! \nPlease Try Again..."); 
							window.location.href = "pharmacist_changepass.php";
						   </script>';
			}
			else
			{
				$new_pass=$_POST['new_pass'];
				$re_pass=$_POST['re_pass'];
				if($re_pass!=$new_pass)
				{
					echo '<script type="text/javascript">
							alert("Passwords did not Match! \nPlease Try Again..."); 
							window.location.href = "pharmacist_changepass.php";
						   </script>';
				}
				else
				{
					$sql="UPDATE pharmacist SET password='$new_pass' WHERE pharmacist_id='$id'";

					if(mysqli_query($con,$sql)) 
					{
						echo '<script type="text/javascript">
								alert("Password has been changed Successfully! \nPlease Login Again..."); 
								window.location.href = "index.php";
							   </script>';
					}
					else
					{
						$error=mysqli_error($con);
						echo '<script type="text/javascript">
							      var e;        
							      e = "'.$error.'";
							      alert("Password Update Failed, Try Again! \nERROR : "+e);
							      window.location.href = "pharmacist_changepass.php";
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
	<title> PHARMACIST CHANGE PASSWORD PAGE </title>
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
			// Validation  for Current Password
			if(a == "Current Password")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Your Current Password');
				}
				else
				{
					textbox.setCustomValidity('');
				}
			}
			// Validation  for New Password
			if(a == "New Password")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Your New Password');
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
			// Validation  for Re-enter Password
			if(a == "Re-enter Password")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Re-enter Your New Password');
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
					<a href="pharmacist_changepass.php" class="active"><img src="images/password.png" height="20px" align="center">&nbsp;&nbsp;Change Password</a>
					<a onclick="return confirm('Are you sure you want to log out?')" href="logout.php"><img src="images/logout.png" height="20px" align="center">&nbsp;&nbsp;Logout</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<!-- THIS IS PHARMACIST MAIN CONTENT -->
				<div id="mainbox" align="center">
					<h4> PHARMACIST - CHANGE PASSWORD
					</h4>
					<?php 
						$result = mysqli_query($con,"SELECT pharmacist_id, username FROM pharmacist where pharmacist_id=$id")or die(mysqli_error());
						$row = mysqli_fetch_array($result);
						$a=$row['pharmacist_id'];
						$b=$row['username'];
					?>
				<form name="change_pass" action="pharmacist_changepass.php" method="post" autocomplete="OFF">
					<table>
        				<tr> 
        					<th>Pharmacist ID</th> 
        					<td> <input type="text" name="id" value="<?php echo $a ?>" placeholder="ID"readonly=""> </td>
        				</tr>
        				<tr>   
        					<th>Username </th> 
        					<td> <input type="text" name="username" value="<?php echo $b ?>" placeholder="Username" readonly=""> </td>
        				</tr>
        				<tr>
        					<th>Enter Current Password </th> 
        					<td> <input type="password" name="current_pass" placeholder="Current Password" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Enter New Password</th> 
        					<td> <input type="password" name="new_pass" placeholder="New Password" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>   
        				<tr>   
        					<th>Re-enter New Password</th> 
        					<td> <input type="password" name="re_pass" placeholder="Re-enter Password" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        			</table>
        			<input type="submit" class="button" name="submit" value="CHANGE PASSWORD">
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>