<?php
require 'QueueManager.php';
$q = new QueueManager();

echo "воркер запущен" . $q->mainQueue . "\n";

$q->consume($q->mainQueue, function($data) {
    echo "Получен заказ для: " . $data['name'] . "\n";
    
    if ($data['name'] === 'Error') {
        throw new Exception("Критическая ошибка");
    }

    sleep(1);
    echo "успешно обработано.\n";
});
