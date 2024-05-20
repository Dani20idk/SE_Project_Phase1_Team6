
<?php
require 'header.php';

require 'classes/Books.php';
require 'connectionToDB.php';

function getBookById($bookId){
  $host = 'localhost';
  $dbName = 'bookstore2';
  $username = 'root';
  $password = '';

  try {
      // Create a PDO connection
      $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

      // Set the PDO error mode to exception
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // SQL query to retrieve data for the specified book ID
      $sql = "SELECT * FROM `books` WHERE `book_id` = :bookId";

      // Prepare and execute the query with a named parameter
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
      $stmt->execute();

      // Fetch the result as an associative array
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      // Close the database connection
      $pdo = null;

      if($data){
        return new Books($data['book_id'], $data['book_title'], $data['book_img'], $data['book_description'], $data['book_price'], $data['Category']);
      }
  } catch (PDOException $e) {
      // Handle database connection errors
      echo "Error: " . $e->getMessage();
      return false;
  }
}

// Get the user-provided book_id (assuming it's from a form or URL parameter)
$userProvidedBookId = isset($_GET['book_id']) ? $_GET['book_id'] : null;

// If book_id is not provided or not valid, you may want to handle this appropriately

// Get the specific book based on the user-provided book_id
$book = getBookById($userProvidedBookId);

if ($book) {
  echo '<body>
    <div class="wrapper" id="productdetail-wrapper">
      <div class="product-img" id="productdetail-img">
        <img src="'. $book->getBook_image() .'" height="420" width="327">
      </div>
      <div class="product-info">
        <div class="product-text" id="productdetail-text">
          '. $book->getBook_description() .'
        </div>
        <div class="product-price-btn" id="product-price-btn">
          <p><span id="productdeai-price">'. $book->getBook_price() .'</span>$</p>
          <form method="post" action="shoppingcart.php">
              <input type="hidden" name="book_id" value="'. $book->getBook_id()  .'">
              <button type="submit" name="add_to_cart" value="1" style="color:white">Add To Cart</button>
          </form>
        </div>
      </div>
    </div>
  </body>';
} else {
  echo '<p>Invalid book ID or book not found.</p>';
}

require 'footer.html';
?>
