<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Add new book";
	require "./template/admin_header.php";
	require "./functions/database_functions.php";

	$connection = new DatabaseConnection();

	// get publisher data
	$result_publisher = $connection->getAllPublisher();
	
	// get author data
	$result_author = $connection->getAllAuthors();


	if(isset($_POST['add'])){
		
		$isbn = trim($_POST['isbn']);
		$isbn = $connection->mysqliRealEscapeString( $isbn);
		
		$title = trim($_POST['title']);
		$title = $connection->mysqliRealEscapeString($title);

		$descr = trim($_POST['descr']);
		$descr = $connection->mysqliRealEscapeString($descr);
		
		$price = floatval(trim($_POST['price']));
		$price = $connection->mysqliRealEscapeString($price);
		
		$publisher_id = $_POST['publisher_id'];
		$author_id = $_POST['author_id'];
		
		
		// add image
		if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
			$image = $_FILES['image']['name'];
			$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
			$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "bootstrap/img/";
			$uploadDirectory .= $image;
			move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory);
		}

		
		$result=$connection->insertIntoBooks($isbn, $title, $image, $descr, $price, $publisher_id);
		
	
		foreach($author_id as $author_add){
			$connection->insertIntoBookAuthor($isbn, $author_add);
		}


		if(!$result){
			echo "Can't add new data " . mysqli_error($conn);
			exit;
		} else {
			header("Location: admin_book.php");
		}
	}
?>
	<form method="post" action="admin_add_book.php" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<th>ISBN</th>
				<td><input type="text" name="isbn"></td>
			</tr>
			<tr>
				<th>Title</th>
				<td><input type="text" name="title" required></td>
			</tr>
			<tr>
				<th>Author</th>
				<td><select name="author_id[]" multiple>
				<?php foreach ($result_author as $author) {?>
					<option value="<?php echo $author['author_id'];?>"><?php echo $author['author_name'];?></option>
				<?php } ?>

				</select></td>
			</tr>
			<tr>
				<th>Image</th>
				<td><input type="file" name="image"></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><textarea name="descr" cols="40" rows="5"></textarea></td>
			</tr>
			<tr>
				<th>Price</th>
				<td><input type="text" name="price" required></td>
			</tr>
			<tr>
				<th>Publisher</th>
				<td>
				<select name="publisher_id">
				<?php foreach ($result_publisher as $publisher) {?>
					<option value="<?php echo $publisher['publisher_id'];?>"><?php echo $publisher['publisher_name'];?></option>
				<?php } ?>

				</select>
			</tr>
		</table>
		<input type="submit" name="add" value="Add new book" class="btn btn-primary">
		<input type="reset" value="Reset" class="btn btn-default">
	</form>
	<br/>
	<a href="admin_book.php" class="btn btn-success">Back</a>
<?php
	require_once "./template/footer.php";
?>