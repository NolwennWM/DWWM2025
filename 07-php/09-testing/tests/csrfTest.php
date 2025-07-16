<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../src/csrf.php";

class csrfTest extends TestCase
{
    protected function setUp(): void
    {
        // セッションを開始する：
        if (session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        // 各テストの前にセッションを初期化する：
        $_SESSION = [];
    }

    public function testSetCSRFOutputAndSession()
    {
        // 出力バッファリングを開始（echoされた内容をキャプチャする）
        ob_start();

        // テスト対象の関数を呼び出す
        setCSRF();

        // 出力内容を文字列として取得する
        $output = ob_get_clean();

        // 出力にhiddenのinputとnameがcsrf_tokenであることを確認する
        $this->assertStringContainsString("<input type='hidden'", $output);
        $this->assertStringContainsString("name='csrf_token'", $output);

        // 値が32文字の16進数トークンであることを確認する
        preg_match("/value='([a-f0-9]{32})'/", $output, $matches);
        $this->assertNotEmpty($matches, "CSRFトークンが見つからない、または不正です。");

        $tokenFromInput = $matches[1];

        // トークンがセッションに正しく保存されていることを確認する
        $this->assertArrayHasKey("csrf_token", $_SESSION);
        $this->assertEquals($tokenFromInput, $_SESSION["csrf_token"]);
    }
}
