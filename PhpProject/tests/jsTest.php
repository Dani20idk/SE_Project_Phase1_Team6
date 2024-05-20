<?
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\PantherTestCaseTrait;

class jsTest extends TestCase
{
    use PantherTestCaseTrait;

    public function testUpdateQuantity()
    {
        $client = static::createPantherClient();
        $client->request('GET', './shoppingcart.php');

        // Simulate updating quantity
        $client->executeScript('updateQuantity(1, 1, 10.99)');
        $quantityInputValue = $client->findElement(WebDriverBy::cssSelector('input#quantity1'))->getAttribute('value');

        $this->assertEquals(1, $quantityInputValue);

        $client->executeScript('updateQuantity(1, -1, 10.99)');
        $quantityInputValue = $client->findElement(WebDriverBy::cssSelector('input#quantity1'))->getAttribute('value');

        $this->assertEquals(0, $quantityInputValue);
    }

    
    

    // public function testUpdateSubtotal()
    // {
    //     $client = static::createPantherClient();
    //     $client->request('GET', '/your-php-file.php');

    //     // Simulate updating subtotal
    //     $client->executeScript('updateSubtotal(1, 10.99)');
    //     $subtotalValue = $client->findElement(\Symfony\Component\Panther\DomCrawler\Crawler::filter('p#subtotal1'))->getText();

    //     $this->assertEquals('$10.99', $subtotalValue);
    // }

    // public function testUpdateTotal()
    // {
    //     $client = static::createPantherClient();
    //     $client->request('GET', '/your-php-file.php');

    //     // Simulate updating total
    //     $client->executeScript('updateTotal()');
    //     $totalValue = $client->findElement(\Symfony\Component\Panther\DomCrawler\Crawler::filter('p#totalDisplay'))->getText();

    //     $this->assertEquals('$13.98', $totalValue);
    // }
}
