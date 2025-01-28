<?php
require './vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Create the logger
$logger = new Logger('my_logger');

// Now add some handlers
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

$topic   = $_POST['topic'] ?? 'topic';
$message = $_POST['message'] ?? 'message';
$key     = $_POST['key'] ?? 'key';

try {

    echo "<pre>Topic: $topic\nMessage: $message\nKey: $key</pre>";

    $config = \Kafka\ProducerConfig::getInstance();
    $config->setMetadataRefreshIntervalMs(10000);
    $config->setMetadataBrokerList('localhost:9092');
    $config->setBrokerVersion('1.0.0');
    $config->setRequiredAck(1);
    $config->setIsAsyn(false);
    $config->setProduceInterval(500);

    $producer = new \Kafka\Producer(
        function () use ($topic, $message, $key) {
            return [
                [
                    'topic' => $topic,
                    'value' => $message,
                    'key'   => $key,
                ],
            ];
        }
    );

    $producer->setLogger($logger);

    $producer->success(function ($result) {
        echo "Success: \n";
        var_dump($result);
    });

    $producer->error(function ($errorCode) {
        echo "Error: \n";
        var_dump($errorCode);
    });

    $producer->send(true);
} catch (Exception | Error $e) {
    var_dump($e->getMessage());
}