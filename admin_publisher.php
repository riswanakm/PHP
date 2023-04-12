<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "List book";
	require_once "./template/admin_header.php";
	require_once "./functions/database_functions.php";
	$connection = new DatabaseConnection();
	$result = $connection->getAllPublisher();
?>
	
	<div class="row">
		<p class="lead"><a class="btn btn-success" href="admin_add_publisher.php">Add new Publisher</a></p>
		
		<table class="table" style="margin-top: 20px">
			<tr>
				<th>Publisher ID</th>
				<th>Name</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php while($row = mysqli_fetch_assoc($result)){ ?>
			<tr>
				<td><?php echo $row['publisher_id']; ?></td>
				<td><?php echo $row['publisher_name']; ?></td>
				<td><a class="btn btn-warning" href="admin_edit_publisher.php?publisher_id=<?php echo $row['publisher_id']; ?>">Edit</a></td>
				<td><a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" href="delete_publisher.php?publisher_id=<?php echo $row['publisher_id']; ?>">Delete</a></td>
			</tr>
			<?php } ?>
		</table>
	</div>
<?php
	require_once "./template/footer.php";
?>