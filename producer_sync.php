<?php
require './vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Create the logger
$logger = new Logger('my_logger');

// Now add some handlers
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

$config = \Kafka\ProducerConfig::getInstance();
$config->setMetadataRefreshIntervalMs(10000);
$config->setMetadataBrokerList('127.0.0.1:9092');
$config->setBrokerVersion('1.0.0');
$config->setRequiredAck(1);
$config->setIsAsyn(false);
$config->setProduceInterval(500);
$producer = new \Kafka\Producer();
$producer->setLogger($logger);

for ($i = 0; $i < 100; $i++) {
    $producer->send([
        [
            'topic' => 'test1',
            'value' => 'test1....message.',
            'key'   => '',
        ],
    ]);
}