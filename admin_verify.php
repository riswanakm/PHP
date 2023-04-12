<?php
	session_start();
	require_once "./functions/database_functions.php";
	$connection = new DatabaseConnection();
	
	if(!isset($_POST['submit'])){
		echo "Something wrong! Check again!";
		exit;
	}
	require_once "./functions/database_functions.php";

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if($username == "" || $password == ""){
		echo "Username or Password is empty!";
		exit;
	}

	$name = $connection->mysqliRealEscapeString($username);
	$password = $connection->mysqliRealEscapeString($password);
	$password = sha1($password);

	$result = $connection->getUserNamePassword();

	$row = mysqli_fetch_assoc($result);

	if($username != $row['username'] && $password != $row['password']){
		echo "Username or Password is wrong. Check again!";
		$_SESSION['admin'] = false;
		exit;
	}

	$_SESSION['admin'] = true;
	header("Location: admin_book.php");
?>