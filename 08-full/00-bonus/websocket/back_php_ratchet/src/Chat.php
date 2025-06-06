<?php
namespace AFCI;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

require dirname(__DIR__)."/vendor/autoload.php";

class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nouvelle connexion ! ({$conn->resourceId})\n";
    }
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients)-1;
        echo sprintf('Connexion %d envoi le message "%s" à %d autres connexion%s \n', $from->resourceId, $msg, $numRecv, $numRecv==1?"":"s");

        foreach($this->clients as $client)
        {
            if($from != $client)
            {
                $client->send($msg);
            }
        }
    }
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connexion {$conn->resourceId} est déconnecté\n";
    }
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Une erreur a eu lieu : {$e->getMessage()}\n";
        $conn->close();
    }
}
?>