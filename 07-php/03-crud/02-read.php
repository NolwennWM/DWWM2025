<?php 
// I require my database connection function
require "../ressources/service/_pdo.php";

// I connect to the database
$db = connexionPDO();

// I run my request
$sql = $db->query("SELECT idUser, username FROM users");

// I get all my users
$users = $sql->fetchAll();
/* 
    CRUD stands for
        Create
        Read
        Update
        Delete
    These are the actions that should be possible on each table in the database.
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
            <!-- My data are in an array (fetchAll) so I will have to loop to display all of it : -->
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
