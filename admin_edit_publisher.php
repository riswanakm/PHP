<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Edit Publisher";
	require_once "./template/admin_header.php";
	require_once "./functions/database_functions.php";
	$connection = new DatabaseConnection();

	if(isset($_GET['publisher_id'])){
		$publisher_id = $_GET['publisher_id'];
	} else {
		echo "Empty query!";
		exit;
	}

	if(!isset($publisher_id)){
		echo "Empty publisher! check again!";
		exit;
	}

	// get book data
	$result = $connection->getByPublisherId($publisher_id);

	$row = mysqli_fetch_assoc($result);


?>
	<form method="post" action="edit_publisher.php" enctype="multipart/form-data">
		<input type="hidden" name="publisher_id" value="<?php echo $row['publisher_id'];?>">
		<table class="table">
			<tr>
				<th>Publisher Name</th>
				<td><input type="text" name="publisher_name" value="<?php echo $row['publisher_name'];?>"></td>
			</tr>
			
		</table>
		<input type="submit" name="save_change" value="Edit Changes" class="btn btn-primary">
		<input type="reset" value="Reset" class="btn btn-default">
	</form>
	<br/>
	<a href="admin_publisher.php" class="btn btn-success">Back</a>
<?php
	require "./template/footer.php"
?>