<?php 
// 開発環境か本番環境かを示す定数
const APP_ENV = "dev";

require "./api.php"; // APIのロジックとユーティリティ
require "./routes.php"; // ルートの定義
require "./router.php"; // ルーティングの処理
