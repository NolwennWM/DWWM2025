<?php 
# --- ヘッダー ---

// APIへのアクセスを許可する。"*" は任意のサイトを意味する。
header("Access-Control-Allow-Origin: *");
// ? 特定のサイト以外からのアクセスを拒否することも可能：
// header("Access-Control-Allow-Origin: https://mon-app-front.com");

// APIのレスポンスがJSON形式であることを示す。
header("Content-Type: application/json; charset=UTF-8");

// CORSプリフライトリクエストのキャッシュ時間（秒）
header("Access-Control-Max-Age: 3600");
/* 
    ? ブラウザがAPIにリクエストを送るとき、まず "OPTIONS" メソッドでプリフライトリクエストを送信する。
    これは、リクエスト元サイトにAPIへのアクセス権限があるか確認するため。
    このヘッダーは、その結果をキャッシュするために使用される。
*/

// クッキーや認証情報の送信を許可する。
header("Access-Control-Allow-Credentials: true");

// クライアントリクエストで許可されるヘッダーを指定する。
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
/* 
    - Content-Type：JSON（または他のタイプ）を送信できるようにする
    - Authorization：JWTやBearerトークンなどの送信を許可
    - X-Requested-With：AJAXがJavaScriptリクエストであることを示すためによく使われる
*/

# --- 関数 ---

// PHPエラーを処理するカスタム関数を定義する。
set_error_handler("handleErrors");
/**
 * JSON形式の標準レスポンスを送信し、スクリプトの実行を停止する
 *
 * @param array $data 返すデータ
 * @param integer $status HTTPステータスコード
 * @param string $message メッセージ
 * @return void
 */
function sendResponse(array $data, int $status, string $message): void
{
    http_response_code($status);
    echo json_encode([
        "data"=>$data,
        "status"=>$status,
        "message"=>$message
    ]);
    exit;
}

/**
 * エラーをバリデーション違反リストに追加、または全体を返す
 *
 * @param boolean|string $property 該当するフィールド名
 * @param boolean|string $message エラーメッセージ
 * @return array|void 引数が不足している場合はエラー一覧を返す
 */
function setError($property = false, $message = false)
{
    static $error = [];
    // 引数が不足している場合、エラー配列を返す
    if(!$property || !$message)
    {
        return ["violations"=>$error];
    }
    // 両方の引数がある場合、エラーを配列に追加する
    $error[]=[
        "propertyPath"=>$property,
        "message"=>$message
    ];
}

/**
 * PHPエラーを例外に変換して処理する
 *
 * @param integer $severity エラーの重大度
 * @param string $message エラーメッセージ
 * @param string $file エラーが発生したファイル
 * @param integer $line エラーが発生した行
 * @return void
 * @throws ErrorException
 */
function handleErrors(int $severity, string $message, string $file, int $line)
{
    throw new ErrorException($message, 0, $severity, $file, $line);
}

/**
 * エラーメッセージをログファイルに書き込む
 *
 * @param string $errorMessage エラーメッセージ
 * @param string $errorFile エラーが検出されたファイル
 * @param string $errorLine エラーが発生した行
 * @return void
 */
function handleLogs(string $errorMessage, string $errorFile, string $errorLine)
{
    $logDir = __DIR__."/logs"; // ログフォルダのパス
    $logFile = $logDir . "/error.log"; // エラー保存用のファイル
    $date = date("Y-m-d H:i:s"); // エラー発生時の日時
    $message = "$date - Error API : $errorMessage - Error File : $errorFile - ErrorLine : $errorLine\n"; // 保存するメッセージ

    if(!is_dir($logDir))
    {
        mkdir($logDir, 0755, true); // フォルダが存在しない場合は作成する
    }
    error_log($message, 3, $logFile); // ログファイルに書き込む
    // ? "3" は、3番目の引数（ログファイル）に出力することを意味する
}

/* 
    mkdir関数はフォルダを作成する。
    第1引数：作成するディレクトリのパス
    第2引数：アクセス権（8進数表記）
        - 0：次の数字が8進数であることを示す
        - 7：オーナーがすべての権限を持つ
        - 5：グループが読み取りと実行のみ可能
        - 5：その他ユーザーも読み取りと実行のみ可能

    第3引数：再帰的にディレクトリを作成するかどうか
        - false：例「fruits/banana」を作成しようとすると、fruitsが存在しないためエラー
        - true：fruitsとbananaの両方を自動的に作成する
*/
