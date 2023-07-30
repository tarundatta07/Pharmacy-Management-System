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
			$s_med123=$_POST['med11'];

			$s_quantity=$_POST['quantity'];
			$s_unit_price=$_POST['unit_price'];

			$sql6=mysqli_query($con,"SELECT unit_price,quantity FROM medicine WHERE medicine_name='$s_med123'")or die(mysqli_error());
	 		$result6=mysqli_fetch_array($sql6);
	 		$s_unit_price=$result6['unit_price'];
	 		$s_stock_quantity=$result6['quantity'];

	 		if($s_quantity>$s_stock_quantity)
	 		{
	 			echo '<script type="text/javascript">
						var p;        
						p = "'.$s_pid123.'";
						var m;
						m = "'.$s_med123.'";
						var s;
						s = "'.$s_stock_quantity.'";
						var q;
						q = "'.$s_quantity.'";
						alert("Quantity \'"+q+"\' Entered for Medicine \""+m+"\" exceeds currently available Stock...\nThe currently available Stock for Medicine \""+m+"\" is \'"+s+"\'");
								window.location.href = "pharmacist_update_pres_details.php?pres_id="+p+"&med_name="+m;
					   </script>';
	 		}
	 		else
	 		{
			$s_cost=$s_quantity*$s_unit_price;

			$sql2 = mysqli_query($con,"SELECT unit_price FROM prescription_details WHERE pres_id='$s_pid123' AND medicine_name='$s_med123'")or die(mysqli_error());
			$row = mysqli_fetch_array($sql2);
			$p=$row['unit_price'];

			if($p!="")
			{
				$sql="UPDATE prescription_details SET quantity='$s_quantity', cost='$s_cost' WHERE pres_id='$s_pid123' AND medicine_name='$s_med123'";
				if(mysqli_query($con,$sql))
				{
					echo '<script type="text/javascript">
							var p;        
						 	p = "'.$s_pid123.'";
						 	var m;
						 	m = "'.$s_med123.'";
							alert("Quantity Details of Prescription ID : \""+p+"\" with Medicine name \""+m+"\" has been Updated Successfully!"); 
								window.location.href = "pharmacist_add_pres_details.php?pres_id="+p;
							</script>';
				}
				else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
							var e;        
							e = "'.$error.'";
							var p;        
						 	p = "'.$s_pid123.'";
						 	var m;
						 	m = "'.$s_med123.'";
							alert("Updating Prescription Detail Failed, Try Again! \nERROR : "+e);
							window.location.href = "pharmacist_update_pres_details.php?pres_id="+p+"&med_name="+m;
						  </script>';
				}
			}
			else
			{
				$error=mysqli_error($con);
				echo '<script type="text/javascript">
						var e;        
						e = "'.$error.'";
						var p;        
						p = "'.$s_pid123.'";
						var m;
						m = "'.$s_med123.'";
						alert("Updating Prescription Detail Failed, Try Again! \nERROR : "+e);
							window.location.href = "pharmacist_update_pres_details.php?pres_id="+p+"&med_name="+m;
					   </script>';
			}
			}
		}

		// GET PRESCRIPTION ID AND MEDICINE NAME FROM URl
		if(isset($_GET['pres_id']) && isset($_GET['med_name']))
		{
			$pid=$_GET['pres_id'];
			$med=$_GET['med_name'];

			// GET DETAILS OF PRESCRIPTION TO BE UPDATED
			$result = mysqli_query($con,"SELECT quantity, unit_price FROM prescription_details WHERE pres_id='$pid' AND medicine_name='$med'")or die(mysqli_error());
			$row = mysqli_fetch_array($result);

			$quantity=$row['quantity'];
			$unit_price=$row['unit_price'];
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> PHARMACIST UPDATE PRESCRIPTION DETAIL PAGE </title>
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
		function increment() 
		{
	      	var a = document.getElementById('quantity').value;
	      	a=parseInt(a);
	      	if(a>=1)
	      	{
	      		a=a+1;
	      		document.getElementById('quantity').value=a;
	      	}
	   	}
	  	function decrement() 
	  	{
	      	var a = document.getElementById('quantity').value;
	      	a=parseInt(a);
	      	if(a>1)
	      	{
	      		a=a-1;
	      		document.getElementById('quantity').value=a;
	      	}
	      	if(a==1)
	      	{
	      		document.getElementById('quantity').value=a;
	      	}
	   	}
	   	function validate(textbox)
		{
			var n = textbox.value;
			if(n == "")
			{
				textbox.setCustomValidity('Please Enter Quantity of Medicine');
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
					<h4> PHARMACIST - UPDATE PRESCRIPTION DETAIL<br>
						<span>-- You can only modify/ update details of Quantity  --</span>
					</h4>
				<form name="update_pres_details" id="update_pres_details" action="pharmacist_update_pres_details.php" method="post" autocomplete="OFF">

					<input type='hidden' name='pid11' value='<?php echo "$pid"; ?>'>
					<input type='hidden' name='med11' value='<?php echo "$med"; ?>'>

					<table>
        				<tr> 
        					<th>Prescription ID</th> 
        					<td> <input type="text" name="pres_id" value="<?php echo "$pid" ?>" placeholder="Prescription ID" readonly=""> </td>
        				</tr>
        				<tr>
        					<th>Medicine Name</th> 
        					<td> <input type="text" name="med_name" value="<?php echo "$med" ?>" placeholder="Medicine Name" readonly=""> </td>
        				</tr>
        				<tr>   
        					<th>Quantity</th> 
        					<td> <input type="text" id="quantity" name="quantity" value="<?php echo "$quantity" ?>" placeholder="Quantity" oninvalid="validate(this);" oninput="validate(this);" required="">
								<button onclick="increment(); return false;" id="btn1">+</button>
								<button onclick="decrement(); return false;" id="btn2">-</button> </td> 
        				</tr>
        				<tr>   
        					<th>Unit Price</th> 
        					<td> <input type="text" name="unit_price" value="<?php echo "$unit_price" ?>" placeholder="Unit Price" readonly=""> </td> 
        				</tr> 
        			</table>
        			<a href="pharmacist_add_pres_details.php?pres_id=<?php echo $pid; ?>" class="button">GO BACK</a>
        			<input type="submit" class="button" name="submit" value="UPDATE DETAILS">
				</form>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>