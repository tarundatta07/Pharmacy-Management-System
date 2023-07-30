<?php
	$con=mysqli_connect('localhost','root','')or die("Cannot connect to Server");
	mysqli_select_db($con,'pharmacy')or die("Cannot connect to Database");
?>