<?php
	$author_id = $_GET['author_id'];

	require_once "./functions/database_functions.php";
	
	$connection = new DatabaseConnection();
  $result = $connection->delete_author($author_id );
	
	header("Location: admin_author.php");
?>