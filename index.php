<?php
  session_start();
  $count = 0;
  require_once "./functions/database_functions.php";
  
  $connection = new DatabaseConnection();
  $result = $connection->get_all_books();
  

  $title = "Full Catalogs of Books";
  require_once "./template/header.php";
?>


  <p class="lead text-center text-muted">Full Catalogs of Books</p>
    <?php for($i = 0; $i < mysqli_num_rows($result); $i++){ ?>
      <div class="row">
        <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
          <div class="col-md-3">
            <a href="book.php?bookisbn=<?php echo $query_row['book_isbn']; ?>">
              <img style="margin: 10px;height:300px;width:250px" class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $query_row['book_image']; ?>">
            </a>
          </div>
        <?php
          $count++;
          if($count >= 4){
              $count = 0;
              break;
            }
          } ?> 
      </div>
<?php
      }
 
  require_once "./template/footer.php";
?>