<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hamburguer_queue', false, false, false, false);

echo "Aguardando pedidos de hamburgueres. Para sair, pressione Ctrl+C\n";

$callback = function ($msg) {
    echo 'Recebido: ', $msg->body, "\n";
};

$channel->basic_consume('hamburguer_queue', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();
