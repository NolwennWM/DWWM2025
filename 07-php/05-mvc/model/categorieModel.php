<?php 
require_once __DIR__."/../../ressources/service/_pdo.php";
/**
 * Retourne toute les catégories.
 *
 * @return array|false
 */
function getAllCategories(): array|false
{
    $pdo = connexionPDO();
    $sql = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
    return $sql->fetchAll();
}
function getCategorieById(int $idCat): array|false
{
    $pdo = connexionPDO();
    $sql = $pdo->prepare("SELECT * FROM categories WHERE idCat = ?");
    $sql->execute([$idCat]);
    return $sql->fetch();
}
?>