<?php	
	if(!isset($_POST['save_change'])){
		echo "Something wrong!";
		exit;
	}

	$isbn = trim($_POST['isbn']);
	$title = trim($_POST['title']);
	
	$descr = trim($_POST['descr']);
	$price = floatval(trim($_POST['price']));
	$publisher_id = trim($_POST['publisher_id']);
	$author_id = $_POST['author_id'];

	if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
		$image = $_FILES['image']['name'];
		$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
		$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "bootstrap/img/";
		$uploadDirectory .= $image;
		move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory);
	}

	require_once("./functions/database_functions.php");
	
	$connection = new DatabaseConnection();
  $result = $connection->edit_book($title,$descr,$price,$publisher_id,$isbn,$author_id);


	
?>