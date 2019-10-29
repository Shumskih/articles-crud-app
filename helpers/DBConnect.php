<?php


class DBConnect
{

    public function __construct()
    {
        try {
            $pdo = new PDO(
              'mysql:host=localhost;dbname=' . DB,
              DB_USER,
              DB_PASSWORD,
              [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {
            echo 'Can\'t connect to database<br>' . $e->getMessage();
        }
        return $pdo;
    }
}