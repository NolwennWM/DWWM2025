<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../src/csrf.php";

class csrfTest extends TestCase
{
    protected function setUp(): void
    {
        // Start the session:
        if (session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        // Clear the session before each test:
        $_SESSION = [];
    }

    public function testSetCSRFOutputAndSession()
    {
        // Start output buffering (captures everything echoed)
        ob_start();

        // Call the function to be tested
        setCSRF();

        // Get the output as a string
        $output = ob_get_clean();

        // Check that the output contains a hidden input and a name csrf_token
        $this->assertStringContainsString("<input type='hidden'", $output);
        $this->assertStringContainsString("name='csrf_token'", $output);

        // Check that the value is a 32-character hexadecimal token
        preg_match("/value='([a-f0-9]{32})'/", $output, $matches);
        $this->assertNotEmpty($matches, "The CSRF token was not found or is incorrect.");

        $tokenFromInput = $matches[1];

        // Check that the token is correctly stored in the session
        $this->assertArrayHasKey("csrf_token", $_SESSION);
        $this->assertEquals($tokenFromInput, $_SESSION["csrf_token"]);
    }
}
