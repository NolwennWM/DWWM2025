<?php 
/*
    ヘッダーはリクエストの先頭部分で、ブラウザによって読み取られます。
    通常、HTMLを出力する前に header() 関数を呼び出す必要があります。
    ヘッダーを使用することで、さまざまなアクションを実行できます。
*/
/* "HTTP/" を使用すると、送信されるステータスコードを変更できます。
たとえば、ここではページを404エラーにしています。*/
header("HTTP/1.1 404 Not Found");
// http_response_code を使うと現在のステータスコードを取得できます。
echo http_response_code();
/* "Location:" を使うとリダイレクトが発生し、
ステータスコードは302に変更され、指定されたページへ移動します。
（リンクは相対パスでも絶対パスでも構いません）*/ 
if(rand(0, 100)<50){
    header("Location: 09-b-header.php");
    /* exit は現在のスクリプトを終了させます。
    リダイレクト後に使用することで、サーバーが無駄な処理をしないようにします。 */
    exit;
    /* 
    exit はデバッグ時にも便利で、スクリプトを強制終了させて
    問題が発生している箇所を特定できます。
    メッセージを表示させることも可能です:
    exit("ここで停止します！");

    また、exit の別名として die も使用できます。
    */
}
// header("Location: 09-b-header.php");
$title = " header page 1";
require("../ressources/template/_header.php");
?>
<h1>あなたは運が良い、私を見ることができました。</h1>
<?php
require("../ressources/template/_footer.php");
?>
