<?php 
require "../ressources/service/_csrf.php";

$title = "Security";
require "../ressources/template/_header.php";
/* 
    Web開発者として、私たちは以下のような一般的な攻撃からサイトを保護する必要があります：
        - XSS（JSスクリプトやHTML、CSSをページに直接挿入する攻撃）
        - CSRF（第三者のフォームから自サイトのフォームへリクエストを送る攻撃）
        - ブルートフォース（複数のログイン試行を繰り返す攻撃）
        - SQLインジェクション（ユーザー入力を通じてSQLクエリを送信する攻撃）
        - スパムボット（連絡フォームや登録フォームから大量のメールを送信する攻撃）

    ------------------ XSS ------------------
    XSS（クロスサイトスクリプティング）
    もしユーザー入力を保護しなければ、任意のHTML、CSS、JSをフォームに注入されてしまいます。
    自分たちを守るために、表示用のデータをデータベース保存前または表示時に以下でフィルタリングします：
        - htmlspecialchars()
        または
        - htmlentities()
*/
$XSS_attack = "<script>document.querySelector('header').style.backgroundColor = 'chartreuse';</script>";
// セキュリティ上安全でない例：
echo $XSS_attack;
// セキュリティ上安全な例：
echo htmlspecialchars($XSS_attack), "<br>";
echo htmlentities($XSS_attack), "<br>";
// これらの関数は "<" のような特定の文字をHTMLエンティティ "&gt;" に置き換えます

/* 
    ----------------------------CSRF---------------------------
    クロスサイトリクエストフォージェリ（CSRF）
    他のサイトやフォームでリクエストを作成します。
    しかし、そのサイトに留まらずリクエストを別のサイトへ送信します。
    例えば、「あなたの好きな果物」の簡単なアンケートフォームが隠れた不可視のフィールドを持ち、
    送信時に、あなたがのみアクセス可能なフォームへリクエストを送るようにします。

    これを防ぐため、セッションに保存したランダムなトークン（英数字の並び）を生成し、
    フォームの隠しフィールドに含めます。
    送信時に、このトークンがセッションのものと一致するか検証します。
    第三者のフォームはトークンを持っていません。
    （_csrf.php ファイルを参照）

    -------------------- ブルートフォース --------------
    ブルートフォース攻撃とは、全ての可能な識別子（メールアドレス/パスワード）を
    試して有効なものを見つけることです。
    手動では非常に遅いですが、ボットは1秒間に数千回試行できます。
    防ぐための可能な対策：
        - 複雑なパスワードの強制（最低8〜12文字、小文字・大文字・数字・特殊文字を含む）
        - 一定回数の失敗後にアカウントアクセスをブロック（一定期間かメール確認まで）
        - 試行間に待機時間を設ける（1〜2秒でも有効）

    -------------------------- SQLインジェクション ---------------------
    これはフォームを通じてSQLコマンドを送り実行させる攻撃です。
    データの取得、削除、変更などに利用されます。

    防ぐために、ユーザーデータを直接SQLクエリに埋め込まないでください：
    $user_message = "(DELETE FROM users;)";
    ! やってはいけない例：
    $sql = "INSERT INTO messages (content) VALUES ($user_message)";
    ! これにより以下のようなクエリになります：
    "INSERT INTO messages (content) VALUES ((DELETE FROM users;))";

    ? 正しい対処法はプリペアドステートメントを使うことです：
    詳細は後で説明しますが、簡単に言うと、
    ユーザーデータ無しでSQLを読むための関数を使い：
        prepare("INSERT INTO messages (content) VALUES (?)")
    次にデータを送る関数を使います：
        values($user_message)
    ユーザーの入力が何であっても、データベースはそれをテキストとして扱います。

    ------------------- スパムボット -------------------------
    ログイン不要でアクセス可能なフォーム（お問い合わせフォーム、登録フォーム、稀にログインフォーム）はボットに狙われやすいです。
    保護が無いと、何百通ものメールが送信される可能性があります。

    - 最も一般的な保護はCAPTCHA（完全自動化された公開チューリングテスト、コンピュータと人間を区別するテスト）を使うことです
    - もう一つはハニーポット（罠）を使うことです。隠しフィールド（CSSで不可視だがinput type=hiddenではない）を設けて、
      人間は記入しないがボットは記入してしまうため、それで判別できます。

    --------------------------- ハッシュ化 -------------------

    セキュリティ上の欠陥ではありませんが重要な点：データベースに保存するパスワードはすべてハッシュ化しなければなりません。
    管理者やハッカーがDBにアクセスしてもすぐにパスワードがわかってはいけません。
    「暗号化」ではなく「ハッシュ化」と呼ぶのは、暗号化テキストは復号できるが、
    ハッシュは逆算できないためです。
    ? ボーナス：
        - 個人情報を含むフォームはPOSTを使うことを確実にする
        - ログイン必須のページはログイン無しでアクセス不可にする

    セキュアなフォームの簡単な例：
*/
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['password']))
{
    if(!isCSRFValid())
    {
        $error = "使用されたメソッドは許可されていません！";
    }
    if(!isset($_POST["captcha"], $_SESSION['captchaStr']) || $_POST["captcha"] !== $_SESSION['captchaStr'])
    {
        $error = "キャプチャが正しくありません！";
    }
    if(empty($_POST["password"]))
    {
        $error = "パスワードを入力してください";
    }
    else
    {
        $password = trim($_POST["password"]);
        /* 
            password_hashは第一引数のパスワードをハッシュ化し、
            第二引数で指定されたアルゴリズムを使用します。
            このアルゴリズムはPHPの定数で表され、以下から選びます：
                PASSWORD_BCRYPT
                PASSWORD_ARGON2I
                PASSWORD_ARGON2ID
                （PASSWORD_DEFAULTはPHPが最も安全なものを選びます）
            第三引数はオプションでアルゴリズムの設定を変更できます。
        */
        $password = password_hash($password, PASSWORD_DEFAULT);
    }
}
?>
<hr>
<form action="06-security.php" method="POST">
    <label for="password">パスワードをハッシュ化する：</label>
    <input type="password" name="password" id="password">
    <!-- キャプチャ追加 -->
    <div>
        <label for="captcha">以下の文字を再入力してください：</label>
        <br>
        <img src="../ressources/service/_captcha.php" alt="captcha">
        <br>
        <input type="text" name="captcha" id="captcha" pattern="[A-Z0-9]{6}">
    </div>
    <!-- キャプチャ終了 -->
    <!-- CSRF -->
        <?php setCSRF(); ?>
    <!-- CSRF終了 -->
    <br>
    <input type="submit" value="送信">
    <span class="error"><?= $error??"" ?></span>
</form>

<?php 
if(empty($error) && !empty($password))
{
    // これは例ですが、誰かのパスワードをこのように表示してはいけません
    echo "<p>あなたのハッシュ化されたパスワードは : $password</p>";
}
require "../ressources/template/_footer.php";
?>
