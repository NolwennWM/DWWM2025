<?php
/**
 * ルートを取得し、対応するクラスとメソッドを実行します
 */ 
class Router
{
    public static function routing()
    {
        // URL を取得し、フィルターをかけてサニタイズ（安全化）する
        $url = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);
        // クエリパラメータ（?以降）を取り除く
        $url = explode("?", $url)[0];
        // 先頭と末尾のスラッシュを削除する
        $url = trim($url, "/");

        // 定義されたルートの中にURLが存在するか確認する
        if(array_key_exists($url, ROUTES))
        {
            $route = ROUTES[$url];
            // 対応するコントローラークラスをインスタンス化
            $controller = new ($route["controller"])();
            // 対応するメソッド（関数）を実行
            $controller->{$route["fonction"]}();
        }
        else
        {
            // ルートが見つからなかった場合、404ページを表示
            require "view/404.php";
        }
    }
}
