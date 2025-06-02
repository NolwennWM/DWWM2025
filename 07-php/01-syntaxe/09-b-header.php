<?php 
/* 
    "refresh:" を使うと、数秒後にページを再読み込みできます。
    さらに "url=" を加え、セミコロン ";" で区切ると、
    数秒後に指定したページへリダイレクトすることができます。
*/
header("refresh:5; url=09-a-header.php");
/* 2番目のパラメータには、デフォルトで true のブール値を指定できます。
この値は、ヘッダーが以前のものを置き換えるか、追加するかを決定します。

3番目のパラメータでは、ページのステータスコードを設定できます。
ただし、これは1番目の引数が空でない場合にのみ有効です。 */
$title = " header page 2";
require("../ressources/template/_header.php");
?>
<h1>ページ2へようこそ… これは一時的です。</h1>
<?php
require("../ressources/template/_footer.php");
?>
