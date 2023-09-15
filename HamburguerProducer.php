<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/HamburguerFactory.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class HamburguerProducer
{
    private $connection;
    private $channel;
    private static $instance;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('hamburguer_queue', false, false, false, false);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function produceHamburguer($type)
    {
        $hamburguer = HamburguerFactory::createHamburguer($type);
        $message = new AMQPMessage($hamburguer->getDescription());

        $this->channel->basic_publish($message, '', 'hamburguer_queue');
        echo "Produzido: ", $hamburguer->getDescription(), "\n";
    }

    public function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

$producer = HamburguerProducer::getInstance();

while (true) {
    echo "Digite o tipo de hambúrguer ('cheese' ou 'chicken') ou 'exit' para sair: ";
    $input = trim(fgets(STDIN));

    if ($input === 'exit') {
        break;
    }

    if ($input === 'cheese' || $input === 'chicken') {
        $producer->produceHamburguer($input);
    } else {
        echo "Tipo de hambúrguer inválido. Tente novamente.\n";
    }
}