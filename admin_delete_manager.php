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

		if(isset($_GET['manager_id']))
		{
			// DELETE MANAGER GETTING MANAGER ID FROM URL
			$manager_id=$_GET['manager_id'];

			$result = mysqli_query($con,"SELECT first_name, last_name FROM manager where manager_id=$manager_id")or die(mysqli_error());
			$row = mysqli_fetch_array($result);
			$fname=$row['first_name'];
			$lname=$row['last_name'];

			
			$sql="DELETE FROM manager WHERE manager_id='$manager_id'";
			
			if(mysqli_query($con,$sql)) 
			{
				echo '<script type="text/javascript">
						var f;        
				 		f = "'.$fname.'";
				 		var l;
				 		l = "'.$lname.'";
						alert("Manager : \""+f+" "+l+"\" has been removed Successfully!"); 
						window.location.href = "admin_manager.php";
					  </script>';
			}
			else
			{
				$error=mysqli_error($con);
				echo '<script type="text/javascript">
				 		var e;        
				 		e = "'.$error.'";
				 		alert("Deleting Manager Failed, Try Again! \nERROR : "+e);
				 		window.location.href = "admin_manager.php";
					  </script>';
			}
		}
?>