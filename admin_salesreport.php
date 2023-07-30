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
?>


			<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> ADMIN SALES REPORT PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/homepagestyle.css">
	<link rel="stylesheet" type="text/css" href="styles/manage.css">
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
		function openTab(tabName) 
		{
  			var i;
  			var x = document.getElementsByClassName("alink");
  			for (i = 0; i < x.length; i++) 
  			{
    			x[i].style.display = "none";  
  			}
  			document.getElementById(tabName).style.display = "block";

  			if(tabName=='today')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("link");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("link1");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";
  			}

  			if(tabName=='thisMonth')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("link");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("link2");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";
  			}

  			if(tabName=='lastMonth')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("link");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("link3");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";
  			}

  			if(tabName=='thisYear')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("link");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("link4");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";
  			}

  			if(tabName=='overall')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("link");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("link5");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";
  			}
		}
		function mopenTab(tabName) 
		{
  			var i;
  			var x = document.getElementsByClassName("malink");
  			for (i = 0; i < x.length; i++) 
  			{
    			x[i].style.display = "none";  
  			}
  			document.getElementById(tabName).style.display = "block";

  			if(tabName=='mtoday')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("mlink");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("mlink1");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";

  				// Animation of Bar's
  				var e = document.getElementsByClassName("bar1");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="10%";
				}

  				var e = document.getElementsByClassName("bar2");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="20%";
				}

				var e = document.getElementsByClassName("bar3");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="30%";
				}

				var e = document.getElementsByClassName("bar4");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="40%";
				}

				var e = document.getElementsByClassName("bar5");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="50%";
				}

				var e = document.getElementsByClassName("bar6");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="60%";
				}

				var e = document.getElementsByClassName("bar7");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="70%";
				}

				var e = document.getElementsByClassName("bar8");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="76%";
				}
  			}

  			if(tabName=='mthisMonth')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("mlink");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("mlink2");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";

  				// Animation of Bar's
  				var e = document.getElementsByClassName("bar1");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="10%";
				}

  				var e = document.getElementsByClassName("bar2");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="20%";
				}

				var e = document.getElementsByClassName("bar3");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="30%";
				}

				var e = document.getElementsByClassName("bar4");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="40%";
				}

				var e = document.getElementsByClassName("bar5");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="50%";
				}

				var e = document.getElementsByClassName("bar6");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="60%";
				}

				var e = document.getElementsByClassName("bar7");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="70%";
				}

				var e = document.getElementsByClassName("bar8");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="76%";
				}
  			}

  			if(tabName=='mlastMonth')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("mlink");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("mlink3");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";

  				// Animation of Bar's
  				var e = document.getElementsByClassName("bar1");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="10%";
				}

  				var e = document.getElementsByClassName("bar2");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="20%";
				}

				var e = document.getElementsByClassName("bar3");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="30%";
				}

				var e = document.getElementsByClassName("bar4");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="40%";
				}

				var e = document.getElementsByClassName("bar5");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="50%";
				}

				var e = document.getElementsByClassName("bar6");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="60%";
				}

				var e = document.getElementsByClassName("bar7");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="70%";
				}

				var e = document.getElementsByClassName("bar8");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="76%";
				}
  			}

  			if(tabName=='mthisYear')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("mlink");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("mlink4");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";

  				// Animation of Bar's
  				var e = document.getElementsByClassName("bar1");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="10%";
				}

  				var e = document.getElementsByClassName("bar2");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="20%";
				}

				var e = document.getElementsByClassName("bar3");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="30%";
				}

				var e = document.getElementsByClassName("bar4");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="40%";
				}

				var e = document.getElementsByClassName("bar5");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="50%";
				}

				var e = document.getElementsByClassName("bar6");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="60%";
				}

				var e = document.getElementsByClassName("bar7");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="70%";
				}

				var e = document.getElementsByClassName("bar8");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="76%";
				}
  			}

  			if(tabName=='moverall')
  			{
  				var j;
  			 	var l = document.getElementsByClassName("mlink");
	  		 	for (j = 0; j < l.length; j++) 
	  		 	{
	     			l[j].style.background = "#436a94";
	     			l[j].style.color= "white";
	     			l[j].style.border = "none";
	  		 	}
  				var a = document.getElementById("mlink5");
  				a.style.background = "#ffcccc";
  				a.style.color = "black";
  				a.style.border = "1px solid black";

  				// Animation of Bar's
  				var e = document.getElementsByClassName("bar1");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="10%";
				}

  				var e = document.getElementsByClassName("bar2");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="20%";
				}

				var e = document.getElementsByClassName("bar3");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="30%";
				}

				var e = document.getElementsByClassName("bar4");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="40%";
				}

				var e = document.getElementsByClassName("bar5");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="50%";
				}

				var e = document.getElementsByClassName("bar6");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="60%";
				}

				var e = document.getElementsByClassName("bar7");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="70%";
				}

				var e = document.getElementsByClassName("bar8");
				for(var i=0; i < e.length; i++) 
				{
				    e[i].style.animation = "fade 2.5s forwards";
				    e[i].width="76%";
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
						 <a href="admin_salesreport.php" class="active"><img src="images/salesreport.png" height="20px" align="center">&nbsp;&nbsp;Sales Report</a>
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
					<h4> ADMIN - VIEW SALES REPORT </h4>

				<div id="tablinks" align="left">
				  <b id="saleslabel">&nbsp; SALES : &nbsp;</b>
				  <button id="link1" class="link" onclick="openTab('today')">Today</button>
				  <button id="link2" class="link" onclick="openTab('thisMonth')">This Month</button>
				  <button id="link3" class="link" onclick="openTab('lastMonth')">Last Month</button>
				  <button id="link4" class="link" onclick="openTab('thisYear')">This Year</button>
				  <button id="link5" class="link" onclick="openTab('overall')">Overall</button>
				</div>
				<br>&nbsp;<br>&nbsp;<br>
				
				<div id="today" class="alink">
				<!-- TABLE FOR DAILY SALES OF MEDICINES-->
				  	<b id='srlabel'>&nbsp; SALES TODAY : &nbsp;</b>
				  	<br>&nbsp;<br>

				  	<?php 
					 	$result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND DATE(a.date) = CURDATE() GROUP BY a.date") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<table>";
				        echo "<tr> 
				        		<th>ID</th>
				        		<th>Customer Name</th>
				        		<th>Date</th>
				        		<th>Quantity</th>
				        		<th>Total Cost</th> 
				        	   </tr>";

				        $result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND DATE(a.date) = CURDATE() GROUP BY a.date ") or die(mysqli_error($con));
				        // loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['pres_id'] . '</td>';
				                echo '<td>' . $row['customer_name'] . '</td>';
				                echo '<td>' . $row['date'] . '</td>';
				                echo '<td>' . $row['quantity'] . '</td>';
				                echo '<td>' . $row['cost'] . '</td>';
				                echo "</tr>";
						 } 
				        // close table>
				        echo "</table>";

				        echo "<br>";

				        $result1 = mysqli_query($con,"SELECT a.invoice_no ,sum(b.cost) as total_cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND DATE(a.date) = CURDATE()") or die(mysqli_error($con));
						$row=mysqli_fetch_array($result1);
						$total_cost = $row['total_cost'];
						echo"<b id='nodatasales'>&nbsp;TOTAL REVENUE COLLECTED = Tk. ".$total_cost."&nbsp;&nbsp;</b>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO SALES DONE TODAY\" </b><br>";
						}
					?>
				</div>

				<div id="thisMonth" class="alink" style="display:none">
				  <!-- TABLE FOR MONTHLY SALES OF MEDICINES-->
				  	<b id='srlabel'>&nbsp; SALES THIS MONTH : &nbsp;</b>
				  	<br>&nbsp;<br>

				  	<?php
					 	$result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY a.date") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<table>";
				        echo "<tr> 
				        		<th>ID</th>
				        		<th>Customer Name</th>
				        		<th>Date</th>
				        		<th>Quantity</th>
				        		<th>Total Cost</th> 
				        	   </tr>";

				        $result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY a.date ") or die(mysqli_error($con));
				        // loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['pres_id'] . '</td>';
				                echo '<td>' . $row['customer_name'] . '</td>';
				                echo '<td>' . $row['date'] . '</td>';
				                echo '<td>' . $row['quantity'] . '</td>';
				                echo '<td>' . $row['cost'] . '</td>';
				                echo "</tr>";
						} 
				        // close table>
				        echo "</table>";

				        echo "<br>";

				        $result1 = mysqli_query($con,"SELECT a.invoice_no ,sum(b.cost) as total_cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE) AND YEAR(date)=YEAR(CURRENT_DATE)") or die(mysqli_error($con));
						$row=mysqli_fetch_array($result1);
						$total_cost = $row['total_cost'];
						echo"<b id='nodatasales'>&nbsp;TOTAL REVENUE COLLECTED = Tk. ".$total_cost."&nbsp;&nbsp;</b>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO SALES DONE THIS MONTH\" </b><br>";
						}
					?>
				</div>

				<div id="lastMonth" class="alink" style="display:none">
				<!-- TABLE FOR LAST MONTH SALES OF MEDICINES-->
				    <b id='srlabel'>&nbsp; SALES LAST MONTH : &nbsp;</b>
				  	<br>&nbsp;<br>
					<?php 
					 	$result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY a.date") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<table>";
				        echo "<tr> 
				        		<th>ID</th>
				        		<th>Customer Name</th>
				        		<th>Date</th>
				        		<th>Quantity</th>
				        		<th>Total Cost</th> 
				        	   </tr>";

				        $result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY a.date ") or die(mysqli_error($con));
				        // loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['pres_id'] . '</td>';
				                echo '<td>' . $row['customer_name'] . '</td>';
				                echo '<td>' . $row['date'] . '</td>';
				                echo '<td>' . $row['quantity'] . '</td>';
				                echo '<td>' . $row['cost'] . '</td>';
				                echo "</tr>";
						 } 
				        // close table>
				        echo "</table>";

				        echo "<br>";

				        $result1 = mysqli_query($con,"SELECT a.invoice_no ,sum(b.cost) as total_cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(date)=YEAR(CURRENT_DATE)") or die(mysqli_error($con));
						$row=mysqli_fetch_array($result1);
						$total_cost = $row['total_cost'];
						echo"<b id='nodatasales'>&nbsp;TOTAL REVENUE COLLECTED = Tk. ".$total_cost."&nbsp;&nbsp;</b>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO SALES DONE LAST MONTH\" </b><br>";
						}
					?>
				</div>
				
				<div id="thisYear" class="alink" style="display:none">
				 <!-- TABLE FOR YEARLY SALES OF MEDICINES-->
				  	<b id='srlabel'>&nbsp; SALES THIS YEAR : &nbsp;</b>
				  	<br>&nbsp;<br>

				  	<?php 
					 	$result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND YEAR(a.date)=YEAR(CURRENT_DATE) GROUP BY a.date") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<table>";
				        echo "<tr> 
				        		<th>ID</th>
				        		<th>Customer Name</th>
				        		<th>Date</th>
				        		<th>Quantity</th>
				        		<th>Total Cost</th> 
				        	   </tr>";

				        $result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND YEAR(a.date)=YEAR(CURRENT_DATE) GROUP BY a.date ") or die(mysqli_error($con));
				        // loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['pres_id'] . '</td>';
				                echo '<td>' . $row['customer_name'] . '</td>';
				                echo '<td>' . $row['date'] . '</td>';
				                echo '<td>' . $row['quantity'] . '</td>';
				                echo '<td>' . $row['cost'] . '</td>';
				                echo "</tr>";
						 } 
				        // close table>
				        echo "</table>";

				        echo "<br>";

				        $result1 = mysqli_query($con,"SELECT a.invoice_no ,sum(b.cost) as total_cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND YEAR(a.date)=YEAR(CURRENT_DATE)") or die(mysqli_error($con));
						$row=mysqli_fetch_array($result1);
						$total_cost = $row['total_cost'];
						echo"<b id='nodatasales'>&nbsp;TOTAL REVENUE COLLECTED = Tk. ".$total_cost."&nbsp;&nbsp;</b>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO SALES DONE THIS YEAR\" </b><br>";
						}
					?>
				</div>

				<div id="overall" class="alink" style="display:none">
				<!-- TABLE FOR OVERALL SALES OF MEDICINES-->
				    <b id='srlabel'>&nbsp; OVERALL SALES : &nbsp;</b>
				  	<br>&nbsp;<br>
					<?php 
					 	$result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') GROUP BY a.date") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<table>";
				        echo "<tr> 
				        		<th>ID</th>
				        		<th>Customer Name</th>
				        		<th>Date</th>
				        		<th>Quantity</th>
				        		<th>Total Cost</th> 
				        	   </tr>";

				        $result = mysqli_query($con,"SELECT a.pres_id, a.customer_name, DATE_FORMAT(a.date,'%d-%m-%Y') as date, sum(b.quantity) as quantity, sum(b.cost) as cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') GROUP BY a.date ") or die(mysqli_error($con));
				        // loop through results of database query, displaying them in the table
				        while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row into a table
				                echo "<tr>";
				                
				                echo '<td>' . $row['pres_id'] . '</td>';
				                echo '<td>' . $row['customer_name'] . '</td>';
				                echo '<td>' . $row['date'] . '</td>';
				                echo '<td>' . $row['quantity'] . '</td>';
				                echo '<td>' . $row['cost'] . '</td>';
				                echo "</tr>";
						 } 
				        // close table>
				        echo "</table>";

				        echo "<br>";

				        $result1 = mysqli_query($con,"SELECT a.invoice_no ,sum(b.cost) as total_cost FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid')") or die(mysqli_error($con));
						$row=mysqli_fetch_array($result1);
						$total_cost = $row['total_cost'];
						echo"<b id='nodatasales'>&nbsp;TOTAL REVENUE COLLECTED = Tk. ".$total_cost."&nbsp;&nbsp;</b>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO SALES DONE YET\" </b><br>";
						}
					?>
				</div>
				<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>


