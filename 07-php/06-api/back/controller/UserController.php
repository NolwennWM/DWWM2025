<?php 
// このページで許可されているメソッドを示す：
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");

session_start();
require __DIR__."/../model/userModel.php";
require __DIR__."/../../../ressources/service/_csrf.php";

$regexPass = "/^(?=.*[!?@#$%^&*+-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/";

/* 
    REST API（REpresentational State Transfer）の原則は、
    同じアドレス（ここでは /06-api/back/user）で
    使用されるHTTPメソッドに応じて異なる操作を行うことです：
*/
switch($_SERVER["REQUEST_METHOD"])
{
    case "POST": create(); break;
    case "GET": read(); break;
    case "PUT": update(); break;
    case "DELETE": delete(); break;
}

/**
 * 登録ページを処理する。
 *
 * @return void
 */
function create():void
{
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $username = $email = $password = "";
    $error = setError();
    if($data && isset($data->userForm))
    {
        // ユーザー名の処理
        if(empty($data->username)){
            setError("username", "ユーザー名を入力してください");
        }else{
            $username = cleanData($data->username);
            if(!preg_match("/^[a-zA-Z' -]{2,25}$/", $username)){
                setError("username", "有効なユーザー名を入力してください");
            }
        }
        // メールアドレスの処理
        if(empty($data->email))
        {
            setError("email", "メールアドレスを入力してください");
        }
        else
        {
            $email = cleanData($data->email);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                setError("email", "有効なメールアドレスを入力してください");
            }
            // データベースにユーザーが存在するか確認する
            $resultat = getOneUserByEmail($email);
            if($resultat)
            {
                setError("email", "このメールアドレスは既に登録されています。");
            }
        }
        // パスワードの処理
        if(empty($data->password))
        {
            setError("password", "パスワードを入力してください");
        }
        else
        {
            $password = cleanData($data->password);
            // 上で定義した正規表現を使用
            global $regexPass;
            if(!preg_match($regexPass, $password))
            {
                setError("password", "有効なパスワードを入力してください");
            }
            else
            {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
        }
        // パスワードの再入力確認
        if(empty($data->passwordBis))
        {
            setError("passwordBis", "もう一度パスワードを入力してください");
        }
        elseif($data->password != $data->passwordBis)
		{
			setError("passwordBis", "同じパスワードを入力してください");
		}
        $error = setError();
        // データの送信
        if(empty($error["violations"]))
        {
            // データベースにユーザーを追加する
            $user = addUser($username, $email, $password);
            sendResponse($user, 200, "登録が完了しました");
        }
    }
    sendResponse($error, 400, "フォームが正しくありません");
}
/**
 * ユーザー一覧を処理する
 *
 * @return void
 */
function read():void
{
    // すべてのユーザーを取得する
    if(isset($_GET["id"]))
        $users = getOneUserById((int)$_GET["id"]);
    else
        $users = getAllUsers();
    sendResponse($users, 200, "ユーザーを取得しました");
}
/**
 * ユーザーの更新ページを処理する。
 *
 * @return void
 */
function update():void
{
    if(!isset($_GET["id"],$_SESSION["idUser"]) || $_SESSION["idUser"] != $_GET["id"])
    {
        sendResponse(setError(), 400, "アクセスが禁止されています！");
    }
    // ユーザー情報を取得する
    $user = getOneUserById((int)$_GET["id"]);

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $username = $password = $email = "";
    $error = setError();

    if($data && isset($data->userForm))
    {
		// ユーザー名の処理
        if(!empty($data->username))
        {
            $username= cleanData($data->username);
            if(!preg_match("/^[a-zA-Z' -]{2,25}$/", $username))
            {
                setError("username", "ユーザー名は英字のみ使用できます。");
            }
        }
        else
        {
            $username = $user["username"];
        }
		// メールアドレスの処理
        if(!empty($data->email))
        {
            $email= cleanData($data->email);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                setError("email","有効なメールアドレスを入力してください");
            }
            elseif($email != $user["email"])
            {
                $exist = getOneUserByEmail($email);
                if($exist)
                {
                    setError("email","このメールアドレスは既に存在します");
                }
            }
        }
        else
        {
            $email = $user["email"];
        }
		// パスワードの処理
        if(!empty($data->password))
        {
            if(empty($data->passwordBis))
            {
                setError("passwordBis","もう一度パスワードを入力してください");
            }
            elseif($data->password != $data->passwordBis)
            {
                setError("passwordBis","同じパスワードを入力してください");
            }
            $password = cleanData($data->password);
            global $regexPass;
            if(!preg_match($regexPass, $password))
            {
                setError("password","有効なパスワードを入力してください");
            }
            else
            {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
        }
        else
        {
            $password = $user["password"];
        }
        $error = setError();
        if(empty($error["violations"]))
        {
            // ユーザーの更新
            $user = updateUserById($username, $email, $password, $user["idUser"]);
            
            sendResponse($user, 200, "ユーザーが更新されました");
        }
    }
    
    sendResponse($error, 400, "フォームが正しくありません");

}
/**
 * ユーザーの削除ページを処理する。
 *
 * @return void
 */
function delete():void
{
    if(!isset($_GET["id"], $_SESSION["idUser"]) || $_SESSION["idUser"] != $_GET["id"])
    {
        sendResponse($_SESSION, 400, "アクセスが禁止されています！");
    }
    // ユーザーを削除する
    deleteUserById((int)$_GET["id"]);
    // そしてログアウトする
    unset($_SESSION);
    session_destroy();
    setcookie("PHPSESSID","", time()-3600);
        
    sendResponse([], 200, "アカウントが削除されログアウトしました");
}