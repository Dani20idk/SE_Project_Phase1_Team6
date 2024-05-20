<?php
require 'header.php';
?>

<section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        
      </div>

      
      <div class="row">
      <?php
              require 'classes/Books.php';
              require 'connectionToDB.php';

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
                   
                     $sql2 = "SELECT * FROM `books`";
            
                    // Prepare and execute the query
                    $stmt2 = $pdo2->query($sql2);
            
                    // Fetch all rows as an associative array
                    $data2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            
                    // Close the database connection
                    $pdo2 = null;
            
                    foreach($data2 as $row){
                        $rows[] = new Books($row['book_id'], $row['book_title'], $row['book_img'], $row['book_description'], $row['book_price'], $row['stock_left'],$row['Category']);
                    }
                } catch (PDOException $e) {
                    // Handle database connection errors
                    echo "Error: " . $e->getMessage();
                    return false;
                }
        
                return $rows;
            }
        
            $books = getBooks();

            
            
            
            foreach ($books as $record) {
              echo '<div class="col-sm-6 col-md-4 col-lg-3">
                      <div class="box">
                        <a href="productdetail.php?book_id=' . $record->getBook_id() . '">
                          <div class="img-box">
                            <img src="' . $record->getBook_image() . '" alt="Image">
                            </a>
                          </div>
                          <div class="detail-box1">
                            <h6>' . $record->getBook_title() . '</h6>
                            <h6>Price<span>' ." ". $record->getBook_price() . "$".'</span></h6>
                            <button class="shopproductbtn"><a href="productdetail.php?book_id=' . $record->getBook_id() . '" style="color:white"> Shop Product</a></button>
                          </div>
                       
                      </div>
                    </div>';
          }
          
            
            ?>  
            </div>
  </section>
  <?php
  require "footer.html";
  ?>