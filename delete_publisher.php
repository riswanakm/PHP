<?php
	$publisher_id = $_GET['publisher_id'];

	require_once "./functions/database_functions.php";
	
	$connection = new DatabaseConnection();
  $result = $connection->delete_publisher($publisher_id);
	
	

	header("Location: admin_publisher.php");
?>