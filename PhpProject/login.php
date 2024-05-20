<?php
session_start();

require 'connectionToDB.php';
require 'classes/Clients.php';
require 'header.php';

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Retrieve login form input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user input (you can add more validation as needed)
    if (empty($username) || empty($password)) {
        $login_error_message = "Please enter both username and password.";
    } else {
        // Check if the user exists in the clients table
        $query = "SELECT client_id, client_username, client_password FROM clients WHERE client_username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            // User found in the clients table, fetch details
            $stmt->bind_result($client_id, $client_username, $client_password);
            $stmt->fetch();

            // Verify password
            if ($password === $client_password) {
                // Login successful for client, set session variables
                $_SESSION['client_id'] = $client_id;
                $_SESSION['client_username'] = $client_username;

                // Redirect to the home page or dashboard
                $login_success_message = "You have logged in successfully";
                echo $login_success_message;
            } else {
                // Invalid password
                $login_error_message = "Invalid password. Please try again.";
            }
        } elseif ($stmt->num_rows === 0) {
            // Check if the user exists in the admins table
            $query = "SELECT admin_id, admin_username, admin_password FROM admin WHERE admin_username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                // User found in the admins table, set admin session variables
                $stmt->bind_result($admin_id, $admin_username, $admin_password);
                $stmt->fetch();

                if ($password === $admin_password) {
                    $_SESSION['admin_id'] = $admin_id;
                    $_SESSION['admin_username'] = $admin_username;
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    $login_error_message = "Invalid password for admin. Please try again.";
                }
            } else {
                // User not found in either clients or admins table
                $login_error_message = "Invalid username or password. Please try again.";
            }
        } else {
            // More than one user found, unexpected scenario
            $login_error_message = "Unexpected error. Please try again.";
        }

        // Close the prepared statement
        $stmt->close();
    }
} 

// Close the database connection
$db->close();

?>


    <!-- login -->
    <section class="contact_section ";>
    <div class="container px-0">
    <div class="heading_container ">
        <h2 class="">
          Log In
        </h2>
      </div>
    </div>
    <div class="container container-bg">
    <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 px-0" id="login_form">
        <?php
        if (isset($login_error_message)) {
            echo '<p class="error-message">' . $login_error_message . '</p>';
        }
        ?>
        <form method="post" action="login.php">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-input" required>
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-input" required>
            <div class="d-flex ">
            <button type="submit" name="login" id="login-btn">Login</button>
            </div>
            <div class="d-flex ">
                <div class="text-center">
            <a href='signup.php' id='signup-link'>Sign up</a>
                </div>
            </div>
        </form>
       
    </div>
    </div>
    </div>
    </section>
<?php
require 'footer.html';

?>
