# コース：PHPUnitによるPHPテストの自動化

---

## はじめに：ユニットテストと自動化

**ユニットテスト**は、PHPの各関数やメソッドが個別に正しく動作するかどうかを検証するためのテストです。

**テストの自動化**とは、これらのテストを自動的に実行することであり、通常はPHPUnitのようなツールを使用します。これにより、コードの品質を保ち、保守性が向上し、バグの早期発見が可能になります。

---

## なぜPHPUnitを使うのか？

- PHPUnitは最も人気のあるPHP用テストフレームワークです。
- Composerで簡単にインストールできます。
- テストを書くための明確な構文（クラス、アサーション）を提供します。
- テストの自動実行やレポート生成が可能です。
- SymfonyやLaravelなどのフレームワークにも対応しています。

---

## 1. PHPUnitのインストール

推奨される方法はComposer経由でのインストールです。

1. 開発用依存としてPHPUnitをインストールします：

    ```bash
    composer require --dev phpunit/phpunit
    ```

2. インストールを確認：

    ```bash
    ./vendor/bin/phpunit --version
    ```

3. **composer.json**にショートカットを追加（任意）：

    ```json
    {
        "scripts": {
            "test": "./vendor/bin/phpunit tests"
        }
    }
    ```

---

## 2. PHPUnitテストの基本構造

PHPUnitのテストは、`\PHPUnit\Framework\TestCase`を継承したクラスです。`test`で始まるパブリックメソッドがテストとして認識されます。

`tests/MathTest.php`のシンプルな例：

```php
<?php
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    public function testAdd()
    {
        $result = 2 + 3;
        $this->assertEquals(5, $result);
    }
}
?>
```

---

## 3. テストの実行

`tests/`ディレクトリ内のすべてのテストを実行するには：

```bash
./vendor/bin/phpunit tests
# またはショートカットを使って：
composer test
```

PHPUnitは、成功・失敗・スキップされたテストのサマリーを表示します。

---

## 4. 実際のクラスをテストする例

`src/`ディレクトリの`Calculator.php`クラスを想定します：

```php
<?php
class Calculator
{
    public function add($a, $b)
    {
        return $a + $b;
    }

    public function divide($a, $b)
    {
        if ($b === 0) {
            throw new InvalidArgumentException("0による除算");
        }
        return $a / $b;
    }
}
?>
```

テストファイル `tests/CalculatorTest.php`：

```php
<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Calculator.php';

class CalculatorTest extends TestCase
{
    private $calculator;

    protected function setUp(): void
    {
        // 各テスト前にインスタンスを作成
        $this->calculator = new Calculator();
    }

    public function testAdd()
    {
        $this->assertEquals(7, $this->calculator->add(3, 4));
    }

    public function testDivide()
    {
        $this->assertEquals(2, $this->calculator->divide(6, 3));
    }

    public function testDivideByZero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->divide(5, 0);
    }
}
?>
```

---

## 5. HTMLと連携する関数の例

---

### `csrf.php`（テスト対象の関数）

```php
<?php
session_start();

/**
 * CSRFトークンを生成し、セッションに保存してhidden入力として出力する
 */
function setCSRF(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // ランダムトークン生成
    $token = bin2hex(random_bytes(16));
    $_SESSION['csrf_token'] = $token;

    // hidden inputとして出力
    echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
}
?>
```

---

#### `CSRFTest.php`（PHPUnitテスト）

```php
<?php
use PHPUnit\Framework\TestCase;

// テスト対象関数を読み込み
require_once 'csrf.php';

class CSRFTest extends TestCase
{
    protected function setUp(): void
    {
        // 各テストでセッションを開始
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // セッションをリセット
        $_SESSION = [];
    }

    public function testSetCSRFOutputAndSession()
    {
        // 出力バッファを開始
        ob_start();

        // 関数を呼び出して出力とセッションを確認
        setCSRF();

        // 出力を取得
        $output = ob_get_clean();

        // hidden inputが含まれているか確認
        $this->assertStringContainsString('<input type="hidden"', $output);
        $this->assertStringContainsString('name="csrf_token"', $output);

        // トークンの値が16バイト（32文字）の16進数であることを確認
        preg_match('/value="([a-f0-9]{32})"/', $output, $matches);
        $this->assertNotEmpty($matches, "CSRFトークンが見つからないか形式が不正です。");

        $tokenFromInput = $matches[1];

        // セッションに保存されたトークンと一致するか確認
        $this->assertArrayHasKey('csrf_token', $_SESSION);
        $this->assertEquals($tokenFromInput, $_SESSION['csrf_token']);
    }
}
?>
```

---

### 解説

- `setCSRF()`関数は、セッションが未開始の場合に開始します。
- トークンを生成して`$_SESSION['csrf_token']`に保存します。
- トークンを含むHTMLのinputタグを出力します。
- テストでは、出力をキャプチャしてHTML内容を検証します。
- セッションを毎回初期化して状態の干渉を防ぎます。
- HTMLのトークンとセッションのトークンが一致するか検証します。

---

## 6. よく使うアサーション一覧

| メソッド                                | 説明                             |
|-----------------------------------------|----------------------------------|
| `assertEquals(\$expected, \$actual)`    | 値が等しいか確認                 |
| `assertTrue(\$condition)`               | 条件がtrueか確認                 |
| `assertFalse(\$condition)`              | 条件がfalseか確認                |
| `assertNull(\$variable)`                | nullかどうか確認                 |
| `assertInstanceOf(\$class, \$object)`   | 指定クラスのインスタンスか確認   |
| `expectException(\$exceptionClass)`     | 例外がスローされることを期待     |

---

## 7. テストの構成とベストプラクティス

- プロジェクトルートに`tests/`ディレクトリを用意。
- ソースコードの構造に合わせてサブディレクトリを分ける。
- `setUp()`と`tearDown()`で各テスト前後の準備・後処理を記述。
- テストメソッドは`test`で始める。

---

## 8. CIとの連携とレポート出力

- PHPUnitはXML形式のレポート出力に対応（Jenkins、GitHub Actions等）。
- CIツールと連携することで、コード変更ごとに自動テストを実行可能。
- `--coverage`オプションでカバレッジ（網羅率）を取得可能。

---

## 9. 参考リンク

- [PHPUnit公式サイト](https://phpunit.de/)
- [SymfonyのPHPUnitガイド](https://symfony.com/doc/current/testing.html)
- [Composer](https://getcomposer.org/)
- [PHPUnit XML設定例](https://phpunit.readthedocs.io/en/9.5/configuration.html)

---

> PHPUnitを活用することで、PHPプロジェクトの信頼性を高め、リファクタリングや機能追加を安心して行えるようになります。
