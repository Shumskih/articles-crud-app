<?php
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/monthsInRussian.php';

$res = [];
$headTitle = '';

session_start();

if (isset($_POST['publish'])) {
    $articleId = $_POST['id'];

    try {
        $query = 'UPDATE articles SET published = 1, returned = 0, moderate = 0 WHERE id = :articleId';
        $doQuery = $pdo->prepare($query);
        $doQuery->execute([
          'articleId' => $articleId
        ]);
    } catch (PDOException $e) {
        $e->getMessage();
    }

    header('Location: /');
}

if (isset($_GET['id']) && !isset($_POST['message']) && !isset($_POST['publish'])) {
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

        $query = 'UPDATE articles SET returned = 1, moderate = 0 WHERE id = :articleId';
        $doQuery = $pdo->prepare($query);
        $doQuery->execute([
          'articleId' => $articleId
        ]);
    } catch (PDOException $e) {
        $e->getMessage();
    }

    $headTitle = 'Сообщение отправлено!';
    include $_SERVER['DOCUMENT_ROOT'] . '/views/articles/moderate/success/success.html.php';
}