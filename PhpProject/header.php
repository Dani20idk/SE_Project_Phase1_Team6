<!DOCTYPE html>
<html>
  <?php
  function getCategory(){
    $host = 'localhost';
    $dbName = 'bookstore1';
    $username = 'root';
    $password = '';
  
    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
  
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
        // SQL query to retrieve distinct categories from the Books table
        $sql = "SELECT DISTINCT category FROM `books`";
  
        // Prepare and execute the query
        $stmt = $pdo->query($sql);
  
        // Fetch all distinct categories as an associative array
        $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
        // Close the database connection
        $pdo = null;
  
        return $categories;
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
        return [];
    }
  }
  
  // Get distinct categories
  $categories = getCategory();
  ?>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>
   Bookstore
  </title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>


<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="index.html">
          <span>
          Librari Art’s
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home </a>
            </li>
            <div class="dropdown">
        
        <li class="nav-item active" id="dropdown_li">
           <a class="nav_link" id="category" href=""><span class="clothing_btn" >CATEGORY</a></span></li>
        <div class="dropdown-content">

       
      <?php
      foreach ($categories as $category) {
          echo '<a href="product.php?Category=' . $category . '">' . $category . '</a>';
      }
      ?>
    
       
          
        </div>
      
      </div>
           
            <li class="nav-item">
              <a class="nav-link" href="contactus.php">Contact Us</a>
            </li>
          </ul>
          <div class="user_option">
            <a href="login.php">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>
                Login
              </span>
            </a>
            <a href="shoppingcart.php">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
             
            </a>
            <form class="form-inline" method="GET" action="search.php">
    <input name="searchterm" type="text" style="margin-right: 6px;">
    <button class="btn nav_search-btn" type="submit" name="submit">
        <i class="fa fa-search" aria-hidden="true"></i>
    </button>
</form>

          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->
    <!-- slider section -->