<?php
$sql = file_get_contents('migration.sql');
$pdo = new PDO('mysql:host=127.0.0.1;port=3307;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec($sql);
echo "✅ База и таблицы успешно созданы. Можешь удалить этот файл.";