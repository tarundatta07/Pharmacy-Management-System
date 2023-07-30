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

		if(isset($_GET['pres_id']))
		{
			// DELETE PRESCRIPTION GETTING PRESCRIPTION ID FROM URL
			$pres_id=$_GET['pres_id'];

			$result = mysqli_query($con,"SELECT customer_name FROM prescription WHERE pres_id=$pres_id")or die(mysqli_error());
			$row = mysqli_fetch_array($result);
			$cust_name=$row['customer_name'];

			$sql2="DELETE FROM prescription_details WHERE pres_id='$pres_id'";
			if(mysqli_query($con,$sql2))
			{
				$sql="DELETE FROM prescription WHERE pres_id='$pres_id'";
			
				if(mysqli_query($con,$sql))
				{

					echo '<script type="text/javascript">
					 		var c;
					 		c = "'.$cust_name.'";
							alert("Prescription of Customer \""+c+"\" has been removed Successfully along with Prescription Details!");
							window.location.href = "pharmacist_manage_prescription.php";
						  </script>';
				}
				else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
					 		var e;        
					 		e = "'.$error.'";
					 		alert("Deleting Prescription Failed, Try Again! \nERROR : "+e);
					 		window.location.href = "pharmacist_manage_prescription.php";
						  </script>';
				}
			}
			else
				{
					$error=mysqli_error($con);
					echo '<script type="text/javascript">
					 		var e;        
					 		e = "'.$error.'";
					 		alert("Deleting Prescription Failed, Try Again! \nERROR : "+e);
					 		window.location.href = "pharmacist_manage_prescription.php";
						  </script>';
				}
		}
?>