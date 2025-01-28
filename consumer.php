<?php
require './vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

date_default_timezone_set('America/Sao_Paulo');

// Create the logger
$logger = new Logger('my_logger');

// Now add some handlers
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

$config = \Kafka\ConsumerConfig::getInstance();
$config->setMetadataRefreshIntervalMs(10000);
$config->setMetadataBrokerList('127.0.0.1:9092');
$config->setGroupId('topic');
$config->setBrokerVersion('1.0.0');
$config->setTopics(['topic']);
$consumer = new \Kafka\Consumer();
$consumer->setLogger($logger);
$consumer->start(function ($topic, $part, $message) {
    var_dump($message);
});