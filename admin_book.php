<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "List book";
	require_once "./template/admin_header.php";
	require_once "./functions/database_functions.php";
	$connection = new DatabaseConnection();
	$result = $connection->getAll();
?>
	
	<div class="row">
		<p class="lead"><a class="btn btn-success" href="admin_add_book.php">Add new book</a></p>
		
		<table class="table" style="margin-top: 20px">
			<tr>
				<th>ISBN</th>
				<th>Title</th>
				<th>Image</th>
				<th>Description</th>
				<th>Price</th>
				<th>Publisher</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php while($row = mysqli_fetch_assoc($result)){ ?>
			<tr>
				<td><?php echo $row['book_isbn']; ?></td>
				<td><?php echo $row['book_title']; ?></td>
				<td><?php echo $row['book_image']; ?></td>
				<td><?php echo $row['book_description']; ?></td>
				<td><?php echo $row['book_price']; ?></td>
				<td><?php echo $connection->getPubName($row['publisher_id']); ?></td>
				<td><a class="btn btn-warning" href="admin_edit_book.php?bookisbn=<?php echo $row['book_isbn']; ?>">Edit</a></td>
				<td><a class="btn btn-danger" href="delete_book.php?bookisbn=<?php echo $row['book_isbn']; ?>">Delete</a></td>
			</tr>
			<?php } ?>
		</table>
	</div>
<?php
	require_once "./template/footer.php";
?>