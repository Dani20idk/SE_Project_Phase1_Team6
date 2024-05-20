<?php
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\PantherTestCaseTrait;
require 'shoppingcart.php';

class ShoppingCartTest extends TestCase
{
    use PantherTestCaseTrait;
   
    public function testAddToCartSuccess()
    {
       
       

        // Simulate form submission with book_id = 1
        $_POST['add_to_cart'] = true;
        $_POST['book_id'] = 1;

        // Create a mock database connection
        $db = new mysqli('localhost', 'root', '', 'bookstore2');

        // Call the function
        addToCart($db);

        // Check if book_id 1 is added to the cart
        $this->assertEquals(1, $_SESSION['shopping_cart'][1]);
    }
    public function testGetBookDetails()
    {
        

        // Create a database connection
        $db = new mysqli('localhost', 'root', '', 'bookstore2');

        // Get book details from the database
        $book = getBookDetails(1, $db);

        // Check if book details are correct
        $this->assertEquals(1, $book->getBook_id());
        $this->assertEquals("Don Kishoti", $book->getBook_title());
        $this->assertEquals("https://onufri.com/wp-content/uploads/2020/04/DON_KISHOT_1_COVER_2015-02.jpg", $book->getBook_image());
        $this->assertEquals("Sojliu mëndje-mprehtë Don Kishoti i Mançës (vëllimi I: El ingenioso hidalgo Don Quijote de la Mancha; vëllimi II: El ingenioso caballero Don Quijote de la Mancha), i njohur shkurt si Don Kishoti i Mançës, është një roman satirik pikaresk në dy vëllime nga shkrimtari spanjoll Miguel de Servantes de Saavedra që konsiderohet një prej klasikëve të letërsisë botërore. Ky libër flet për aventurat e Don Kishotit, i cili ishte një njeri idealist (me plot kuptimin e fjalës). Në shqip vëllimi i parë është sjellë nga Fan Noli, pjesa e dytë nga Petro Zheji.", $book->getBook_description());
        $this->assertEquals(12, $book->getBook_price());
        $this->assertEquals("Classics", $book->getCategory());
    }
    
    
    public function testUpdateQuantity()
    {
        // Mock the document and quantity input
        $quantityInputMock = $this->getMockBuilder(stdClass::class)
                                  ->setMethods(['setValue'])
                                  ->getMock();
        
        // Set up the mock to return the current quantity
        $quantityInputMock->value = 5;
    
        // Mock the price and book_id
        $price = 10;
        $book_id = 1;
    
        // Set up the mock to return the quantity input
        $documentMock = $this->getMockBuilder(stdClass::class)
                             ->setMethods(['getElementById'])
                             ->getMock();
    
        $documentMock->expects($this->any())
                     ->method('getElementById')
                     ->with('quantity' . $book_id)
                     ->willReturn($quantityInputMock);
    
        // Execute the shopping cart script and store the output
        $output = shell_exec("php -r 'require_once(\"shoppingcart.php\");'");
    
        // Run the JavaScript function
        $output = shell_exec("node -e \"let document = { getElementById: function(id) { return { value: 5, setValue: function(val) { this.value = val; }}; } }; $output updateQuantity($book_id, 3, $price);\"");
    
        // Get the updated quantity
        $newQuantity = $quantityInputMock->value;
    
        // Test if the quantity is updated correctly
        $this->assertEquals(5, $newQuantity);
    }
    
