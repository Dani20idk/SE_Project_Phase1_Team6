<?php
session_start();
require 'header.php'; // Include header to handle session-related functionality
require 'connectionToDB.php';
require 'classes/Books.php';
require 'classes/Sales.php';
require 'classes/Clients.php';

function addToCart($db) {
    if (isset($_POST['add_to_cart'])) {
        // Get book ID from the form
        $book_id = $_POST['book_id'];

        // Prepare and execute statement to prevent SQL injection
        $query = "SELECT * FROM books WHERE book_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the book exists
        if ($result->num_rows > 0) {
            $book_data = $result->fetch_assoc();
            $book = new Books(
                $book_data['book_id'],
                $book_data['book_title'],
                $book_data['book_img'],
                $book_data['book_description'],
                $book_data['book_price'],
                $book_data['Category']
            );

            // Check if the book is already in the cart
            if (!isset($_SESSION['shopping_cart'][$book_id])) {
                $_SESSION['shopping_cart'][$book_id] = 1;
            } else {
                $_SESSION['shopping_cart'][$book_id]++;
            }
            echo '<p>Book added to cart successfully.</p>';
        }
        $stmt->close();
    }
}

addToCart($db);

function getBookDetails($book_id, $db) {
    $query = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the result set is not empty
    if ($result->num_rows > 0) {
        $book_data = $result->fetch_assoc();

        // Instantiate the Books object with constructor arguments
        $book = new Books(
            $book_data['book_id'],
            $book_data['book_title'],
            $book_data['book_img'],
            $book_data['book_description'],
            $book_data['book_price'],
            $book_data['Category']
        );

        $stmt->close();
        return $book;
    } else {
        // Return null or handle the case where the book is not found
        return null;
    }
}

if (!isset($_SESSION['shopping_cart']) || empty($_SESSION['shopping_cart'])) {
    echo '<p>Your shopping cart is empty.</p>';
} else {
    // Calculate subtotal and total
    $subtotal = 0;
    foreach ($_SESSION['shopping_cart'] as $book_id => $quantity) {
        $book = getBookDetails($book_id, $db);
        $subtotal += $quantity * $book->getBook_price();
    }
    $shippingCost = 2.99;
    $total = $subtotal + $shippingCost;

    // Display the table header
    ?>
    <section class="h-100 h-custom">
        <div class="container h-100 py-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="h5">Shopping Bag</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Display each book in the shopping cart
                                foreach ($_SESSION['shopping_cart'] as $book_id => $quantity) {
                                    $book = getBookDetails($book_id, $db);
                                    ?>
                                    <tr>
                                        <th scope="row" class="border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $book->getBook_image() ?>" class="img-fluid rounded-3" style="width: 120px;" alt="Book">
                                                <div class="flex-column ms-4">
                                                    <p class="mb-2"><?= $book->getBook_title() ?></p>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="align-middle border-bottom-0">
                                            <div class="d-flex flex-row">
                                                <button class="btn btn-link px-2" onclick="updateQuantity(<?= $book->getBook_id() ?>, -1, <?= $book->getBook_price() ?>)">
                                                    <i class="fa fa-minus" style="color:#eab92d"></i>
                                                </button>
                                                <input id="quantity<?= $book->getBook_id() ?>" min="0" name="quantity" value="<?= $quantity ?>" type="number" class="form-control form-control-sm" style="width: 50px;" oninput="updateSubtotal(<?= $book->getBook_id() ?>, <?= $book->getBook_price() ?>)">
                                                <button class="btn btn-link px-2" onclick="updateQuantity(<?= $book->getBook_id() ?>, 1, <?= $book->getBook_price() ?>)">
                                                    <i class="fa fa-plus" style="color:#eab92d"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="align-middle border-bottom-0">
                                            <p id="subtotal<?= $book->getBook_id() ?>" class="mb-0" style="font-weight: 500;">$<?= number_format($quantity * $book->getBook_price(), 2) ?></p>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-4 col-xl-3" style="max-width: 95%; flex: 95%; padding-left: 50px;">
                                    <div class="d-flex justify-content-between" style="font-weight: 500; text-align: end;">
                                        <p class="mb-2">Subtotal</p>
                                        <p id="subitotalDisplay" class="mb-2">$<?= number_format($subtotal, 2) ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between" style="font-weight: 500;">
                                        <p class="mb-0">Shipping</p>
                                        <p class="mb-0">$<?= number_format($shippingCost, 2) ?></p>
                                    </div>
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                                        <p class="mb-2">Total</p>
                                        <p id="totalDisplay" name="finaltotal" class="mb-2">$<?= number_format($total, 2) ?></p>
                                    </div>
                                    <form method="post" action="checkout.php">
                                        <input type="hidden" name="subtotal" id="subtotalInput" value="<?= $subtotal ?>">
                                        <input type="hidden" name="finaltotal" id="finaltotalInput" value="<?= $total ?>">
                                        <button type="submit" name="check_out" class="btn btn-primary btn-block btn-lg" style="background-color:#eab92d;">
                                            <div class="d-flex justify-content-center">
                                                <span>Checkout</span>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}

require 'footer.html';
?>
<script>
    function updateQuantity(book_id, change, price) {
        const quantityInput = document.getElementById('quantity' + book_id);
        const currentQuantity = parseInt(quantityInput.value);
        const newQuantity = Math.max(0, currentQuantity + change);
        quantityInput.value = newQuantity;
        updateSubtotal(book_id, price);
         // Update quantityInput value
   
    }

    function updateSubtotal(book_id, price) {
        const quantityInput = document.getElementById('quantity' + book_id);
        const subtotalElement = document.getElementById('subtotal' + book_id);

        const quantity = parseInt(quantityInput.value);
        const subtotal = (quantity * price).toFixed(2);

        subtotalElement.textContent = '$' + subtotal;

        // Update the total based on all subtotals
        updateTotal();
    }

    function updateTotal() {
        const subtotalInputs = document.querySelectorAll('[id^="subtotal"]');
        const shippingCost = 2.99;

        let subtotal = 0;

        subtotalInputs.forEach(subtotalInput => {
            subtotal += parseFloat(subtotalInput.textContent.replace('$', '')) || 0; // Use 0 if NaN
        });

        const total = subtotal + shippingCost;
        document.getElementById('subtotalInput').value = subtotal.toFixed(2);
        document.getElementById('finaltotalInput').value = total.toFixed(2);

        document.getElementById('subitotalDisplay').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2);
    }

    updateTotal();
</script>
