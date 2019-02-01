<?php
include 'helpers/connectToDB.php';
include 'helpers/fillTables.php';
include_once 'sql/createTablesData.php';

//Insert fake data to database
//faker($pdo, $tables, $relations);

$headTitle = 'Список статей';
$articlesArr = [];

try {
    $query = 'SELECT id, title, short_desc FROM articles ORDER BY datetime DESC';
    $articles = $pdo->query($query);

    while($art = $articles->fetch())
        array_push($articlesArr, [
          'id' => $art['id'],
          'title' => $art['title'],
          'short_desc' => $art['short_desc']
        ]);
} catch (PDOException $e) {
    echo 'Ошибка извлечения из базы данных<br>' . $e->getMessage();
}

include 'views/articles/index.html.php';

