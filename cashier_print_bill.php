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
?>

	<!-- HTML CODE STARTS FROM HERE-->
<!DOCTYPE html>
<html>
<head>
	<title> PRINT INVOICE/ BILL PAGE </title>
	<link rel="icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="styles/bill.css">
	<script type="text/javascript">
		window.onload=on_load;
		// FUNCTION FOR ON LOAD
		function on_load()
		{	
		    window.print();
			window.onafterprint = function(event) {
   			 		window.location.href = 'cashier_generate_bill.php'};
		}
	</script>
</head>
<body>
	<div id="pageborder"></div>
		<div id="invoice">
			<!-- THIS IS HEADER CONTENT -->
			<div id="header">
				<img id="headerimg" src="images/logo.png" alt="HEADER LOGO">
				 <b id="shopname">
					<span><img src="images/pharm.png" alt="PLUS LOGO" height="24px">Green University Of Bangladesh<img src="images/pharm.png" alt="PLUS LOGO" height="24px"></span> 
				 </b>
				 <br>
				 <b>Address :</b> 
				 	Shewrapara, Mirpur, Dhaka 
				 	<br> 
				 <span id="address">
				 		Bangladesh
				 </span>
				 <br>
				 <span id="mobile">
				 <b>Mobile No :</b> +88 01773109429
				 </span>
				 <span id="tel">
				 <b>Telephone No :</b> 022-26985624
				 </span>
			</div>
			
			<!-- THIS IS INVOICE MAIN CONTENT-->
			<?php 			
			if(isset($_GET['invoice_no']))
			{
				$invoice_no = $_GET['invoice_no'];

				// GET INVOICE DETAILS OF CUSTOMER
				$result = mysqli_query($con,"SELECT customer_name, payment_status, payment_type, DATE_FORMAT(date, '%d-%b-%Y &nbsp;%r') as date FROM invoice WHERE invoice_no=$invoice_no")or die(mysqli_error());
				$row = mysqli_fetch_array($result);
					
				$customer_name=$row['customer_name'];
				$payment_status=$row['payment_status'];
				$payment_type=$row['payment_type'];
				$date=$row['date'];

				// GET PRESCRIPTION DATA OF CUSTOMER
				$result1 = mysqli_query($con,"SELECT pres_id, address, phone FROM prescription WHERE invoice_no=$invoice_no")or die(mysqli_error());
				$row1 = mysqli_fetch_array($result1);
						
				$pres_id=$row1['pres_id'];
				$address=$row1['address'];
				$phone=$row1['phone'];
				?>
				<!--THIS IS TITLE CONTENT -->
				<div id="title">
					<b id='tit'>MEDICINE INVOICE</b>
				</div>
				
				<!--THIS IS SUBTITLE CONTENT -->
				<div id="subtitle">
					<b id='sub'>Tax Invoice/ Bill of Supply</b>
				</div>
				
				<!--THIS IS INVOICE NO AND DATE CONTENT -->
				<div id="invoice_no">
					<div id="left">
						<span id='inv'>
							<b>Invoice No : </b><?php echo $invoice_no; ?>
						</span>
					</div>
					
					<div id="right">
						<span id='date'>
								<b>Date : </b><?php echo $date; ?>
						</span>
					</div>
				</div>

				<!--THIS IS CUSTOMER INFO CONTENT -->
				<div id="cust_info">
					<div id="full">
						<span id='cust_inf'>
							<b>Customer Information : </b>
						</span>
					</div> 

					<div id="left">
						<span id='cust_name'>
							<b>Name : </b><?php echo $customer_name; ?>
						</span>
					</div>

					<div id="right">
						<span id='cust_phone'>
							<b>Mobile No : </b>+88 <?php echo $phone; ?>
						</span>
					</div>

					<div id="full">
						<span id='cust_address'>
							<b>Address : </b><?php echo $address; ?>
						</span>
					</div>
				</div>

				<!--THIS IS CASHIER INFO CONTENT -->
				<div id="cash_info">
					<div id="full">
						<span id='cash_inf'>
							<b>Cashier Information : </b>
						</span>
					</div> 

					<div id="left">
						<span id='cash_id'>
							<b>Cashier ID : </b><?php echo $id; ?>
						</span>
					</div> 

					<div id="right">
						<span id='cash_name'>
							<b>Cashier Name : </b><?php echo $first_name." ".$last_name; ?>
						</span>
					</div>
				</div>

				<!--THIS IS ITEMS PURCHASED CONTENT -->
				<div id="items_list">
					<div id="full">
						<span id='items'>
							<b>ITEMS PURCHASED</b>
						</span>
					</div>
				<?php
				//PRINT ITEMS PURCHASED BY CUSTOMER
				//GET PRESCRIPTION DETAILS OF CUSTOMER
				$result2 = mysqli_query($con,"SELECT medicine_name, quantity, unit_price, cost FROM prescription_details WHERE pres_id=$pres_id")or die(mysqli_error());
				$row2 = mysqli_fetch_array($result2);
				if($row2>0)
				{
					echo "<table align='center'>";
					echo "<tr> 
						  	<th>Sr No.</th>
						   	<th>Medicine Name</th>
					     	<th>Quantity</th> 
					       	<th>Unit Price</th>
						   	<th>Amount</th>
					       </tr>";

					$result3 = mysqli_query($con,"SELECT medicine_name, quantity, unit_price, cost FROM prescription_details WHERE pres_id=$pres_id")or die(mysqli_error());
							
					// FOR SERIAL NUMBER
					$no=1;
							
					// loop through results of database query, displaying them in the table
					while($row = mysqli_fetch_array( $result3 )) 
					{        
						// echo out the contents of each row into a table
						echo "<tr>";
						                
						echo '<td>' . $no. '</td>';
						echo '<td>' . $row['medicine_name'] . '</td>';
						echo '<td>' . $row['quantity'] . '</td>';
						echo '<td>' . $row['unit_price'] . '</td>';
						echo '<td>' . $row['cost'] . '</td>';
							
						$no=$no+1;
					} 
					// close table>
					echo "</table>";

					$result4 = mysqli_query($con,"SELECT count(pres_id) as items, sum(quantity) as total_quantity, sum(cost) as total_cost FROM prescription_details WHERE pres_id=$pres_id")or die(mysqli_error());
					$row4 = mysqli_fetch_array($result4);
						
					$items=$row4['items'];
					$total_cost=$row4['total_cost'];
					$total_quantity=$row4['total_quantity'];

					//FUNCTION FOR CONVERTING AMOUNT IN WORDS
					function amountInWords(float $number)
					{
					    $decimal = round($number - ($no = floor($number)), 2) * 100;
					    $hundred = null;
					    $digits_length = strlen($no);
					    $i = 0;
					    $str = array();
					    $words = array(0 => '', 1 => 'One', 2 => 'Two',
					        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
					        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
					        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
					        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
					        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
					        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
					        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
					        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
					    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
					    while( $i < $digits_length ) 
					    {
					        $divider = ($i == 2) ? 10 : 100;
					        $number = floor($no % $divider);
					        $no = floor($no / $divider);
					        $i += $divider == 10 ? 1 : 2;
					        if ($number) 	
					        {
					            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
					            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
					            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
					        } 
					        else
					        { 
					        	$str[] = null;
					    	}
					    }
					    $Taka = implode('', array_reverse($str));
					    $paise = ($decimal > 0) ? "And " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
					    return ($Taka ?  'Taka ' . $Taka : '') . " Only";
					}
					?>
					
					<div id="l2">
						<b id="it">Total Items : <?php echo $items; ?></b>
					</div>

					<div id="c2">
						<b id="qt">Total Quantity : <?php echo $total_quantity; ?></b>
					</div>

					<div id="r2">
						<b id="at">Total Amount : Tk. <?php echo $total_cost; ?></b>
					</div>
					
					
					<div id="full">
						<b id="words">Total Amount in Words : <?php echo amountInWords($total_cost); ?></b>
					</div>

					<div id='l1'>
						<b id='status'>Payment Status : <?php echo $payment_status; ?></b>

						<img id="paidstamp" src="images/paid.png" alt="PAID STAMP" height="70px" width="85px">
					</div>

					<div id='r1'>
						<b id='type'>Payment Type : <?php echo $payment_type; ?></b>
					</div>

					<hr color='black' width='100%' size='2px' noshade='noshade'>

					<div id='full'>
						<b id='doctor'>CONSULT YOUR DOCTOR BEFORE USING MEDICINE(S)</b>
					</div>
					
					<div id='full'>
						<b id='terms'>Terms and Conditions :</b>
					</div>

					<div id='full'>
						<span id='return'>No Return or Exchange - Medicines once sold will not be taken back or exchanged</span>
					</div>

					<div id='full'>
						<b id='sign'>*** This is a computer generated invoice and signature is not required ***</b>
					</div>

					<div id='full'>
						<b id='quote'>--- WE HOPE YOU FEEL BETTER SOON ! ---</b>
					</div>

				<?php
				}
				else
				{
					echo "<div id='full'>";
					echo "<b id='nomed'>NO MEDICINE(S) HAVE BEEN ADDED TO THIS PRESCRIPTION<b>";
					echo "</div>";
				}
				echo "</div>";
			}
			?>
		</div>
</body>
</html>