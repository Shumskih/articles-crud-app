<?php
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/monthsInRussian.php';

session_start();

if (isset($_GET['articleId']) && isset($_SESSION['loggedIn']) && isset($_SESSION['writer'])) {
    $articleId = $_GET['articleId'];

    $userId = $_SESSION['user_id'];

    $query = 'SELECT message, articles.id, title, short_desc, body, img, datetime FROM messages
              INNER JOIN articles_messages on articles_messages.message_id = messages.id
              INNER JOIN articles on articles_messages.article_id = articles.id
              WHERE articles.id = :articleId';
    $data = $pdo->prepare($query);
    $data->execute([
    'articleId' => $articleId
    ]);
    $data = $data->fetch();

    $query = 'SELECT users.id as userId FROM users
              INNER JOIN users_articles on users_articles.user_id = users.id
              INNER JOIN articles on users_articles.article_id = articles.id
              WHERE articles.id = :articleId';
    $doQuery = $pdo->prepare($query);
    $doQuery->execute([
      'articleId' => $articleId
    ]);
    $u = $doQuery->fetch();

    $headTitle = $data['title'];

    // Convert english months to russian months
    $date = convertEngDateToRussian(strtotime($data['datetime']));
    include $_SERVER['DOCUMENT_ROOT'] . '/views/messages/read/read.html.php';
}