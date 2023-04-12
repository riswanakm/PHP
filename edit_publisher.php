<?php	
	session_start();
	require_once "./functions/admin.php";
	$title = "Edit publisher";
	require "./template/admin_header.php";
	require "./functions/database_functions.php";
	
	
	if(!isset($_POST['save_change'])){
		echo "Something wrong!";
		exit;
	}
	
	$publisher_id = trim($_POST['publisher_id']);
	$publisher_name = trim($_POST['publisher_name']);

	$connection = new DatabaseConnection();
  $result = $connection->edit_publisher($publisher_name,$publisher_id);	
	
?>