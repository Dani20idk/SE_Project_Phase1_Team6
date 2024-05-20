

<?php
require 'header.php';
require 'classes/Books.php';
require 'connectionToDB.php';

echo'<section class="shop_section layout_padding">
<div class="container">
  <div class="heading_container heading_center">
   
  </div>

  
  <div class="row">';
function getBooksByCategory($category) {
    $host = 'localhost';
    $dbName = 'bookstore2';
    $username = 'root';
    $password = '';

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to retrieve books for the specified category
        $sql = "SELECT * FROM `books` WHERE `category` = :category";

        // Prepare and execute the query with a named parameter
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch all books for the specified category as an associative array
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the database connection
        $pdo = null;

        return $books;
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Get the user-provided category (assuming it's from a form or URL parameter)
$userProvidedCategory = isset($_GET['Category']) ? $_GET['Category'] : null;

// If category is not provided or not valid, you may want to handle this appropriately

// Get all books for the specific category
$books = getBooksByCategory($userProvidedCategory);

// Display the product details
if ($books) {
    foreach ($books as $book) {
        echo '<div class="col-sm-8 col-md-6 col-lg-3">
                    <div class="box">
                        <a href="productdetail.php?book_id=' . $book['book_id'] . '">
                            <div class="img-box">
                                <img src="' . $book['book_img'] . '" alt="Image">
                            </div>
                            <div class="detail-box1">
                                <h6>' . $book['book_title'] . '</h6>
                                <h6>Price<span>' ." ". $book['book_price'] . "$".'</span></h6>
                                <button class="shopproductbtn"><a href="productdetail.php?book_id=' . $book['book_id'] . '" style="color:white"> Shop Product</a></button>
                            </div>
                        </a>
                    </div>
                    </div>';
    }
} else {
    echo '<p>No books found for the specified category.</p>';
}
echo'</div>
</section>';

require 'footer.html';
?>
 