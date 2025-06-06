<?php 
use React\Socket\LimitingServer;
use React\Socket\SocketServer;
use AFCI\Chat;
use React\EventLoop\Loop;

require dirname(__DIR__)."/vendor/autoload.php";
require dirname(__DIR__)."/src/Chat.php";

$loop = Loop::get();
$socket = new SocketServer('127.0.0.1:8080', [
    'tls' => [
        'local_cert' => 'server.pem'
    ]
], $loop);

$socket = new LimitingServer($socket, 20);
$Chat = new Chat($socket);
echo 'Listening on ' . $socket->getAddress() . PHP_EOL;
$loop->run();
?>