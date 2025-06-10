<?php 
// データベース接続機能が必要です
require "../ressources/service/_pdo.php";

// データベースに接続する
$db = connexionPDO();

// 私はリクエストを実行します
$sql = $db->query("SELECT idUser, username FROM users");

// すべてのユーザーを獲得
$users = $sql->fetchAll();
/* 
    CRUD とは
        Create
        Read
        Update
        Delete
    データベース内の各テーブルに対して実行可能なアクションのことです。
*/
$title = " CRUD - Liste Utilisateur";
require "../ressources/template/_header.php";

if($users):
?>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>username</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- データは配列（fetchAll）にあるので、すべてを表示するにはループする必要があります。 : -->
            <?php foreach($users as $row): ?>
                <tr>
                    <td><?= $row["idUser"] ?></td>
                    <td><?= $row["username"] ?></td>
                    <td>
                        <a href="TODO">Voir Blog</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else:?>
    <p>Aucun utilisateur disponible.</p>
<?php endif;
require "../ressources/template/_footer.php";
?>
