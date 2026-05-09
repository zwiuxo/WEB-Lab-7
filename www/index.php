<?php
require 'QueueManager.php';
$q = new QueueManager();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lab 7 - Queues</title>
    <style>
        body { background: #1a1a1a; color: white; font-family: sans-serif; padding: 20px; }
        .stat-box { border: 2px solid yellow; padding: 15px; margin-bottom: 20px; }
        .error-count { color: #ff4444; }
    </style>
</head>
<body>
    <h1> Taxi Queue System (Lab 7)</h1>

    <div class="stat-box">
        <h3>Статистика RabbitMQ:</h3>
        <p>Заказов в очереди: <b><?= $q->getStats($q->mainQueue) ?></b></p>
        <p>Ошибок в очереди: <b class="error-count"><?= $q->getStats($q->errorQueue) ?></b></p>
    </div>

    <form action="send.php" method="POST">
        <input type="text" name="name" placeholder="Ваше имя" required>
        <button type="submit" style="background:yellow; padding:10px;">Заказать такси</button>
    </form>
    
    <p><small>Введите "Error" в имени, чтобы проверить очередь ошибок.</small></p>
</body>
</html>
