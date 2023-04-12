<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Add new author";
	require "./template/admin_header.php";
	require "./functions/database_functions.php";

	$connection = new DatabaseConnection();
	


	if (isset($_POST['add'])) {

		$author_name = trim($_POST['author_name']);
		


		$result = $connection->insertIntoAuthors($author_name);

		if (!$result) {
			echo "Can't add new data " . mysqli_error($conn);
			exit;
		} else {
			header("Location: admin_author.php");
		}
	}
	?>
	<form method="post" action="admin_add_author.php" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<th>Author Name</th>
				<td><input type="text" name="author_name"></td>
			</tr>
		</table>
		<input type="submit" name="add" value="Add new author" class="btn btn-primary">
		<input type="reset" value="Reset" class="btn btn-default">
	</form>
	<br />
	<a href="admin_author.php" class="btn btn-success">Back</a>
	<?php
	require_once "./template/footer.php";
?>