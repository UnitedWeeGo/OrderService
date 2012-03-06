<html>
	<head>
	<title>Customer List</title>
	<?php
		require_once "reqbase.php";
	
		$customerlookup = new Customer();
		$orderlookup = new Order();
		
		$customers = $customerlookup->GetList();
	?>
	<script type="text/javascript" src="js/jquery-latest.js"></script> 
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script> 
	
	</head>
	
	<body>
		<script type="text/javascript">
			$(document).ready(function() 
    			{ 
        			$("#myTable").tablesorter(); 
    			}
    		); 
		</script>
		
		<?php 

		$username = "admin"; 
		$password = "Sapient123"; 

		if ($_POST['txtUsername'] != $username || $_POST['txtPassword'] != $password) 
		{ 
		?> 

		<h1>Login</h1> 

		<form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
    		<p><label for="txtUsername">Username:</label> 
    		<br /><input type="text" title="Enter your Username" name="txtUsername" /></p> 

    		<p><label for="txtpassword">Password:</label> 
    		<br /><input type="password" title="Enter your password" name="txtPassword" /></p> 

    		<p><input type="submit" name="Submit" value="Login" /></p> 
		</form> 

		<?php 
		} 
		else 
		{
		?> 
		
		<h1>Customer List</h1>
		<table id="myTable" class="tablesorter" border="1">
			<thead>
				<tr>
					<th width="150">Name</th>
					<th width="150">Phone Number</th>
					<th width="200">Date (CT)</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($customers as $customer)
			{
				echo "<tr>";
				echo "<td>";
				echo $customer->name;
				echo "</td>";
				echo "<td>";
				echo $customer->phoneNumber;
				echo "</td>";
				echo "<td align=\"right\">";
				$order = $orderlookup->GetList(array( array("orderid", "=", $customer->orderId)));
				if($order && sizeof($order) > 0)
				{	
					$time = new DateTime($order[0]->orderPlaced);
					$time->setTimeZone(new DateTimeZone("CST"));
				
					echo $time->format("g:i A, m/d/Y");
				}
				echo "</td>";
				echo "</tr>";
			}
			?>
			</tbody>
		</table>
		
		<?php 
		} 
		?> 
	</body>
</html>