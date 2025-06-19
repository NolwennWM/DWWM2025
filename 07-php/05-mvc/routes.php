<?php 
/* 
    1つのコントローラーファイルで複数のページを管理しています。
    そのため、読み込むファイルだけでなく、呼び出す関数も指定できるようにルーティングシステムを改良しています。
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
    // 演習：
];
