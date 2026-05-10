<?php
require 'QueueManager.php';

$q = new QueueManager();

$name = $_POST['name'] ?? 'Аноним';

$data = [
    'name' => htmlspecialchars($name),
    'type' => 'Такси',
    'timestamp' => date('Y-m-d H:i:s')
];

$q->publish($data, $q->mainQueue);

echo "<h2> Заказ отправлен в очередь!</h2>";
echo "Имя клиента: " . $data['name'] . "<br>";
echo "<a href='index.php'>Вернуться на главную (статистика)</a>";
