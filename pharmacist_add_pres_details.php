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
				$s_pid123=$_POST['pid1'];

				$s_med_name=$_POST['med_name'];
				$s_quantity=$_POST['quantity'];
				
				// Checking if Medicine Name already exists 
				$sql5=mysqli_query($con,"SELECT quantity, unit_price FROM prescription_details WHERE pres_id='$s_pid123' AND medicine_name='$s_med_name'")or die(mysqli_error());
	 			$result5=mysqli_fetch_array($sql5);
	 			if($result5>0)
	 			{
	 				$s_old_quantity=$result5['quantity'];
	 				$s_unit_price=$result5['unit_price'];

	 				$s_new_quantity=$s_quantity+$s_old_quantity;
	 				
	 				$sql11=mysqli_query($con,"SELECT quantity FROM medicine WHERE medicine_name='$s_med_name'")or die(mysqli_error());
	 				$result11=mysqli_fetch_array($sql11);
	 				$s_stock_quantity=$result11['quantity'];

	 				if($s_new_quantity>$s_stock_quantity)
	 				{
	 					echo '<script type="text/javascript">
								var i;        
						 		i = "'.$s_pid123.'";
						 		var m;
						 		m = "'.$s_med_name.'";
						 		var s;
						 		s = "'.$s_stock_quantity.'";
						 		var q;
						 		q = "'.$s_quantity.'";
								alert("Medicine Name Entered  \""+m+"\" Already Exists! \nQuantity \'"+q+"\' Entered for Medicine \""+m+"\" exceeds currently available Stock...\nThe currently available Stock for Medicine \""+m+"\" is \'"+s+"\'");
								window.location.href = "pharmacist_add_pres_details.php?pres_id="+i;
							   </script>';
	 				}
	 				else
	 				{
	 				$s_cost=$s_new_quantity*$s_unit_price;

	 				$sql="UPDATE prescription_details SET quantity='$s_new_quantity', cost='$s_cost' WHERE pres_id='$s_pid123' AND medicine_name='$s_med_name'";

	 				if(mysqli_query($con,$sql))
	 				{
						echo '<script type="text/javascript">
								var i;        
						 		i = "'.$s_pid123.'";
						 		var m;
						 		m = "'.$s_med_name.'";
								alert("Medicine Name Entered  \""+m+"\" Already Exists! \nThe Quantity of Medicines have been Updated...");
								window.location.href = "pharmacist_add_pres_details.php?pres_id="+i;
							   </script>';
	 				}
	 				else
					{
						$error=mysqli_error($con);
						echo '<script type="text/javascript">
								var i;        
						 		i = "'.$s_pid123.'";
							    var e;        
							    e = "'.$error.'";
							    alert("Adding Medicine Failed, Try Again! \nERROR : "+e);
							    window.location.href = "pharmacist_add_pres_details.php?pres_id="+i;
							 </script>';
					}
					}
	 			}
				else
				{	
					$sql6=mysqli_query($con,"SELECT unit_price,quantity FROM medicine WHERE medicine_name='$s_med_name'")or die(mysqli_error());
	 				$result6=mysqli_fetch_array($sql6);
	 				$s_unit_price=$result6['unit_price'];
	 				$s_stock_quantity=$result6['quantity'];

	 				if($s_quantity>$s_stock_quantity)
	 				{
	 					echo '<script type="text/javascript">
								var i;        
						 		i = "'.$s_pid123.'";
						 		var m;
						 		m = "'.$s_med_name.'";
						 		var s;
						 		s = "'.$s_stock_quantity.'";
						 		var q;
						 		q = "'.$s_quantity.'";
								alert("Quantity \'"+q+"\' Entered for Medicine \""+m+"\" exceeds currently available Stock...\nThe currently available Stock for Medicine \""+m+"\" is \'"+s+"\'");
								window.location.href = "pharmacist_add_pres_details.php?pres_id="+i;
							   </script>';
	 				}
	 				else
	 				{
	 				$s_cost=$s_quantity*$s_unit_price;

					$sql="INSERT INTO prescription_details (pres_id, medicine_name, quantity, unit_price, cost) VALUES ('$s_pid123', '$s_med_name', '$s_quantity', '$s_unit_price', '$s_cost')";

					if(mysqli_query($con,$sql))
	 				{
						echo '<script type="text/javascript">
								var i;        
						 		i = "'.$s_pid123.'";
						 		var m;
						 		m = "'.$s_med_name.'";
								alert("Medicine \""+m+"\" has been added Successfully to Prescription ID :\""+i+"\"");
								window.location.href = "pharmacist_add_pres_details.php?pres_id="+i;
							   </script>';
	 				}
	 				else
					{
						$error=mysqli_error($con);
						echo '<script type="text/javascript">
								var i;        
						 		i = "'.$s_pid123.'";
							    var e;        
							    e = "'.$error.'";
							    alert("Adding Medicine Failed, Try Again! \nERROR : "+e);
							    window.location.href = "pharmacist_add_pres_details.php?pres_id="+i;
							 </script>';
					}
					}
				}
		}

		// GET PRESCRIPTION ID FROM URl
		if(isset($_GET['pres_id']))
		{
			$pid=$_GET['pres_id'];

			// GET DETAILS OF PRESCRIPTION
			$result = mysqli_query($con,"SELECT customer_name FROM prescription where pres_id='$pid'")or die(mysqli_error());
			$row = mysqli_fetch_array($result);			
			$cust_name=$row['customer_name'];
		}