<!------------------------------------------------------------>

				<!-- MEDICINE SALES -->
				<div id="tablinks" align="left">
				  <b id="saleslabel">MEDICINE SALES :</b>
				  <button id="mlink1" class="mlink" onclick="mopenTab('mtoday')">Today</button>
				  <button id="mlink2" class="mlink" onclick="mopenTab('mthisMonth')">This Month</button>
				  <button id="mlink3" class="mlink" onclick="mopenTab('mlastMonth')">Last Month</button>
				  <button id="mlink4" class="mlink" onclick="mopenTab('mthisYear')">This Year</button>
				  <button id="mlink5" class="mlink" onclick="mopenTab('moverall')">Overall</button>
				</div>
				<br>&nbsp;<br>&nbsp;<br>

				<div id="mtoday" class="malink">
				<!-- TABLE FOR DAILY SALES OF MEDICINES-->
				  	<b id='srlabel'>&nbsp; MEDICINE SALES TODAY : &nbsp;</b>
				  	<br>&nbsp;<br>

				  	<?php 
					 	$result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND DATE(a.date) = CURDATE() GROUP BY b.medicine_name ") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
					 		echo "<br>";
				        	
				        $result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND DATE(a.date) = CURDATE() GROUP BY b.medicine_name ") or die(mysqli_error($con));
				        echo "<div class='bar-container'>";
						while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row
				        	 	echo "<div class='bar-content'>";
				                
				                echo "<span id='btitle' class='bar-title'>";
				                echo $row['medicine_name'];
				                echo "</span>";

				                if($row['quantity']>0 && $row['quantity']<=5)
				                {
				                	if($row['quantity'] == 1)
				                	{
					                	echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' unit';
						                echo "</div>";
					                }
					                else
					                {
						                echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' units';
						                echo "</div>";
								    }
				                }
				                else if($row['quantity']>5 && $row['quantity']<=15)
				                {
					                echo "<div id='bar' class='bar2' style='width:20%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>15 && $row['quantity']<=30)
				                {
					                echo "<div id='bar' class='bar3' style='width:30%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>30 && $row['quantity']<=50)
				                {
					                echo "<div id='bar' class='bar4' style='width:40%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>50 && $row['quantity']<=80)
				                {
					                echo "<div id='bar' class='bar5' style='width:50%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>80 && $row['quantity']<=100)
				                {
					                echo "<div id='bar' class='bar6' style='width:60%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>100 && $row['quantity']<=150)
				                {
					                echo "<div id='bar' class='bar7' style='width:70%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else
				                {
				                	echo "<div id='bar' class='bar8' style='width:76%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }

				                echo "</div>";
						 }
						 echo "</div>";
						 echo "<br>&nbsp;<br>&nbsp;<br>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO MEDICINE SALES DONE TODAY\" </b><br>&nbsp;<br>&nbsp;<br>";
						}
					?>
				</div>

				<div id="mthisMonth" class="malink" style="display:none">
				  <!-- TABLE FOR MONTHLY SALES OF MEDICINES-->
				  	<b id='srlabel'>&nbsp; MEDICINE SALES THIS MONTH : &nbsp;</b>
				  	<br>&nbsp;<br>

				  	<?php
					 	$result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY b.medicine_name ") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
				        echo "<br>";
				        	   
				        $result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY b.medicine_name ") or die(mysqli_error($con));
				        echo "<div class='bar-container'>";
						while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row
				        	 	echo "<div class='bar-content'>";
				                
				                echo "<span id='btitle' class='bar-title'>";
				                echo $row['medicine_name'];
				                echo "</span>";

				                if($row['quantity']>0 && $row['quantity']<=5)
				                {
				                	if($row['quantity'] == 1)
				                	{
					                	echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' unit';
						                echo "</div>";
					                }
					                else
					                {
						                echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' units';
						                echo "</div>";
								    }
				                }
				                else if($row['quantity']>5 && $row['quantity']<=15)
				                {
					                echo "<div id='bar' class='bar2' style='width:20%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>15 && $row['quantity']<=30)
				                {
					                echo "<div id='bar' class='bar3' style='width:30%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>30 && $row['quantity']<=50)
				                {
					                echo "<div id='bar' class='bar4' style='width:40%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>50 && $row['quantity']<=80)
				                {
					                echo "<div id='bar' class='bar5' style='width:50%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>80 && $row['quantity']<=100)
				                {
					                echo "<div id='bar' class='bar6' style='width:60%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>100 && $row['quantity']<=150)
				                {
					                echo "<div id='bar' class='bar7' style='width:70%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else
				                {
				                	echo "<div id='bar' class='bar8' style='width:76%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }

				                echo "</div>";
						 }
						 echo "</div>";
						 echo "<br>&nbsp;<br>&nbsp;<br>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO MEDICINE SALES DONE THIS MONTH\" </b><br>&nbsp;<br>&nbsp;<br>";
						}
					?>
				</div>

				<div id="mlastMonth" class="malink" style="display:none">
				<!-- TABLE FOR LAST MONTH SALES OF MEDICINES-->
				    <b id='srlabel'>&nbsp; MEDICINE SALES LAST MONTH : &nbsp;</b>
				  	<br>&nbsp;<br>
					<?php
					 	$result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY b.medicine_name ") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
				        echo "<br>";

				        $result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND MONTH(date)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(date)=YEAR(CURRENT_DATE) GROUP BY b.medicine_name ") or die(mysqli_error($con));
				        echo "<div class='bar-container'>";
						while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row
				        	 	echo "<div class='bar-content'>";
				                
				                echo "<span id='btitle' class='bar-title'>";
				                echo $row['medicine_name'];
				                echo "</span>";

				                if($row['quantity']>0 && $row['quantity']<=5)
				                {
				                	if($row['quantity'] == 1)
				                	{
					                	echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' unit';
						                echo "</div>";
					                }
					                else
					                {
						                echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' units';
						                echo "</div>";
								    }
				                }
				                else if($row['quantity']>5 && $row['quantity']<=15)
				                {
					                echo "<div id='bar' class='bar2' style='width:20%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>15 && $row['quantity']<=30)
				                {
					                echo "<div id='bar' class='bar3' style='width:30%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>30 && $row['quantity']<=50)
				                {
					                echo "<div id='bar' class='bar4' style='width:40%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>50 && $row['quantity']<=80)
				                {
					                echo "<div id='bar' class='bar5' style='width:50%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>80 && $row['quantity']<=100)
				                {
					                echo "<div id='bar' class='bar6' style='width:60%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>100 && $row['quantity']<=150)
				                {
					                echo "<div id='bar' class='bar7' style='width:70%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else
				                {
				                	echo "<div id='bar' class='bar8' style='width:76%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }

				                echo "</div>";
						 }
						 echo "</div>";
						 echo "<br>&nbsp;<br>&nbsp;<br>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO MEDICINE SALES DONE LAST MONTH\" </b><br>&nbsp;<br>&nbsp;<br>";
						}
					?>
				</div>
				
				<div id="mthisYear" class="malink" style="display:none">
				 <!-- TABLE FOR YEARLY SALES OF MEDICINES-->
				  	<b id='srlabel'>&nbsp; MEDICINE SALES THIS YEAR : &nbsp;</b>
				  	<br>&nbsp;<br>
				  	<?php 
					 	$result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND YEAR(a.date)=YEAR(CURRENT_DATE) GROUP BY b.medicine_name ") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
				        echo "<br>";

				        $result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') AND YEAR(a.date)=YEAR(CURRENT_DATE) GROUP BY b.medicine_name ") or die(mysqli_error($con));
				        echo "<div class='bar-container'>";
						while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row
				        	 	echo "<div class='bar-content'>";
				                
				                echo "<span id='btitle' class='bar-title'>";
				                echo $row['medicine_name'];
				                echo "</span>";

				                if($row['quantity']>0 && $row['quantity']<=5)
				                {
				                	if($row['quantity'] == 1)
				                	{
					                	echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' unit';
						                echo "</div>";
					                }
					                else
					                {
						                echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' units';
						                echo "</div>";
								    }
				                }
				                else if($row['quantity']>5 && $row['quantity']<=15)
				                {
					                echo "<div id='bar' class='bar2' style='width:20%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>15 && $row['quantity']<=30)
				                {
					                echo "<div id='bar' class='bar3' style='width:30%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>30 && $row['quantity']<=50)
				                {
					                echo "<div id='bar' class='bar4' style='width:40%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>50 && $row['quantity']<=80)
				                {
					                echo "<div id='bar' class='bar5' style='width:50%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>80 && $row['quantity']<=100)
				                {
					                echo "<div id='bar' class='bar6' style='width:60%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>100 && $row['quantity']<=150)
				                {
					                echo "<div id='bar' class='bar7' style='width:70%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else
				                {
				                	echo "<div id='bar' class='bar8' style='width:76%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }

				                echo "</div>";
						 }
						 echo "</div>";
						 echo "<br>&nbsp;<br>&nbsp;<br>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO MEDICINE SALES DONE THIS YEAR\" </b><br>&nbsp;<br>&nbsp;<br>";
						}
					?>
				</div>

				<div id="moverall" class="malink" style="display:none">
				<!-- TABLE FOR OVERALL SALES OF MEDICINES-->
				    <b id='srlabel'>&nbsp; OVERALL MEDICINE SALES : &nbsp;</b>
				  	<br>&nbsp;<br>

					<?php 
					 	$result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') GROUP BY b.medicine_name ") or die(mysqli_error($con));
					 	$res=mysqli_fetch_array($result);
					 	if($res>0)
					 	{
						echo "<br>";

				        $result = mysqli_query($con,"SELECT b.medicine_name, sum(b.quantity) as quantity FROM prescription a, prescription_details b WHERE a.pres_id = b.pres_id AND a.invoice_no IN (SELECT invoice_no FROM invoice WHERE payment_status='Paid') GROUP BY b.medicine_name ") or die(mysqli_error($con));
				        echo "<div class='bar-container'>";
						while($row = mysqli_fetch_array( $result )) 
				        {        
				                // echo out the contents of each row
				        	 	echo "<div class='bar-content'>";
				                
				                echo "<span id='btitle' class='bar-title'>";
				                echo $row['medicine_name'];
				                echo "</span>";

				                if($row['quantity']>0 && $row['quantity']<=5)
				                {
				                	if($row['quantity'] == 1)
				                	{
					                	echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' unit';
						                echo "</div>";
					                }
					                else
					                {
						                echo "<div id='bar' class='bar1' style='width:10%'>";
						                echo $row['quantity'].' units';
						                echo "</div>";
								    }
				                }
				                else if($row['quantity']>5 && $row['quantity']<=15)
				                {
					                echo "<div id='bar' class='bar2' style='width:20%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>15 && $row['quantity']<=30)
				                {
					                echo "<div id='bar' class='bar3' style='width:30%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>30 && $row['quantity']<=50)
				                {
					                echo "<div id='bar' class='bar4' style='width:40%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>50 && $row['quantity']<=80)
				                {
					                echo "<div id='bar' class='bar5' style='width:50%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>80 && $row['quantity']<=100)
				                {
					                echo "<div id='bar' class='bar6' style='width:60%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>100 && $row['quantity']<=150)
				                {
					                echo "<div id='bar' class='bar7' style='width:70%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else
				                {
				                	echo "<div id='bar' class='bar8' style='width:76%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }

				                echo "</div>";
						 }
						 echo "</div>";
						 echo "<br>&nbsp;<br>&nbsp;<br>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO MEDICINE SALES DONE YET\" </b><br>&nbsp;<br>&nbsp;<br>";
						}
					?>
				</div>
				<b id="saleslabel">MEDICINE STOCKS :</b>
				<br>&nbsp;<br>&nbsp;<br>

				<b id='srlabel'>&nbsp; AVAILABLE MEDICINE STOCKS : &nbsp;</b>
				  	<br>&nbsp;<br>

					<?php 
					 	$result4 = mysqli_query($con,"SELECT medicine_name, quantity FROM medicine WHERE medicine_status='Available' GROUP BY medicine_name ") or die(mysqli_error($con));
					 	$res4=mysqli_fetch_array($result4);
					 	if($res4>0)
					 	{
						echo "<br>";

				        $result5 = mysqli_query($con,"SELECT medicine_name, quantity FROM medicine WHERE medicine_status='Available' GROUP BY medicine_name ") or die(mysqli_error($con));
				        echo "<div class='bar-container'>";
						while($row = mysqli_fetch_array( $result5 )) 
				        {        
				                // echo out the contents of each row
				        	 	echo "<div class='bar-content'>";
				                
				                echo "<span id='btitle' class='bar-title'>";
				                echo $row['medicine_name'];
				                echo "</span>";

				                if($row['quantity']>0 && $row['quantity']<=50)
				                {
				                	if($row['quantity'] == 1)
				                	{
					                	echo "<div id='bar123' style='width:10%'>";
						                echo $row['quantity'].' unit';
						                echo "</div>";
					                }
					                else
					                {
						                echo "<div id='bar123' style='width:10%'>";
						                echo $row['quantity'].' units';
						                echo "</div>";
								    }
				                }
				                else if($row['quantity']>50 && $row['quantity']<=100)
				                {
					                echo "<div id='bar123' style='width:20%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>100 && $row['quantity']<=150)
				                {
					                echo "<div id='bar123' style='width:30%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>150 && $row['quantity']<=200)
				                {
					                echo "<div id='bar123' style='width:40%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>200 && $row['quantity']<=250)
				                {
					                echo "<div id='bar123' style='width:50%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>250 && $row['quantity']<=300)
				                {
					                echo "<div id='bar123' style='width:60%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else if($row['quantity']>300 && $row['quantity']<=350)
				                {
					                echo "<div id='bar123' style='width:70%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }
				                else
				                {
				                	echo "<div id='bar123' style='width:76%'>";
					                echo $row['quantity'].' units';
					                echo "</div>";
				                }

				                echo "</div>";
						 }
						 echo "</div>";
						 echo "<br>&nbsp;<br>&nbsp;<br>";
				    	}
				    	else
				    	{
				    		echo"<br> <b id='nodatasales11'> \"NO STOCKS OF MEDICINES AVAILABLE\" </b><br>&nbsp;<br>&nbsp;<br>";
						}
					?>
					&nbsp;<br>
				</div>
		</div>
		<!-- THIS IS FOOTER CONTENT -->
		<?php include_once('footer.php') ?>
	</div>
</body>
</html>