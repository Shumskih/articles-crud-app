<?php

try {
    $pdo = new PDO(
      'mysql:host=localhost;dbname=' . DB,
      DB_USER,
      DB_PASSWORD,
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo "Невозможно установить соединение с базой данных<br>" . $e->getMessage();
}