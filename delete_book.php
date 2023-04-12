<?php
	$book_isbn = $_GET['bookisbn'];

	require_once "./functions/database_functions.php";
	
	$connection = new DatabaseConnection();
  $result = $connection->delete_book($book_isbn );

	header("Location: admin_book.php");
?>