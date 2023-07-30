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

		if(isset($_GET['pres_id']) && isset($_GET['med_name']))
		{
			// DELETE PRESCRIPTION DETAIL, GETTING PRESCRIPTION ID AND MEDICINE NAME FROM URL
			$pres_id=$_GET['pres_id'];
			$med_name=$_GET['med_name'];

			$result = mysqli_query($con,"SELECT customer_name FROM prescription WHERE pres_id=$pres_id")or die(mysqli_error());
			$row = mysqli_fetch_array($result);
			$cust_name=$row['customer_name'];

			$sql2="DELETE FROM prescription_details WHERE pres_id='$pres_id' AND medicine_name='$med_name'";
			if(mysqli_query($con,$sql2))
			{
				echo '<script type="text/javascript">
					 	var i;        
					 	i = "'.$pres_id.'";
					 	var c;
					 	c = "'.$cust_name.'";
					 	var m;
					 	m = "'.$med_name.'";
						alert("Prescription Detail of Customer \""+c+"\" has been removed Successfully with Medicine Name : \""+m+"\"");
						window.location.href = "pharmacist_update_prescription_details.php?pres_id="+i;
					  </script>';
			}
			else
			{
				$error=mysqli_error($con);
				echo '<script type="text/javascript">
					 	var i;        
					 	i = "'.$pres_id.'";
					 	var e;        
					 	e = "'.$error.'";
					 	alert("Deleting Prescription Detail Failed, Try Again! \nERROR : "+e);
					 	window.location.href = "pharmacist_update_prescription_details.php?pres_id="+i;
					  </script>';
			}
		}
?>