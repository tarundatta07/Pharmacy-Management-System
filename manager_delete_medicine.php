		<!-- PHP CODE STARTS FROM HERE -->
<?php
		session_start();
		include_once('connect_db.php');
		if(isset($_SESSION['manager_id']))
		{
			$id=$_SESSION['manager_id'];
			$first_name=$_SESSION['first_name'];
			$last_name=$_SESSION['last_name'];
		}
		else
		{
			header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
			exit();
		}

		if(isset($_GET['medicine_id']))
		{
			// DELETE MEDICINE GETTING MEDICINE ID FROM URL
			$medicine_id=$_GET['medicine_id'];

			$result = mysqli_query($con,"SELECT medicine_name FROM medicine where medicine_id=$medicine_id")or die(mysqli_error());
			$row = mysqli_fetch_array($result);
			$med_name=$row['medicine_name'];
			
			$sql="DELETE FROM medicine WHERE medicine_id='$medicine_id'";
			
			if(mysqli_query($con,$sql)) 
			{
				echo '<script type="text/javascript">
				 		var m;
				 		m = "'.$med_name.'";
						alert("Medicine : \""+m+"\" has been removed Successfully!");
						window.location.href = "manager_update_stocks.php";
					  </script>';
			}
			else
			{
				$error=mysqli_error($con);
				echo '<script type="text/javascript">
				 		var e;        
				 		e = "'.$error.'";
				 		alert("Deleting Medicine Failed, Try Again! \nERROR : "+e);
				 		window.location.href = "manager_update_stocks.php";
					  </script>';
			}
		}
?>