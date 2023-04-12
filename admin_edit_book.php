<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Edit book";
	require_once "./template/admin_header.php";
	require_once "./functions/database_functions.php";
	$connection = new DatabaseConnection();

	if(isset($_GET['bookisbn'])){
		$book_isbn = $_GET['bookisbn'];
	} else {
		echo "Empty query!";
		exit;
	}

	if(!isset($book_isbn)){
		echo "Empty isbn! check again!";
		exit;
	}

	// get book data
	$result = $connection->getBookByIsbn($book_isbn);
	$row = mysqli_fetch_assoc($result);
	
	// get publisher data
	$result_publisher = $connection->getAllPublisher();
	
	// get author data
	$result_author = $connection->getAllAuthors();
	
	// get book data
	$result_book_author = $connection->getBookData($book_isbn);
	$row_book_author = mysqli_fetch_assoc($result_book_author);
	$author_id = explode(',',$row_book_author['author_id']);


?>
	<form method="post" action="edit_book.php" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<th>ISBN</th>
				<td><input type="text" name="isbn" value="<?php echo $row['book_isbn'];?>" readOnly="true"></td>
			</tr>
			<tr>
				<th>Title</th>
				<td><input type="text" name="title" value="<?php echo $row['book_title'];?>" required></td>
			</tr>
			<tr>
				<th>Author</th>
				<td><select multiple name="author_id[]">
				<?php foreach ($result_author as $author) {?>
					<option <?php if(in_array($author['author_id'],$author_id)){ ?> selected <?php } ?> value="<?php echo $author['author_id'];?>"><?php echo $author['author_name'];?></option>
				<?php } ?>

				</select></td>
			</tr>
			<tr>
				<th>Image</th>
				<td><input type="file" name="image"></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><textarea name="descr" cols="40" rows="5"><?php echo $row['book_description'];?></textarea>
			</tr>
			<tr>
				<th>Price</th>
				<td><input type="text" name="price" value="<?php echo $row['book_price'];?>" required></td>
			</tr>
			<tr>
				<th>Publisher</th>
				<td>
				<select name="publisher_id">
				<?php foreach ($result_publisher as $publisher) {?>
					<option value="<?php echo $publisher['publisher_id'];?>" <?php if($publisher['publisher_id'] == $row['publisher_id']){ ?> selected <?php } ?>><?php echo $publisher['publisher_name'];?></option>
				<?php } ?>

				</select>
			</tr>
		</table>
		<input type="submit" name="save_change" value="Edit Changes" class="btn btn-primary">
		<input type="reset" value="Reset" class="btn btn-default">
	</form>
	<br/>
	<a href="admin_book.php" class="btn btn-success">Back</a>
<?php
	require "./template/footer.php"
?>