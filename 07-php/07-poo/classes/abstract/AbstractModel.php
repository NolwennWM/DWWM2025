<?php 
namespace Classes\Abstract;
use \PDO;
use \PDOStatement;

require __DIR__."/../../../ressources/service/_pdo.php";
/**
 * 各モデルに継承されるべき抽象クラス。
 */
abstract class AbstractModel
{
    protected PDO $pdo;
    protected string $linkedClass = "ChangeInModelClass";

    public function __construct()
    {
        $this->pdo = connexionPDO();
        // デフォルトのフェッチモードを連想配列ではなくクラスとして取得するように変更します。
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS);
    }

    /**
     * 使用するクラスを指定するためにフェッチモードを設定します。
     * 
     * 引数に & をつけることで、関数の外でも変数が変更されるようになります。
     *
     * @param PDOStatement $sql 実行済みのSQL文
     * @return PDOStatement
     */
    private function setFetchMode(PDOStatement &$sql):PDOStatement
    {
        $sql->setFetchMode(PDO::FETCH_CLASS, $this->linkedClass);
        return $sql;
    }

    /**
     * 引数のクエリを実行し、フェッチモードを設定します。
     *
     * @param string $query 実行するSQL文
     * @return PDOStatement
     */
    protected function runQuery(string $query):PDOStatement
    {
        $sql = $this->pdo->query($query);
        $this->setFetchMode($sql);
        return $sql;
    }

    /**
     * 引数のクエリをプリペアし、フェッチモードを設定します。
     *
     * @param string $query プリペアするSQL文
     * @return PDOStatement
     */
    protected function prepareQuery(string $query):PDOStatement
    {
        $sql = $this->pdo->prepare($query);
        $this->setFetchMode($sql);
        return $sql;
    }
}
