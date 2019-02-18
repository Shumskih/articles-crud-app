<?php
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';

$headTitle = 'Сообщения от модераторов';

session_start();

if (isset($_SESSION['loggedIn']) && isset($_SESSION['writer'])) {
    $email = $_SESSION['email'];

    $articles = [];
    try {
        $query = 'SELECT articles.id, title FROM articles
          INNER JOIN users_articles on users_articles.article_id = articles.id
          INNER JOIN users on users_articles.user_id = users.id
          WHERE email = :email AND returned = 1';
        $articles = $pdo->prepare($query);
        $articles->execute([
          'email' => $email
        ]);
    } catch (PDOException $e) {
        $e->getMessage();
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/views/messages/messages.html.php';
} else {
    include $_SERVER['DOCUMENT_ROOT'] . '/views/denied/index.html.php';
}