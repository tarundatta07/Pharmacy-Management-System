<?php
		session_start();
		unset($_SESSION['admin_id']);
		unset($_SESSION['manager_id']);
		unset($_SESSION['pharmacist_id']);
		unset($_SESSION['cashier_id']);
		unset($_SESSION['first_name']);
		unset($_SESSION['last_name']);

		session_destroy();
		header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
?>