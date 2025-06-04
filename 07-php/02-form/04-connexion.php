<?php 
if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
    // セッションの有効期限を指定しなければ、ブラウザを閉じた時点でログアウトします。
}

// もしユーザーが既にログインしている場合
if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)
{
    // 別のページにリダイレクトします
    header("Location: /");
    exit;
}

$email = $pass = "";
$error = [];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['login']))
{
    if(empty($_POST["email"]))
    {
        $error["email"] = "メールアドレスを入力してください";
    }
    else
    {
        $email = trim($_POST["email"]);
    } // メールアドレスのチェック終了

    if(empty($_POST["password"]))
    {
        $error["password"] = "パスワードを入力してください";
    }
    else
    {
        $pass = trim($_POST["password"]);
    } // パスワードのチェック終了

    if(empty($error))
    {
        /* 
            通常はここでデータベースからユーザーデータを取得しますが、
            今回はJSONファイルから取得しています。

            file_get_contents() はファイルからデータを取得する関数です。
        */
        $users = file_get_contents("../ressources/users.json");
        /* 
            json_decode はJSON形式の文字列をPHPで扱えるデータに変換します。
            デフォルトではJSONオブジェクトはPHPオブジェクトに変換されますが、
            第二引数に true を渡すと連想配列として扱えます。
        */
        $users = json_decode($users, true);
        // var_dump($users);

        // そのメールアドレスのユーザーがいるかチェック
        $user = $users[$email] ?? false;

        // ユーザーが見つかった場合
        if($user)
        {
            /* 
                データベースやJSONに保存されたパスワードはハッシュ化されています。
                ハッシュは毎回違うため、単純な「==」では比較できません。
                そのため password_verify() を使います。
                第一引数にフォームからの平文パスワード、
                第二引数に保存されたハッシュを渡します。
            */
            if(password_verify($pass, $user["password"]))
            {
                /* 
                    メールアドレスとパスワードが正しいのでユーザーはログイン状態になります。
                    セッションを使ってログイン状態をページ間で保持します。
                */
                $_SESSION["logged"] = true;
                /* 
                    またユーザー名やアバターなど
                    複数ページで使いたい情報も保存できます。
                */
                $_SESSION["username"] = $user["username"];
                /* 
                    セッションの有効期限などもここで設定可能です。
                */
                $_SESSION["expire"] = time()+3600;
                // ログイン後は別のページにリダイレクトします（例：プロフィールやトップページ）
                header("Location: /");
                exit;
            } else
            {
                $error["login"] = "メールアドレスまたはパスワードが間違っています（パスワード）";
            } // パスワードチェック終了
        }
        else
        {
            $error["login"] = "メールアドレスまたはパスワードが間違っています（メールアドレス）";
        } // メールアドレスチェック終了
    }
}

$title = "ログイン";
require("../ressources/template/_header.php");
?>
    <form action="04-connexion.php" method="post">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email">
        <span class="error"><?= $error["email"]??"" ?></span>
        <br>
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
        <span class="error"><?= $error["password"]??"" ?></span>
        <br>
        <button type="submit" name="login">ログイン</button>
        <span class="error"><?= $error["login"]??"" ?></span>
    </form>

<?php 
require("../ressources/template/_footer.php");
?>
