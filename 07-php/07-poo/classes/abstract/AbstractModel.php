<?php 
namespace Classes\Abstract;
use \PDO;
use \PDOStatement;

require __DIR__."/../../../ressources/service/_pdo.php";
/**
 * Abstract class to be inherited by different models.
 */
abstract class AbstractModel
{
    protected PDO $pdo;
    protected string $linkedClass = "ChangeInModelClass";

    public function __construct()
    {
        $this->pdo = connexionPDO();
        // We change the fetch mode to get objects instead of associative arrays:
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS);
    }

    /**
     * Sets the fetch mode to indicate which class to use
     * 
     * The & before the parameter indicates that changes will apply to the variable outside the function as well.
     *
     * @param PDOStatement $sql SQL query
     * @return PDOStatement
     */
    private function setFetchMode(PDOStatement &$sql):PDOStatement
    {
        $sql->setFetchMode(PDO::FETCH_CLASS, $this->linkedClass);
        return $sql;
    }

    /**
     * Runs the query and sets the fetch mode
     *
     * @param string $query SQL query
     * @return PDOStatement
     */
    protected function runQuery(string $query):PDOStatement
    {
        $sql = $this->pdo->query($query);
        $this->setFetchMode($sql);
        return $sql;
    }

    /**
     * Prepares the query and sets the fetch mode
     *
     * @param string $query SQL query
     * @return PDOStatement
     */
    protected function prepareQuery(string $query):PDOStatement
    {
        $sql = $this->pdo->prepare($query);
        $this->setFetchMode($sql);
        return $sql;
    }
}