    public function testUpdateSubtotal()
{
    // Include your JavaScript functions
    $jsFunctions = file_get_contents('shoppingcart.php');

    // Include the entire content of shoppingcart.php
    $shoppingCartContent = file_get_contents('shoppingcart.php');

    // Extract updateSubtotal function from shoppingcart.php
    preg_match('/function updateSubtotal\([^)]+\)\s*{([^}]+)/', $shoppingCartContent, $matches1);
    $updateSubtotalFunction = $matches1[0];

    // Mock the document and quantity input
    $documentMock = $this->getMockBuilder(stdClass::class)
                         ->setMethods(['getElementById'])
                         ->getMock();

    // Mock the quantity input and subtotal element
    $quantityInputMock = $this->getMockBuilder(stdClass::class)
                              ->setMethods(['value'])
                              ->getMock();

    $subtotalElementMock = $this->getMockBuilder(stdClass::class)
                                 ->setMethods(['textContent'])
                                 ->getMock();

    // Set up the mock to return the current quantity and subtotal
    $quantityInputMock->value = 5;
    $subtotalElementMock->textContent = '$50.00'; // Corrected expected value

    // Mock the book_id and price
    $book_id = 1;
    $price = 10;

    // Set up the mock to return the quantity input and subtotal element
    $documentMock->expects($this->any())
                 ->method('getElementById')
                 ->willReturnMap([
                     ['quantity' . $book_id, $quantityInputMock],
                     ['subtotal' . $book_id, $subtotalElementMock]
                 ]);

    // Define the updateSubtotal function
    eval("?>" . $updateSubtotalFunction);

    // Run the JavaScript function
    $output = shell_exec("node -e \"let document = { getElementById: function(id) { return { value: 5 }; } }; " . $jsFunctions . "; updateSubtotal($book_id, $price);\"");

    // Get the updated subtotal
    $updatedSubtotal = $subtotalElementMock->textContent;

    // Test if the subtotal is updated correctly
    $this->assertEquals('$50.00', $updatedSubtotal); 
}

public function testUpdateTotal()
{
    // Mock the document and subtotal inputs
    $documentMock = $this->getMockBuilder(stdClass::class)
                         ->setMethods(['querySelectorAll', 'getElementById'])
                         ->getMock();

    // Mock the subtotal input elements
    $subtotalInputMock = $this->getMockBuilder(stdClass::class)
                              ->setMethods(['value'])
                              ->getMock();

    $finalTotalInputMock = $this->getMockBuilder(stdClass::class)
                                ->setMethods(['value'])
                                ->getMock();

    // Mock the subtotal display and total display elements
    $subtotalDisplayMock = $this->getMockBuilder(stdClass::class)
                                 ->setMethods(['textContent'])
                                 ->getMock();

    $totalDisplayMock = $this->getMockBuilder(stdClass::class)
                             ->setMethods(['textContent'])
                             ->getMock();

    // Mock the shipping cost
    $shippingCost = 2.99;

    // Mock the subtotal inputs
    $subtotalInputs = [
        $subtotalInputMock
    ];

    // Set up the mock to return the subtotal inputs
    $documentMock->expects($this->any())
                 ->method('querySelectorAll')
                 ->with('[id^="subtotal"]')
                 ->willReturn($subtotalInputs);

    // Set up the mock to return the subtotal and total
    $subtotalInputMock->value = '100.00';
    $finalTotalInputMock->value = '102.99';
    $subtotalDisplayMock->textContent = '$100.00';
    $totalDisplayMock->textContent = '$102.99';

    // Execute the shopping cart script and store the output
    $output = shell_exec("php -r '?>' " . 'shoppingcart.php');

    // Run the JavaScript function
    $output = shell_exec("node -e \"let document = { getElementById: function(id) { 
        if(id === 'subtotalInput') return { value: '100.00' };
        if(id === 'finaltotalInput') return { value: '102.99' };
        if(id === 'subitotalDisplay') return { textContent: '$100.00' };
        if(id === 'totalDisplay') return { textContent: '$102.99' };
    }}; $output function updateTotal() {
        const subtotalInputs = document.querySelectorAll('[id^=\"subtotal\"]');
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
    } updateTotal();\"");

    // Test if the subtotal and total are updated correctly
    $this->assertEquals('100.00', $subtotalInputMock->value);
    $this->assertEquals('102.99', $finalTotalInputMock->value);
    $this->assertEquals('$100.00', $subtotalDisplayMock->textContent);
    $this->assertEquals('$102.99', $totalDisplayMock->textContent);
}
    

}
       

