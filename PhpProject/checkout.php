<?php
session_start();
require 'header.php'; // Include header to handle session-related functionality
require 'connectionToDB.php';
require 'classes/Books.php';
require 'classes/Sales.php';
require 'classes/Clients.php';

function getNextIncrementedValue($tableName, $columnName) {
            
    $host = 'localhost';
    $dbName = 'bookstore2';
    $username = 'root';
    $password = '';

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Build the SQL query to get the highest value
        $sql = "SELECT COALESCE(MAX($columnName), 0) AS max_value FROM $tableName";

        // Execute the query
        $stmt = $pdo->query($sql);

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        $pdo = null;

        // Return the next incremented value
        return $result['max_value'] + 1;

    } catch (PDOException $e) {
        // Handle database connection errors
        error_log("Error: " . $e->getMessage());
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_out'])) {
    if (!isset($_SESSION['client_id'])) {
        // If not set, print "Please log in first" and exit
        echo "Please log in first";
        exit();
    }
    
    // Proceed with the checkout process
    $client_id = $_SESSION['client_id'];
    // $client_id = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;
    
    $sale_date= date('Y-m-d');
    $sale_id = getNextIncrementedValue('sales', 'sale_id');

    foreach ($_SESSION['shopping_cart'] as $book_id => $quantity) {
        // Use $book_id directly from the shopping cart
        // Assuming $db is already defined in shoppingcart.php
        $query = "SELECT * FROM books WHERE book_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the result set is not empty
        if ($result->num_rows > 0) {
            $book_data = $result->fetch_assoc();

            // Access the book details directly
            $book_price = $book_data['book_price'];

            // Calculate subtotal and total
            //  $subtotal = $quantity * $book_price;
            $subtotal = $_POST['subtotal'];
            $total = $_POST['finaltotal'];
              

            // SQL query to insert data into the contact table
            $sql = "INSERT INTO sales (sale_id, book_id, client_id, quantity, subtotal, total, sale_date)
                    VALUES ('$sale_id', '$book_id', '$client_id', '$quantity', '$subtotal', '$total', '$sale_date')";

            if ($db->query($sql) === TRUE) {
                echo "Order placed succesfuly";
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        } else {
            echo "Book details not found for book_id: $book_id";
        }
    }

    unset($_SESSION['shopping_cart']);

    // Redirect or display a success message
   
    exit();
}
else {
    header('login.php');
}

$db->close();
?>
