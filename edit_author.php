<?php	
	session_start();
	require_once "./functions/admin.php";
	$title = "Edit author";
	require "./template/admin_header.php";
	require "./functions/database_functions.php";
	
	
	if(!isset($_POST['save_change'])){
		echo "Something wrong!";
		exit;
	}
	
	$author_id = trim($_POST['author_id']);
	$author_name = trim($_POST['author_name']);

	$connection = new DatabaseConnection();
  $result = $connection->edit_author($author_name ,$author_id);
	
?>