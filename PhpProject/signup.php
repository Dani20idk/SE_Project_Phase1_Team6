<?php
session_start();

require 'connectionToDB.php';
require 'classes/Clients.php';
require 'header.php';

// Process registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Retrieve registration form input
    $username = $_POST['client_username'];
    $password = $_POST['client_password'];

    // Validate user input (you can add more validation as needed)
    if (empty($username) || empty($password)) {
        $registration_error_message = "Please enter both username and password.";
    } else {
        // Check if the username is already taken
        $query = "SELECT client_id FROM clients WHERE client_username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Username already taken
            $registration_error_message = "Username already taken. Please choose a different username.";
        } else {
            // Insert new user into the database
            $query = "INSERT INTO clients (client_username, client_password) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('ss', $username, $password);

            if ($stmt->execute()) {
                // Registration successful
                $registration_success_message = "Registration successful. You can now log in.";
                echo $registration_success_message;
            } else {
                // Registration failed
                $registration_error_message = "Registration failed. Please try again.";
            }

            // Close the prepared statement
            $stmt->close();
        }
    }

    // Close the database connection
    $db->close();
}
?>


    <!-- registration -->
    <section class="contact_section ";>
    <div class="container px-0">
    <div class="heading_container ">
        <h2 class="">
          Register
        </h2>
      </div>
    </div>
    <div class="container container-bg">
    <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 px-0" id="login_form">
        <?php
        if (isset($registration_error_message)) {
            echo '<p style="color: red;">' . $registration_error_message . '</p>';
        }
        ?>
        <form method="post" action="signup.php">
            <label for="client_username" class="form-label">Username:</label>
            <input type="text" name="client_username" class="form-input" required>
            <label for="client_password" class="form-label">Password:</label>
            <input type="password" name="client_password" class="form-input" required>
            <div class="d-flex ">
            <button type="submit" name="register" id="login-btn">Register</button>
            </div>
          
        </form>
       
    </div>
    </div>
    </div>
    </section>
   
    <?php
    require 'footer.html';
    ?>
