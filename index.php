 		<!-- PHP CODE STARTS FROM HERE -->
<?php
			include_once('connect_db.php');
			$username = $password = $position = $message = "";
			if(isset($_POST['submit']))
			{
				$username=$_POST['username'];
				$password=$_POST['password'];
				$position=$_POST['position'];

				// ADMIN LOGIN DETAILS
				if($position == 'admin')
				{
					$sql="SELECT admin_id, first_name, last_name FROM admin WHERE username='$username' AND password='$password'";
					$result=mysqli_query($con,$sql);
					$row=mysqli_fetch_array($result);
					if($row>0)
					{
						session_start();
						$_SESSION['admin_id']=$row[0];
						$_SESSION['first_name']=$row[1];
						$_SESSION['last_name']=$row[2];
						echo "<script>location.href='loading.php?position=admin';</script>";
						
						// header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/admin.php");
					}
					else
					{
						$message="<font color=red>Username or Password is Incorrect Try Again</font>";
					}
				}
				// MANAGER LOGIN DETAILS
				if($position == 'manager')
				{
					$sql="SELECT manager_id, first_name, last_name FROM manager WHERE username='$username' AND password='$password'";
					$result=mysqli_query($con,$sql);
					$row=mysqli_fetch_array($result);
					if($row>0)
					{
						session_start();
						$_SESSION['manager_id']=$row[0];
						$_SESSION['first_name']=$row[1];
						$_SESSION['last_name']=$row[2];
						echo "<script>location.href='loading.php?position=manager';</script>";
						
						// header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/manager.php");
					}
					else
					{
						$message="<font color=red>Username or Password is Incorrect Try Again</font>";
					}
				}
				// PHARMACIST LOGIN DETAILS
				if($position == 'pharmacist')
				{
					$sql="SELECT pharmacist_id, first_name, last_name FROM pharmacist WHERE username='$username' AND password='$password'";
					$result=mysqli_query($con,$sql);
					$row=mysqli_fetch_array($result);
					if($row>0)
					{
						session_start();
						$_SESSION['pharmacist_id']=$row[0];
						$_SESSION['first_name']=$row[1];
						$_SESSION['last_name']=$row[2];
						echo "<script>location.href='loading.php?position=pharmacist';</script>";
						
						// header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/pharmacist.php");
					}
					else
					{
						$message="<font color=red>Username or Password is Incorrect Try Again</font>";
					}
				}
				// CASHIER LOGIN DETAILS
				if($position == 'cashier')
				{
					$sql="SELECT cashier_id, first_name, last_name FROM cashier WHERE username='$username' AND password='$password'";
					$result=mysqli_query($con,$sql);
					$row=mysqli_fetch_array($result);
					if($row>0)
					{
						session_start();
						$_SESSION['cashier_id']=$row[0];
						$_SESSION['first_name']=$row[1];
						$_SESSION['last_name']=$row[2];
						echo "<script>location.href='loading.php?position=cashier';</script>";
						
						// header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/cashier.php");
					}
					else
					{
						$message="<font color=red>Username or Password is Incorrect Try Again</font>";
					}
				}
			}
?>

		<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title>PHARMACY MANAGEMENT SYSTEM</title>
	<link rel="stylesheet" type="text/css" href="styles/loginstyle.css">
	<link rel="icon" href="images/favicon.png">
	<script type="text/javascript">
		function validate(textbox) 
		{
			var v = textbox.value;
			var n = v.trim();
			if(n == "")
			{
				textbox.setCustomValidity('Please Enter your Username');
			}
			else
			{
				textbox.setCustomValidity('');
			}
		}

		function showpassword() 
		{
			var a = document.getElementById('pass');
			var image = document.getElementById('showpass');

			if(a.type == 'password')
			{
				a.type='text';
				image.src = "images/hide.png";
			}
			else
			{
				a.type='password';
				image.src = "images/show.png";
			}
		}
		
	</script>
</head>
<body>
	<!-- MAIN CONTENT -->
	<div id="loginpage">
		<!-- THIS IS HEADER CONTENT -->
		<?php include_once('header.php'); ?>
		<!-- THIS IS LOGIN FORM CONTENT -->
		<div id="login" align="center">
				<form class="box" name="loginform" action="index" method="post" autocomplete="OFF">
						<center>
							<h2><u> &nbsp;LOGIN&nbsp;</u></h2>
							<?php  echo $message; ?> <br> <br>
							USERNAME : <br>
							<img src="images/user.png" alt="USER LOGO" height="26px" width="24px" align="center">&nbsp;
							<input type="text" id="text" name="username" placeholder="Enter Username" oninvalid="validate(this);" oninput="validate(this);" required=""> 
							<br>
						
							PASSWORD : <br>
							<img src="images/lock.png" alt="LOCK LOGO" height="23px" width="23px" align="center">&nbsp;
							<input type="password" id="pass" name="password" placeholder="Enter Password" oninvalid="this.setCustomValidity('Please Enter your Password')" oninput="setCustomValidity('')" required="">&nbsp;
							<img src="images/show.png" id="showpass" alt="SHOW LOGO" height="23px" width="23px" align="center" onclick="showpassword();">
							<br> <br>
							
							SELECT POSITION : &nbsp;<select name="position" oninvalid="this.setCustomValidity('Please Select your Position')" oninput="setCustomValidity('')" required="">
								<option value="">Select Position</option>
								<option value="admin">Admin</option>
								<option value="manager">Manager</option>
								<option value="pharmacist">Pharmacist</option>
								<option value="cashier">Cashier</option>
							</select>
							<br> <br>
							<input type="submit" name="submit" value="LOGIN">
						</center>
				</form>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>