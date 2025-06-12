<?php
if(session_status() === PHP_SESSION_NONE)
	session_start();

/**
 * ユーザーがログインしているかどうかを確認し、していない場合はリダイレクトします。
 * 
 * ブール値が true の場合、ユーザーがログインしているか確認します。 
 * ブール値が false の場合、ユーザーがログアウトしているか確認します。
 * 2 番目の引数は、ユーザーをどこにリダイレクトするかを示します。
 *
 * @param boolean $logged
 * @param string $redirect
 * @return void
 */
function shouldBeLogged(bool $logged = true, string $redirect = "/"): void
{
    $logged_in = $_SESSION["logged"]??$_SESSION["logged_in"]??false;

    if($logged)
    {
        if(isset($_SESSION["expire"]))
        {
            // セッションの有効期限が切れている場合、それを削除します。
            if(time()> $_SESSION["expire"])
            {
                unset($_SESSION);
                session_destroy();
                setcookie("PHPSESSID", "", time()-3600);
            }else
            {
                // そうでない場合、セッションは 1 時間延長されます。
                $_SESSION["expire"] = time() + 3600;
            }
        } // 有効期限の確認終了
        if(!$logged_in )
        {
            // ユーザーがログインしていない場合は、リダイレクトします。
            header("Location: $redirect");
            exit;
        }
    }
    else
    {
        /* 
            ページにアクセスするにはユーザーがログアウトしている必要がある場合、
            ログインしているかどうかを確認し、
            その場合はリダイレクトします。
        */
        if($logged_in)
        {
            header("Location: $redirect");
            exit;
        }
    }
}
/**
 * GET または POST で指定された ID と一致しない場合、ユーザーをリダイレクトします。
 *
 * @param string $redirect
 * @param string $index 
 * @param string $session
 * @return string
 */
function isSelectedUser(string $redirect = "/", string $index = "id", string $session = "idUser"): string
{
    $selectedId = $_GET[$index] ?? $_POST[$index]?? false;

    if(!isset($_SESSION[$session]) || $_SESSION[$session] != $selectedId)
    {
        header("Location: ".$redirect);
        exit;
    }
    return $selectedId;
}
?>