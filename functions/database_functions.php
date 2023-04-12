<?php

class DatabaseConnection
{

	const DB_USER = 'root';
	const DB_PASSWORD = '';
	const DB_HOST = 'localhost';
	const DB_NAME = 'group6_bookstore';

	private $dbc;

	function __construct()
	{
		$this->dbc = @mysqli_connect(
			self::DB_HOST,
			self::DB_USER,
			self::DB_PASSWORD,
			self::DB_NAME
		)
			or die('Could not connect to MySQL: ' . mysqli_connect_error());

		mysqli_set_charset($this->dbc, 'utf8');
	}

	function __destruct()
	{
		if (isset($this->dbc)) {
			mysqli_close($this->dbc);
		}
	}


	function select4LatestBook()
	{
		$row = array();
		$query = "SELECT book_isbn, book_image FROM books ORDER BY book_isbn DESC";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		for ($i = 0; $i < 4; $i++) {
			array_push($row, mysqli_fetch_assoc($result));
		}
		return $row;
	}

	function getBookByIsbn($isbn)
	{
		$query = "SELECT * FROM books WHERE book_isbn = '$isbn'";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}

	function getOrderId($customerid)
	{
		$query = "SELECT order_id FROM orders WHERE customer_id = '$customerid'";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "retrieve data failed!" . mysqli_error($this->dbc);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['order_id'];
	}

