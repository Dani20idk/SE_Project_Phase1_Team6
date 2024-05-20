<?php
require 'header.php';
require 'classes/Books.php';
require 'connectionToDB.php';

// Check for connection errors
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Retrieve user input from the form using $_GET
$searchterm = isset($_GET['searchterm']) ? trim($_GET['searchterm']) : '';

// Check if search term is provided
if (!$searchterm) {
    echo '<p>You have not entered a search term.<br/>Please go back and try again.</p>';
    exit;
}

// Prepare the SQL query to search for books by title
$query = "SELECT book_id, book_title, book_img, book_description, book_price FROM books WHERE book_title LIKE ?";
$stmt = $db->prepare($query);
$searchterm = "%$searchterm%"; // Adding wildcards to search term

// Bind the search term to the prepared statement
$stmt->bind_param('s', $searchterm);
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Display search results
if ($result->num_rows === 0) {
    echo "<h3 id='search-error'>No books found matching your search.</h3>";
} else {
    echo '<p>Number of books found: ' . $result->num_rows . '</p>
    <section class="shop_section layout_padding" style= "padding-top:5px";>
    
      
<div class="row">';
        

    // Loop through each matching book and display its details
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box">
                    <a href="productdetail.php?book_id=' . $row['book_id'] . '">
                        <div class="img-box">
                            <img src="' . $row['book_img'] . '" alt="Image">
                        </div>
                        <div class="detail-box1">
                            <h6>' . $row['book_title'] . '</h6>
                            <h6>Price<span>' .' '. $row['book_price'] . '$'.'</span></h6>
                            <button class="shopproductbtn"><a href="productdetail.php?book_id=' . $row['book_id'] . '" style="color:white"> Shop Product</a></button>
                        </div>
                    </a>
                </div>
            </div>
            </div>
</section>';
    }
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$db->close();
require 'footer.html';
?>
