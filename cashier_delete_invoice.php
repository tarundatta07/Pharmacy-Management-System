		<!-- PHP CODE STARTS FROM HERE -->
<?php
		session_start();
		include_once('connect_db.php');
		if(isset($_SESSION['cashier_id']))
		{
			$id=$_SESSION['cashier_id'];
			$first_name=$_SESSION['first_name'];
			$last_name=$_SESSION['last_name'];
		}
		else
		{
			header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
			exit();
		}

		if(isset($_GET['invoice_id']))
		{
			// DELETE INVOICE GETTING INVOICE ID FROM URL
			$invoice_id=$_GET['invoice_id'];

			$result = mysqli_query($con,"SELECT customer_name FROM invoice where invoice_id=$invoice_id")or die(mysqli_error());
			$row = mysqli_fetch_array($result);
			$cust_name=$row['customer_name'];
			
			$sql="DELETE FROM invoice WHERE invoice_id='$invoice_id'";
			
			if(mysqli_query($con,$sql)) 
			{
				echo '<script type="text/javascript">
				 		var c;
				 		c = "'.$cust_name.'";
				 		var i;
				 		i = "'.$invoice_id.'";
						alert("Invoice of \""+c+"\" with ID : \""+i+"\" has been removed Successfully!");
						window.location.href = "cashier_manage_invoices.php";
					  </script>';
			}
			else
			{
				$error=mysqli_error($con);
				echo '<script type="text/javascript">
				 		var e;        
				 		e = "'.$error.'";
				 		alert("Deleting Invoice Failed, Try Again! \nERROR : "+e);
				 		window.location.href = "cashier_manage_invoices.php";
					  </script>';
			}
		}
?>