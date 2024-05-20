<?php
    //Database connection
    $host = 'localhost';      // Replace with your database host
    $dbname = 'bookstore2';      // Replace with your database name
    $username = 'root';  // Replace with your database username
    $password = ''; // Replace with your database password

    // Create a MySQLi connection
    $db = new mysqli($host, $username, $password,  $dbname);

    // Check the connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }else{
        echo("");
    }


?>