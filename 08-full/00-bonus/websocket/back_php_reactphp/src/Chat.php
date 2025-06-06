<?php 
namespace AFCI;

use React\Socket\ConnectionInterface;
use React\Socket\LimitingServer;

class Chat
{
    protected $clients;

    public function __construct(private LimitingServer $socket)
    {
        $this->clients = new \SplObjectStorage();
        $this->startChatListener();
    }
    private function startChatListener()
    {
        $this->socket->on('connection',[$this, "onConnexion"]);
        $this->socket->on('error',[$this, "onError"]);
    }
    public function onConnexion(ConnectionInterface $connection)
    {
        
    // $connection->write('hello there!' . PHP_EOL);
        $this->clients->attach($connection);
        $connection->on('data',[$this, "onData"]);
        $connection->on('close',[$this, "onClose"]);
        echo '[' . $connection->getRemoteAddress() . ' connected]' . PHP_EOL;
            // $connection->write("connexion");
        // foreach ($this->clients as $connection) {
        //     $connection->write("connexion");
        //     echo "message : connexion sent". PHP_EOL;
        // }
    }
    public function onData($data)
    {
        // remove any non-word characters (just for the demo)
        echo '[data]' . PHP_EOL;
        $data = trim(preg_replace('/[^\w\d \.\,\-\!\?]/u', '', $data));

        // ignore empty messages
        if ($data === '') {
            return;
        }
        var_dump($data);
        // prefix with client IP and broadcast to all connected clients
        // $data = trim(parse_url($connection->getRemoteAddress(), PHP_URL_HOST), '[]') . ': ' . $data . PHP_EOL;
        // foreach ($socket->getConnections() as $connection) {
        //     $connection->write($data);
        // }
    }
    public function onClose(ConnectionInterface $connection)
    {
        echo '[' . $connection->getRemoteAddress() . ' disconnected]' . PHP_EOL;
        $this->clients->detach($connection);
    }
    public function onError(\Exception $e)
    {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    }
}