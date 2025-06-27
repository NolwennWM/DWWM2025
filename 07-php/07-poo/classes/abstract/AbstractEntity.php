<?php 
namespace Classes\Abstract;

/**
 * Abstract class to be inherited by entities.
 * An entity is a class representing a table in the database.
 * For example, a "user" entity would contain the same fields as the user table in the DB.
 */
abstract class AbstractEntity
{
    /**
     * Validates the various properties of the entity
     *
     * @return array Array containing possible errors.
     */
    abstract public function validate():array;

    /**
     * Cleans the provided string to avoid XSS attacks or simple whitespace errors.
     *
     * @param string $data Data to clean
     * @return string Cleaned data
     */
    protected function cleanData(string $data):string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
}
