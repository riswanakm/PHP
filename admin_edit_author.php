<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Edit Author";
	require_once "./template/admin_header.php";
	require_once "./functions/database_functions.php";
	$connection = new DatabaseConnection();

	if(isset($_GET['author_id'])){
		$author_id = $_GET['author_id'];
	} else {
		echo "Empty query!";
		exit;
	}

	if(!isset($author_id)){
		echo "Empty author! check again!";
		exit;
	}

	// get book data
	$result = $connection->getByAuthorId($author_id);
	
	$row = mysqli_fetch_assoc($result);


?>
	<form method="post" action="edit_author.php" enctype="multipart/form-data">
		<input type="hidden" name="author_id" value="<?php echo $row['author_id'];?>">
		<table class="table">
			<tr>
				<th>Author Name</th>
				<td><input type="text" name="author_name" value="<?php echo $row['author_name'];?>"></td>
			</tr>
			
		</table>
		<input type="submit" name="save_change" value="Edit Changes" class="btn btn-primary">
		<input type="reset" value="Reset" class="btn btn-default">
	</form>
	<br/>
	<a href="admin_author.php" class="btn btn-success">Back</a>
<?php
	require "./template/footer.php"
?>