?>

			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> PHARMACIST ADD PRESCRIPTION DETAILS PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/homepagestyle.css">
	<link rel="stylesheet" type="text/css" href="styles/prescription.css">
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
					<h4 id="above"> PHARMACIST - ADD PRESCRIPTION DETAILS </h4>
					<?php 
					if(isset($_GET['pres_id']))
					{
					?>
						<b id="top"> Add Medicine Details of Customer "<?php echo $cust_name; ?>" with ID : <?php echo $pid; ?> </b>
						<br><br>
						<form name="add_pres" action="pharmacist_add_pres_details.php" method="post" autocomplete="OFF">

						<input type='hidden' name='pid1' value='<?php echo "$pid"; ?>'>
							
							<table>
								<tr>
									<th>Medicine Name</th>
									<th>Quantity</th>
									<th>Reset</th>
								</tr>
								<tr>
									<td>
									<select id="med_name" name="med_name" oninvalid="this.setCustomValidity('Please Select Medicine')" oninput="setCustomValidity('')" required="">
										<option value="">Select Medicine</option>
									<?php 
										$result1 = mysqli_query($con,"SELECT medicine_name FROM medicine WHERE medicine_status='Available' ORDER BY medicine_name ASC")or die(mysqli_error());
										while ($row1 = mysqli_fetch_array($result1)) 
										{ ?>
											<option value="<?php echo $row1['medicine_name']; ?>"><?php echo $row1['medicine_name']?></option>
										<?php
										}
									?>
									</select>
									</td>
									<td>
										<input type="text" id="quantity" name="quantity" value="1" placeholder="Quantity" oninvalid="validate(this);" oninput="validate(this);" required="">
										<button onclick="increment(); return false;" id="btn1">+</button>
										<button onclick="decrement(); return false;" id="btn2">-</button>
									</td>
									<td>
										<input type="reset" value="RESET">
									</td>
								</tr>
							</table>
							<input type="submit" class="button" name="submit" value="ADD MEDICINE">
						</form>
						<br>&nbsp;<br>&nbsp;<br>&nbsp;
					<?php
						$sql3=mysqli_query($con,"SELECT medicine_name, quantity, unit_price, cost FROM prescription_details WHERE pres_id='$pid'")or die(mysqli_error());
						$result3=mysqli_fetch_array($sql3);

						if($result3>0)
						{?>
							<b id="top"> Prescription Details of Customer "<?php echo $cust_name; ?>" with ID : <?php echo $pid; ?> </b>
							<br><br>
							<table>
				        	<tr> 
				        		<th>Medicine name </th>
				        		<th>Quantity </th> 
				        		<th>Unit price </th>
				        		<th>Cost</th>
				        		<th>Update/ Delete</th>
				        	   </tr>

				         <?php
				        	$sql3=mysqli_query($con,"SELECT medicine_name, quantity, unit_price, cost FROM prescription_details WHERE pres_id='$pid'")or die(mysqli_error());

						// loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array($sql3)) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['medicine_name'] . '</td>';
				                echo '<td>' . $row['quantity'] . '</td>';
								echo '<td>' . $row['unit_price'] . '</td>';
								echo '<td>' . $row['cost'] . '</td>';
								?>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="pharmacist_update_pres_details.php?pres_id=<?php echo $pid ?>&med_name=<?php echo $row['medicine_name'] ?>"><img src="images/update-icon.png" width="35" height="35"/></a>
									&nbsp;&nbsp;
									<a onclick="return confirm('Are you sure you want to delete this Prescription detail with Medicine Name : \'<?php echo $row['medicine_name'] ?>\' ?')" href="pharmacist_delete_pres_details.php?pres_id=<?php echo $pid ?>&med_name=<?php echo $row['medicine_name'] ?>"><img src="images/delete-icon.png" width="35" height="35"/></a>
								</td>
								<?php
						 } 
				        // close table>
				        echo "</table> <br>";

				        $sql4=mysqli_query($con,"SELECT sum(cost) as total FROM prescription_details WHERE pres_id='$pid'")or die(mysqli_error());
				        $result4=mysqli_fetch_array($sql4);
				        $total_cost=$result4['total'];

				        echo"<b id='nodatasales'>&nbsp;TOTAL COST = Tk. ".$total_cost."&nbsp;&nbsp;</b>";
				        echo"<br>&nbsp;<br>";
						echo"<a href='pharmacist_generate_prescription.php' class='button'> GENERATE NEW PRESCRIPTION </a>";
						echo"<a href='#above' class='button'> ADD NEW MEDICINE</a>";
				        }
					?>
					<br>&nbsp;<br>&nbsp;
				<?php 
				}  ?>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php'); ?>
	</div>
</body>
</html>