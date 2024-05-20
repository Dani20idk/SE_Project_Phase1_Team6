<?php
require 'header.php';
require 'classes/Contact.php';
require 'connectionToDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone_number = $_POST['phone_number'];
  $message = $_POST['message'];

  // SQL query to insert data into the events table
  $sql = "INSERT INTO contact (name, email, phone_number,message)
          VALUES ('$name', '$email', '$phone_number', '$message')";

  if ($db->query($sql) === TRUE) {
      echo "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error();
  }

  $db->close();
}
?>
<!-- contact section -->

<section class="contact_section ";>
    <div class="container px-0">
      <div class="heading_container ">
        <h2 class="">
          Contact Us
        </h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
              <img src="images/bookstore.avif" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div>
              <input type="text" placeholder="Name" id="name"  name="name"/>
            </div>
            <div>
              <input type="email" placeholder="Email"  id="email" name="email" />
            </div>
            <div>
              <input type="text" placeholder="Phone" id="phone_number" name="phone_number"/>
            </div>
            <div>
              <input type="text" class="message-box" placeholder="Message" id="message" name="message"/>
            </div>
            <div class="d-flex ">
              <button>
                SEND
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->
 
  <?php
require 'footer.html';
?>