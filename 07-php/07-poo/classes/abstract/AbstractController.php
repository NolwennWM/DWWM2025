<?php
// オートローダーの動作のために、フォルダに対応する名前空間を指定します
namespace Classes\Abstract;

require __DIR__."/../../../ressources/service/_shouldBeLogged.php";
require __DIR__."/../../../ressources/service/_csrf.php";
/** 
 *    抽象クラスはインスタンス化できません。
 *    このクラスの役割は、すべてのコントローラに継承されて共通機能を提供することです。
*/
abstract class AbstractController
{
    /**
     * フラッシュメッセージを表示します
     *
     * @return void
     */
    protected function getFlash():void
    {
        if(isset($_SESSION["flash"]))
        {
            echo "<div class='flash'>{$_SESSION['flash']}</div>";
            unset($_SESSION["flash"]);
        }
    }

    /**
     * フラッシュメッセージを登録します。
     *
     * @param string $message
     * @return void
     */
    protected function setFlash(string $message): void
    {
        $_SESSION["flash"] = $message;
    }

    /**
     * 指定されたビューを表示します。
     * 
     * オプションとして、ビューに渡す連想配列の変数を受け取ることができます。
     *
     * @param string $view "view"フォルダからのビューのパス
     * @param array $variables ビューに送るデータ
     * @return void
     */
    protected function render(string $view, array $variables = []):void
    {
        foreach($variables as $name => $value)
        {
            /* 
                例：
                ["users"=>$users] という配列を送ると、
                ここでは $users という変数が生成され、ユーザーのリストが代入されます。
                $$ を使うことで動的に変数名を作成できます。
            */
            $$name = $value;
        }
        // この関数は、ビューの前後に自動的にヘッダーとフッターを挿入します。
        require __DIR__."/../../../ressources/template/_header.php";
        require __DIR__."/../../view/$view";
        require __DIR__."/../../../ressources/template/_footer.php";
    }

    /**
     * ユーザーがページにアクセスできるかどうかを、ログイン状態に応じて確認します。
     * 
     * ブール値が true の場合、未ログインユーザーのアクセスをブロックします。
     * ブール値が false の場合、ログイン済みユーザーのアクセスをブロックします。
     *
     * @param boolean $bool ログインしているべきかどうか
     * @param string $redirect リダイレクト先のパス
     * @return void
     */
    protected function shouldBeLogged(bool $bool = true, string $redirect = "/"):void
    {
        shouldBeLogged($bool, $redirect);
    }

    /**
     * セッショントークンを設定し、CSRF用のhidden inputを追加します。
     * 
     * 任意でトークンの有効期限を設定できます。
     *
     * @param integer $time トークンの有効時間（秒）
     * @return void
     */
    protected function setCSRF(int $time = 0): void
    {
        setCSRF($time);
    }

    /**
     * CSRFトークンが有効かどうかを確認します。
     *
     * @return boolean 有効なら true
     */
    protected function isCSRFValid():bool
    {
        return isCSRFValid();
    }
}
