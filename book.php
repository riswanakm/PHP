<?php
  session_start();
  $book_isbn = $_GET['bookisbn'];
  require_once "./functions/database_functions.php";

  $connection = new DatabaseConnection();
  $result = $connection->book($book_isbn);

  $row = mysqli_fetch_assoc($result);
  if(!$row){
    echo "Empty book";
    exit;
  }

  $title = $row['book_title'];
  require "./template/header.php";
?>
      
      <p class="lead" style="margin: 25px 0"><a href="books.php">Books</a> > <?php echo $row['book_title']; ?></p>
      <div class="row">
        <div class="col-md-3 text-center">
          <img class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $row['book_image']; ?>">
        </div>
        <div class="col-md-6">
          <h4><b>Book Description</b></h4>
          <p style="text-align: justify;"><?php echo $row['book_description']; ?></p>
		  <br>
          <h4><b>Book Details</b></h4>
          <table class="table">
          	<?php foreach($row as $key => $value){
              if($key == "book_description" || $key == "book_image" || $key == "publisher_id" || $key == "book_title"){
                continue;
              }
              switch($key){
                case "book_isbn":
                  $key = "ISBN";
                  break;
                case "book_title":
                  $key = "Title";
                  break;
                case "book_author":
                  $key = "Author";
                  break;
                case "book_price":
                  $key = "Price";
                  break;
				case "author_name":
                  $key = "Author Name";
                  break;
				case "publisher_name":
                  $key = "Publisher Name";
                  break;
				case "publish_date":
                  $key = "Publish Date";
                  break;
              }
            ?>
            <tr>
              <td><?php echo $key; ?></td>
              <td><?php echo $value; ?></td>
            </tr>
            <?php 
              } 
              if(isset($conn)) {mysqli_close($conn); }
            ?>
          </table>
          <form method="post" action="cart.php">
            <input type="hidden" name="bookisbn" value="<?php echo $book_isbn;?>">
            <input type="submit" value="Buy Now" name="cart" class="btn btn-primary">
          </form>
       	</div>
      </div>
<?php
  require "./template/footer.php";
?>