	function insertIntoOrder($customerid, $total_price, $date, $ship_name, $ship_address, $ship_city, $ship_zipcode, $ship_state, $ship_country)
	{
		$query = "INSERT INTO orders   (customer_id,amount,ship_name,ship_address,ship_city,ship_zipcode,ship_state,ship_country,order_date) VALUES
		('" . $customerid . "', '" . $total_price . "', '" . $ship_name . "', '" . $ship_address . "', '" . $ship_city . "', '" . $ship_zipcode . "','" . $ship_state . "', '" . $ship_country . "', '" . date('Y-m-d H:i:s') . "')";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Insert orders failed " . mysqli_error($this->dbc);
			exit;
		}
	}

	function getbookprice($isbn)
	{

		$query = "SELECT book_price FROM books WHERE book_isbn = '$isbn'";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "get book price failed! " . mysqli_error($this->dbc);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['book_price'];
	}

	function getCustomerId($name, $address, $city, $zipcode, $state, $country)
	{

		$query = "SELECT customer_id from customers WHERE 
		name = '$name' AND 
		address= '$address' AND 
		city = '$city' AND 
		zipcode = '$zipcode' AND 
		state = '$state' AND 
		country = '$country'";
		$result = mysqli_query($this->dbc, $query);
		// if there is customer in db, take it out
		if ($result) {
			$row = mysqli_fetch_assoc($result);
			return $row['customer_id'];
		} else {
			return null;
		}
	}

	function setCustomerId($name, $address, $city, $zipcode, $state, $country)
	{

		$query = "INSERT INTO customers VALUES 
			('', '" . $name . "', '" . $address . "', '" . $city . "', '" . $zipcode . "', '" . $state . "', '" . $country . "')";

		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "insert false !" . mysqli_error($this->dbc);
			exit;
		}
		$customerid = mysqli_insert_id($this->dbc);
		return $customerid;
	}

	function getPubName($publisher_id)
	{
		$query = "SELECT publisher_name FROM publisher WHERE publisher_id = '$publisher_id'";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		if (mysqli_num_rows($result) == 0) {
			echo "Empty books ! Something wrong! check again";
			exit;
		}

		$row = mysqli_fetch_assoc($result);
		return $row['publisher_name'];
	}

	function getAll()
	{
		$query = "SELECT * from books ORDER BY book_isbn DESC";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}

	function getAllAuthors()
	{
		$query = "SELECT * from authors ORDER BY author_id DESC";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		
		return $result;
	}

	function getAllPublisher()
	{
		$query = "SELECT * from publisher ORDER BY publisher_id DESC";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}

	function getAllOrders()
	{
		$query = "SELECT * from orders ORDER BY order_id DESC";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}
	function get_all_books()
	{
		$query = "SELECT book_isbn, book_image FROM books";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			$result = "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}

	function insertIntoAuthors($author_name)
	{
		$author_name = mysqli_real_escape_string($this->dbc, $author_name);
		$query = "INSERT INTO authors (author_name) VALUES ('" . $author_name . "')";
		$result = mysqli_query($this->dbc, $query);
		return $result;
	}

	function insertIntoBooks($isbn, $title, $image, $descr, $price, $publisher_id)
	{
		$query = "INSERT INTO books VALUES ('" . $isbn . "', '" . $title . "','" . $image . "', '" . $descr . "', '" . $price . "', '" . $publisher_id . "','" . date('Y-m-d') . "')";
		$result = mysqli_query($this->dbc, $query);
		return $result;
	}

	function insertIntoBookAuthor($isbn, $author_add)
	{
		mysqli_query($this->dbc, "INSERT INTO book_author VALUES ('" . $isbn . "', '" . $author_add . "')");
	}

	function insertIntoPublisherName($publisher_name)
	{
		$publisher_name = mysqli_real_escape_string($this->dbc, $publisher_name);
		$query = "INSERT INTO publisher (publisher_name) VALUES ('" . $publisher_name . "')";
		$result = mysqli_query($this->dbc, $query);
		return $result;
	}

	function getByAuthorId($author_id)
	{
		$query = "SELECT * FROM authors WHERE author_id = '$author_id'";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}

	function getBookData($book_isbn)
	{
		$query_book_author = "SELECT GROUP_CONCAT(author_id) as author_id FROM book_author WHERE book_isbn = '$book_isbn'";
		$result_book_author = mysqli_query($this->dbc, $query_book_author);
		if (!$result_book_author) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result_book_author;
	}

	function getByPublisherId($publisher_id)
	{
		$query = "SELECT * FROM publisher WHERE publisher_id = '$publisher_id'";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}

	function getUserNamePassword()
	{
		$query = "SELECT username, password from admin";
		$result = mysqli_query($this->dbc, $query);
		if (!$result) {
			echo "Empty data " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}

	function mysqliRealEscapeString($variableToEscape)
	{
		return mysqli_real_escape_string($this->dbc, $variableToEscape);
	}

	
	function book($book_isbn){
		$query = "SELECT books.*, publisher.publisher_name , GROUP_CONCAT(authors.author_name) author_name 
  	FROM books 
  	inner join book_author on book_author.book_isbn = books.book_isbn 
  	inner join authors on authors.author_id = book_author.author_id  
  	inner join publisher on publisher.publisher_id = books.publisher_id  
  	WHERE books.book_isbn = '$book_isbn'";
  	$result = mysqli_query($this->dbc, $query);
  	if(!$result){
   	 	echo "Can't retrieve data " . 		mysqli_error($this->dbc);
    	exit;
  	}
		return $result;
	}

	function books(){
		$query = "SELECT book_isbn, book_image FROM books";
  	$result = mysqli_query($this->dbc, $query);
  	if(!$result){
    	echo "Can't retrieve data " . mysqli_error($this->dbc);
    	exit;
 	 	}
		return $result;
	}

	function delete_book($book_isbn){
		$query = "DELETE FROM books WHERE book_isbn = '$book_isbn'";
		$result = mysqli_query($this->dbc, $query);
		if(!$result){
			echo "delete data unsuccessfully " . mysqli_error($this->dbc);
			exit;
		}
		return $result;
	}

	function delete_author($author_id){
		$query = "DELETE FROM authors WHERE author_id = '$author_id'";
		$result = mysqli_query($this->dbc, $query);
		if(!$result){
			echo "delete data unsuccessfully " . mysqli_error($this->dbc);
		exit;
		}
		return $result;
	}

	function edit_author($author_name,$author_id){
		$query = "UPDATE authors SET author_name = '$author_name' WHERE author_id = '$author_id'";
	
		$result = mysqli_query($this->dbc, $query);
		if(!$result){
			echo "Can't update data " . 	mysqli_error($this->dbc);
			exit;
		} else {
		header("Location: admin_author.php");
		}
		return $result;
	}

	function edit_book($title,$descr,$price,$publisher_id,$isbn,$author_id){
		$query = "UPDATE books SET  
	book_title = '$title', 
	book_description = '$descr', 
	book_price = '$price',
	publisher_id = '$publisher_id'";
	
	if(isset($image)){
		$query .= ", book_image='$image' WHERE book_isbn = '$isbn'";
	} else {
		$query .= " WHERE book_isbn = '$isbn'";
	}
	
	mysqli_query($this->dbc,"DELETE FROM book_author WHERE book_isbn = '$isbn'");
	
	foreach($author_id as $author_add){
		mysqli_query($this->dbc,"INSERT INTO book_author VALUES ('" . $isbn . "', '" . $author_add . "')");
	}

	
	$result = mysqli_query($this->dbc, $query);
	if(!$result){
		echo "Can't update data " . mysqli_error($this->dbc);
		exit;
	} else {
		header("Location: admin_edit_book.php?bookisbn=$isbn");
	}
		return $result;
	}

	function edit_publisher($publisher_name,$publisher_id){
		$query = "UPDATE publisher SET publisher_name = '$publisher_name' WHERE publisher_id = '$publisher_id'";
	
		$result = mysqli_query($this->dbc, $query);
		if(!$result){
			echo "Can't update data " . mysqli_error($this->dbc);
			exit;
		} else {
			header("Location: admin_publisher.php");
	}
		return $result;
	}

	function delete_publisher($publisher_id){
		$query = "DELETE FROM publisher WHERE publisher_id = '$publisher_id'";
		$result = mysqli_query($this->dbc, $query);
		if(!$result){
			echo "delete data unsuccessfully " . mysqli_error($this->dbc);
			exit;
		}
		return $result;

	}
	function get_order_details($order){
		$query = "SELECT * FROM orders WHERE order_id = '$order'";
		$result_order = mysqli_query($this->dbc, $query);
		if(!$result_order){
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		
		$order_details = mysqli_fetch_assoc($result_order);
		return $order_details;
	}
	function get_order_details_all($order){
		$query_order_item =  "SELECT order_items.book_isbn,order_items.quantity,order_items.item_price,books.book_title FROM order_items, books where books.book_isbn = order_items.book_isbn and order_id = '$order'";
		$result_order_item = mysqli_query($this->dbc, $query_order_item);
		if(!$result_order_item){
			echo "Can't retrieve data " . mysqli_error($this->dbc);
			exit;
		}
		return $result_order_item;
	}

	function insert_order_items($orderid,$isbn,$bookprice,$qty)
	{
		$query = "INSERT INTO order_items VALUES 
		('$orderid', '$isbn', '$bookprice', '$qty')";
		$result = mysqli_query($this->dbc, $query);
		if(!$result){
			echo "Insert value false!" . mysqli_error($this->dbc);
			exit;
		}
	}
	
}
