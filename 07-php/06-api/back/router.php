<?php

try
{
    // URLを取得・フィルターし、整形
    $url = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);
    $url = explode("?", $url)[0]; // GETパラメータを削除
    $url = trim($url, "/");       // スラッシュを除去

    // URLが定義済みのルートに一致するか確認
    if (array_key_exists($url, ROUTES)) {
        // 対応するコントローラーファイルを読み込む
        $controllerPath = "./controller/" . ROUTES[$url];
        if (file_exists($controllerPath)) {
            require($controllerPath);
        } else {
            sendResponse([], 500, "コントローラーが見つかりません");
        }
    } else {
        sendResponse([], 404, "ページが見つかりません");
    }
}
catch (\Throwable $e) {
    // エラーログを error.log に出力
    handleLogs($e->getMessage(), $e->getFile(), $e->getLine());

    $error = [];
    if(APP_ENV === "dev")
    {
        $error = [
            "errorMessage"=>$e->getMessage(),
            "errorFile"=>$e->getFile(),
            "errorLine"=>$e->getLine()
        ];
    }
    sendResponse($error, 500, "サーバー内部エラー");
}
