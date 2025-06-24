<?php 
/* 
    Pour un même fichier controller, j'ai plusieurs pages qui sont gérés.
    Je fais donc évoluer mon système de route pour qu'en plus d'avoir un fichier à charger, il y ai aussi une fonction à appeler.
*/
const ROUTES = [
    "05-mvc"=>[
        "controller"=>"userController.php",
        "fonction"=>"readUsers"
    ],
    "05-mvc/inscription"=>[
        "controller"=>"userController.php",
        "fonction"=>"createUser"
    ],
    "05-mvc/profil"=>[
        "controller"=>"userController.php",
        "fonction"=>"updateUser"
    ],
    "05-mvc/profil/supprimer"=>[
        "controller"=>"userController.php",
        "fonction"=>"deleteUser"
    ],
    // Exercices :
    "05-mvc/connexion"=>[
        "controller"=>"authController.php", 
        "fonction"=>"login"
    ],
    "05-mvc/deconnexion"=>[
        "controller"=>"authController.php", 
        "fonction"=>"logout"
    ],
    "05-mvc/message/list"=>[
        "controller"=>"messageController.php", 
        "fonction"=>"readMessage"
    ],
    "05-mvc/message/create"=>[
        "controller"=>"messageController.php", 
        "fonction"=>"createMessage"
    ],
    "05-mvc/message/update"=>[
        "controller"=>"messageController.php", 
        "fonction"=>"updateMessage"
    ],
    "05-mvc/message/delete"=>[
        "controller"=>"messageController.php", 
        "fonction"=>"deleteMessage"
    ]
];