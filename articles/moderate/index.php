<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/monthsInRussian.php';

$headTitle = 'Статьи на модерацию';

try {
    $query = 'SELECT id, title, short_desc, img, datetime FROM articles 
              WHERE moderate = true ORDER BY datetime ASC';
    $articles = $pdo->query($query);

    $img = __DIR__ . "/uploads/images/";
} catch (PDOException $e) {
    echo 'Ошибка извлечения из базы данных<br>' . $e->getMessage();
}

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/views/articles/moderate/articles.html.php';