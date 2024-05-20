<?php
session_start();
require 'header.php'; // Include header to handle session-related functionality
require 'connectionToDB.php';
require 'classes/Books.php';
require 'classes/Sales.php';
require 'classes/Clients.php';





function getBooks(){
                
    $host = 'localhost';
    $dbName = 'bookstore2';
    $username = 'root';
    $password = '';
    $rows = [];

    try {
        // Create a PDO connection
        $pdo2 = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

        // Set the PDO error mode to exception
        $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to retrieve data from the specified table
        $sql2 ="SELECT * FROM books ORDER BY book_id ";
        // $sql2 = "SELECT * FROM `books`";

        // Prepare and execute the query
        $stmt2 = $pdo2->query($sql2);

        // Fetch all rows as an associative array
        $data2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Close the database connection
        $pdo2 = null;

        foreach($data2 as $row){
            $rows[] = new Books($row['book_id'], $row['book_title'], $row['book_img'], $row['book_description'], $row['book_price'], $row['Category']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
        return false;
    }

    return $rows;
}

function deleteBooks(){
  
// Check if the book id is provided
if (isset($_GET['book_id'])) {
    // Get the book id
    $bookId = $_GET['book_id'];

    require 'connectionToDB.php';
   

    // Prepare and execute the delete query
    $query = "DELETE FROM books WHERE book_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $bookId);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Book deleted successfully.";
    } else {
        echo "Error deleting book.";
    }

    // Close the statement and database connection
    $stmt->close();
    $db->close();
} 

}


    echo '
    <section class="h-100 h-custom">
   
            <div class="container h-100 py-5">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                              
                                <tbody>';

    // Display each book in the shopping cart
    $books = getBooks();
   
    foreach ($books as $record) {

        echo '
        <tr >
                <th scope="row" class="border-bottom-0" style="padding: 3.85rem">
                    <div class="d-flex align-items-center">
                        <img src="'. $record->getBook_image() .'" class="img-fluid rounded-3" style="width: 120px;" alt="Book">
                        <div class="flex-column ms-4">
                            <p class="mb-2">'. $record->getBook_title() .'</p>
                           
                        </div>
                    </div>
                </th>
                <td class="align-middle border-bottom-0">
                    <div class="d-flex flex-row">
                    <p class="mb-2">'. $record->getBook_description() .'</p>
                    </div>
                </td>
                <td class="align-middle border-bottom-0">
                    <div class="d-flex flex-row">
                    <p class="mb-2"> $'. $record->getBook_price() .'</p>
                    </div>
                </td>
             
                <td class="align-middle border-bottom-0">
                <div class="d-flex flex-row">
                    <button class="btn btn-link px-2" onclick="confirmDelete('. $record->getBook_id() .')">
                        <i class="fa fa-minus" style="color:#eab92d"></i>
                    </button>

                    </div>
                    </td>        
        </tr>';
    }
    $deletebooks = deleteBooks();
  
    // Display the table footer
    echo '
    </tbody>
    </table>
</div>

<div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
    
<form method="post" action="addbook.php">
                <button type="submit" name="add"class="btn btn-primary btn-block btn-lg" style="background-color:#eab92d; ">
                    <div class="d-flex justify-content-center">
                        <span>ADD BOOK</span>
                    </div>
                </button>
                </form>
          
        
</div>

</div>

</section>'
;



// Close the database connection
// $db->close();
require 'footer.html';
 ?>
<script>
    function confirmDelete(book_id) {
        var userInput = prompt("Are you sure you want to delete this book? Type 'yes' to confirm.");
        if (userInput === "yes") {
            window.location.href = "admin_dashboard.php?book_id=" + book_id;
        }
    }
</script>