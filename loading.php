<?php
		session_start();
		if(isset($_SESSION['first_name']))
		{
			if(isset($_GET['position']))
			{
				if($_GET['position']=='admin')
				{
					echo "<script>setTimeout(\"location.href='admin.php';\",2000)</script>";
				}
				else if($_GET['position']=='manager')
				{
					echo "<script>setTimeout(\"location.href='manager.php';\",2000)</script>";
				}
				else if($_GET['position']=='pharmacist')
				{
					echo "<script>setTimeout(\"location.href='pharmacist.php';\",2000)</script>";
				}
				else if($_GET['position']=='cashier')
				{
					echo "<script>setTimeout(\"location.href='cashier.php';\",2000)</script>";
				}
				else
				{
					header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
					exit();
				}
			}
			else
			{
				header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
				exit();
			}
		}
		else
		{
			header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
			exit();
		}
?>
<!DOCTYPE html>
<html>
<head>
	<title> INVOICE MANAGEMENT SYSTEM </title>
	<link rel="icon" href="images/favicon.png">
	<style type="text/css">
		body
		{
			background: #ffe5e5;
		}
		#loading
		{
			position: absolute;
			top: 45%;
			left: 42%;
		}
		img
		{
			vertical-align: middle;
		}
		span
		{
			vertical-align: middle;
			font-size: 20px;
			color: black;
		}
	</style>
</head>
<body>
	<div id="loading">
		<img src="images/load.png" height="35px" width="35px"> 
		<span>&nbsp;Please Wait...Connect To Server </span>
	</div>	
</body>
</html>