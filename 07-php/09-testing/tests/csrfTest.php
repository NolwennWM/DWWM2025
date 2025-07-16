<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../src/csrf.php";

class csrfTest extends TestCase
{
    protected function setUp(): void
    {
        // Démarrer la session :
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        // vider la session avant chaque test :
        $_SESSION = [];
    }
    public function testSetCSRFOutputAndSession()
    {
        // Démarrer la capture de sortie (capture tout ce qui est affiché sur la page)
        ob_start();

        // lancer la fonction à tester
        setCSRF();

        // Récupère le contenu affiché sous forme de string
        $output = ob_get_clean();

        // Vérifier que la sortie contient un input hidden et un name csrf_token
        $this->assertStringContainsString("<input type='hidden'", $output);
        $this->assertStringContainsString("name='csrf_token'", $output);

        // Vérifier que la valeur est un token hexadecimal de 32 caractères.
        preg_match("/value='([a-f0-9]{32})'/", $output, $matches);
        $this->assertNotEmpty($matches, "Le token CSRF n'a pas été trouvé ou est incorect.");

        $tokenFromInput = $matches[1];

        // Vérifier que le token est bien stocké en session :
        $this->assertArrayHasKey("csrf_token", $_SESSION);
        $this->assertEquals($tokenFromInput, $_SESSION["csrf_token"]);
    }
}