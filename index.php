<?php
include 'helpers/connectToDB.php';
include 'helpers/fillTables.php';
include_once 'sql/createTablesData.php';
include 'helpers/monthsInRussian.php';

//Insert fake data to database
//faker($pdo, $tables, $relations, $users, $roles);

$headTitle = 'Список статей';

try {
    $query = 'SELECT id, title, short_desc, img, datetime FROM articles
              WHERE published = true ORDER BY datetime DESC';
    $articles = $pdo->query($query);

    $img = __DIR__ . "/uploads/images/";
} catch (PDOException $e) {
    echo 'Ошибка извлечения из базы данных<br>' . $e->getMessage();
}

session_start();

include __DIR__ . '/views/articles/index.html.php';