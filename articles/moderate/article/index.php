<?php
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/monthsInRussian.php';

$res = [];
$headTitle = '';

session_start();

if (isset($_GET['id']) && !isset($_POST['message'])) {
    try {
        $query = 'SELECT id, title, body, datetime FROM articles WHERE id = :id';
        $article = $pdo->prepare($query);
        $article->execute(['id' => $_GET['id']]);
        $res = $article->fetch();

        $headTitle = $res['title'];

        // Convert english months to russian months
        $date = convertEngDateToRussian(strtotime($res['datetime']));
    } catch (PDOException $e) {
        echo 'Ошибка извлечения статьи из БД<br>' . $e->getMessage();
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/views/articles/moderate/article.html.php';
}

if (isset($_POST['message'])) {
    $articleId = $_POST['id'];
    $message = $_POST['messageBody'];

    try {
        $query = 'INSERT INTO messages VALUES (NULL, :message)';
        $doQuery = $pdo->prepare($query);
        $doQuery->execute([
          'message' => $message
        ]);

        $messageId = $pdo->lastInsertId();

        $query = 'INSERT INTO articles_messages VALUES (:articleId, :messageId)';
        $doQuery = $pdo->prepare($query);
        $doQuery->execute([
          'articleId' => $articleId,
          'messageId' => $messageId
        ]);
    } catch (PDOException $e) {
        $e->getMessage();
    }

    $headTitle = 'Сообщение отправлено!';
    include $_SERVER['DOCUMENT_ROOT'] . '/views/articles/moderate/success/success.html.php';
}