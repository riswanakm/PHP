<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "List book";
	require_once "./template/admin_header.php";
	require_once "./functions/database_functions.php";
	$connection = new DatabaseConnection();
	$result = $connection->getAllOrders();
?>
	
	<div class="row">
		
		<table class="table" style="margin-top: 20px">
			<tr>
				<th>Order Id</th>
				<th>Amount</th>
				<th>Customer Name</th>
				<th>Order Date</th>
				<th>Invoice</th>
			</tr>
			<?php while($row = mysqli_fetch_assoc($result)){ ?>
			<tr>
				<td><?php echo $row['order_id']; ?></td>
				<td><?php echo $row['amount']; ?></td>
				<td><?php echo $row['ship_name']; ?></td>
				<td><?php echo $row['order_date']; ?></td>
				<td><a class="btn btn-warning" href="invoice.php?order=<?php echo $row['order_id']; ?>" target="_blank">Invoice</a></td>
			</tr>
			<?php } ?>
		</table>
	</div>
<?php
	require_once "./template/footer.php";
?>