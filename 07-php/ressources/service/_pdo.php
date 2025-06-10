<?php 
/**
 * 「ブログ」データベースに接続するためのPDO接続インスタンスを返します
 *
 * @return \PDO
 */
function connexionPDO(): \PDO
{
    // 詳細については、「00-database.php」コースを参照してください。
    try
    {
        // 設定を取得しています :
        $config = require __DIR__."/../config/_blogConfig.php";
        // DSNを構築する :
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
        // PDOインスタンスを作成する :
        $pdo = new \PDO($dsn, $config["user"], $config["password"], $config["options"]);
        // インスタンスを返す :
        return $pdo;
    }
    catch(\PDOException $e)
    {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}