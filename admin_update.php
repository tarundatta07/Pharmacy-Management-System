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
			$admin_id=$_POST['id'];
			$username=$_POST['username'];
			$fname=$_POST['first_name'];
			$lname=$_POST['last_name'];
			$email=$_POST['email_id'];

			$sql2 = mysqli_query($con,"SELECT username FROM admin where admin_id=$id")or die(mysqli_error());
			$row = mysqli_fetch_array($sql2);
			$p=$row['username'];

			if($username!=$p)
			{
				// Checking if username already exists 
				$sql1=mysqli_query($con,"SELECT * FROM admin WHERE username='$username'")or die(mysqli_error());
	 			$result1=mysqli_fetch_array($sql1);
	 			if($result1>0)
	 			{
					echo '<script type="text/javascript">
							var u;        
					 		u = "'.$username.'";
							alert("Sorry, the Username Entered \""+u+"\" Already Exists! \nPlease Try Again with some other Username..."); 
							window.location.href = "admin_update.php";
						   </script>';
	 			}
 			}
 			
				$sql="UPDATE admin SET admin_id='$admin_id',username='$username', first_name='$fname', last_name='$lname', email_id='$email' WHERE admin_id=$id";

				if(mysqli_query($con,$sql)) 
				{
					$_SESSION['admin_id']=$admin_id;
					$_SESSION['first_name']=$fname;
					$_SESSION['last_name']=$lname;
					echo '<script type="text/javascript">
							alert("Details has been Updated Successfully!"); 
							window.location.href = "admin_profile.php";
						   </script>';
				}
				else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
						      var e;        
						      e = "'.$error.'";
						      alert("Update Failed, Try Again! \nERROR : "+e);
						      window.location.href = "admin_update.php";
						 </script>';
				}
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> ADMIN DETAILS UPDATE PAGE </title>
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
			// Validation  for ID
			if(a == "ID")
			{
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Your ID');
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
			// Validation  for 	Username
			if(a == "Username")
			{
				var letters1 = /^[A-Za-z0-9]+$/;
				var letters2 = /^[A-Za-z]\w*$/;
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Your Username');
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
			// Validation  for First name
			if(a == "First name")
			{
				var letters = /^[A-Za-z]+$/;
				if(n == "")
				{
					textbox.setCustomValidity('Please Enter Your First name');
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
					textbox.setCustomValidity('Please Enter Your Last name');
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
					textbox.setCustomValidity('Please Enter Your Email ID');
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
						 <a href="admin_pharmacist.php"><img src="images/pharmacist.png" height="20px" align="center">&nbsp;&nbsp;Manage Pharmacist</a>
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
					<a href="admin_profile.php" class="active"><img src="images/userprofile.png" height="20px" align="center">&nbsp;&nbsp;User Profile</a>
					<a href="admin_changepass.php"><img src="images/password.png" height="20px" align="center">&nbsp;&nbsp;Change Password</a>
					<a onclick="return confirm('Are you sure you want to log out?')" href="logout.php"><img src="images/logout.png" height="20px" align="center">&nbsp;&nbsp;Logout</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<!-- THIS IS ADMIN MAIN CONTENT -->
				<div id="mainbox" align="center">
					<h4> ADMIN - UPDATE DETAILS <br>
						<span>-- Only modify details that you want to update --</span>
					</h4>
					<?php 
						$result = mysqli_query($con,"SELECT admin_id, username, first_name, last_name, email_id FROM admin where admin_id=$id")or die(mysqli_error());
						$row = mysqli_fetch_array($result);
						$a=$row['admin_id'];
						$b=$row['username'];
						$c=$row['first_name'];
						$d=$row['last_name'];
						$e=$row['email_id'];
					?>
				<form name="update_details" action="admin_update.php" method="post" autocomplete="OFF">
					<table>
        				<tr> 
        					<th>Admin ID</th> 
        					<td> <input type="text" name="id" value="<?php echo $a ?>" placeholder="ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>   
        					<th>Username </th> 
        					<td> <input type="text" name="username" value="<?php echo $b ?>" placeholder="Username" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        				<tr>
        					<th>First name </th> 
        					<td> <input type="text" name="first_name" value="<?php echo $c ?>" placeholder="First name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>
        				<tr>   
        					<th>Last name </th> 
        					<td> <input type="text" name="last_name" value="<?php echo $d ?>" placeholder="Last name" oninvalid="validate(this);" oninput="validate(this);" required=""> </td> 
        				</tr>   
        				<tr>   
        					<th>Email ID </th> 
        					<td> <input type="email" name="email_id" value="<?php echo $e ?>" placeholder="Email ID" oninvalid="validate(this);" oninput="validate(this);" required=""> </td>
        				</tr>
        			</table>
					<a href="admin_profile.php" class="button">GO BACK TO PROFILE</a>
        			<input type="submit" class="button" name="submit" value="UPDATE DETAILS">
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>