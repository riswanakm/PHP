<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Add new publisher";
	require "./template/admin_header.php";
	require "./functions/database_functions.php";

	$connection = new DatabaseConnection();
	
	
	if(isset($_POST['add'])){
		
		$publisher_name = trim($_POST['publisher_name']);
		
		
		$result = $connection->insertIntoPublisherName($publisher_name);

		if(!$result){
			echo "Can't add new data " . mysqli_error($conn);
			exit;
		} else {
			header("Location: admin_publisher.php");
		}
	}
?>
	<form method="post" action="admin_add_publisher.php" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<th>Publisher Name</th>
				<td><input type="text" name="publisher_name"></td>
			</tr>
		</table>
		<input type="submit" name="add" value="Add new publisher" class="btn btn-primary">
		<input type="reset" value="Reset" class="btn btn-default">
	</form>
	<br/>
	<a href="admin_publisher.php" class="btn btn-success">Back</a>
<?php
	require_once "./template/footer.php";
?>