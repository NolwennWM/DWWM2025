<?php 
/* 
    In PHP, there are several tools for connecting to a database.
    Examples include "mysqli" or "pdo."
    Here, we'll see "pdo" (PHP Data Object).

    To connect, PDO requires a DSN (Data Source Name).
    This is a string containing all the information needed to locate the database.
    {driver}:host={address};port={connection port};dbname={database name};charset={charset to use}
*/
$dsn = "mysql:host=bddsql;port=3306;dbname=biere;charset=utf8mb4";
/* 
    When creating a new PDO instance, it will take the following parameters:
        1. the DSN
        2. the username to connect to the database
        3. the database password
        4. an array containing the PDO configuration
*/
$pdo = new PDO($dsn, "root", "root", [
    // Type of error that PDO should display:
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // How data retrieved from the database should be displayed
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Tells PDO to not emulate prepared statements (see below)
    // PDO::ATTR_EMULATE_PREPARES => false
]);

// Send a request to the database:
$sqlCouleur = $pdo->query("SELECT * FROM couleur");
// var_dump($sql);

// recover data :
$couleurs = $sqlCouleur->fetchAll();
// var_dump($couleurs);
// If we want to retrieve only the first result, we will use "fetch"
$sqlType = $pdo->query("SELECT * FROM type");
$type = $sqlType->fetch();

/* 
    When the query doesn't require any user input, "query" is sufficient.
    But if the query contains user input, you should definitely not use query. Otherwise, you risk SQL injection.

    We'll need to use prepared statements.
    If your database driver (mysql, mariadb, postgresql, etc.) doesn't support prepared statements,
    PDO can emulate them. (Here, mariadb does, so emulation has been disabled.)

    We'll use the "prepare" method, in which we'll write the SQL query, replacing user input with:
    "?" or ":aChosenWord"
*/
$sqlCouleur2 = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = ?");
/* 
    Then we'll pass the user input either through the methods discussed below,
    or through "execute", which we'll pass an array.
        If "?" was used, the first element of the array will go to the first "?", and so on.
        If ":aWord" was used, we'll return an associative array:
        "SELECT * FROM color WHERE COLOR_NAME = :mySuperColor"
        execute(["mySuperColor"=>$entryUser]);
*/
$entreUtilisateur = "Blanche";
$sqlCouleur2->execute([$entreUtilisateur]);
$couleurFromPrepare = $sqlCouleur2->fetch();
/* 
    In the case of execute, all parameters passed are treated as strings.
    This can be problematic in certain cases, such as when specifying a limit.
    Another way to pass parameters exists:
        "bindValue" and "bindParam"
        They work the same way:
        First parameter: the name in the prepared statement,
        Second parameter: the value to use,
        Third parameter: a PDO constant indicating the type of the value
                PDO::PARAM_NULL
                PDO::PARAM_BOOL
                PDO::PARAM_INT
                PDO::PARAM_STR
*/
$sqlArticle = $pdo->prepare("SELECT * FROM article LIMIT :lim");
$sqlArticle->bindValue("lim", 5, PDO::PARAM_INT);
// in this case execute remains empty:
$sqlArticle->execute();
// For example, this will cause an error, if PDO emulates the prepared statement :
// $sqlArticle->execute(["lim"=>5]);
$articles = $sqlArticle->fetchAll();

// ? Difference between bindValue and bindParam :

// ? Example with bindValue :
// I choose a color
$UserCouleur = "Blanche";
// I am preparing the request
$sqlBindValue = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = :col");
// I call bindValue
$sqlBindValue->bindValue("col", $UserCouleur, PDO::PARAM_STR);
// I change the color
$UserCouleur = "Ambrée";
// I execute the query
$sqlBindValue->execute();
$couleurBindValue = $sqlBindValue->fetch();

// ? Example with bindParam :
// I choose a color
$UserCouleur = "Blanche";
// I am preparing the request
$sqlBindParam = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = :col");
// I call bindParam
$sqlBindParam->bindParam("col", $UserCouleur, PDO::PARAM_STR);
// I change the color
$UserCouleur = "Ambrée";
// I execute the query
$sqlBindParam->execute();
$couleurBindParam = $sqlBindParam->fetch();
/* 
    With bindValue, the value in the variable is passed directly to our prepared statement.
    With bindParam, the entire variable is passed. So if it changes before execution, the statement will change.
*/

$title = " Connexion à la Base de donnée ";
require("../ressources/template/_header.php");

echo '<pre>'.print_r($couleurs, 1).'</pre>';
echo '<pre>'.print_r($type, 1).'</pre>';
echo '<pre>'.print_r($couleurFromPrepare, 1).'</pre>';
echo '<pre>'.print_r($articles, 1).'</pre>';
echo '<pre>'.print_r($couleurBindValue, 1).'</pre>';
echo '<pre>'.print_r($couleurBindParam, 1).'</pre>';


require("../ressources/template/_footer.php");
?>