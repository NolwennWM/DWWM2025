<?php 
/**
 * Returns a PDO connection instance to connect to the "blog" database
 *
 * @return \PDO
 */
function connexionPDO(): \PDO
{
    // For more details, see the course "00-database.php"    try
    try
    {
        // I'm getting my configuration :
        $config = require __DIR__."/../config/_blogConfig.php";
        // I construct my DSN :
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
        // I create my PDO instance :
        $pdo = new \PDO($dsn, $config["user"], $config["password"], $config["options"]);
        // I return my instance :
        return $pdo;
    }
    catch(\PDOException $e)
    {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}