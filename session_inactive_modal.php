<html>
<head>
	<title>SESSION INACTIVE</title>
	<link rel="stylesheet" type="text/css" href="styles/inactive.css">
	<script type="text/javascript">
		var IDLE_TIMEOUT = 300; //5 min * 60 s = 900 seconds
	 	var idleSecondsCounter = 0; //IDLE Counter in seconds
	 	var timeleft = 180; //AUTO LOGOUT Timer in seconds
	 	
	 	document.onload = function()
		{
		    idleSecondsCounter = 0;
		};

		document.onkeypress = function() 
		{
		    idleSecondsCounter = 0;
		};
		document.onkeyup = function() 
		{
		    idleSecondsCounter = 0;
		};
		document.onkeydown = function() 
		{
		    idleSecondsCounter = 0;
		};

		document.onclick = function() 
		{
		    idleSecondsCounter = 0;
		};
		document.ondblclick = function() 
		{
		    idleSecondsCounter = 0;
		};
		document.onmousemove = function()
		{
		    idleSecondsCounter = 0;
		};
		document.onmouseover = function()
		{
		    idleSecondsCounter = 0;
		};
		document.onmousedown = function()
		{
		    idleSecondsCounter = 0;
		};
		document.onmouseout = function()
		{
		    idleSecondsCounter = 0;
		};
		document.onmouseup = function()
		{
		    idleSecondsCounter = 0;
		};
		document.onscroll = function()
		{
		    idleSecondsCounter = 0;
		};
		
		
		var myVar = window.setInterval(CheckIdleTime, 1000);//1000ms = 1 second

		function CheckIdleTime()
		{
		    idleSecondsCounter++;
		    if(idleSecondsCounter >= IDLE_TIMEOUT) 
		    {
		    	window.setTimeout(ModalMsg,1000);
		    	setInterval(Countdown, 1000);
		    	myStopFunction();
			}
		}

		function ModalMsg()
		{
			document.getElementById('modal').style.display = 'block';
		}

		function myStopFunction()
		{
  			window.clearInterval(myVar);
		}
		
		function Countdown() 
		{
		  	if(timeleft <= 0)
		  	{
		    	document.getElementById("seconds").innerHTML = "0";
		    	window.setTimeout(AlertMsg,500);
		  	} 
		  	else 
		  	{
		    	document.getElementById("seconds").innerHTML = timeleft;
		  	}
		  	timeleft = timeleft-1;
		}

		function AlertMsg()
		{
		    window.alert("There was no activity for a while so you have been logged out !\nPlease Log in Again...");
		    window.location.href = "logout.php";
		}
		
		// "x" close button function
		function CloseFunc()
		{	
		  	window.location.reload();
		}

		function LogoutFunc() 
		{	
			document.getElementById('modal').style.display = 'none';
		  	window.setTimeout(LogoutAlertMsg,200);
		}
		function LogoutAlertMsg()
		{
			alert('You have been logged out Successfully !');
		  	window.location.href='logout.php';
		}

		function LoginFunc() 
		{	
		  	window.location.reload();
		}
	</script>
</head>
<body>
		<!-- MODAL FOR INACTIVE MESSAGE -->

		<!-- The Modal -->
		<div id="modal" align="center">
			<div id="modal-content">
				<button onclick="CloseFunc()" id="close">&times;</button> <br>
				<b id="line1">Are you still there ?</b> <br>
				<p id="line2">If not, you will be logged out automatically in : 
				<b id="seconds"></b> Seconds.</p>
				<button onclick="LogoutFunc()" id="logout">Log Out Now</button>
				<button onclick="LoginFunc()" id="login">Stay Logged In</button>
			</div>
		</div>
</body>
</html>