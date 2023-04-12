<?php
	session_start();

	$_SESSION['err'] = 1;
	foreach($_POST as $key => $value){
		if(trim($value) == ''){
			$_SESSION['err'] = 0;
		}
		break;
	}

	if($_SESSION['err'] == 0){
		header("Location: purchase.php");
	} else {
		unset($_SESSION['err']);
	}

	require_once "./functions/database_functions.php";
	$title = "Purchase Process";
	require "./template/header.php";
	$connection = new DatabaseConnection();
	extract($_SESSION['ship']);

	// validate post section
	$card_number = $_POST['card_number'];
	$card_PID = $_POST['card_PID'];
	$card_expire = strtotime($_POST['card_expire']);
	$card_owner = $_POST['card_owner'];

	// find customer
	$customerid = $connection->getCustomerId($name, $address, $city, $zipcode, $state, $country);
	if($customerid == null) {
		// insert customer into database and return customerid
		$customerid = $connection->setCustomerId($name, $address, $city, $zipcode,$state,  $country);
	}
	$date = date("Y-m-d H:i:s");
	$connection->insertIntoOrder($customerid, $_SESSION['total_price'], $date, $name, $address, $city, $zipcode, $state, $country);

	// take orderid from order to insert order items
	$orderid = $connection->getOrderId($customerid);

	foreach($_SESSION['cart'] as $isbn => $qty){
		$bookprice = $connection->getbookprice($isbn);
		$connection->insert_order_items($orderid,$isbn,$bookprice,$qty);
	}

	session_unset();
?>
	<p class="lead text-success">Your order has been processed sucessfully. Please download your invoice <a href="invoice.php?order=<?php echo $orderid; ?>">Click here</a> </p>

<?php
	
	require_once "./template/footer.php";
?>