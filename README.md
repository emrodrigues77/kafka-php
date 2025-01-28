# PHP Kafka study with nmred/kafka-php library
PHP simplest study on Kafka, using nmred/kafka-php.

## To run

### Start Kafka docker
docker run -p 9092:9092 apache/kafka-native:3.9.0

### Create a topic
Use Offset Explorer to create a topic (since the nmred/kafka-php library doesn't create topics)

### Run the consumer
php consumer.php (modify consumer.php to set the topic)

### Run the producer
Navigate to index.html and fill the form and click on Send. (The topic must be previously created.)
