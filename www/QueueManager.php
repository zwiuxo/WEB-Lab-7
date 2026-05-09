<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueManager {
    private $connection;
    private $channel;
    public $mainQueue = 'taxi_main';
    public $errorQueue = 'taxi_errors';

    public function __construct() {
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        
        $this->channel->queue_declare($this->mainQueue, false, true, false, false);
        $this->channel->queue_declare($this->errorQueue, false, true, false, false);
    }

    public function publish($data, $queue) {
        $msg = new AMQPMessage(json_encode($data), ['delivery_mode' => 2]);
        $this->channel->basic_publish($msg, '', $queue);
    }

        $this->channel->basic_consume($queue, '', false, false, false, false, function($msg) use ($callback) {
            $data = json_decode($msg->body, true);
            try {
                $callback($data);
                $msg->ack();
            } catch (Exception $e) {

                // штрафное задание
                $this->publish($data, $this->errorQueue);
                $msg->ack(); 
                echo "Ошибка, заказ перенесен в очередь ошибок.\n";
            }
        });

        while($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function getStats($queue) {
        list(,,$count) = $this->channel->queue_declare($queue, false, true, false, false);
        return $count;
    }
}
